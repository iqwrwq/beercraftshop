<?php

use config\ShopConfig;
use modules\database\ShopDataBaseHandler;
use modules\database\tables\TableType;

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages/public/partials/meta.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages/public/partials/title.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/config/ShopConfig.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/ShopDataBaseHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/tables/TableType.php";

$shopConfig = new ShopConfig();

if (isset($_GET["id"])) {
    $shopConfig = new ShopConfig();
    $shopDataBaseHandler = new ShopDataBaseHandler($shopConfig->getDataBaseConfig());
    $productTableType = new TableType(TableType::PRODUCT_TABLE);
    $productRow = $shopDataBaseHandler->get($productTableType, (int)$_GET["id"]);
}

?>
<?php if (isset($_GET["id"])): ?>

    <div class="add-item-form">
        <form action="/BeerCraftShop/src/modules/database/submit/update.php" method="post" >
            <img width="300px"
                 src="/BeerCraftShop/public/resources/images/products/<?php echo $productRow->getImgUrl() ?>.jpg">
            <div class="form-content">
                <input name="updateId" type="text" value="<?php echo $productRow->getId()?>" class="hide">
                <label for="updateName">Name:</label>
                <input name="updateName" type="text" value="<?php echo $productRow->getName() ?>">
                <label for="updateDescription">Description:</label>
                <textarea name="updateDescription" style="resize: none" type="text"><?php echo $productRow->getDescription() ?></textarea>
                <label for="updatePrice">Price:</label>
                <input name="updatePrice" type="text" value="<?php echo $productRow->getPrice() ?>">
                <label for="">Percentage:</label>
                <input name="updatePercentage" type="text" value="<?php echo $productRow->getPercentage() ?>">
            </div>
            <input type="submit" name="update_product_item" value="Edit">
        </form>
        <form action="/BeerCraftShop/src/modules/database/submit/add.php">
            <input type="submit" class="cancel-btn" value="Cancel">
        </form>
    </div>

<?php else: ?>

    <div class="add-item-form">
        <form action="/BeerCraftShop/src/modules/database/submit/add.php" method="POST" id="inner-form"
              enctype="multipart/form-data">
            <div class="form-header">
                <i class="fas fa-beer"></i>
                <span>
                    Create an item in your <span class="tc-highlight">database</span>
                </span>
            </div>
            <div class="form-content">
                <span>Name:</span>
                <input type="text" name="newProductName" required>

                <span>Description:</span>
                <input type="text" name="newProductDescription">

                <label for="fileSelect">Image:</label>
                <input type="file" name="newProductImage" required>

                <span>Alcohol Content:</span>
                <input type="text" name="newProductPercentage" required>

                <span>Price:</span>
                <input type="text" name="newProductPrice" required>

                <input type="submit" name="add_product_item" value="create">
        </form>
        <form action="/BeerCraftShop/src/modules/database/submit/add.php">
            <input type="submit" class="cancel-btn" value="Cancel">
        </form>
    </div>

    </div>

<?php endif; ?>
<?php if (!$shopConfig->getFastMode()): ?>
    <video autoplay muted loop id="myVideo">
        <source src="/BeerCraftShop/public/resources/videos/beer_bg.mp4" type="video/mp4">
    </video>
<?php endif; ?>
<div class="wavy-overlay" id="wavy-overlay">
    <div class="wave"></div>
    <div class="wave"></div>
    <div class="cover"></div>
</div>
