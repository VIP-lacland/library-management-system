<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('css/admin_dashboard.css') ?>">
</head>
<body>  
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <?php require_once __DIR__ . '/components/sidebar.php'; ?>
        
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                </div>
            </nav>
            
            <div class="container-fluid p-4">
                <h2 class="mb-4">Dashboard Overview</h2>
                
                <div class="row g-4">
                    <!-- Book Stats -->
                    <div class="col-md-3">
                        <div class="card bg-primary text-white h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Books</h6>
                                        <h3 class="mb-0">Manage</h3>
                                    </div>
                                    <i class="fas fa-book fa-2x opacity-50"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="admin.php?action=book-list" class="text-white text-decoration-none small">Go to Books <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Borrow Stats -->
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Borrowing</h6>
                                        <h3 class="mb-0">Requests</h3>
                                    </div>
                                    <i class="fas fa-clipboard-list fa-2x opacity-50"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="admin.php?action=borrow-requests" class="text-dark text-decoration-none small">View Requests <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Overdue Stats -->
                    <div class="col-md-3">
                        <div class="card bg-danger text-white h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Overdue</h6>
                                        <h3 class="mb-0">Alerts</h3>
                                    </div>
                                    <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="admin.php?action=borrow-overdue" class="text-white text-decoration-none small">View Overdue <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
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
    </script>
</body>
</html>