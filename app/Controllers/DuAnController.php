<?php

namespace App\Controllers;

use App\Models\DuAn;

class DuAnController extends BaseController
{

    public function index() {
        $this->checkAuth();
        $keyword = $_GET['keyword'] ?? ''; // Lấy từ khóa

        $duAnModel = new DuAn();
        $danhSachDuAn = $duAnModel->getAll($keyword);

        return $this->render('du-an/index', [
            'title' => 'Quản lý Dự án/Công trình',
            'danhSachDuAn' => $danhSachDuAn,
            'keyword' => $keyword // Truyền ra view
        ]);
    }
    // Hàm 1: Hiển thị giao diện Form
    public function create()
    {
        $this->checkAuth();

        $duAnModel = new DuAn();
        $danhSachDoiTac = $duAnModel->getAllDoiTac();

        return $this->render('du-an/create', [
            'title' => 'Thêm Dự án mới',
            'danhSachDoiTac' => $danhSachDoiTac
        ]);
    }

    // Hàm 2: Nhận dữ liệu từ Form và Lưu vào Database
    public function store()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'da_ten' => $_POST['da_ten'] ?? '',
                'da_diachi' => $_POST['da_diachi'] ?? '',
                'dt_ma_chudautu' => !empty($_POST['dt_ma_chudautu']) ? $_POST['dt_ma_chudautu'] : null,
                'da_ngay_bat_dau' => !empty($_POST['da_ngay_bat_dau']) ? $_POST['da_ngay_bat_dau'] : date('Y-m-d')
            ];

            $duAnModel = new DuAn();
            if ($duAnModel->insert($data)) {
                // Lưu thành công thì chuyển hướng về trang danh sách dự án
                header('Location: /du-an');
                exit;
            } else {
                echo "Có lỗi xảy ra khi lưu vào cơ sở dữ liệu!";
            }
        }
    }

    // Hiển thị Form sửa với dữ liệu cũ
    public function edit() {
        $this->checkAuth();
        
        // Lấy ID từ thanh địa chỉ (ví dụ: /du-an/sua?id=5)
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /du-an'); // Không có ID thì đuổi về trang danh sách
            exit;
        }

        $duAnModel = new DuAn();
        $duAn = $duAnModel->getById($id); // Lấy data dự án cũ
        
        if (!$duAn) {
            echo "Không tìm thấy dự án này trong hệ thống!";
            exit;
        }

        $danhSachDoiTac = $duAnModel->getAllDoiTac();

        return $this->render('du-an/edit', [
            'title' => 'Cập nhật Dự án',
            'duAn' => $duAn,
            'danhSachDoiTac' => $danhSachDoiTac
        ]);
    }

    // Xử lý lưu dữ liệu Cập nhật
    public function update() {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['da_ma'] ?? null; // Lấy ID ẩn từ Form gửi lên
            
            $data = [
                'da_ten' => $_POST['da_ten'] ?? '',
                'da_diachi' => $_POST['da_diachi'] ?? '',
                'dt_ma_chudautu' => !empty($_POST['dt_ma_chudautu']) ? $_POST['dt_ma_chudautu'] : null,
                'da_ngay_bat_dau' => !empty($_POST['da_ngay_bat_dau']) ? $_POST['da_ngay_bat_dau'] : null
            ];

            $duAnModel = new DuAn();
            if ($id && $duAnModel->update($id, $data)) {
                header('Location: /du-an'); // Xong thì quay về danh sách
                exit;
            } else {
                echo "Có lỗi xảy ra khi cập nhật!";
            }
        }
    }

    // Xử lý logic khi người dùng bấm nút Xóa
    public function delete() {
        $this->checkAuth();
        
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $duAnModel = new DuAn();
            // Gọi hàm xóa trong Model
            if ($duAnModel->delete($id)) {
                // Tùy chọn: Bạn có thể lưu một thông báo (Flash Message) vào Session ở đây để hiện thông báo Xóa thành công
            } else {
                // Nếu không xóa được (có thể do vướng khóa ngoại)
                echo "<script>alert('Không thể xóa dự án này vì đang có phiếu yêu cầu liên quan!'); window.location.href='/du-an';</script>";
                exit;
            }
        }
        
        // Xong xuôi thì tự động quay về trang danh sách
        header('Location: /du-an');
        exit;
    }
}
