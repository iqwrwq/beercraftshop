<?php
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/properties/PropertiesController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/DataBaseController.php";

$properties = PropertiesDepControllerDep::getContent($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json");
$dataBaseController = new \BeerCraftShop\src\modules\database\DataBaseControllerDep($properties["db_host"], $properties["db_user"], $properties["db_pwd"], $properties["db_name"]);
$products = $dataBaseController->getAllProducts();
?>

<div class="main-site-wrapper">

    <div class="admin-page" id="adminPage">
        <?php require_once "partials/adminPageNav.php"?>

        <?php require_once "partials/adminGraphs.php"?>

        <div class="content">
            <?php
            echo "<table class='inventory-overview'><tr><th>ID</th><th>Name</th><th>Description</th><th>Img_Url</th><th>Alcohol_content</th><th>Price</th></tr>";
            while ($product = mysqli_fetch_array($products)) {
                echo "<tr class='item-row'><td class='nameField'>" . $product["id"] . "</td><td class='descriptionField'>" . $product["name"] . "</td><td class='priceField'>" . substr($product["description"], 0, 55) . "[...]" . "</td><td class='priceField'>" . $product["img_url"] . "</td><td class='priceField'>" . $product["alcohol_content"] . "</td><td class='priceField'>" . $product["price"] . "</td></tr>";
            }
            echo "<tr class='add-row' id='add-btn'><td colspan=6><i class='fas fa-plus-square' ></i></td></tr></table>";

            ?>
        </div>
    </div>


    <div class="overlay hide" id="overlay"></div>

    <?php require_once "partials/addItemForm.php"?>

    <?php require_once "partials/changeItemForm.php"?>

    <div id="loading-overlay">
        <img id="loading-gif" src="/BeerCraftShop/public/resources/images/loading.gif" alt="funny GIF" width="100%">
    </div>

    <script>
        addRowButton = document.querySelector("#add-btn");
        overlay = document.querySelector("#overlay");
        addItemForm = document.querySelector("#add-item-form");
        addItemInnerForm = document.querySelector("#inner-form");

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
