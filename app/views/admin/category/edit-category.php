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
    <title>Edit Category</title>
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
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $message_type === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show">
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="book-form-container">
                    <h2 class="book-form-title">
                        <i class="fas fa-edit me-2"></i>
                        <?= htmlspecialchars($title ?? 'Edit Category') ?>
                    </h2>

                    <form method="POST" action="admin.php?action=edit-category&id=<?= htmlspecialchars($category['category_id'] ?? '') ?>">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control"
                                   value="<?= htmlspecialchars($category['name'] ?? '') ?>"
                                   maxlength="100"
                                   required>
                        </div>
                        
                        <div class="form-actions mt-3">
                            <a href="admin.php?action=category-list" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Thêm Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('wrapper').classList.toggle('toggled');
        });
    </script>
</body>

</html>