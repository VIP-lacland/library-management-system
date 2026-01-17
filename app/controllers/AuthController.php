<?php

class AuthController {
    private $userModel;

    public function __construct() {
        require_once APP_ROOT . '/app/models/User.php';
        $this->userModel = new User();
    }

    public function loginForm() {
        require APP_ROOT . '/app/views/auth/login.php';
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Fake user để test
        $correctEmail = "user@test.com";
        $correctPassword = "123456";

        if ($email === $correctEmail && $password === $correctPassword) {
            $_SESSION['user'] = $email;
            header("Location: " . URL_ROOT . "/dashboard");
            exit;
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header("Location: " . URL_ROOT . "/auth");
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: " . URL_ROOT . "/auth");
        exit;
    }

    public function forgotPassword() {
        $message = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            if (empty($email)) {
                $error = 'Vui lòng nhập địa chỉ email';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Địa chỉ email không hợp lệ';
            } else {
                // Kiểm tra xem email có tồn tại trong hệ thống
                $user = $this->userModel->getUserByEmail($email);

                if (!$user) {
                    // Không hiển thị thông báo người dùng không tồn tại vì lý do bảo mật
                    $message = 'Nếu email tồn tại trong hệ thống, bạn sẽ nhận được một liên kết đặt lại mật khẩu';
                } else {
                    // Tạo token reset
                    $token = bin2hex(random_bytes(32));
                    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

                    if ($this->userModel->createPasswordReset($user->user_id, $email, $token, $expiresAt)) {
                        // Tạo liên kết reset
                        $resetLink = URL_ROOT . '/reset-password?token=' . $token;

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

        require APP_ROOT . '/app/views/auth/forgot-password.php';
    }

    public function resetPassword() {
        $token = $_GET['token'] ?? '';
        $message = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            // Kiểm tra token
            $resetRecord = $this->userModel->getPasswordResetByToken($token);

            if (!$resetRecord) {
                $error = 'Token không hợp lệ hoặc đã hết hạn';
            } elseif (empty($password)) {
                $error = 'Vui lòng nhập mật khẩu mới';
            } elseif (strlen($password) < 6) {
                $error = 'Mật khẩu phải có ít nhất 6 ký tự';
            } elseif ($password !== $password_confirm) {
                $error = 'Mật khẩu không khớp';
            } else {
                // Hash mật khẩu và cập nhật
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                if ($this->userModel->updatePassword($resetRecord->user_id, $hashedPassword)) {
                    $this->userModel->markResetTokenUsed($resetRecord->reset_id);
                    $_SESSION['success'] = 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập';
                    header("Location: " . URL_ROOT . "/auth");
                    exit;
                } else {
                    $error = 'Có lỗi xảy ra. Vui lòng thử lại sau';
                }
            }
        } else {
            // Kiểm tra token khi tải trang
            $resetRecord = $this->userModel->getPasswordResetByToken($token);
            if (!$resetRecord) {
                $error = 'Token không hợp lệ hoặc đã hết hạn';
            }
        }

        require APP_ROOT . '/app/views/auth/reset-password.php';
    }
}
