<?php

use BeerCraftShop\src\modules\controller\PageController;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/controller/PageController.php";

$properties_path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json";
$pageController = new PageController($properties_path);
$pageController->route($_SERVER["REQUEST_URI"]);
