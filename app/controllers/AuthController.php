<?php
class AuthController extends Controller {

    // Hiển thị trang đăng nhập
    public function index() {
        // Nếu đã đăng nhập rồi thì không cho vào trang login nữa
        if ($this->isLoggedIn()) {
            $this->redirect('/home');
        }
        $this->view('auth/login');
    }

    // Xử lý dữ liệu từ form gửi lên
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Load model User thông qua hàm của lớp cha
            $userModel = $this->model('User');
            $user = $userModel->getUserByEmail($email);

            if ($user) {
                // Kiểm tra mật khẩu (Giả sử dùng password_verify cho bảo mật)
                if (password_verify($password, $user->password)) {
                    
                    // Kiểm tra trạng thái tài khoản
                    if ($user->status == 'block') {
                        $this->view('auth/login', ['error' => 'Tài khoản của bạn đã bị khóa!']);
                        return;
                    }

                    // Thiết lập Session
                    $_SESSION['user_id'] = $user->user_id;
                    $_SESSION['user_name'] = $user->name;
                    $_SESSION['user_role'] = $user->role;

                    // Chuyển hướng sử dụng hàm redirect có sẵn của nhóm
                    $this->redirect('/home'); 
                } else {
                    $this->view('auth/login', ['error' => 'Email hoặc mật khẩu không chính xác!']);
                }
            } else {
                $this->view('auth/login', ['error' => 'Email hoặc mật khẩu không chính xác!']);
            }
        }
    }

    // Đăng xuất
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        $this->redirect('/auth/login');
    }
}