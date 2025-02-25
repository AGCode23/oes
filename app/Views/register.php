<?php include "partials/header.php" ?>

<section class="register__section">
    <div class="register__center-div">
        <h2>Register</h2>
        <?php if (isset($data["user_error"])): ?>
            <p class="register__error"><?= $data["user_error"] ?></p>
        <?php endif ?>
        <form class="register__form" action="/register" method="POST">
            <input type="text" name="register-name" placeholder="Name">
            <input type="email" name="register-email" placeholder="Email">
            <input type="password" name="register-password" placeholder="Password">
            <input type="password" name="register-confirm-password" placeholder="Confirm Password">
            <button type="submit">Register</button>
        </form>
    </div>
</section>

<?php include "partials/footer.php" ?>