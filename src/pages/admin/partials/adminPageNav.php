<nav class="admin-nav">
    <a href="/BeerCraftShop/public/admin" class="logo-container">
        <img id="logo-icon" style="max-width: 100px; max-height: 100px"
             src="/BeerCraftShop/public/resources/images/logo.png">
        <span>/ADMIN</span>
    </a>
    <span class="status tooltip">
            <form action="/BeerCraftShop/src/modules/install/Authorizer.php" method="POST">
                <button type="submit" name="toggleStorefront" onclick="displayLoadingOverlay()"
                        class="fas fa-power-off current-<?php echo $properties["storefront"] === "on" ? "on" : "off" ?>
                " id="onOff-btn"></button>
                <span class="tooltiptext"><span style="color:red">OFF</span>/<span
                        style="color:lime">ON</span> STOREFRONT</span>
            </span>
    </form>
</nav>