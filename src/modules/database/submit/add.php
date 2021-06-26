<?php

use config\ShopConfig;
use modules\database\rows\ProductRow;
use modules\database\ShopDataBaseHandler;
use modules\database\tables\TableType;

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/config/ShopConfig.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/ShopDataBaseHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/tables/TableType.php";

$shopConfig = new ShopConfig();
$shopDataBaseHandler = new ShopDataBaseHandler($shopConfig->getDataBaseConfig());
$productTableType = new TableType(TableType::PRODUCT_TABLE);
$product_image_path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/public/resources/images/products/";

if (isset($_POST["add_product_item"])) {
    $productRow = new ProductRow(array(
        "id" => "NULL",
        "name" => $_POST["newProductName"],
        "description" => $_POST["newProductDescription"],
        "price" => $_POST["newProductPrice"],
        "img_url" => handleUploadedProductImageReturnURL(),
        "percentage" => $_POST["newProductPercentage"]
    ));
    $shopDataBaseHandler->insert($productTableType, $productRow);
    unset($_FILES);
    unset($_POST);
    header("Location: /BeerCraftShop/public/admin");
} else {
    unset($_FILES);
    unset($_POST);
    header("Location: /BeerCraftShop/public/admin");
}

function handleUploadedProductImageReturnURL(): string
{
    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
    $ext = pathinfo($_FILES["newProductImage"]["name"], PATHINFO_EXTENSION);
    $filebase = randomImageUrl();
    $filename = $filebase . "." . $ext;
    $filetype = $_FILES["newProductImage"]["type"];
    $file_destination = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/public/resources/images/products/";

    if (in_array($filetype, $allowed)) {
            move_uploaded_file($_FILES["newProductImage"]["tmp_name"], $file_destination . $filename);
    }
    return $filebase;
}

function randomImageUrl(): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < 15; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}