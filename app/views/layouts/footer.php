<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config/config.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= asset('css/footer.css') ?>">
    <title>Library Management System Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <footer>
        <div class="footer-container">
            <div class="footer-content">
                <!-- Logo và thống kê -->
                <div class="footer-section">
                    <div class="footer-logo">
                        <div class="logo-img"><Label></Label></div>
                        <div class="logo-text">
                            <h3>LIBRARY MANAGEMENT SYSTEM</h3>
                        </div>
                    </div>
                    <div class="footer-stats">
                        <div class="stat-item">
                            <div class="stat-number">3</div>
                            <div class="stat-label">online visits</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">5</div>
                            <div class="stat-label">total visits</div>
                        </div>
                    </div>
                </div>

                <!-- Tài liệu -->
                <div class="footer-section">
                    <h4>Document</h4>
                    <ul>
                        <li><a href="#">Books online</a></li>
                        <li><a href="#">Audio books</a></li>
                        <li><a href="#">Online lectures</a></li>
                        <li><a href="#">Album</a></li>
                        <li><a href="#">Video</a></li>
                    </ul>
                </div>

                <!-- Tin tức -->
                <div class="footer-section">
                    <h4>News</h4>
                    <ul>
                        <li><a href="#">Introduce</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>

                <!-- Trống (để cân đối layout) -->
                <div class="footer-section">
                </div>
            </div>

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
        </div>
    </footer>
</body>
</html>