<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Đăng nhập LAS-XD</title>
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .company-logo {
            max-width: 100px;
            margin-bottom: 15px;
        }
        .company-name {
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: 1px;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ced4da;
        }
        .btn-login {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            background-color: #0d6efd;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="card login-card p-4">
                <div class="card-body">
                    <div class="text-center">
                      <img src="../../public/img/logo1.png" class="rounded" alt="logo" width="200">
                        <h4 class="company-name text-uppercase">LAS-XD</h4>
                    </div>

                    <?php if(isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center py-2" style="font-size: 0.9rem;">
                            Tên đăng nhập hoặc mật khẩu không đúng!
                        </div>
                    <?php endif; ?>

                    <form action="/login" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Tên đăng nhập</label>
                            <input type="text" name="username" class="form-control" placeholder="Nhập tài khoản" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" placeholder="********" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-login w-100">
                            ĐĂNG NHẬP
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <small class="text-muted">© 2026 Hệ thống quản lý LAS-XD</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>