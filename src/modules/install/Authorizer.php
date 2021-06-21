<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/controller/PageController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/properties/PropertiesController.php";

class Authorizer
{
    /**
     * @return bool
     */
    public static function isLoggedIn()
    {
        if (isset($_COOKIE["beercraftshop_admin_user_logged"])){
            return $_COOKIE["beercraftshop_admin_user_logged"] === "true";
        }
        return false;
    }

    public static function looseRememberMeCookie(){
        setcookie("beercraftshop_admin_user_logged", "true", time() - (86400 * 30));
    }

    public static function isAuthorized(){
        return isset($_COOKIE["beercraftshop_admin_user_authorized"]);
    }


    public static function clearOldCookies()
    {
        setcookie("beercraftshop_admin_user_logged", "false", time() - (86400 * 30));
        setcookie("beercraftshop_admin_user_authorized", "true", time() - (86400 * 30));
    }
}

//logout

if (isset($_POST["loginUser"]) && isset($_POST["loginPassword"])) {
    $properties = PropertiesController::getContent($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json");
    $pageController = new \BeerCraftShop\src\modules\controller\PageController($properties);
    if (isset($_POST["remember-user"])) {
        setcookie("beercraftshop_admin_user_logged", "true", time() + (86400 * 30), "/");
    }
    if (password_verify($_POST["loginPassword"], $properties["user_pwd"])) {
        setcookie("beercraftshop_admin_user_authorized", "true", time() + 60, "/");
    }
    header("Location: /BeerCraftShop/public/admin");
}

if(isset($_POST["toggleStorefront"])){
    $properties_path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json";
    $propertiesController = new PropertiesController($properties_path);
    if($propertiesController->get("storefront") === "on"){
        $propertiesController->change("storefront", "off");
    }else{
        $propertiesController->change("storefront", "on");
    }
    header("Location: /BeerCraftShop/public/admin");
}