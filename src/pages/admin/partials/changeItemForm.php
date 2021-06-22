<div class="change-item-form hide" id="change-item-form">
    <form action="/BeerCraftShop/src/modules/database/DataBaseController.php" method="POST" id="inner-change-form" enctype="multipart/form-data">
        <div class="change-form-header">
                <span>
                    <span class="tc-highlight">CHANGE</span> or <span
                        style="color:red">DELETE</span> your <span>ITEM</span>
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