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
    <link rel="stylesheet" href="<?= asset('css/home.css') ?>">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/header.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<?php require_once __DIR__ . '/layouts/header.php'; ?>

<body>

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
                            </div>

                            <div class="mt-auto">
                                <a href="<?= url('index.php?action=book-detail&id=' . $book['book_id']) ?>" class="btn btn-primary w-100">View Details</a>
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
    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php require_once __DIR__ . '/layouts/footer.php'; ?>
</body>

</html>