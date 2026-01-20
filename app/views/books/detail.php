<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= asset('css/detail.css') ?>">
    <title>Chi tiết sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <?php require_once __DIR__ . '/../layouts/header.php'; ?>
<body>
    <main>
        <div class="container">
            <div class="book-detail">
        <?php if ($book): ?>
            <div class="book-header">
                <h1><?php echo htmlspecialchars($book['title']); ?></h1>
                <p class="author">
                    <strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?>
                </p>
            </div>

            <div class="book-info">
                <div class="info">
                    <strong>Category:</strong>
                    <span><?php echo htmlspecialchars($book['category_name'] ?? 'N/A'); ?></span>
                </div>

                <div class="info">
                    <strong>NXB:</strong>
                    <span><?php echo htmlspecialchars($book['publisher'] ?? 'N/A'); ?></span>
                </div>

                <div class="info">
                    <strong>Year of publication:</strong>
                    <span><?php echo htmlspecialchars($book['publish_year'] ?? 'N/A'); ?></span>
                </div>

                <p class="description">
                    <strong>Describe:</strong><br>
                    <?php echo nl2br(htmlspecialchars($book['description'] ?? '')); ?>
                </p>

                <?php if (!empty($book['url'])): ?>
                    <div class="info">
                        <strong>Reference links:</strong>
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
                    <h3>Book condition</h3>
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
                <a href="<?= BASE_URL ?>" class="btn btn-secondary">
                    ← Back to the list
                </a>
            </div>

        <?php else: ?>
            <div class="alert alert-error">
                <p>No books found.</p>
            </div>
            <div class="btn-group">
                <a href="<?= BASE_URL ?> ?>" class="btn btn-secondary">
                    ← Back to the list
                </a>
            </div>
        <?php endif; ?>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

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
