<?php
$act = isset($_GET['action']) ? $_GET['action'] : 'dashboard';
?>
<div id="sidebar-wrapper">
    <div class="sidebar-heading text-white"><i class="fas fa-book-reader me-2"></i>LMS Admin</div>
    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action p-3 <?= $act === 'dashboard' ? 'active' : '' ?>" href="admin.php?action=dashboard">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a class="list-group-item list-group-item-action p-3 <?= strpos($act, 'book-') === 0 ? 'active' : '' ?>" href="admin.php?action=book-list">
            <i class="fas fa-book me-2"></i> Book Management
        </a>
        <a class="list-group-item list-group-item-action p-3" href="#" onclick="return false;" style="cursor: not-allowed; opacity: 0.6;">
            <i class="fas fa-list me-2"></i> Category
        </a>
        <!-- Active nếu action bắt đầu bằng 'borrow' (borrow-list, borrow-requests,...) -->
        <a class="list-group-item list-group-item-action p-3 <?= strpos($act, 'borrow') === 0 ? 'active' : '' ?>" href="admin.php?action=borrow-list">
            <i class="fas fa-exchange-alt me-2"></i> Borrow & Return
        </a>
        <a class="list-group-item list-group-item-action p-3" href="#" onclick="return false;" style="cursor: not-allowed; opacity: 0.6;">
            <i class="fas fa-users me-2"></i> User
        </a>
        <a class="list-group-item list-group-item-action p-3 mt-4" href="index.php?action=logout">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>