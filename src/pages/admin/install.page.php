<div class="install-page">
    <?php
        session_start();
        if (isset($_SESSION['INSTALL_ERROR'])):
    ?>
    <div class="isa_error">
        <i class="fa fa-times-circle"></i>
        <?php echo $_SESSION['INSTALL_ERROR'] ?>
    </div>
    <?php
        endif;
        unset($_SESSION['INSTALL_ERROR']);
    ?>
    <form action="/BeerCraftShop/src/modules/install/Installer.php"
          method="post" onsubmit="resetBody()">
        <div class="install-database-form ">
            <h3>
                Connect to Database
                <i class="fas fa-database tc-highlight"></i>
            </h3>
            <small class="top-description">
                Enter your connection data to connect to your database,
                we suggest you read the documentation of your host-service if you have no
                idea how to connect.
            </small>
            <div class="input-area">
                <label for="host_input">Host</label>
                <input type="text" id="host_input" name="host_input" placeholder="localhost">
                <label for="db_user_input">User</label>
                <input type="text" id="db_user_input" name="db_user_input" placeholder="root">
                <label for="db_pwd_input">Password</label>
                <input type="password" id="db_pwd_input" name="db_pwd_input">
                <div class="demo-data-space">
                    <label for="demo_data">insert demo data ? (recommended)</label>
                    <input name="demo_data" id="demo_data" type="checkbox" checked>
                </div>
                <input type="button" value="Continue" name="db_button" id="continue-install-form">
            </div>
        </div>
        <div class="setup-user-form hide" id="setup-user-form">
            <h3>
                Create a User
                <i class="fas fa-user tc-highlight"></i>
            </h3>
            <small class="top-description">
                Create a shop administrator (this might be you). Enter a safe Password and repeat
                it to proceed. Choose a password with at least 6 digits.
            </small>
            <div class="input-area">
                <label for="user_input">Username</label>
                <input type="text" id="user_input" name="user_input" required>
                <label for="pwd_input">Password</label>
                <input type="password" id="pwd_input" name="pwd_input" required>
                <label for="pwd_confirm_input">Confirm Password</label>
                <input type="password" name="pwd_confirm_input" id="pwd_confirm_input" required>
                <input type="submit" value="Install" name="install_db" id="install_db_btn" onclick="displayLoadingOverlay()">
            </div>
        </div>
    </form>
</div>

<video autoplay muted loop id="myVideo">
    <source src="/BeerCraftShop/public/resources/videos/beer_bg.mp4" type="video/mp4">
</video>

<div class="wavy-overlay" id="wavy-overlay">
    <div class="wave"></div>
    <div class="wave"></div>
    <div class="cover"></div>
</div>

<div id="loading-overlay">
    <img id="loading-gif" src="/BeerCraftShop/public/resources/images/loading.gif" alt="funny GIF" width="100%">
</div>

<script>
    function displayLoadingOverlay() {
        document.querySelector("#loading-overlay").style.display = "grid";
    }
</script>
<script src="/BeerCraftShop/public/js/wavyOverlay.js"></script>