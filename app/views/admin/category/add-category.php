<?php
require_once __DIR__ . '../../../../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
    <title>Document</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <?php require_once __DIR__ . '../../components/sidebar.php'; ?>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </nav>

            <div class="container-fluid px-4 py-4">
                <?php if (isset($message) && $message): ?>
                    <div class="alert alert-<?= $message_type === 'error' ? 'danger' : 'success' ?>">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
                <div class="book-form-container">
                    <h2 class="book-form-title">
                        <i class="fas fa-book me-2"></i>
                        <?= $title ?? 'Add New Category' ?>
                    </h2>

                    <form method="POST" action="admin.php?action=<?= isset($category_id) ? 'add-category&id=' . $category_id : 'add-category' ?>">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control"
                                value="<?= htmlspecialchars($name ?? '') ?>"
                                maxlength="100">
                        </div>
                        <div class="form-actions mt-3">
                            <a href="admin.php?action=category-list" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>




        </div>
    </div>
</body>

</html>