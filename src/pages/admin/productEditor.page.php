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
<?php if (isset($_GET["id"])): ?>
    <div class="admin-page-wrapper">
        <?php require_once "partials/adminPageNav.php" ?>
        <form action="#">
            <img width="300px" src="/BeerCraftShop/public/resources/images/products/<?php echo $productRow->getImgUrl() ?>.jpg">
            <label for=""></label>
            <input type="text" value="<?php echo $productRow->getId() ?>">
            <label for=""></label>
            <textarea style="resize: none" type="text"><?php echo $productRow->getDescription() ?></textarea>
            <label for=""></label>
            <input type="text" value="<?php echo $productRow->getId() ?>">
            <label for=""></label>
            <input type="text" value="<?php echo $productRow->getId() ?>">
        </form>
    </div>
<?php else: ?>
    <div class="admin-page-wrapper">
        <?php require_once "partials/adminPageNav.php" ?>
        <form action="#">
            <img width="300px" src="/BeerCraftShop/public/resources/images/products/<?php echo $productRow->getImgUrl() ?>.jpg">
            <label for=""></label>
            <input type="text" value="<?php echo $productRow->getId() ?>">
            <label for=""></label>
            <textarea style="resize: none" type="text"><?php echo $productRow->getDescription() ?></textarea>
            <label for=""></label>
            <input type="text" value="<?php echo $productRow->getId() ?>">
            <label for=""></label>
            <input type="text" value="<?php echo $productRow->getId() ?>">
        </form>
    </div>
<?php endif; ?>