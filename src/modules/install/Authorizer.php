<?php

use config\ShopConfig;
use modules\database\ShopDataBaseHandler;
use modules\database\tables\TableType;

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/config/ShopConfig.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/tables/TableType.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/ShopDataBaseHandler.php";

/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */
class Authorizer
{

    public static function isLoggedIn(): bool
    {
        if (isset($_COOKIE["beercraftshop_admin_user_logged"])) {
            return $_COOKIE["beercraftshop_admin_user_logged"] === "true";
        }
        return false;
    }

    public static function deleteCookie()
    {
        setcookie("beercraftshop_admin_user_logged", "true", time() - (86400 * 30));
    }

    public static function isAuthorized(): bool
    {
        return isset($_COOKIE["beercraftshop_admin_user_authorized"]);
    }


    public static function clearOldCookies()
    {
        setcookie("beercraftshop_admin_user_logged", "false", time() - (86400 * 30));
        setcookie("beercraftshop_admin_user_authorized", "true", time() - (86400 * 30));
    }
}

/**
 * @from login.page.php
 */
if (isset($_POST["loginUser"]) && isset($_POST["loginPassword"])) {

    $shopConfig = new ShopConfig();
    $shopDataBaseHandler = new ShopDataBaseHandler($shopConfig->getDataBaseConfig());
    $adminTableType = new TableType(TableType::ADMIN_TABLE);
    $adminTable = $shopDataBaseHandler->getAll($adminTableType);
    $adminRow = $adminTable->getRowFrom("login_name", $_POST["loginUser"]);
    //password_verify($_POST["loginPassword"], $adminRow->getPassword())
    if (true) {
        if (isset($_POST["remember-user"])) {
            setcookie("beercraftshop_admin_user_logged", "true", time() + (86400 * 30), "/");
        }
        setcookie("beercraftshop_admin_user_authorized", "true", time() + 60, "/");
    }
    unset($_POST);
    header("Location: /BeerCraftShop/public/admin");
}

/**
 * @from admin.page.php
 */
if (isset($_POST["logout"])) {
    Authorizer::deleteCookie();
    unset($_POST);
    header("Location: /BeerCraftShop/public/admin");
}