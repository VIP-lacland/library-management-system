<?php

class AdminUserController extends Controller
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function getAllUser()
    {
        if ($this->isPost()) {
            $this->redirect(url('admin.php?action=users'));
            return;
        }

        $limit = 10;
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($currentPage - 1) * $limit;

        $totalUsers = $this->userModel->getTotalUsers($keyword);
        $totalPages = $totalUsers > 0 ? ceil($totalUsers / $limit) : 1;


        if ($currentPage > $totalPages && $totalPages > 0) {
            $currentPage = $totalPages;
            $offset = ($currentPage - 1) * $limit;
        }

        $users = $this->userModel->getUsers($limit, $offset, $keyword);

        $data = [
            'users' => $users,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalUsers' => $totalUsers,
            'keyword' => $keyword,
            'message' => $this->getFlash('message'),
            'message_type' => $this->getFlash('message_type')
        ];

        $this->view('admin/users/user-management', $data);
    }


    private function validateUser()
    {
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


    private function isAdminUser(array $user): bool
    {
        return isset($user['role']) && $user['role'] === 'admin';
    }


    public function blockUser()
    {
        if (!$this->isPost()) {
            $this->redirect(url('admin.php?action=users'));
            return;
        }

        $user = $this->validateUser();
        if (!$user) return;

        if ($this->isAdminUser($user)) {
            $this->setFlash('message', 'Không thể chặn tài khoản Admin');
            $this->setFlash('message_type', 'error');
            $this->redirect(url('admin.php?action=users'));
            return;
        }

        $user_id = $user['user_id'];
        if ($this->userModel->blockUser($user_id)) {
            $this->setFlash('message', 'Đã chặn người dùng "' . htmlspecialchars($user['name']) . '" thành công');
            $this->setFlash('message_type', 'success');
        } else {
            $this->setFlash('message', 'Không thể chặn người dùng. Vui lòng thử lại');
            $this->setFlash('message_type', 'error');
        }

        $this->redirect(url('admin.php?action=users'));
    }


    public function unblockUser()
    {
        if (!$this->isPost()) {
            $this->redirect(url('admin.php?action=users'));
            return;
        }

        $user = $this->validateUser();
        if (!$user) return;

        $userId = $user['user_id'];

        if ($this->userModel->unblockUser($userId)) {
            $this->setFlash('message', 'Đã mở chặn người dùng "' . htmlspecialchars($user['name']) . '" thành công');
            $this->setFlash('message_type', 'success');
        } else {
            $this->setFlash('message', 'Không thể mở chặn người dùng. Vui lòng thử lại');
            $this->setFlash('message_type', 'error');
        }

        $this->redirect(url('admin.php?action=users'));
    }
}
