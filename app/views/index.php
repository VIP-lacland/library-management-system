<?php require_once __DIR__ . '/layouts/header.php'; ?>

<main class="container">
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
</main>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>