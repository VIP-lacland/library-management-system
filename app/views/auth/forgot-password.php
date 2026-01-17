<!DOCTYPE html>
<html>
<head>
    <title>Quên Mật Khẩu</title>
    <link rel="stylesheet" href="<?= URL_ROOT ?>/css/login.css">
    <style>
        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="login-container">

    <h2>Quên Mật Khẩu</h2>

    <p class="info-text">
        Nhập địa chỉ email của bạn và chúng tôi sẽ giúp bạn đặt lại mật khẩu.
    </p>

    <?php if (!empty($message)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= URL_ROOT ?>/forgot-password">
        <input type="email" name="email" placeholder="Nhập địa chỉ email của bạn" required>
        <button type="submit">Gửi Liên Kết Đặt Lại</button>
    </form>

    <a class="back-link" href="<?= URL_ROOT ?>/auth">← Quay lại Đăng Nhập</a>

</div>

</body>
</html>
