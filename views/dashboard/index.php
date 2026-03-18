<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= $title ?></title>
    <style>
        .sidebar { min-height: 100vh; background: #212529; color: white; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 10px 20px; }
        .sidebar a:hover { background: #343a40; color: white; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-0">
            <h3 class="p-3 text-center text-primary">LAS-XD</h3>
            <a href="/dashboard">🏠 Tổng quan</a>
            <a href="/nhan-vien">👥 Quản lý nhân viên</a>
            <a href="/du-an">🏗️ Dự án / Công trình</a>
            <a href="/bieu-mau">📄 Tiêu chuẩn thí nghiệm</a>
            <hr>
            <a href="/logout" class="text-danger">🚪 Đăng xuất</a>
        </div>
        
        <div class="col-md-10 p-4">
            <h4>Chào mừng, <?= $user_name ?> (<?= $user_role ?>)</h4>
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white p-3">
                        <h5>Dự án đang chạy</h5>
                        <h2>12</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white p-3">
                        <h5>Mẫu chờ duyệt</h5>
                        <h2>45</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>