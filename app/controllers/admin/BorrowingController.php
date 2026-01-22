<?php

class BorrowingController extends Controller {
    
    public function index() {
        $borrowModel = $this->model('Borrow');
        
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        if (!empty($keyword)) {
            $loans = $borrowModel->searchLoans($keyword);
        } else {
            $loans = $borrowModel->getAllLoans();
        }
        $title = 'All Borrowing History';

        // Hiển thị giao diện trực tiếp (Không cần file view)
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title><?= $title ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <link rel="stylesheet" href="<?= asset('css/admin_dashboard.css') ?>">
        </head>
        <body>
            <div class="d-flex" id="wrapper">
                <?php require_once __DIR__ . '/../../views/admin/components/sidebar.php'; ?>
                <div id="page-content-wrapper">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                        <div class="container-fluid">
                            <button class="btn btn-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                        </div>
                    </nav>
            <div class="container-fluid p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-history me-2"></i>Borrowing History</h2>
                </div>

                <!-- Search Form -->
                <form action="admin.php" method="GET" class="row g-2 mb-4">
                    <input type="hidden" name="action" value="borrow-list">
                    <div class="col-md-8">
                        <input type="text" name="keyword" class="form-control" placeholder="Search by user, email, book title or barcode..." value="<?= htmlspecialchars($keyword) ?>">
                    </div>
                    <div class="col-md-4"><button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button> <?php if(!empty($keyword)): ?><a href="admin.php?action=borrow-list" class="btn btn-secondary ms-1">Reset</a><?php endif; ?></div>
                </form>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <a href="admin.php?action=borrow-list" class="btn btn-primary active">All History</a>
                        <a href="admin.php?action=borrow-requests" class="btn btn-outline-warning">Pending Requests</a>
                        <a href="admin.php?action=borrow-overdue" class="btn btn-outline-danger">Overdue Books</a>
                    </div>
                    <a href="admin.php?action=borrow-export<?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>" class="btn btn-success"><i class="fas fa-file-excel me-2"></i>Export Excel</a>
                </div>
                <?php if (isset($_SESSION['flash']['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show"><?= $_SESSION['flash']['success']; unset($_SESSION['flash']['success']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['flash']['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show"><?= $_SESSION['flash']['error']; unset($_SESSION['flash']['error']); ?></div>
                <?php endif; ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Book</th>
                                        <th>Borrowed Date</th>
                                        <th>Due Date</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($loans)): ?>
                                        <?php foreach ($loans as $loan): ?>
                                        <tr>
                                            <td>#<?= $loan['loan_id'] ?></td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($loan['user_name']) ?></div>
                                                <small class="text-muted"><?= htmlspecialchars($loan['email']) ?></small>
                                            </td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($loan['book_title']) ?></div>
                                                <small class="text-muted">Barcode: <?= htmlspecialchars($loan['barcode']) ?></small>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($loan['borrow_date'])) ?></td>
                                            <td><?= date('d/m/Y', strtotime($loan['due_date'])) ?></td>
                                            <td><?= $loan['return_date'] ? date('d/m/Y', strtotime($loan['return_date'])) : '-' ?></td>
                                            <td>
                                                <span class="badge bg-<?= ($loan['status'] == 'borrowing' ? 'primary' : ($loan['status'] == 'overdue' ? 'danger' : ($loan['status'] == 'returned' ? 'success' : 'secondary'))) ?>">
                                                    <?= ucfirst($loan['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if($loan['status'] == 'borrowing' || $loan['status'] == 'overdue'): ?>
                                                    <a href="admin.php?action=borrow-return&id=<?= $loan['loan_id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Confirm return book?')"><i class="fas fa-undo"></i> Return</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="8" class="text-center py-4">No records found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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
        <?php
    }

    public function requests() {
        $borrowModel = $this->model('Borrow');
        $requests = $borrowModel->getAllLoans('pending');
        $title = 'Borrow Requests';

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title><?= $title ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <link rel="stylesheet" href="<?= asset('css/admin_dashboard.css') ?>">
        </head>
        <body>
            <div class="d-flex" id="wrapper">
                <?php require_once __DIR__ . '/../../views/admin/components/sidebar.php'; ?>
                <div id="page-content-wrapper">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                        <div class="container-fluid">
                            <button class="btn btn-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                        </div>
                    </nav>
            <div class="container-fluid p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-clipboard-list me-2"></i>Borrow Requests</h2>
                </div>
                <div class="mb-3">
                    <a href="admin.php?action=borrow-list" class="btn btn-outline-primary">All History</a>
                    <a href="admin.php?action=borrow-requests" class="btn btn-warning active text-dark">Pending Requests</a>
                    <a href="admin.php?action=borrow-overdue" class="btn btn-outline-danger">Overdue Books</a>
                </div>
                <?php if (isset($_SESSION['flash']['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show"><?= $_SESSION['flash']['success']; unset($_SESSION['flash']['success']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['flash']['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show"><?= $_SESSION['flash']['error']; unset($_SESSION['flash']['error']); ?></div>
                <?php endif; ?>
                <div class="card shadow-sm border-warning">
                    <div class="card-header bg-warning text-dark"><h5 class="mb-0">Pending Approvals</h5></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Book</th>
                                        <th>Request Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($requests)): ?>
                                        <?php foreach ($requests as $req): ?>
                                        <tr>
                                            <td>#<?= $req['loan_id'] ?></td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($req['user_name']) ?></div>
                                                <small class="text-muted"><?= htmlspecialchars($req['email']) ?></small>
                                            </td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($req['book_title']) ?></div>
                                                <small class="text-muted">Barcode: <?= htmlspecialchars($req['barcode']) ?></small>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($req['borrow_date'])) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="admin.php?action=borrow-approve&id=<?= $req['loan_id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Approve this request?')"><i class="fas fa-check"></i> Approve</a>
                                                    <a href="admin.php?action=borrow-reject&id=<?= $req['loan_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Reject this request?')"><i class="fas fa-times"></i> Reject</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="5" class="text-center py-4">No pending requests found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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
        <?php
    }

    public function overdue() {
        $borrowModel = $this->model('Borrow');
        $overdueLoans = $borrowModel->getOverdueLoans();
        $title = 'Overdue Books';

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title><?= $title ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <link rel="stylesheet" href="<?= asset('css/admin_dashboard.css') ?>">
        </head>
        <body>
            <div class="d-flex" id="wrapper">
                <?php require_once __DIR__ . '/../../views/admin/components/sidebar.php'; ?>
                <div id="page-content-wrapper">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                        <div class="container-fluid">
                            <button class="btn btn-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                        </div>
                    </nav>
            <div class="container-fluid p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Overdue Books</h2>
                </div>
                <div class="mb-3">
                    <a href="admin.php?action=borrow-list" class="btn btn-outline-primary">All History</a>
                    <a href="admin.php?action=borrow-requests" class="btn btn-outline-warning">Pending Requests</a>
                    <a href="admin.php?action=borrow-overdue" class="btn btn-danger active">Overdue Books</a>
                </div>
                <?php if (isset($_SESSION['flash']['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show"><?= $_SESSION['flash']['success']; unset($_SESSION['flash']['success']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['flash']['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show"><?= $_SESSION['flash']['error']; unset($_SESSION['flash']['error']); ?></div>
                <?php endif; ?>
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger text-white"><h5 class="mb-0">Late Returns</h5></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Book</th>
                                        <th>Borrowed Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($overdueLoans)): ?>
                                        <?php foreach ($overdueLoans as $loan): ?>
                                        <tr>
                                            <td>#<?= $loan['loan_id'] ?></td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($loan['user_name']) ?></div>
                                                <small class="text-muted"><?= htmlspecialchars($loan['email']) ?></small>
                                            </td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($loan['book_title']) ?></div>
                                                <small class="text-muted">Barcode: <?= htmlspecialchars($loan['barcode']) ?></small>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($loan['borrow_date'])) ?></td>
                                            <td class="text-danger fw-bold"><?= date('d/m/Y', strtotime($loan['due_date'])) ?></td>
                                            <td><span class="badge bg-danger">Overdue</span></td>
                                            <td>
                                                <a href="admin.php?action=borrow-return&id=<?= $loan['loan_id'] ?>" class="btn btn-primary btn-sm" onclick="return confirm('Mark this book as returned?')"><i class="fas fa-undo"></i> Mark Returned</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="7" class="text-center py-4">No overdue books found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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
        <?php
    }

    public function approve() {
        if ($this->isGet()) {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id > 0) {
                $borrowModel = $this->model('Borrow');
                // Mặc định mượn 14 ngày
                $dueDate = date('Y-m-d', strtotime('+14 days'));
                
                if ($borrowModel->approveRequest($id, $dueDate)) {
                    $this->setFlash('success', 'Request approved successfully.');
                } else {
                    $this->setFlash('error', 'Failed to approve request.');
                }
            }
        }
        $this->redirect('admin.php?action=borrow-requests');
    }

    public function reject() {
        if ($this->isGet()) {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id > 0) {
                $borrowModel = $this->model('Borrow');
                if ($borrowModel->rejectRequest($id)) {
                    $this->setFlash('success', 'Request rejected.');
                } else {
                    $this->setFlash('error', 'Failed to reject request.');
                }
            }
        }
        $this->redirect('admin.php?action=borrow-requests');
    }
    
    public function returnBook() {
        if ($this->isGet()) {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id > 0) {
                $borrowModel = $this->model('Borrow');
                if ($borrowModel->returnBook($id)) {
                    $this->setFlash('success', 'Book returned successfully.');
                } else {
                    $this->setFlash('error', 'Failed to return book.');
                }
            }
        }
        $this->redirect('admin.php?action=borrow-list');
    }

    public function export() {
        $borrowModel = $this->model('Borrow');
        
        // Hỗ trợ xuất dữ liệu theo từ khóa tìm kiếm nếu có
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        if (!empty($keyword)) {
            $loans = $borrowModel->searchLoans($keyword);
        } else {
            $loans = $borrowModel->getAllLoans();
        }
        
        $filename = "borrow_list_" . date('Y-m-d_H-i') . ".csv";
        
        // Thiết lập header để trình duyệt hiểu đây là file CSV tải về
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Thêm BOM để Excel hiển thị đúng tiếng Việt UTF-8
        fputs($output, "\xEF\xBB\xBF");
        
        // Dòng tiêu đề
        fputcsv($output, ['ID', 'User Name', 'Email', 'Book Title', 'Barcode', 'Borrow Date', 'Due Date', 'Return Date', 'Status']);
        
        // Dữ liệu
        foreach ($loans as $loan) {
            fputcsv($output, [
                $loan['loan_id'], $loan['user_name'], $loan['email'], $loan['book_title'], 
                $loan['barcode'], $loan['borrow_date'], $loan['due_date'], 
                $loan['return_date'], ucfirst($loan['status'])
            ]);
        }
        fclose($output);
        exit;
    }
}