<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="<?= url('public/css/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">

    <div class="sidebar">
        <h2>ADMIN</h2>
        <a href="<?= url('admin.php?action=dashboard') ?>"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="<?= url('admin.php?action=admin-books') ?>"><i class="fas fa-book"></i> Book Management</a>
        <a href="<?= url('admin.php?action=categories') ?>"><i class="fas fa-tags"></i> Categories Management</a>
        <a href="<?= url('admin.php?action=borrowings') ?>"><i class="fas fa-shopping-cart"></i> Order books to borrow</a>
        <a href="<?= url('admin.php?action=users') ?>"><i class="fas fa-users"></i> User Management</a>
        
        <hr style="border: 0.5px solid #4a5568; margin: 20px 0;">
        <a href="<?= url('index.php?action=logout') ?>" style="color: #feb2b2;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <?php 
        /**
         * LƯU Ý: Trong hàm $this->view() của nhóm trưởng, 
         * nội dung thường được render và lưu vào biến $content.
         * Nếu anh ấy dùng render trực tiếp thì chỉ cần để layout thế này.
         */
        if (isset($content)) {
            echo $content;
        } elseif (isset($viewFile)) {
            // Backup nếu hệ thống cũ của bạn vẫn dùng $viewFile
            include $viewFile;
        }
        ?>
    </div>

</div>

</body>
</html>