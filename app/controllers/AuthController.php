<?php

class AuthController extends Controller
{
    public function loginForm()
    {
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

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['name'];
            $this->redirect(url('index.php?action=index'));
        } else {
            // Login failed
            $this->setFlash('error', 'Invalid email or password');
            $this->redirect(url('index.php?action=login'));
        }
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
                $error = 'Enter your email';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Invalid email address';
            } else {
                // Kiểm tra xem email có tồn tại trong hệ thống
                $userModel = $this->model('User');
                $user = $userModel->getUserByEmail($email);

                if (!$user) {
                    // Không hiển thị thông báo người dùng không tồn tại vì lý do bảo mật
                    $message = 'If the email exists in our system, you will receive a password reset link';
                } else {
                    // Tạo token reset
                    $token = bin2hex(random_bytes(32));
                    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

                    if ($userModel->createPasswordReset($user->user_id, $email, $token, $expiresAt)) {
                        // Tạo liên kết reset
                        $resetLink = url('index.php?action=reset-password&token=' . $token);

                        // Gửi email (trong production sử dụng PHPMailer hoặc SwiftMailer)
                        $subject = 'Reset Password – Library Management System';
                        $body = "Hello " . $user->name . ",\n\n";
                        $body .= "You have requested to reset your password.\n";
                        $body .= "Click the link below to reset your password:\n\n";
                        $body .= $resetLink . "\n\n";
                        $body .= "This link will expire in 1 hour.\n\n";
                        $body .= "If you did not request a password reset, please ignore this email.\n\n";
                        $body .= "Sincerely,\nLibrary Management System";

                        $headers = "From: noreply@library.com\r\n";
                        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                        // Thực hiện gửi email (bạn cần cấu hình SMTP hoặc sử dụng mail())
                        mail($email, $subject, $body, $headers);

                        $message = 'If the email exists in our system, you will receive a password reset link.';
                    } else {
                        $error = 'An error occurred. Please try again later.';
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
                // Hash mật khẩu và cập nhật
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                if ($userModel->updatePassword($resetRecord->user_id, $hashedPassword)) {
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
