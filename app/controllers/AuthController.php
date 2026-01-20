<?php

class AuthController extends Controller
{
    public function loginForm()
    {
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] === 'admin') {
                $this->redirect(url('index.php?action=admin/dashboard'));
            } else {
                $this->redirect(url('index.php?action=index'));
            }
            exit;
        }

        $this->view('auth/login');
    }

    public function login()
    {
        if (!$this->isPost()) {
            $this->redirect(url('index.php?action=login'));
            return;
        }

        $email = $this->input('email');
        $password = $this->input('password');

        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        //validate input
        if (!$user || $password !== $user['password']) {
            $this->setFlash('error', 'Invalid email or password');
            $this->redirect(url('index.php?action=login'));
            exit;
        }

         $_SESSION['user'] = [
            'id' => $user['user_id'],
            'username' => $user['name'],
            'full_name' => $user['full_name'],
            'email' => $user['email'],
            'role' => $user['role'] 
        ];

        if ($user['role'] === 'admin') {
            $this->redirect(url('admin.php?action=dashboard'));
        } else {
            $this->redirect(url('index.php?action=index'));
        }
        exit;
    }

    public function logout()
    {
        session_destroy();
        $this->redirect(url('index.php?action=index'));
    }

    public function forgotPasswordForm()
    {
        $this->view('auth/forgot-password');
    }

    public function forgotPassword()
    {
        $message = '';
        $error = '';

        if ($this->isPost()) {
            $email = trim($this->input('email'));

            if (empty($email)) {
                $error = 'Vui lòng nhập địa chỉ email';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Địa chỉ email không hợp lệ';
            } else {
                // Kiểm tra xem email có tồn tại trong hệ thống
                $userModel = $this->model('User');
                $user = $userModel->getUserByEmail($email);

                if (!$user) {
                    // Không hiển thị thông báo người dùng không tồn tại vì lý do bảo mật
                    $message = 'Nếu email tồn tại trong hệ thống, bạn sẽ nhận được một liên kết đặt lại mật khẩu';
                } else {
                    // Tạo token reset
                    $token = bin2hex(random_bytes(32));
                    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

                    if ($userModel->createPasswordReset($user->user_id, $email, $token, $expiresAt)) {
                        // Tạo liên kết reset
                        $resetLink = url('index.php?action=reset-password&token=' . $token);

                        // Gửi email (trong production sử dụng PHPMailer hoặc SwiftMailer)
                        $subject = 'Đặt lại mật khẩu - Hệ thống quản lý thư viện';
                        $body = "Xin chào " . $user->name . ",\n\n";
                        $body .= "Bạn đã yêu cầu đặt lại mật khẩu của mình.\n";
                        $body .= "Nhấp vào liên kết bên dưới để đặt lại mật khẩu của bạn:\n\n";
                        $body .= $resetLink . "\n\n";
                        $body .= "Liên kết này sẽ hết hạn trong 1 giờ.\n\n";
                        $body .= "Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.\n\n";
                        $body .= "Trân trọng,\nHệ thống quản lý thư viện";

                        $headers = "From: noreply@library.com\r\n";
                        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                        // Thực hiện gửi email (bạn cần cấu hình SMTP hoặc sử dụng mail())
                        mail($email, $subject, $body, $headers);

                        $message = 'Nếu email tồn tại trong hệ thống, bạn sẽ nhận được một liên kết đặt lại mật khẩu';
                    } else {
                        $error = 'Có lỗi xảy ra. Vui lòng thử lại sau';
                    }
                }
            }
        }

        $this->view('auth/forgot-password', ['message' => $message, 'error' => $error]);
    }

    public function resetPassword()
    {
        $token = $_GET['token'] ?? '';
        $message = '';
        $error = '';

        if ($this->isPost()) {
            $password = $this->input('password');
            $password_confirm = $this->input('password_confirm');

            // Kiểm tra token
            $userModel = $this->model('User');
            $resetRecord = $userModel->getPasswordResetByToken($token);

            if (!$resetRecord) {
                $error = 'Token không hợp lệ hoặc đã hết hạn';
            } elseif (empty($password)) {
                $error = 'Vui lòng nhập mật khẩu mới';
            } elseif (strlen($password) < 6) {
                $error = 'Mật khẩu phải có ít nhất 6 ký tự';
            } elseif ($password !== $password_confirm) {
                $error = 'Mật khẩu không khớp';
            } else {
                // Cập nhật mật khẩu
                if ($userModel->updatePassword($resetRecord->user_id, $password)) {
                    $userModel->markResetTokenUsed($resetRecord->reset_id);
                    $this->setFlash('success', 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập');
                    $this->redirect(url('index.php?action=login'));
                } else {
                    $error = 'Có lỗi xảy ra. Vui lòng thử lại sau';
                }
            }
        } else {
            // Kiểm tra token khi tải trang
            $userModel = $this->model('User');
            $resetRecord = $userModel->getPasswordResetByToken($token);
            if (!$resetRecord) {
                $error = 'Token không hợp lệ hoặc đã hết hạn';
            }
        }

        $this->view('auth/reset-password', ['token' => $token, 'message' => $message, 'error' => $error]);
    }

    public function resetPasswordForm()
    {
        $token = $_GET['token'] ?? '';
        $error = '';

        // Kiểm tra token khi tải trang
        if ($token) {
            $userModel = $this->model('User');
            $resetRecord = $userModel->getPasswordResetByToken($token);
            if (!$resetRecord) {
                $error = 'Token không hợp lệ hoặc đã hết hạn';
            }
        }

        $this->view('auth/reset-password', ['token' => $token, 'error' => $error]);
    }
}
