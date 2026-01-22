<?php

class BorrowController extends Controller
{
    public function __construct()
    {
        // 1. Yêu cầu đăng nhập
        $this->requireLogin();

        // 2. Kiểm tra quyền Admin hoặc Librarian
        // Giả sử thông tin user được lưu trong $_SESSION['user']
        $user = $_SESSION['user'] ?? null;
        $role = isset($user['role']) ? $user['role'] : '';

        if ($role !== 'admin' && $role !== 'librarian') {
            $this->setFlash('error', 'Bạn không có quyền truy cập chức năng này.');
            // Redirect về trang chủ hoặc dashboard user
            $this->redirect('index.php');
        }
    }

    /**
     * Xử lý duyệt yêu cầu mượn sách
     * Route: index.php?action=borrow-approve&id={id}
     */
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
        
        // 1. Lấy thông tin yêu cầu mượn để kiểm tra
        $request = $borrowModel->getById($borrowId);

        if (!$request) {
            $this->setFlash('error', 'Không tìm thấy yêu cầu mượn.');
            $this->redirect('index.php?action=borrow-list');
        }

        // 2. Kiểm tra trạng thái hiện tại (Chỉ được duyệt đơn đang Pending)
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

        // 4. Gọi Model để thực hiện Transaction
        // Logic trong Model cần:
        // - Kiểm tra xem còn sách (Book Items) khả dụng không (status = 'available')
        // - Nếu còn: Update trạng thái Borrow -> 'approved'
        // - Update trạng thái Book Item -> 'borrowed'
        // - Update ngày hẹn trả (due_date)
        
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