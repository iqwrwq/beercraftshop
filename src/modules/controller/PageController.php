<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

namespace BeerCraftShop\src\modules\controller;

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/install/Installer.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/properties/PropertiesController.php";

use Authorizer;
use Installer;

define('HOME_PAGE', 'home');
define('HOME_PAGE_REQUEST_URI', '/BeerCraftShop/public/');
define('ADMIN_PAGE', 'admin');
define('ADMIN_PAGE_REQUEST_URI', '/BeerCraftShop/public/admin/');
define('LOAD_ERROR_PAGE', 'loadError');
define('INSTALL_PAGE', 'install');
define('OUT_OF_SERVICE_PAGE', 'outOfService');
define('LOGIN_PAGE', 'login');
define('__HEADER__', $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages/public/partials/head.php");
define('__PAGES__', $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages");

class PageController
{
    private $pages;
    private $properties_path;

    public function __construct($properties_path)
    {
        $this->properties_path = $properties_path;
        $this->pages = [
            "home" => __PAGES__ . DIRECTORY_SEPARATOR . "public/homepage/home.page.php",
            "admin" => __PAGES__ . DIRECTORY_SEPARATOR . "admin/admin.page.php",
            "install" => __PAGES__ . DIRECTORY_SEPARATOR . "admin/install.page.php",
            "loadError" => __PAGES__ . DIRECTORY_SEPARATOR . "public/content.page.php",
            "outOfService" => __PAGES__ . DIRECTORY_SEPARATOR . "service/outOfService.page.php",
            "login" => __PAGES__ . DIRECTORY_SEPARATOR . "admin/login.page.php",
        ];
    }

    public function securedLogin()
    {
        require_once __HEADER__;
        require_once $this->pages[ADMIN_PAGE];
    }

    /**
     * @param $request_root
     */
    public function route($request_root)
    {
        if (Installer::check($this->properties_path)) {
            require_once __HEADER__;
            if ($request_root == ADMIN_PAGE_REQUEST_URI) {
                if (Authorizer::isLoggedIn()) {
                    require_once $this->pages[ADMIN_PAGE];
                }elseif(Authorizer::isAuthorized()){
                    require_once $this->pages[ADMIN_PAGE];
                } else {
                    require_once $this->pages[LOGIN_PAGE];
                }
            } elseif ($request_root == HOME_PAGE_REQUEST_URI) {
                $propertiesController = new \PropertiesController($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json");
                if($propertiesController->get("storefront") === "on"){
                    require_once $this->pages[HOME_PAGE];
                }else{
                    require_once $this->pages[OUT_OF_SERVICE_PAGE];
                }

            } else {
                require_once $this->pages[LOAD_ERROR_PAGE];
            }
        } else {
            require_once __HEADER__;
            require_once $this->pages[INSTALL_PAGE];
        }
    }
}