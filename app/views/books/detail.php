<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/header.css">
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/footer.css">
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
            max-width: 900px;
            margin: 0 auto;
        }

        .book-detail {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .book-header {
            border-bottom: 2px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .book-header h1 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-weight: bold;
        }

        .author {
            color: #666;
            font-size: 16px;
            margin: 0;
        }

        .info {
            display: flex;
            margin: 15px 0;
            padding: 10px 0;
        }

        .info strong {
            min-width: 150px;
            color: #333;
        }

        .info span, .info a {
            color: #666;
        }

        .info a {
            text-decoration: none;
            color: #667eea;
        }

        .info a:hover {
            text-decoration: underline;
        }

        .description {
            line-height: 1.6;
            color: #555;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            border-radius: 4px;
        }

        .status {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #ddd;
        }

        .status h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .status-list {
            list-style: none;
            padding: 0;
        }

        .status-list li {
            background: #f8f9fa;
            padding: 12px;
            margin: 8px 0;
            border-radius: 4px;
            border-left: 4px solid #667eea;
        }

        .btn-group {
            margin-top: 30px;
            text-align: center;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background-color: #5568d3;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            color: white;
        }

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            <div class="book-detail">
        <?php if ($book): ?>
            <div class="book-header">
                <h1><?php echo htmlspecialchars($book['title']); ?></h1>
                <p class="author">
                    <strong>Tác giả:</strong> <?php echo htmlspecialchars($book['author']); ?>
                </p>
            </div>

            <div class="book-info">
                <div class="info">
                    <strong>Thể loại:</strong>
                    <span><?php echo htmlspecialchars($book['category_name'] ?? 'N/A'); ?></span>
                </div>

                <div class="info">
                    <strong>NXB:</strong>
                    <span><?php echo htmlspecialchars($book['publisher'] ?? 'N/A'); ?></span>
                </div>

                <div class="info">
                    <strong>Năm xuất bản:</strong>
                    <span><?php echo htmlspecialchars($book['publish_year'] ?? 'N/A'); ?></span>
                </div>

                <p class="description">
                    <strong>Mô tả:</strong><br>
                    <?php echo nl2br(htmlspecialchars($book['description'] ?? '')); ?>
                </p>

                <?php if (!empty($book['url'])): ?>
                    <div class="info">
                        <strong>Link tham khảo:</strong>
                        <span>
                            <a href="<?php echo htmlspecialchars($book['url']); ?>" 
                               target="_blank" rel="noopener noreferrer">
                                <?php echo htmlspecialchars($book['url']); ?>
                            </a>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($statuses)): ?>
                <div class="status">
                    <h3>Tình trạng sách</h3>
                    <ul class="status-list">
                        <?php foreach ($statuses as $item): ?>
                            <li>
                                <?php echo ucfirst(htmlspecialchars($item['status'])); ?>: 
                                <strong><?php echo htmlspecialchars($item['total']); ?></strong> cuốn
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="btn-group">
                <a href="<?php echo URL_ROOT; ?>/?url=book/index" class="btn btn-secondary">
                    ← Quay lại danh sách
                </a>
            </div>

        <?php else: ?>
            <div class="alert alert-error">
                <p>Không tìm thấy sách.</p>
            </div>
            <div class="btn-group">
                <a href="<?php echo URL_ROOT; ?>/?url=book/index" class="btn btn-secondary">
                    ← Quay lại danh sách
                </a>
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
