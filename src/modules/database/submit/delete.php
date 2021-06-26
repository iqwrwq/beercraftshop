<?php

use config\ShopConfig;
use modules\database\ShopDataBaseHandler;
use modules\database\tables\TableType;

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/config/ShopConfig.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/ShopDataBaseHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/tables/TableType.php";

$shopConfig = new ShopConfig();
$shopDataBaseHandler = new ShopDataBaseHandler($shopConfig->getDataBaseConfig());
$productTableType = new TableType(TableType::PRODUCT_TABLE);

if (isset($_GET["id"])) {
    $shopDataBaseHandler->delete($productTableType, $_GET["id"]);
    unset($_FILES);
    unset($_POST);
    header("Location: /BeerCraftShop/public/admin");
} else {
    unset($_FILES);
    unset($_POST);
    header("Location: /BeerCraftShop/public/admin");
}

