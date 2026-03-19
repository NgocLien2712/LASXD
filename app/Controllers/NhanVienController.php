<?php

namespace App\Controllers;

use App\Models\NhanVien;

class NhanVienController extends BaseController
{

    // Hiển thị danh sách nhân viên
    public function index() {
        $this->checkAuth();

        // Bắt từ khóa tìm kiếm và bộ lọc từ thanh URL (nếu có)
        $keyword = $_GET['keyword'] ?? '';
        $cv_ma = $_GET['cv_ma'] ?? '';

        $nhanVienModel = new NhanVien();
        
        // Truyền từ khóa vào hàm getAll
        $danhSachNhanVien = $nhanVienModel->getAll($keyword, $cv_ma);
        $danhSachChucVu = $nhanVienModel->getAllChucVu(); // Lấy để đổ vào thẻ <select> bộ lọc

        return $this->render('nhan-vien/index', [
            'title' => 'Quản lý Nhân sự',
            'danhSachNhanVien' => $danhSachNhanVien,
            'danhSachChucVu' => $danhSachChucVu,
            'keyword' => $keyword,
            'cv_ma_filter' => $cv_ma // Truyền lại để giữ nguyên trạng thái dropdown khi F5
        ]);
    }

    public function create()
    {
        $this->checkAuth();
        $nhanVienModel = new NhanVien();
        return $this->render('nhan-vien/create', [
            'title' => 'Thêm nhân viên mới',
            'danhSachChucVu' => $nhanVienModel->getAllChucVu()
        ]);
    }

    public function store()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nv_tendn' => $_POST['nv_tendn'] ?? '',
                // Mã hóa mật khẩu ngay lập tức bằng BCRYPT
                'nv_matkhau' => password_hash($_POST['nv_matkhau'], PASSWORD_BCRYPT),
                'nv_ten' => $_POST['nv_ten'] ?? '',
                'nv_sdt' => $_POST['nv_sdt'] ?? '',
                'cv_ma' => !empty($_POST['cv_ma']) ? $_POST['cv_ma'] : null
            ];

            $nhanVienModel = new NhanVien();
            if ($nhanVienModel->insert($data)) {
                header('Location: /nhan-vien');
                exit;
            } else {
                echo "Lỗi: Tên đăng nhập có thể đã tồn tại!";
            }
        }
    }

    public function edit()
    {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /nhan-vien');
            exit;
        }

        $nhanVienModel = new NhanVien();
        $nhanVien = $nhanVienModel->getById($id);

        if (!$nhanVien) {
            echo "Không tìm thấy nhân viên!";
            exit;
        }

        return $this->render('nhan-vien/edit', [
            'title' => 'Cập nhật thông tin',
            'nhanVien' => $nhanVien,
            'danhSachChucVu' => $nhanVienModel->getAllChucVu()
        ]);
    }

    public function update()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['nv_ma'] ?? null;
            $data = [
                'nv_tendn' => $_POST['nv_tendn'] ?? '',
                'nv_ten' => $_POST['nv_ten'] ?? '',
                'nv_sdt' => $_POST['nv_sdt'] ?? '',
                'cv_ma' => !empty($_POST['cv_ma']) ? $_POST['cv_ma'] : null
            ];

            // Nếu người dùng nhập mật khẩu mới ở ô Sửa, thì mới mã hóa và lưu
            if (!empty($_POST['nv_matkhau'])) {
                $data['nv_matkhau'] = password_hash($_POST['nv_matkhau'], PASSWORD_BCRYPT);
            }

            $nhanVienModel = new NhanVien();
            if ($id && $nhanVienModel->update($id, $data)) {
                header('Location: /nhan-vien');
                exit;
            } else {
                echo "Có lỗi xảy ra khi cập nhật!";
            }
        }
    }

    public function delete()
    {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $nhanVienModel = new NhanVien();
            $nhanVienModel->delete($id);
        }
        header('Location: /nhan-vien');
        exit;
    }
}
