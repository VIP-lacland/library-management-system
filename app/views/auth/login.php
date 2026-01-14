<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Hệ thống Thư viện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/login.css">
</head>
<body class="login-body">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="card login-card shadow-lg">
                <div class="login-header">
                    <h4 class="mb-0">LIBRARY MANAGEMENT</h4>
                    <small>Vui lòng đăng nhập để tiếp tục</small>
                </div>
                
                <div class="card-body p-4">
                    <?php if(isset($data['error'])): ?>
                        <div class="alert alert-danger py-2 small text-center">
                            <?php echo $data['error']; ?>
                        </div>
                    <?php endif; ?>

                    <form action="/auth/login" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" 
                                   placeholder="example@gmail.com" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" 
                                   placeholder="******" required>
                        </div>

                        <button type="submit" class="btn btn-login w-100 shadow-sm">
                            ĐĂNG NHẬP
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <a href="/auth/forgot" class="auth-link">Quên mật khẩu?</a>
                    </div>
                </div>
            </div>
            
            <p class="text-center mt-4 text-muted small">&copy; 2024 Library Team - Sprint 1</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>