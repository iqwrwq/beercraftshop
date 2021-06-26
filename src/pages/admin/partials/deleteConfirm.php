<?php

use config\ShopConfig;
use modules\database\ShopDataBaseHandler;
use modules\database\tables\TableType;

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages/public/partials/meta.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages/public/partials/title.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/config/ShopConfig.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/ShopDataBaseHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/tables/TableType.php";

if (isset($_GET["id"])) {
    $shopConfig = new ShopConfig();
    $shopDataBaseHandler = new ShopDataBaseHandler($shopConfig->getDataBaseConfig());
    $productTableType = new TableType(TableType::PRODUCT_TABLE);
    $productRow = $shopDataBaseHandler->get($productTableType, (int)$_GET["id"]);
}

?>
<div class="page-offline">
    <div class="box-header--out-of-box" style="color: #A40808">Delete <?php echo $productRow->getName()?>?</div>
    <div class="box-content">
        <button onclick="window.location='/BeerCraftShop/src/modules/database/submit/delete.php?id=<?php echo $_GET["id"] ?>'" class="delete-btn">Delete</button>
        <button onclick="window.location='/BeerCraftShop/public/admin/'"  class="cancel-btn">Cancel</button></div>
</div>
<?php if(!$shopConfig->getFastMode()):?>
    <video autoplay muted loop id="myVideo">
        <source src="/BeerCraftShop/public/resources/videos/beer_bg.mp4" type="video/mp4">
    </video>
<?php endif; ?>
<div class="wavy-overlay" id="wavy-overlay">
    <div class="wave"></div>
    <div class="wave"></div>
    <div class="cover"></div>
</div>
