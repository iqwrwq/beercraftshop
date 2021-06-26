<?php

use config\ShopConfig;
use modules\database\ShopDataBaseHandler;

/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */
class Authorizer
{
    /**
     * @return bool
     */
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
    if (isset($_POST["remember-user"])) {
        setcookie("beercraftshop_admin_user_logged", "true", time() + (86400 * 30), "/");
    }
    if (password_verify($_POST["loginPassword"], $shopDataBaseHandler->get("admins", $shopDataBaseHandler->getAll("admins")->getRowFrom("login_name", $_POST["loginUser"])))) {
        setcookie("beercraftshop_admin_user_authorized", "true", time() + 60, "/");
    }
    header("Location: /BeerCraftShop/public/admin");
}

/**
 * @from admin.page.php
 */
if (isset($_POST["toggleStorefront"])) {
    $shopConfig = new ShopConfig();
    if ($shopConfig->getIsStoreFrontOpen()) {
        $shopConfig->set("storefront", "off");
    } else {
        $shopConfig->set("storefront", "on");
    }
    header("Location: /BeerCraftShop/public/admin");
}