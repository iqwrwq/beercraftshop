<?php


namespace modules\install;

use config\ShopConfig;
use modules\database\rows\AdminRow;
use modules\database\rows\ProductRow;
use modules\database\rows\Row;
use modules\database\ShopDataBaseHandler;
use modules\database\tables\AdminTable;
use modules\database\tables\ProductTable;


require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/config/ShopConfig.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/ShopDataBaseHandler.php";

class ShopInstaller
{
    public function installShop(array $postData)
    {
        list($data, $shopConfig) = $this->initData($postData);
        $shopDataBaseHandler = $this->initDataBase($shopConfig, $data);
        $this->polishInstall($shopDataBaseHandler, $data, $shopConfig);
    }

    private function initialAdmin(ShopDataBaseHandler $shopDataBaseHandler, array $data)
    {
        $shopDataBaseHandler->insert(new AdminTable(), new AdminRow(array(
            "id" => "NULL",
            "login_name" => $data["loginName"],
            "password" => password_hash($data["password"], PASSWORD_DEFAULT)
        )));
    }

    private function insertDemoData(ShopDataBaseHandler $shopDataBaseHandler)
    {
        $json = file_get_contents("https://iqwrwq.github.io/beercraftshop/data/products/products.json");
        $data = json_decode($json);
        $product_image_path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/public/resources/images/products/";
        $api_url = "https://iqwrwq.github.io/beercraftshop/data/products/img/";
        foreach ($data as $product) {
            $product_data = array();
            foreach ($product as $key => $value) {
                if ($key === "img_url") {
                    file_put_contents($product_image_path . $value . ".jpg", file_get_contents($api_url . $value . ".jpg"));
                }
                $product_data[$key] = $value;
            }
            $shopDataBaseHandler->insert(new ProductTable(), new ProductRow($product_data));
        }
    }


    public static function shopIsInstalled(): bool
    {
        $shopConfig = new ShopConfig();
        $dataBaseConnection = $shopConfig->getDataBaseConfig();
        if (!$shopConfig->getIsShopInstalled()) {
            $shopConfig->set("installed", "false");
            return false;
        }
        if (!ShopDataBaseHandler::canConnectToDatabase(
            $dataBaseConnection["host"],
            $dataBaseConnection["user"],
            $dataBaseConnection["pwd"]
        )) {
            return false;
        }
        return file_exists($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/install.lock");
    }

    public static function passwordAuthentication($pwd, $pwd_confirm): bool
    {
        return $pwd === $pwd_confirm & strlen($pwd) >= 4;
    }

    private function toConvention(array $data): array
    {
        return array(
            "host" => $data["host_input"],
            "user" => $data["db_user_input"],
            "pwd" => $data["db_pwd_input"],
            "insertDemoData" => $data["demo_data"],
            "loginName" => $data["user_input"],
            "password" => $data["pwd_input"],
            "password_confirm" => $data["pwd_confirm_input"]
        );
    }

    public function initDataBase(ShopConfig $shopConfig, array $data): ShopDataBaseHandler
    {
        $dataBaseConnection = $shopConfig->getDataBaseConfig();
        $tables = $shopConfig->getTables();
        $shopDataBaseHandler = new ShopDataBaseHandler($data);
        $shopDataBaseHandler->setupDataBase($dataBaseConnection["db_name"], $tables);
        return $shopDataBaseHandler;
    }

    public function initData(array $postData): array
    {
        $data = $this->toConvention($postData);
        $shopConfig = new ShopConfig();
        $shopConfig->configure($data);
        return array($data, $shopConfig);
    }

    public function polishInstall(ShopDataBaseHandler $shopDataBaseHandler, $data, $shopConfig)
    {
        $this->initialAdmin($shopDataBaseHandler, $data);
        if ($data["insertDemoData"] === "on") $this->insertDemoData($shopDataBaseHandler);
        $shopConfig->set("installed", "true");
        fopen($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/install.lock", "w");
    }
}

/**
 * @from Install.page.php
 */
if (isset($_POST['install_db'])) {
    if (ShopDataBaseHandler::canConnectToDatabase(
        $_POST['host_input'],
        $_POST['db_user_input'],
        $_POST['db_pwd_input']
    )) {
        if (ShopInstaller::passwordAuthentication(
            $_POST['pwd_input'],
            $_POST['pwd_confirm_input']
        )) {

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            $shopInstaller = new ShopInstaller();
            $shopInstaller->installShop($_POST);
            if (ShopInstaller::shopIsInstalled()) {
                unset($_POST);
                header("Location: /BeerCraftShop/public");
            } else {
                returnToInstallPage("Could not install Shop", 403);
            }
        } else {
            returnToInstallPage("User Passwords bad", 402);
        }
    } else {
        returnToInstallPage("Could not Connect to Database", 401);
    }
}

/**
 * @param string $errMsg
 * @param int $errCode
 */
function returnToInstallPage(string $errMsg, int $errCode)
{
    session_start();
    $_SESSION['INSTALL_ERROR'] = $errMsg . "::" . $errCode;
    header("Location: /BeerCraftShop/public");
}

