<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

use BeerCraftShop\src\modules\database\DataBaseController;

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/controller/PageController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/properties/PropertiesController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/DataBaseController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/DemoData.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/install/Authorizer.php";

class Installer
{

    /**
     * @param $properties_path
     * @return bool
     */
    public static function check($properties_path)
    {
        if (PropertiesController::check($properties_path)) {
            $properties = PropertiesController::getContent($properties_path);
            if (DataBaseController::check($properties, true)) {
                return true;
            }
        }
        return false;
    }

}

if (isset($_POST["host_input"]) && isset($_POST["db_user_input"]) && isset($_POST["user_input"]) && isset($_POST["pwd_input"]) && isset($_POST["pwd_confirm_input"])) {
    if ($_POST["pwd_confirm_input"] !== $_POST["pwd_input"]) {
        unset($_POST);
        session_start();
        $_SESSION['INSTALL_ERROR'] = "Installation Error: Passwords didn't match!";
        header("Location: /BeerCraftShop/public");
    } else {
        Authorizer::clearOldCookies();
        $strict_data = array(
            "db_host" => $_POST["host_input"],
            "db_user" => $_POST["db_user_input"],
            "db_pwd" => $_POST["db_pwd_input"],
            "db_name" => "beer_craft_shop_data",
            "user_name" => $_POST["user_input"],
            "user_pwd" => password_hash($_POST["pwd_input"], PASSWORD_DEFAULT),
            "tables" => [
                "products" => [
                    "id" => "INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
                    "name" => "VARCHAR(35) CHARACTER SET utf8 NOT NULL",
                    "description" => "TEXT",
                    "price" => "DECIMAL(10,2) NOT NULL",
                    "img_url" => "VARCHAR(125)",
                    "alcohol_content" => "DECIMAL(10,2)",
                ],
            ],
            "insertDemoData" => isset($_POST["demo_data"]) ? "true" : "false",
            "demoDataInserted" => "false",
            "storefront" => "on"
        );
        if (DataBaseController::check($strict_data)) {
            $dataBaseController = new DataBaseController($_POST["host_input"], $_POST["db_user_input"], $_POST["db_pwd_input"], $strict_data["db_name"]);
            $dataBaseController->init($strict_data["tables"]["products"], "products");
            $properties_path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json";
            $propertiesController = new PropertiesController($properties_path);

            if ($propertiesController->init($strict_data)) {
                $demoData = new DemoData();
                $demoData->insert_demo_data($dataBaseController, $propertiesController);
                header("Location: /BeerCraftShop/public");
            } else {
                echo "something went wrong";
            }
        } else {
            unset($_POST);
            session_start();
            $_SESSION['INSTALL_ERROR'] = "Installation Error: Could not connect to database! Recheck your input!";
            header("Location: /BeerCraftShop/public");
        }


    }
    unset($_POST);
    header("Location: /BeerCraftShop/public");
}