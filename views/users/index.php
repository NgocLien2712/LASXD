<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= $title ?></title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Danh sách nhân viên LAS-XD</h3>
            <a href="/dashboard" class="btn btn-secondary">Quay lại</a>
        </div>
        
        <div class="card shadow">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã NV</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th>Chức vụ</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($employees as $emp): ?>
                        <tr>
                            <td><?= $emp['nv_ma'] ?></td>
                            <td><?= $emp['nv_tendn'] ?></td>
                            <td><?= $emp['nv_ten'] ?></td>
                            <td><?= $emp['nv_sdt'] ?></td>
                            <td><span class="badge bg-info text-dark"><?= $emp['role_name'] ?></span></td>
                            <td>
                                <button class="btn btn-sm btn-warning">Sửa</button>
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>