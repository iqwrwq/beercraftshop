<?php

namespace modules\controller;

use Authorizer;
use config\ShopConfig;
use modules\install\ShopInstaller;

require_once "PageBuilder.php";
require_once "Page.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/install/ShopInstaller.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/install/Authorizer.php";

class PageController extends PageBuilder
{

    public function index(string $from)
    {
        if (ShopInstaller::shopIsInstalled()) {
            $this->route($from);
        } else {
            $this->startInstall();
        }
    }

    private function route(string $from)
    {
        if ($from === "/BeerCraftShop/public/admin/") {
            $this->routeToAdminPage();
        } elseif ($from === "/BeerCraftShop/public/") {
            $this->routeToHomePage();
        } elseif ($from === "/BeerCraftShop/public/about.php") {
            $aboutPage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "public/homepage/about.page.php");
            $this->build("BeerCraft/About", $aboutPage);
        } elseif ($from === "/BeerCraftShop/public/notice.php") {
            $noticePage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "public/homepage/notice.page.php");
            $this->build("BeerCraft/Notice", $noticePage);
        } elseif ($from === "/BeerCraftShop/public/contact.php") {
            $contactPage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "public/homepage/contact.page.php");
            $this->build("BeerCraft/Contact", $contactPage);
        } elseif ($from === "/BeerCraftShop/public/admin/edit.php") {
            $contactPage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "admin/productEditor.page.php");
            $this->build("BeerCraft/Edit", $contactPage);
        } elseif (preg_match("/\/BeerCraftShop\/public\/admin\/edit.php\?id=\d*/", $from)) {
            $contactPage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "admin/productEditor.page.php");
            $this->build("BeerCraft/Edit", $contactPage);
        } elseif (preg_match("/\/BeerCraftShop\/public\/admin\/delete.php\?id=\d*/", $from)) {
            $contactPage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "admin/partials/deleteConfirm.php");
            $this->build("Delete Item ?", $contactPage);
        } else {
            $contactPage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "service/couldNotLoad.page.php");
            $this->build("BeerCraft/Not Found", $contactPage);
        }
    }

    private function routeToAdminPage()
    {
        if (Authorizer::isLoggedIn()) {
            $this->continueToAdmin();
        } elseif (Authorizer::isAuthorized()) {
            $this->continueToAdmin();
        } else {
            $adminLoginPage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "admin/login.page.php");
            $this->build("BeerCraft/Login", $adminLoginPage);
        }
    }

    private function continueToAdmin()
    {
        $adminPage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "admin/admin.page.php");
        $this->build("BeerCraft/Admin", $adminPage);
    }

    private function startInstall()
    {
        $installPage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "admin/install.page.php");
        $this->build("BeerCraft/Installation", $installPage);
    }

    private function routeToHomePage()
    {
        $shopConfig = new ShopConfig();
        if ($shopConfig->getIsStoreFrontOpen()) {
            $homePage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "public/homepage/home.page.php");
            $this->build("BeerCraft/Shop", $homePage);
        } else {
            $outOfServicePage = new Page($this->pages_root . DIRECTORY_SEPARATOR . "service/outOfService.page.php");
            $this->build("BeerCraft/Shop is out of Service", $outOfServicePage);
        }

    }
}