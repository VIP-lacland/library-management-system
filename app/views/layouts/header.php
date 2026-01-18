<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config/config.php';
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= asset('css/header.css') ?>">
    <title>Library Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <!-- Top Header -->
        <div class="header-top">
            <a href="<?= url('index.php?action=index') ?>" class="logo">
                <i class="fa-solid fa-book-open"></i>
                <span>Library System</span>
            </a>

            <div class="search-container">
                <input type="text" class="search-bar" placeholder="Search books, authors, categories...">
                <button class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-menu">
                    <span class="username">
                        <i class="fa-solid fa-user"></i>
                        Hello, <?= htmlspecialchars($_SESSION['username'] ?? '') ?>
                    </span>
                    <a href="<?= url('index.php?action=logout') ?>" class="logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </a>
                </div>
            <?php else: ?>
                <a href="<?= url('index.php?action=login') ?>" class="login-btn">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Login
                </a>
            <?php endif; ?>
        </div>

        <!-- Navigation Bar -->
        <nav>
            <div class="nav-container">
                <button class="menu-toggle" onclick="toggleMenu()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="<?= url('index.php?action=index') ?>" class="nav-link">
                            <i class="fa-solid fa-house"></i>
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= url('index.php?action=index') ?>" class="nav-link">
                            <i class="fa-solid fa-book"></i>
                            Books
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= url('index.php?action=index') ?>" class="nav-link">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                            My Borrowed Books
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= url('index.php?action=index') ?>" class="nav-link">
                            <i class="fa-solid fa-tags"></i>
                            Categories
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-user-circle"></i>
                            Profile
                            <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <div class="dropdown-content">
                            <a href="<?= url('index.php?action=index') ?>"><i class="fa-solid fa-user"></i> My Profile</a>
                            <a href="<?= url('index.php?action=change-password') ?>"><i class="fa-solid fa-key"></i> Change Password</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

