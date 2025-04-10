<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoremSU</title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/ViewsCSS/register.css">
</head>

<body>
    <section class="register__section">
        <div class="register__center-div">
            <h2>Account Creation</h2>
            <?php if (isset($data["user_error"])): ?>
                <p class="register__error"><?= $data["user_error"] ?></p>
            <?php endif ?>
            <form class="register__form" action="/register" method="POST">
                <input type="text" name="register-name" placeholder="Full Name">
                <input type="email" name="register-email" placeholder="Email">
                <input type="password" name="register-password" placeholder="Password">
                <input type="password" name="register-confirm-password" placeholder="Confirm Password">
                <button type="submit">Register</button>
            </form>
        </div>
    </section>
</body>

</html>