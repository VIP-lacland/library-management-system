<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config/config.php';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="<?= asset('css/login.css') ?>">
    <style>
        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }
    </style>
</head>
<body>

<div class="login-container">

    <h2>Reset Password</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <a class="back-link" href="<?= url('index.php?action=forgot-password') ?>">← Thử lại</a>
    <?php else: ?>
        <p class="info-text">
            Please enter your new password
        </p>

        <form method="POST" action="<?= url('index.php?action=reset-password&token=' . htmlspecialchars($token ?? '')) ?>">
            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới" required>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirm Password:</label>
                <input type="password" id="password_confirm" name="password_confirm" placeholder="Xác nhận mật khẩu" required>
            </div>

            <button type="submit">Reset Password</button>
        </form>
        <a class="back-link" href="<?= url('index.php?action=login') ?>">← Go back to Login</a>
    <?php endif; ?>

</div>

</body>
</html>
