<?php

class BorrowController extends Controller
{
    public function __construct()
    {
        // 1. Yêu cầu đăng nhập
        $this->requireLogin();

        $user = $_SESSION['user'] ?? null;
        $role = isset($user['role']) ? $user['role'] : '';

        if ($role !== 'admin' && $role !== 'librarian') {
            $this->setFlash('error', 'Bạn không có quyền truy cập chức năng này.');
            // Redirect về trang chủ hoặc dashboard user
            $this->redirect('index.php');
        }
    }

    public function approve()
    {
        // Lấy ID từ GET param
        $borrowId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($borrowId <= 0) {
            $this->setFlash('error', 'ID yêu cầu không hợp lệ.');
            $this->redirect('index.php?action=borrow-list');
        }

        // Load Models
        $borrowModel = $this->model('Borrow');
        

        $request = $borrowModel->getById($borrowId);

        if (!$request) {
            $this->setFlash('error', 'Không tìm thấy yêu cầu mượn.');
            $this->redirect('index.php?action=borrow-list');
        }

 
        if ($request['status'] !== 'pending') {
            $this->setFlash('error', 'Yêu cầu này đã được xử lý trước đó (Trạng thái: ' . $request['status'] . ').');
            $this->redirect('index.php?action=borrow-list');
        }

        // 3. Thiết lập thông số duyệt
        // Ví dụ: Mượn 14 ngày tính từ ngày duyệt
        $daysToBorrow = 14;
        $dueDate = date('Y-m-d', strtotime("+$daysToBorrow days"));
        
        // Lấy ID người duyệt (Admin đang login) để lưu log (nếu cần)
        $adminId = $_SESSION['user']['user_id'] ?? 0;

        
        // Giả sử method approveRequest trả về: true (thành công), 'out_of_stock' (hết sách), false (lỗi khác)
        $result = $borrowModel->approveRequest($borrowId, $dueDate, $adminId);

        if ($result === true) {
            $this->setFlash('success', 'Đã duyệt yêu cầu mượn thành công. Hạn trả: ' . $dueDate);
        } elseif ($result === 'out_of_stock') {
            $this->setFlash('error', 'Duyệt thất bại: Sách này hiện đã hết trong kho.');
        } else {
            $this->setFlash('error', 'Có lỗi hệ thống xảy ra khi duyệt yêu cầu.');
        }

        // Quay lại danh sách mượn
        $this->redirect('index.php?action=borrow-list');
    }
}