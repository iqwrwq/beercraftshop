<nav class="admin-page-nav">
    <a href="/BeerCraftShop/public/admin" class="admin-logo">
        <img style="height: 50px" id="logo-icon" src="/BeerCraftShop/public/resources/images/logo.png">
    </a>
    <div class="navigation-bar">
        <form action="/BeerCraftShop/public/admin" method="post">
            <button type="submit" class=" navigation-bar--item" href="#" onclick="return">
                <i class="fas fa-user"></i>
                <span class="username">User</span>
            </button>
        </form>
        <form action="/BeerCraftShop/src/modules/install/Authorizer.php" method="post">
            <button type="submit" name="logout" type="submit" class="navigation-bar--item logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</nav>