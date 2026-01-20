<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config/config.php';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="<?= asset('css/login.css') ?>">
</head>
<body>

<div class="login-container">

    <h2>Forgot Password</h2>

    <p class="info-text">
        Enter your email address and we'll help you reset your password.
    </p>

    <?php if (!empty($message)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= url('index.php?action=forgot-password') ?>">
        <input type="email" name="email" placeholder="Nhập địa chỉ email của bạn" required>
        <button type="submit">Send Reset Link</button>
    </form>

    <a class="back-link" href="<?= url('index.php?action=login') ?>">← Go back to Login</a>

</div>

</body>
</html>
