<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="<?= URL_ROOT ?>/css/login.css">
</head>
<body>

<div class="login-container">

<h2>User Login</h2>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?= $_SESSION['error']; ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form method="POST" action="<?= URL_ROOT ?>/auth/login">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<a href="<?= URL_ROOT ?>/forgot-password">Forgot Password?</a>



</div>

</body>
</html>
