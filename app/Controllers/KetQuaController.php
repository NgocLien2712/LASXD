<?php

namespace App\Controllers;

use App\Models\KetQua;

class KetQuaController extends BaseController
{
    // 1. Trang danh sách quản lý kết quả (/ket-qua)

    public function index()
    {
        $this->checkAuth();

        $ketQuaModel = new KetQua();

        // 1. Tab 1: Danh sách chưa nhập
        $danhSachChuaNhap = $ketQuaModel->getDanhSachChuaNhap();

        // 2. Tab 2: Danh sách chờ duyệt
        $danhSachChoDuyet = $ketQuaModel->getDanhSachTheoTrangThai('Chờ duyệt');

        // 3. Tab 3: Danh sách đã ban hành
        $danhSachDaBanHanh = $ketQuaModel->getDanhSachTheoTrangThai('Đã ban hành');

        // Truyền cả 3 biến này sang View
        return $this->render('ket-qua/index', [
            'danhSachChuaNhap'  => $danhSachChuaNhap,
            'danhSachChoDuyet'  => $danhSachChoDuyet,
            'danhSachDaBanHanh' => $danhSachDaBanHanh
        ]);
    }

    // 2. Hiển thị form nhập số liệu thô (/ket-qua/nhap)

    public function nhapKetQua()
    {
        $this->checkAuth();

        $pyc_ma = $_GET['pyc_ma'] ?? null;
        if (!$pyc_ma) {
            die('Lỗi: Không tìm thấy mã phiếu yêu cầu trên URL.');
        }

        // Khởi tạo Model
        $ketQuaModel = new KetQua();

        // Gọi dữ liệu thật từ Database
        $phieu = $ketQuaModel->getChiTietPhieu($pyc_ma);
        $danhSachMau = $ketQuaModel->getDanhSachMauVaPhepThu($pyc_ma);

        // Truyền đầy đủ dữ liệu sang View 'nhap.php'
        return $this->render('ket-qua/nhap', [
            'phieu' => $phieu,
            'danhSachMau' => $danhSachMau,
            'title' => 'Nhập số liệu đo đạc'
        ]);
    }

    // 3. Xử lý lưu số liệu thô và kết luận vào Database (/ket-qua/luu)

    public function luuKetQua()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ketQuaModel = new KetQua();
            $pyc_ma = $_POST['pyc_ma'] ?? null;
            
            // Lấy ID người dùng đang đăng nhập làm người thực hiện
            $nv_thuc_hien = $_SESSION['user_id'] ?? 1; 
            
            // Lấy ngày thí nghiệm từ form
            $ngay_thi_nghiem = $_POST['ngay_thi_nghiem'] ?? date('Y-m-d'); 

            // Bắt dữ liệu mảng từ form gửi lên
            $duLieuTho = $_POST['du_lieu'] ?? [];
            $ketQuaCuoi = $_POST['ket_qua_cuoi'] ?? [];

            try {
                // Lặp qua từng kết quả cuối để lưu
                foreach ($ketQuaCuoi as $mtn_ma => $phepThuArray) {
                    foreach ($phepThuArray as $pt_ma => $kq_ket_luan) {

                        // CHỖ NÀY ĐÃ SỬA LỖI: Tạo chuỗi JSON
                        $duLieuThoJson = isset($duLieuTho[$mtn_ma][$pt_ma])
                            ? json_encode($duLieuTho[$mtn_ma][$pt_ma], JSON_UNESCAPED_UNICODE)
                            : '{}';

                        $cong_thuc_su_dung = ''; 

                        // CHỖ NÀY ĐÃ SỬA LỖI: Truyền đúng biến $duLieuThoJson
                        $ketQuaModel->insertKetQua(
                            $pyc_ma,
                            $mtn_ma,
                            $pt_ma,
                            $nv_thuc_hien,
                            $duLieuThoJson, // <--- Sửa $kq_du_lieu_tho thành $duLieuThoJson
                            $kq_ket_luan,
                            $cong_thuc_su_dung,
                            $ngay_thi_nghiem // Đã truyền ngày thí nghiệm
                        );
                    }
                }

                // Cập nhật trạng thái phiếu để nhảy sang Tab "Chờ duyệt"
                if ($pyc_ma) {
                    $ketQuaModel->updateTrangThaiPhieu($pyc_ma, 'Chờ duyệt');
                }

                header('Location: /ket-qua?msg=success');
                exit;
            } catch (\PDOException $e) {
                echo "Lỗi lưu dữ liệu: " . $e->getMessage();
            }
        }
    }

    //  4. Xử lý Duyệt phiếu (Chuyển từ Chờ duyệt -> Đã ban hành)
    public function duyetPhieu()
    {
        $this->checkAuth();
        $pyc_ma = $_GET['pyc_ma'] ?? null;
        
        // Lấy ID người đang đăng nhập từ Session (Người duyệt) - Chú ý key session của bạn, mặc định mình để là user_id
        $nguoi_duyet_id = $_SESSION['user_id'] ?? 1; 
        $ngay_duyet = date('Y-m-d');

        if ($pyc_ma) {
            $ketQuaModel = new \App\Models\KetQua(); // Có thể dùng namespace nếu cần
            
            // Gọi hàm vừa tạo bên Model để xử lý database
            $ketQuaModel->xacNhanDuyetPhieu($pyc_ma, $nguoi_duyet_id, $ngay_duyet);
        }

        header('Location: /ket-qua?msg=duyet_success');
        exit;
    }

    // 5. Hiển thị trang in kết quả (/ket-qua/xem?pyc_ma=...)
    public function xem()
    {
        $this->checkAuth();

        $pyc_ma = $_GET['pyc_ma'] ?? null;
        if (!$pyc_ma) {
            die('Lỗi: Không tìm thấy mã phiếu.');
        }

        $ketQuaModel = new KetQua();

        // Lấy thông tin chung của phiếu (Lưu ý: Bạn phải đảm bảo hàm này đã dùng JOIN để lấy Tên và Chức vụ người nhập nhé)
        $phieu = $ketQuaModel->getChiTietPhieu($pyc_ma);

        // Lấy danh sách mẫu và kết quả
        $danhSachMau = $ketQuaModel->getDanhSachMauVaKetQua($pyc_ma);

        return $this->render('ket-qua/xem', [
            'title' => 'In Kết Quả Thí Nghiệm',
            'phieu' => $phieu,
            'danhSachMau' => $danhSachMau
        ]);
    }
}