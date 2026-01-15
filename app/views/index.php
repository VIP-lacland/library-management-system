<?php
require_once __DIR__ . '/../config/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page - Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/header.css">
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/footer.css">
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/home.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #f5f5f5;
        }

        main {
            flex: 1;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <header>
        <!-- Top Header -->
        <div class="header-top">
            <a href="<?php echo URL_ROOT; ?>/?url=book/index" class="logo">
                <i class="fa-solid fa-book-open"></i>
                <span>Library System</span>
            </a>

            <div class="search-container">
                <input type="text" class="search-bar" placeholder="Search books, authors, categories...">
                <button class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

            <a href="#" class="login-btn">
                <i class="fa-solid fa-right-to-bracket"></i>
                Login
            </a>
        </div>

        <!-- Navigation Bar -->
        <nav>
            <div class="nav-container">
                <button class="menu-toggle" onclick="toggleMenu()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="<?php echo URL_ROOT; ?>/?url=book/index" class="nav-link">
                            <i class="fa-solid fa-house"></i>
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo URL_ROOT; ?>/?url=book/index" class="nav-link">
                            <i class="fa-solid fa-book"></i>
                            Books
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-user-circle"></i>
                            Profile
                            <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <div class="dropdown-content">
                            <a href="#"><i class="fa-solid fa-user"></i> My Profile</a>
                            <a href="#"><i class="fa-solid fa-key"></i> Change Password</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="row g-4 mt-3">
            <?php if (isset($books) && !empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <div class="col-md-3">
                        <div class="card h-100 shadow-sm border-0">

                            <div class="card-img-container">
                                <img src="<?= $book["url"] ?>" class="card-img-top" alt="Book cover">
                            </div>

                            <div class="card-body d-flex flex-column">
                                <div class="card-content-box">
                                    <h5 class="card-title"><?= htmlspecialchars($book["title"]) ?></h5>
                                    <p class="card-author">Author: <?= htmlspecialchars($book["author"]) ?></p>
                                </div>

                                <div class="mt-auto">
                                    <a href="<?php echo URL_ROOT; ?>/?url=book/detail/<?php echo $book['book_id']; ?>" class="btn btn-primary w-100">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">There are no books in the library.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </main>

    <footer>
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2024 Library Management System. All rights reserved.</p>
            <p>Library Management System - Developed by Your Team</p>
            
            <div class="social-links">
                <a href="#" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" title="Twitter"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#" title="Email"><i class="fa-solid fa-envelope"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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