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

    <?php require_once "partials/adminPageNav.php" ?>

    <section class="upper-section">
        <div class="user-table">
            <div class="table--header table-details">
                <div class="table-name"><span class="title">Users</span></div>
                <div class="table-count"><span class="count"><?php echo $userTable->count() ?></span></div>
            </div>
            <div class="user-table--content">
                <table class="tableTemplate userTable">
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
                            <td><?php echo $userRow->getPassword() !== null ? "true" : "false" ?></td>
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
            <form class="config-panel--item" method="post" action="/BeerCraftShop/src/config/ShopConfig.php">
                <label>Fast Modus</label>
                <button name="fastModeToggle" type="submit" class="toggle-btn">
                    <i class="fas fa-toggle-on <?php echo $shopConfig->getFastMode() ? "on" : "off" ?>"></i>
                </button>
            </form>
        </div>
    </section>


    <section class="content-section">
        <div class="table--header table-details">
            <div class="table-name"><span class="title">Products</span></div>
            <button id="add-product-btn"
                    onclick="window.location='/BeerCraftShop/public/admin/edit.php'">
                <i class="fas fa-plus-square"></i>
                <span class="txt">create new product</span>
            </button>
            <div class="table-count"><span class="count"><?php echo $productTable->count() ?></span></div>
        </div>
        <table class="tableTemplate productsTable">
            <thead>
            <tr>
                <th></th>
                <?php foreach ($productTable->getFormat() as $productHead): ?>
                    <th><?php echo $productHead ?></th>
                <?php endforeach; ?>
                <th></th>
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
                    <td>
                        <button id="edit-product-btn"
                                onclick="window.location='/BeerCraftShop/public/admin/edit.php?id=<?php echo $productRow->getId() ?>'">
                            <i class="fas fa-edit"></i>
                            <span class="txt">Edit</span>
                        </button>
                    </td>
                    <td>
                        <button id="delete-product-btn"
                                onclick="window.location='/BeerCraftShop/public/admin/delete.php?id=<?php echo $productRow->getId() ?>'">
                            <i class="fas fa-trash-alt"></i>
                            <span class="txt">Delete</span>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </tr>
        </table>
    </section>

</div>



