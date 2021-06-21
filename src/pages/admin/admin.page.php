<?php

use BeerCraftShop\src\modules\database\DataBaseController;

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/properties/PropertiesController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/DataBaseController.php";

$properties = PropertiesController::getContent($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json");
$dataBaseController = new DataBaseController($properties["db_host"], $properties["db_user"], $properties["db_pwd"], $properties["db_name"]);
$products = $dataBaseController->getAllProducts();

?>

<div class="admin-page-wrapper">
    <div class="admin-configurator">
        <form action="/BeerCraftShop/src/modules/install/Authorizer.php" method="POST">
        <span class="status tooltip">
            <button type="submit" name="toggleStorefront" onclick="displayLoadingOverlay()"
                    class="fas fa-power-off current-<?php echo $properties["storefront"] === "on" ? "on" : "off" ?>
                " id="onOff-btn"></button>
            <span class="tooltiptext"><span style="color:red">OFF</span>/<span
                        style="color:lime">ON</span> STOREFRONT</span>
        </span>
        </form>
    </div>
    <div class="product-table-content">
        <div class="table">
            <div class="table-header">
                <div class="header__item"><a id="product_id" class="filter__link" href="#">ID</a></div>
                <div class="header__item"><a id="product_name" class="filter__link filter__link--number"
                                             href="#">Name</a></div>
                <div class="header__item"><a id="product_description" class="filter__link filter__link--number"
                                             href="#">Description</a>
                </div>
                <div class="header__item"><a id="product_alcohol_content" class="filter__link filter__link--number"
                                             href="#">Alcohol_content</a>
                </div>
                <div class="header__item"><a id="product_price" class="filter__link filter__link--number"
                                             href="#">Price</a>
                </div>
                <div class="header__item"><a id="product_image" class="filter__link filter__link--number" href="#">Image_url</a>
                </div>
            </div>
            <div class="table-content">
                <?php foreach ($products as $product): ?>
                    <div class="table-row">
                        <div class="table-data"><?php echo $product["id"] ?></div>
                        <div class="table-data"><?php echo $product["name"] ?></div>
                        <div class="table-data"><?php echo substr($product["description"], 0, 55) ?>...</div>
                        <div class="table-data"><?php echo $product["alcohol_content"] ?></div>
                        <div class="table-data"><?php echo $product["price"] ?></div>
                        <div class="table-data"><?php echo $product["img_url"] ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <button id="newItemButton" onclick="toggleNewItemForm()">New</button>
</div>

<div class="form-create-container hide">
    <form id="create-item-form" action="/BeerCraftShop/src/modules/database/DataBaseController.php" method="post"  enctype="multipart/form-data">
        <label for="new_product_image_field">Image:</label>
        <input type="file" id="new_product_image_field" name="new_product_image">
        <label for="new_product_name_field">Name:</label>
        <input type="text" id="new_product_name_field" name="new_product_name" required>
        <label for="new_product_alcoholContent_field">Alcohol Content:</label>
        <input type="number" id="new_product_alcoholContent_field" name="new_product_alcoholContent"
               min="1" max="100" step="0.1">
        <label for="new_product_price_field">Price:</label>
        <input type="number" id="new_product_price_field" name="new_product_price"
               min="0" step="0.1">
        <label for="new_product_description_field">Description</label>
        <textarea name="new_product_description" id="new_product_description_field" cols="30" rows="10" required></textarea>
        <input type="submit" value="Create" id="create_new_product_button" name="create_new_product">
    </form>
    <div class="overlay hide" id="overlay"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.slim.js"
        integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY="
        crossorigin="anonymous"></script>
<script src="/BeerCraftShop/public/js/tableSorting.js"></script>
<script src="/BeerCraftShop/public/js/adminTogglers.js"></script>
<script>
    createItem = document.querySelector("#create-item-form");

    function toggleNewItemForm(){
        createItem.parentElement.classList.remove("hide");
        window.addEventListener('click', function (e) {
            if (overlay.contains(e.target)) {
                createItem.reset();
                createItem.parentElement.classList.add("hide");
            }
        });
    }
</script>
