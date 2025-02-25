<?php include "partials/header.php" ?>

<section class="login__section">
    <div class="login__center-div">
        <h2>Login</h2>
        <?php if (isset($data["user_error"])): ?>
            <p class="login__error"><?= $data["user_error"] ?></p>
        <?php endif ?>
        <form class="login__form" action="/login" method="POST">
            <input type="email" name="login-email" placeholder="Email" value="<?php echo isset($data['user_email']) ? htmlspecialchars($data['user_email']) : ''; ?>">
            <input type="password" name="login-password" placeholder="Password">
            <button type="submit">Login</button>
        </form>
    </div>
</section>

<?php include "partials/footer.php" ?>