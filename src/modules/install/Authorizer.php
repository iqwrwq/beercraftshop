<?php
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
        if (isset($_COOKIE["beercraftshop_admin_user_logged"])){
            return $_COOKIE["beercraftshop_admin_user_logged"] === "true";
        }
        return false;
    }

    public static function deleteCookie(){
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
    $shopConfig = new \config\ShopConfig();
    $shopDataBaseHandler = new \modules\database\rows\ShopDataBaseHandler($shopConfig->getDataBaseConfig());
    if (isset($_POST["remember-user"])) {
        setcookie("beercraftshop_admin_user_logged", "true", time() + (86400 * 30), "/");
    }
    if (password_verify($_POST["loginPassword"], $shopDataBaseHandler->get("admins", $shopDataBaseHandler->getAll("admins")->getRowFrom("login_name", $_POST["loginUser"])))) {
        setcookie("beercraftshop_admin_user_authorized", "true", time() + 60, "/");
    }
    header("Location: /BeerCraftShop/public/admin");
}

if(isset($_POST["toggleStorefront"])){
    $properties_path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json";
    $propertiesController = new PropertiesDepControllerDep($properties_path);
    if($propertiesController->get("storefront") === "on"){
        $propertiesController->change("storefront", "off");
    }else{
        $propertiesController->change("storefront", "on");
    }
    header("Location: /BeerCraftShop/public/admin");
}