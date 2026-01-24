<?php 

class AdminUserController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function getAllUser() {
        if ($this->isPost()) {
            $this->redirect(url('admin.php?action=users'));
            return;
        }
        // truy cập đến hàm getAllUser ở model
        $users = $this->userModel->getAllUser();

        $data = [
            'users' => $users,
            'message' => $this->getFlash('message'),
            'message_type' => $this->getFlash('message_type')
        ];
        
        $this->view('admin/users/user-management', $data);
    }

    public function validateUser() {
        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

        if ($userId <= 0) {
            $this->setFlash('message', 'ID người dùng không hợp lệ');
            $this->setFlash('message_type', 'error');
            $this->redirect(url('admin.php?action=users'));
            return null;
        }

        $user = $this->userModel->findById($userId);
        if (!$user) {
            $this->setFlash('message', 'Người dùng không tồn tại');
            $this->setFlash('message_type', 'error');
            $this->redirect(url('admin.php?action=users'));
            return null;
        }
        return $user;
    }

    public function blockUser() {
        if (!$this->isPost()) {
            $this->redirect(url('admin.php?action=users'));
            return;
        }

        $user = $this->validateUser();
        if (!$user) return;
      
        $user_id = $user['user_id'];

        // check to can not block admin account
        if (isset($user['role']) && $user['role'] === 'admin') {
            $this->setFlash('message', 'Không thể chặn tài khoản Admin');
            $this->setFlash('message_type', 'error');
            $this->redirect(url('admin.php?action=users'));
            return;
        }

        // do block user
        if ($this->userModel->blockUser($user_id)) {
            $this->setFlash('message', 'Đã chặn người dùng thành công');
            $this->setFlash('message_type', 'success');
        } else {
            $this->setFlash('message', 'Không thể chặn người dùng');
            $this->setFlash('message_type', 'error');
        }

        $this->redirect(url('admin.php?action=users'));
    }

    public function unblockUser() {
        if (!$this->isPost()) {
            $this->setFlash('message', 'Phương thức không hợp lệ');
            $this->setFlash('message_type', 'error');
            $this->redirect(url('admin.php?action=users'));
            return;
        }

        $user = $this->validateUser();
        if (!$user) return;

        $userId = $user['user_id'];

        // do unblock user
        if ($this->userModel->unblockUser($userId)) {
            $this->setFlash('message', 'Đã mở chặn người dùng thành công');
            $this->setFlash('message_type', 'success');
        } else {
            $this->setFlash('message', 'Không thể mở chặn người dùng');
            $this->setFlash('message_type', 'error');
        }

        $this->redirect(url('admin.php?action=users'));
    }
}