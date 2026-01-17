<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/header.css">
    <title>Library Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <!-- Top Header -->
        <div class="header-top">
            <a href="#" class="logo">
                <i class="fa-solid fa-book-open"></i>
                <span>Library System</span>
            </a>

            <div class="search-container">
                <input type="text" class="search-bar" placeholder="Search books, authors, categories...">
                <button class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

            <a href="<?php echo URL_ROOT; ?>/auth">
                <i class="fa-solid fa-right-to-bracket"></i>  Login</a>
        </div>

        <!-- Navigation Bar -->
        <nav>
            <div class="nav-container">
                <button class="menu-toggle" onclick="toggleMenu()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="<?php echo URL_ROOT; ?>/home" class="nav-link">
                            <i class="fa-solid fa-house"></i>Home</a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo URL_ROOT; ?>/books" class="nav-link">
                            <i class="fa-solid fa-book"></i>
                            Books
                            <!-- <i class="fa-solid fa-chevron-down dropdown-arrow"></i> -->
                        </a>
                        <!-- <div class="dropdown-content">
                            <a href="#"><i class="fa-solid fa-list"></i> Book Listing</a>
                            <a href="#"><i class="fa-solid fa-info-circle"></i> Book Details</a>
                        </div> -->
                    </li>

                    <li class="nav-item">
                    <a href="<?php echo URL_ROOT; ?>/borrowing" class="nav-link">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                     My Borrowed Books
                    </a>
                    <div class="dropdown-content">
                    <a href="<?php echo URL_ROOT; ?>/borrowing/requests">
                    <i class="fa-solid fa-paper-plane"></i> Borrow Request
                    </a>
                    <a href="<?php echo URL_ROOT; ?>/borrowing/history">
                    <i class="fa-solid fa-clock-rotate-left"></i> History
                    </a>
                    </div>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo URL_ROOT; ?>/categories" class="nav-link">
                        <i class="fa-solid fa-tags"></i> Categories
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-user-circle"></i>
                            Profile
                            <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <div class="dropdown-content">
                            <a href="<?php echo URL_ROOT; ?>/profile">
                            <i class="fa-solid fa-user"></i> My Profile
                            </a>
                            <a href="<?php echo URL_ROOT; ?>/profile/change_password">
                            <i class="fa-solid fa-key"></i> Change Password
                            </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>


    <script>
        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const navMenu = document.getElementById('navMenu');
            const menuToggle = document.querySelector('.menu-toggle');
            
            if (!event.target.closest('nav') && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
            }
        });

        // Handle dropdown on mobile
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (window.innerWidth <= 992) {
                    if (this.querySelector('.dropdown-content')) {
                        e.preventDefault();
                        this.classList.toggle('active');
                    }
                }
            });
        });
    </script>
</body>
</html>