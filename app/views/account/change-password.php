<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config/config.php';
}
require_once __DIR__ . '/../layouts/header.php';
?>

<link rel="stylesheet" href="<?= asset('css/auth.css') ?>">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Change Password</h4>
                </div>

                <div class="card-body">
                    <?php if (isset($_SESSION['flash']['success'])): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['flash']['success']); ?>
                        </div>
                        <?php unset($_SESSION['flash']['success']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['flash']['errors'])): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($_SESSION['flash']['errors'] as $error): ?>
                                    <li><?= htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php unset($_SESSION['flash']['errors']); ?>
                    <?php endif; ?>
                </div>

                <form method="POST" action="<?= url('index.php?action=change-password') ?>">
                    <div class="input_box">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>

                    <div class="input_box">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required>
                        <small>Password must be at least 8 characters long.</small>
                    </div>

                    <div class="input_box">
                        <label for="confirm_new_password">Confirm New Password</label>
                        <input type="password" id="confirm_new_password" name="confirm_new_password" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
