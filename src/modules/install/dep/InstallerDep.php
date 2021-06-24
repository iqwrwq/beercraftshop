<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

namespace modules\install;

use BeerCraftShop\src\modules\database\DataBaseControllerDep;
use config\Config;
use modules\database\rows\ShopDataBaseHandler;
use PropertiesDepControllerDep;

//require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/controller/PageController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/properties/PropertiesController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/ShopDataBaseHandler.php";
//require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/DataBaseController.php";
//require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/DemoData.php";
//require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/install/Authorizer.php";

class InstallerDep
{
    /**
     * @param array $propertiesData
     */
    public function installShop(array $propertiesData)
    {
        $databaseController = new DataBaseControllerDep();
        $databaseController->initDatabase();
        foreach ($propertiesData['tables'] as $table) {
            $databaseController->initTable($table);
        }
    }

    /**
     * @return bool
     */
    public function shopIsInstalled(): bool
    {
        return true;
    }


}

if (isset($_POST['install_db']))
{
    if (ShopDataBaseHandler::canConnectToDatabase(
        $_POST['host_input'],
        $_POST['db_user_input'],
        $_POST['db_pwd_input']
    )) {
        if (PropertiesDepControllerDep::canCreateAdmin(
            $_POST[''],
            $_POST[''],
            $_POST['']
        )) {
            $installer = install();
            if ($installer->shopIsInstalled()) {
                unset($_POST);
                header("Location: /BeerCraftShop/public");
            } else {
                returnToInstallPage("Could not install Shop", 403);
            }
        } else {
            returnToInstallPage("Could not create User", 402);
        }
    } else {
        returnToInstallPage("Could not Connect to Database", 401);
    }
}

/**
 * @return InstallerDep
 */
function install(): InstallerDep
{
    $propertiesController = new PropertiesDepControllerDep();
    $installer = new InstallerDep();
    $configuration = $propertiesController->buildAndReturnConfig($_POST);

    $installer->installShop($configuration);
    return $installer;
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

