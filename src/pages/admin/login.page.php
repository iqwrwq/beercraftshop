<div class="login-page">
    <div class="login-form">
        <h3><i class="fas fa-sign-in-alt tc-highlight"></i> Login to <span class="tc-highlight">BEERCRAFT </span></h3>
        <hr>
    </div>
    <div class="form-errors">
         <span class="error-text">

         </span>
    </div>
    <form action="/BeerCraftShop/src/modules/install/Authorizer.php" method="post">
        <div class="input-area">
            <label for="">Username</label>
            <input type="text" name="loginUser" required>
            <label for="">Password</label>
            <input type="password" name="loginPassword" required>
            <div class="remember-me">
                <label for="remember-user-field">Remember Me</label>
                <input type="checkbox" name="remember-user" id="remember-user-field">
            </div>

            <input type="submit" value="Login" name="loginRequest">
        </div>
    </form>
</div>

<div class="wavy-overlay" id="wavy-overlay">
    <div class="wave"></div>
    <div class="wave"></div>
    <div class="cover"></div>
</div>

<script src="/BeerCraftShop/public/js/wavyOverlay.js"></script>