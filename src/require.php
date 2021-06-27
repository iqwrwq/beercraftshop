<?php

use modules\controller\PageController;

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/controller/PageController.php";

$pageController = new PageController();
$pageController->index($_SERVER["REQUEST_URI"]);
