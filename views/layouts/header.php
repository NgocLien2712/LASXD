<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Hệ thống Quản lý LAS-XD' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Chỉnh lại Sidebar để khớp với Header mới */
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #2c3e50;
        }

        #sidebar ul li a {
            padding: 15px 25px;
            display: block;
            color: #bdc3c7;
            text-decoration: none;
        }

        #sidebar ul li a:hover {
            color: #fff;
            background: #34495e;
        }

        #sidebar ul li.active>a {
            color: #fff;
            background: #3498db;
            border-left: 5px solid #fff;
        }

        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
    </style>
</head>

<body class="d-flex flex-column vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm px-3" style="background-color: #1a252f; z-index: 1000;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/dashboard">
                <img src="/img/logolasxd.png" alt="Logo" width="70" height="auto" class="d-inline-block align-text-top me-2">
                <span class="fw-bold tracking-wide" style="letter-spacing: 1px;">LAS-XD <br> Quản lý phòng thí nghiệm</span>
            </a>

            <div class="ms-auto d-flex align-items-center text-light">
                <i class="fas fa-bell text-warning me-4 fa-lg" style="cursor: pointer;"></i>
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'Admin') ?>&background=random"
                    class="rounded-circle me-2" alt="Avatar" width="35" height="35">
                <div class="d-flex flex-column me-3 lh-1">
                    <strong class="mb-1"><?= $_SESSION['user_name'] ?? 'Admin' ?></strong>
                    <small class="text-info"><?= $_SESSION['user_role'] ?? 'Quản trị' ?></small>
                </div>
                <a href="/logout" class="btn btn-sm btn-outline-danger border-0" title="Đăng xuất">
                    <i class="fas fa-power-off fa-lg"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="d-flex flex-grow-1 overflow-hidden">