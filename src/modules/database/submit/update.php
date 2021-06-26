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

if (isset($_POST["update_product_item"])) {
    $shopDataBaseHandler->update($productTableType, $_POST["updateId"], "name", $_POST["updateName"]);
    $shopDataBaseHandler->update($productTableType, $_POST["updateId"], "description", $_POST["updateDescription"]);
    $shopDataBaseHandler->update($productTableType, $_POST["updateId"], "price", $_POST["updatePrice"]);
    $shopDataBaseHandler->update($productTableType, $_POST["updateId"], "percentage", $_POST["updatePercentage"]);
    unset($_FILES);
    unset($_POST);
    header("Location: /BeerCraftShop/public/admin");
} else {
    unset($_FILES);
    unset($_POST);
    header("Location: /BeerCraftShop/public/admin");
}

