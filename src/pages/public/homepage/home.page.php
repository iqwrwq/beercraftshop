<?php

use config\ShopConfig;
use modules\database\rows\ShopDataBaseHandler;

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/ShopDataBaseHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/config/ShopConfig.php";

$shopConfig = new ShopConfig();
$shopDataBaseHandler = new ShopDataBaseHandler($shopConfig->getDataBaseConfig());
$products = $shopDataBaseHandler->getAllProducts();
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

                <?php if ($products):
                    while ($product = mysqli_fetch_array($products)):?>
                        <?php require $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages/public/partials/productItem.php" ?>
                    <?php endwhile;endif; ?>
            </div>
        </div>
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages/public/partials/footer.php" ?>
    </div>
</div>