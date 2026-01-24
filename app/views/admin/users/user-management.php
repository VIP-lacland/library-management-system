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
    <title>User Management</title>
</head>

<body>
    <div class="d-flex" id="wrapper">

        <?php require_once __DIR__ . '../../components/sidebar.php'; ?>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                </div>
            </nav>

            <div class="container-fluid px-4">
                <h2 class="mb-2 mt-4">User Management</h2>
                <p class="text-muted mb-4">View and manage user accounts</p>

                <!-- Flash Messages -->
                <?php if (isset($message) && !empty($message)): ?>
                    <div class="alert alert-<?= $message_type === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                        <i class="fas fa-<?= $message_type === 'success' ? 'check-circle' : 'exclamation-circle' ?> me-2"></i>
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($users)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                                <p class="mb-0">No user</p>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td>
                                                    <i class="fas fa-user-circle me-2 text-secondary"></i>
                                                    <?= htmlspecialchars($user['name']) ?>
                                                </td>
                                                <td><?= htmlspecialchars($user['email']) ?></td>
                                                <td><?= htmlspecialchars($user['phone'] ?? 'N/A') ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $user['role'] === 'admin' ? 'primary' : 'secondary' ?>">
                                                        <?= $user['role'] === 'admin' ? 'Admin' : 'Reader' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $user['status'] === 'active' ? 'success' : 'danger' ?>">
                                                        <i class="fas fa-<?= $user['status'] === 'active' ? 'check-circle' : 'ban' ?> me-1"></i>
                                                        <?= $user['status'] === 'active' ? 'Active' : 'Blocked' ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    
                                                    $isAdmin = $user['role'] === 'admin';
                                                    ?>

                                                    <?php if (!$isAdmin): ?>
                                                     
                                                        <?php if ($user['status'] === 'active'): ?>
                                                            <!-- Block Button -->
                                                            <form method="POST" action="admin.php?action=blockUser" style="display: inline;">
                                                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                                        onclick="return confirm('Bạn có chắc muốn chặn người dùng <?= htmlspecialchars($user['name']) ?>?')"
                                                                        title="Block User">
                                                                    <i class="fas fa-ban me-1"></i>Block
                                                                </button>
                                                            </form>
                                                        <?php else: ?>
                                                            <!-- Unblock Button -->
                                                            <form method="POST" action="admin.php?action=unblockUser" style="display: inline;">
                                                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                                                <button type="submit" class="btn btn-sm btn-success" 
                                                                        onclick="return confirm('Bạn có chắc muốn mở chặn người dùng <?= htmlspecialchars($user['name']) ?>?')"
                                                                        title="Unblock User">
                                                                    <i class="fas fa-check-circle me-1"></i>Unblock
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <!-- Badge cho tài khoản Admin -->
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-shield-alt me-1"></i>Protected
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation" class="mt-3">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                });
            }
        });

        // Auto dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    </script>
</body>

</html>