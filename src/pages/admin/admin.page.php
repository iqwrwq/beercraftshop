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

$userTableType = new TableType(TableType::USER_TABLE);
$userTable = $shopDataBaseHandler->getAll($userTableType);
?>

<div class="admin-page-wrapper">

    <nav class="admin-page-nav">
        <a href="/BeerCraftShop/public/" class="admin-logo">
            <img style="height: 50px" id="logo-icon" src="/BeerCraftShop/public/resources/images/logo.png">
        </a>
        <div class="navigation-bar">
            <a class=" navigation-bar--item" href="#">
                <i class="fas fa-user"></i>
                <span class="username">arthur</span>
            </a>
            <a name="logout" type="submit" class="navigation-bar--item logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </nav>

    <section class="upper-section">
        <div class="user-table">
            <div class="table--header table-details">
                <div class="table-name"><span class="title">Users</span></div>
                <div class="table-count"><span class="count"><?php echo $userTable->count() ?></span></div>
            </div>
            <div class="user-table--content">
                <table class="userTable">
                    <thead>
                    <tr>
                        <?php foreach ($userTable->getFormat() as $userHead): ?>
                            <th><?php echo $userHead ?></th>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($userTable->getRows() as $userRow): ?>
                        <tr>
                                <td><?php echo $userRow->getId() ?></td>
                                <td><?php echo $userRow->getFirstName() ?></td>
                                <td><?php echo $userRow->getLastName() ?></td>
                                <td><?php echo $userRow->getEmail() ?></td>
                                <td><?php echo $userRow->getPassword() ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </tr>
                </table>
            </div>
        </div>

        <div class="config-panel">
            <form class="config-panel--item" method="post" action="/BeerCraftShop/src/config/ShopConfig.php">
                <label>deactivate/activate storefront</label>
                <button name="storeFrontToggle" type="submit" class="toggle-btn">
                    <i class="fas fa-toggle-on <?php echo $shopConfig->getIsStoreFrontOpen() ? "on" : "off" ?>"></i>
                </button>
            </form>
            <form class="config-panel--item" action="#">
                <label for="storeFrontToggle">Deny Users</label>
                <button name="storeFrontToggle" type="submit" class="toggle-btn">
                    <i class="fas fa-toggle-on <?php echo false ? "on" : "off" ?>"></i>
                </button>
            </form>
            <form class="config-panel--item" action="#">
                <label for="storeFrontToggle">Translate</label>
                <button name="storeFrontToggle" type="submit" class="toggle-btn">
                    <i class="fas fa-toggle-on <?php echo false ? "on" : "off" ?>"></i>
                </button>
            </form>
            <form class="config-panel--item" action="#">
                <label for="storeFrontToggle">Fast Mode</label>
                <button name="storeFrontToggle" type="submit" class="toggle-btn">
                    <i class="fas fa-toggle-on <?php echo false ? "on" : "off" ?>"></i>
                </button>
            </form>
        </div>
    </section>
    <section class="content-section">
        <div class="table--header table-details">
            <div class="table-name"><span class="title">Products</span></div>
            <button id="add-product-btn" onclick="">
                <i class="fas fa-plus-square"></i>
                <span class="txt">create new product</span>
            </button>
            <div class="table-count"><span class="count"><?php echo $productTable->count() ?></span></div>
        </div>
        <table class="userTable">
            <thead>
            <tr>
                <th></th>
                <?php foreach ($productTable->getFormat() as $productHead): ?>
                    <th><?php echo $productHead ?></th>
                <?php endforeach; ?>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($productTable->getRows() as $productRow): ?>
                <tr>
                    <td><img style="width: 50px; height: 50px"
                             src="/BeerCraftShop/public/resources/images/products/<?php echo $productRow->getImgUrl() ?>.jpg"
                             alt="none"></td>
                    <td><?php echo $productRow->getId() ?></td>
                    <td><?php echo $productRow->getName() ?></td>
                    <td><?php echo $productRow->getDescription() !== "" ? "..." : "none" ?></td>
                    <td><?php echo $productRow->getPrice() ?>€</td>
                    <td><?php echo $productRow->getImgUrl() ?></td>
                    <td><?php echo $productRow->getPercentage() ?>%</td>
                    <td><a href="">edit</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </tr>
        </table>
    </section>

