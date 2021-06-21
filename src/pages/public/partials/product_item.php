<div class="item-chart">
    <div class="item-head-show">
        <img src="/BeerCraftShop/public/resources/images/products/<?php echo $product['img_url'] ?>.jpg"
             alt="oops">
        <span class="item-prz"><?php echo $product["alcohol_content"] ?>%</span>
        <div class="item-buying-info">
            <h1 class="item-name"><?php echo $product["name"] ?></h1>
            <p class="item-price"><?php echo $product["price"] ?>€</p>
        </div>
    </div>
    <span class="item-text"><?php echo $product["description"] ?></span>
    <input class="item-card-btn" type="button" value="Add">
</div>