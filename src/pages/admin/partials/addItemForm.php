<div class="add-item-form hide" id="add-item-form">
    <form action="/BeerCraftShop/src/modules/database/DataBaseController.php" method="POST" id="inner-form" enctype="multipart/form-data">
        <div class="form-header">
            <i class="fas fa-beer"></i>
            <span>
                    Create an item in your <span class="tc-highlight">database</span>
                </span>
        </div>
        <div class="form-content">
            <span>Name:</span>
            <input type="text" name="addItemName" required>

            <span>Description:(desc.txt)</span>
            <input type="file" name="addItemDescription" required>

            <label for="fileSelect">Image:</label>
            <input type="file" name="addItemImage" required>

            <span>Alcohol Content:</span>
            <input type="text" name="addItemAlcoholContent" required>

            <span>Price:</span>
            <input type="text" name="addItemPrice" required>

            <input type="submit" value="create">

            <button>Cancel</button>
        </div>
    </form>
</div>