</div>
<div class="hide" id="description-panel"></div>

<div class="overlay hide" id="overlay"></div>

<?php require_once "partials/addItemForm.php" ?>

<?php require_once "partials/changeItemForm.php" ?>

<div id="loading-overlay">
    <img id="loading-gif" src="/BeerCraftShop/public/resources/images/loading.gif" alt="GIF" width="100%">
</div>
<script>
    addRowButton = document.querySelector("#add-btn");
    overlay = document.querySelector("#overlay");
    addItemForm = document.querySelector("#add-item-form");
    addItemInnerForm = document.querySelector("#inner-form");
    descriptionContentData = document.querySelectorAll(".description-content-data")
    viewButtons = document.querySelectorAll(".show-desc-btn");
    descriptionPanel = document.querySelector("#description-panel")

    viewButtons.forEach(element => {
        element.addEventListener("click", () => {
            descriptionPanel.classList.remove("hide");
            overlay.classList.remove("hide");
            window.addEventListener('click', function (e) {
                if (overlay.contains(e.target)) {
                    overlay.classList.add("hide");
                    descriptionPanel.classList.add("hide");
                }
            });
        })
    })

    addRowButton.addEventListener("click", () => {
        addItemForm.classList.remove("hide");
        overlay.classList.remove("hide");
        window.addEventListener('click', function (e) {
            if (overlay.contains(e.target)) {
                addItemInnerForm.reset();
                addItemForm.classList.add("hide");
                overlay.classList.add("hide");
            }
        });
    })
    changeBtn = document.querySelector("#changeBtn");
    changeItemForm = document.querySelector("#change-item-form");
    changeItemInnerForm = document.querySelector("#inner-change-form");
    itemRows = document.querySelectorAll('.item-row');
    itemRows.forEach(element => {
        element.addEventListener("click", () => {
            changeItemForm.classList.remove("hide");
            overlay.classList.remove("hide");
            changeBtn.disabled = true;
            document.querySelector("#oldNameField").value = element.cells[1].innerHTML;
            document.querySelector("#oldDescField").value = element.cells[2].innerHTML;
            document.querySelector("#oldImageField").value = element.cells[3].innerHTML;
            document.querySelector("#oldAlcoholContentField").value = element.cells[4].innerHTML;
            document.querySelector("#oldPriceField").value = element.cells[5].innerHTML;

            document.querySelector("#changeFormNameField").value = element.cells[1].innerHTML;
            document.querySelector("#changeFormDescField").value = element.cells[2].innerHTML;
            document.querySelector("#selectedItemImage").src = "/BeerCraftShop/public/resources/images/products/" + element.cells[3].innerHTML + ".jpg";
            document.querySelector("#changeFormAlcoholContentField").value = element.cells[4].innerHTML;
            document.querySelector("#changeFormPriceField").value = element.cells[5].innerHTML;
            document.querySelector("#changeFormNameField").addEventListener("change", () => {
                unlockChangeButton();
            });
            document.querySelector("#changeFormDescField").addEventListener("change", () => {
                unlockChangeButton()
            });
            document.querySelector("#changeFormImageField").addEventListener("change", () => {
                unlockChangeButton()
            });
            document.querySelector("#changeFormAlcoholContentField").addEventListener("change", () => {
                unlockChangeButton()
            });
            document.querySelector("#changeFormPriceField").addEventListener("change", () => {
                unlockChangeButton();
            });


            window.addEventListener('click', function (e) {
                if (overlay.contains(e.target)) {
                    changeItemInnerForm.reset();
                    changeItemForm.classList.add("hide");
                    overlay.classList.add("hide");
                }
            });
        })
    });

    function unlockChangeButton() {
        changeBtn.disabled = false;
    }

    function displayLoadingOverlay() {
        document.querySelector("#loading-overlay").style.display = "grid";
    }
</script>

</div>
