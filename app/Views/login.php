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
        <div class="login__form-container" id="login__form-container">
            <!-- Login form -->
            <div class="login__form-sub" id="login__login-form">
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
                    <div class="login__switch" onclick="toggleForm()">
                        <p class="login__account-info">Don't have an account? <span>Register</span></p>
                    </div>
                </div>
                <p class="developer-of-web">© <?= date('Y') ?> AGCODE. All rights reserved.</p>
            </div>

            <!-- Register form -->
            <div class="login__form-sub" id="login__register-form" style="display: none;">
                <div class="login__center-div">
                    <div class="login__logo">
                        <img src="/assets/LIU-Logo.svg" alt="School logo">
                        <p>Lorem Ipsum University</p>
                    </div>
                    <p class="login__login-text">Account Creation</p>
                    <?php if (isset($data["user_error"])): ?>
                        <p class="login__error"><?= $data["user_error"] ?></p>
                    <?php endif ?>
                    <form class="login__form" action="/register" method="POST">
                        <input class="login-input-form" type="text" name="register-name" placeholder="Fullname" value="<?php echo isset($data['user_name_register']) ? htmlspecialchars($data['user_name_register']) : ''; ?>">
                        <input class="login-input-form" type="email" name="register-email" placeholder="Email" value="<?php echo isset($data['user_email_register']) ? htmlspecialchars($data['user_email_register']) : ''; ?>">
                        <div class="gender-dob">
                            <div class="gender-container">
                                <input class="login-gender-form" type="radio" name="register-gender" value="male">
                                <label>Male</label>
                                <input class="login-gender-form" type="radio" name="register-gender" value="female">
                                <label>Female</label>
                            </div>
                            <div class="dob-container">
                                <input class="login-dob-form" type="date" name="register-dob" max="<?= date('Y-m-d') ?>">
                            </div>

                        </div>
                        <input class="login-input-form" type="password" name="register-password" placeholder="Password">
                        <input class="login-input-form" type="password" name="register-confirm-password" placeholder="Confirm Password">
                        <button type="submit">Register</button>
                    </form>
                    <div class="login__switch" onclick="toggleForm()">
                        <p class="login__account-info">Already have an account? <span>Login</span></p>
                    </div>

                </div>
                <p class="developer-of-web">© <?= date('Y') ?> AGCODE. All rights reserved.</p>
            </div>
        </div>


        <div class="login__image-container" id="login__image-container"></div>
    </section>
    <script src="/js/login.js"></script>
</body>

</html>