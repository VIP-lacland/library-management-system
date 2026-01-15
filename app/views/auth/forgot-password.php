<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="<?= URL_ROOT ?>/css/login.css">
</head>
<body>

<div class="login-container">

    <h2>Forgot Password</h2>

    <p class="info-text">
        Enter your email address and we will help you reset your password.
    </p>

    <form method="POST" action="#">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send Reset Link</button>
    </form>

    <a class="back-link" href="<?= URL_ROOT ?>/auth">← Back to Login</a>

</div>

</body>
</html>
