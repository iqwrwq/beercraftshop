<?php
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/properties/PropertiesController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/database/DataBaseController.php";

$properties = PropertiesController::getContent($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json");
$dataBaseController = new \BeerCraftShop\src\modules\database\DataBaseController($properties["db_host"], $properties["db_user"], $properties["db_pwd"], $properties["db_name"]);
$products = $dataBaseController->getAllProducts();
?>

<div class="main-site-wrapper">

    <div class="admin-page" id="adminPage">
        <nav class="admin-nav">
            <div class="logo">
                <i class="fas fa-beer"></i>
                <span>-ADMIN</span>
            </div>
            <span class="status tooltip">
            <form action="/BeerCraftShop/src/modules/install/Authorizer.php" method="POST">
                <button type="submit" name="toggleStorefront" onclick="displayLoadingOverlay()" class="fas fa-power-off current-<?php echo $properties["storefront"] === "on" ? "on": "off"?>
                " id="onOff-btn"></button>
                <span class="tooltiptext"><span style="color:red">OFF</span>/<span
                            style="color:lime">ON</span> STOREFRONT</span>
            </span>
            </form>
        </nav>
        <div class="graphs">
            <dl id="first-graph">
                <dt>
                    Bestellungen 2021
                </dt>
                <!-- KEINE FUNKTION -->
                <dd class="percentage percentage-50"><span class="text">Januar: 50</span></dd>
                <dd class="percentage percentage-49"><span class="text">Februar: 49</span></dd>
                <dd class="percentage percentage-25"><span class="text">März: 25</span></dd>
                <dd class="percentage percentage-27"><span class="text">April: 27</span></dd>
                <dd class="percentage percentage-2"><span class="text">Mai: 2</span></dd>
                <dd class="percentage percentage-1"><span class="text">Juni: 0</span></dd>
            </dl>
            <dl id="second-graph">
                <dt>
                    Seitenbesuche 2021
                </dt>
                <!-- KEINE FUNKTION -->
                <dd class="percentage percentage-98"><span class="text">Januar: 5842</span></dd>
                <dd class="percentage percentage-79"><span class="text">Februar: 3451</span></dd>
                <dd class="percentage percentage-30"><span class="text">März: 1250</span></dd>
                <dd class="percentage percentage-44"><span class="text">April: 2349</span></dd>
                <dd class="percentage percentage-22"><span class="text">Mai: 1258</span></dd>
                <dd class="percentage percentage-19"><span class="text">Juni: 1130</span></dd>
            </dl>
        </div>
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

    <div class="add-item-form hide" id="add-item-form">
        <form action="/BeerCraftShop/src/modules/database/DataBaseController.php" method="POST" id="inner-form">
            <div class="form-header">
                <i class="fas fa-beer"></i>
                <span>
                    Create an item in your <span class="tc-highlight">database</span>
                </span>
            </div>
<!--            <div class="form-content">-->
<!--                <span>Name:</span>-->
<!--                <input type="text" name="addItemName" required>-->
<!--                <span>Description:</span>-->
<!--                <input type="text" name="addItemDescription" required>-->
                <label for="fileSelect">Filename:</label>
                <input type="file" name="photo" id="fileSelect">
<!--                <span>Alcohol Content:</span>-->
<!--                <input type="text" name="addItemAlcoholContent" required>-->
<!--                <span>Price:</span>-->
<!--                <input type="text" name="addItemPrice" required>-->


<!--                <span></span>-->
                <input type="submit" value="create">
            </div>
        </form>
    </div>

    <div class="change-item-form hide" id="change-item-form">
        <form action="/BeerCraftShop/src/modules/database/DataBaseController.php" method="POST" id="inner-change-form">
            <div class="change-form-header">
                <span>
                    <span class="tc-highlight">CHANGE</span> or <span style="color:red">DELETE</span> your <span>ITEM</span>
                </span>
            </div>
            <div class="change-form-content">

                <input name="oldNameField" id="oldNameField" class="hide" type="text">
                <input name="oldDescField" id="oldDescField" class="hide" type="text">
                <input name="oldImageField" id="oldImageField" class="hide" type="text">
                <input name="oldAlcoholContentField" id="oldAlcoholContentField" class="hide" type="text">
                <input name="oldPriceField" id="oldPriceField" class="hide" type="text">

                <input type="file" name="changeFormImageField" id="changeFormImageField" value="change">
                <img src="" id="selectedItemImage">
                <span>Name:</span>
                <input id="changeFormNameField" type="text" name="changeItemName" required>
                <span>Description:</span>
                <input id="changeFormDescField" type="text" name="changeItemDescription" required>
                <span>Alcohol Content:</span>
                <input id="changeFormAlcoholContentField" type="text" name="changeItemAlcoholContent" required>
                <span>Price:</span>
                <input id="changeFormPriceField" type="text" name="changeItemPrice" required>
                <input name="change" class="change-btn" id="changeBtn" type="submit" value="CHANGE" disabled>
                <input name="delete" class="delete-btn" type="submit" value="DELETE ITEM">
            </div>
        </form>
    </div>

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
