<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
    <title>Category Management</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <?php require_once __DIR__ . '../../components/sidebar.php'; ?>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                </div>
            </nav>
            <div class="container-fluid p-4">
                <h2 class="mb-4">Category Management</h2>
                <p class="text-muted mb-4">Add, edit, and manage categories</p>

                <!-- Flash Messages -->
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?= $message_type === 'error' ? 'danger' : 'success' ?>">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>

                <div class="row mb-3">
                    <div class="col-md-11 mb-3 text-end">
                        <a href="admin.php?action=add-category" class="btn btn-success">
                            <i class="fas fa-plus"></i> Add New Category
                        </a>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories as $category): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($category['name']) ?></td>
                                                <td>
                                                    <a href="admin.php?action=edit-category&id=<?= $category['category_id'] ?>"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>                        
                                                    <form method="POST" action="admin.php?action=delete-category"
                                                        class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                        <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>