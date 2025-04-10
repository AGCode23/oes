<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoremSU</title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/ViewsCSS/login.css">
</head>

<body>
    <section class="login__section">
        <div class="login__left-side">

            <div class="login__center-div">
                <div class="login__logo">
                    <img src="/assets/LIU-Logo.svg" alt="School logo">
                    <p>Lorem Ipsum University</p>
                </div>
                <p class="login__login-text">Account Login</p>
                <?php if (isset($data["user_error"])): ?>
                    <p class="login__error"><?= $data["user_error"] ?></p>
                <?php endif ?>
                <form class="login__form" action="/login" method="POST">
                    <input class="login-input-form" type="email" name="login-email" placeholder="Email" value="<?php echo isset($data['user_email']) ? htmlspecialchars($data['user_email']) : ''; ?>">
                    <input class="login-input-form" type="password" name="login-password" placeholder="Password">
                    <div class="login__form-account-info">
                        <label>
                            <input type="checkbox" name="login-remember-me">Remember Account
                        </label>
                        <a href="/forgot">Forgot Account?</a>
                    </div>
                    <button type="submit">Login</button>
                </form>
                <p>Don't have an account?</p>
                <a class="login__form login__signup-button" href="/register">
                    <div>Sign Up</div>
                </a>
            </div>
            <p class="developer-of-web">© <?= date('Y') ?> AGCODE. All rights reserved.</p>
        </div>
        <div class="login__right-side"></div>
    </section>
</body>

</html>