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
$productTable = $shopDataBaseHandler->getAll($productTableType);

?>
<div class="main-site-wrapper">
    <div class="content">
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages/public/partials/header.php" ?>
        <div class="lading-page">
            <img class="page-wallpaper" src="/BeerCraftShop/public/resources/images/landing_image.jpg"
                 alt="oops">
            <div class="content-text-box">
                <div class="content-text-header">
                    10 deutsche Craft-Biere, die Du probiert haben solltest
                </div>
                <div class="content-text">
                    Bier ist nicht gleich Bier, das d&uuml;rfte mittlerweile den meisten klar sein.<br> Einige
                    Brauereien schaffen es einfach besser als
                    andere, herrliche Bierkompositionen aus Basis-, Karamell- und R&ouml;stmalzen, Bitter- und
                    Aromahopfen und sogar Zutaten wie
                    Fr&uuml;chten, N&uuml;ssen und Kr&auml;utern aus dem Braukessel zu stampfen. Wir haben einige
                    handwerklich gebraute Biere aus
                    Deutschland f&uuml;r Euch zusammengestellt, die Ihrem Genre den Weg weisen - und die jeder einmal
                    getrunken haben sollte!
                </div>
            </div>
            <div class="item-showcase">

                <?php if ($productTable):
                    foreach ($productTable->getRows() as $productRow):?>
                        <div class="item-chart">
                            <div class="item-head-show">
                                <img src="/BeerCraftShop/public/resources/images/products/<?php echo $productRow->getImgUrl() ?>.jpg"
                                     alt="oops">
                                <span class="item-prz"><?php echo $productRow->getPercentage() ?>%</span>
                                <div class="item-buying-info">
                                    <h1 class="item-name"><?php echo $productRow->getName() ?></h1>
                                    <p class="item-price"><?php echo $productRow->getPrice() ?>€</p>
                                </div>
                            </div>
                            <span class="item-text"><?php echo $productRow->getDescription() ?></span>
                            <input class="item-card-btn" type="button" value="Add">
                        </div>
                    <?php endforeach;endif; ?>
            </div>
        </div>
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages/public/partials/footer.php" ?>
    </div>
</div>