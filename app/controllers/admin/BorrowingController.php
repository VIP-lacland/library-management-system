<?php

class BorrowingController extends Controller
{

    public function listBorrowings()
    {
        $borrowModel = $this->model('Borrow');

        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $loans = $borrowModel->getLoansPaginated($limit, $offset, $keyword);
        $totalLoans = $borrowModel->countLoans($keyword);
        $totalPages = ceil($totalLoans / $limit);

        $title = 'All Borrowing History';

        $this->view('admin/borrowing/borrowing-list', [
            'loans' => $loans,
            'title' => $title,
            'keyword' => $keyword,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function requests()
    {
        $borrowModel = $this->model('Borrow');
        $requests = $borrowModel->getAllLoans('pending');
        $title = 'Borrow Requests';
        $this->view('admin/borrowing/pending', ['requests' => $requests, 'title' => $title]);
    }
    public function overdue()
    {
        $borrowModel = $this->model('Borrow');
        $overdueLoans = $borrowModel->getOverdueLoans();
        $title = 'Overdue Books';
        $this->view('admin/borrowing/overdue', ['overdueLoans' => $overdueLoans, 'title' => $title]);
    }

    public function approve()
    {
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

    public function reject()
    {
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

    public function returnBook()
    {
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
}
