<?php

namespace App\Controllers;

use App\Models\KetQua;

class KetQuaController extends BaseController
{
    /**
     * 1. Trang danh sách quản lý kết quả (/ket-qua)
     */
    public function index()
    {
        $this->checkAuth();

        $ketQuaModel = new KetQua();
        $danhSach = $ketQuaModel->getDanhSachChuaNhap();

        return $this->render('ket-qua/index', [
            'danhSach' => $danhSach
        ]);
    }

    /**
     * 2. Hiển thị form nhập số liệu thô (/ket-qua/nhap)
     */
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

    /**
     * 3. Xử lý lưu số liệu thô và kết luận vào Database (/ket-qua/luu)
     */
    public function luuKetQua()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $ketQuaModel = new KetQua();

            $pyc_ma = $_POST['pyc_ma'] ?? null;
            $mtn_ma = $_POST['mtn_ma'] ?? null;
            $pt_ma = $_POST['pt_ma'] ?? null;
            $cong_thuc_su_dung = $_POST['cong_thuc_su_dung'] ?? null;
            $kq_du_lieu_tho = $_POST['kq_du_lieu_tho'] ?? '{}'; 
            $kq_ket_luan = $_POST['kq_ket_luan'] ?? null; 
            
            $nv_thuc_hien = $_SESSION['user_id'] ?? 1;

            try {
                $ketQuaModel->insertKetQua(
                    $pyc_ma, 
                    $mtn_ma, 
                    $pt_ma, 
                    $nv_thuc_hien, 
                    $kq_du_lieu_tho, 
                    $kq_ket_luan, 
                    $cong_thuc_su_dung
                );

                header('Location: /ket-qua?msg=success');
                exit;

            } catch (\PDOException $e) {
                echo "Lỗi lưu dữ liệu: " . $e->getMessage();
            }
        }
    }
}