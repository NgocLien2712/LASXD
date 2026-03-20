<?php
namespace App\Models;
use App\Core\Database;

class PhieuYeuCau {
    protected $db;

    public function __construct() {
        // Lưu ý: Dùng getConnection() theo cấu trúc Core của bạn
        $this->db = Database::getConnection(); 
    }

    public function getAll($keyword = '') {
    // Dùng JOIN để lấy tên Dự án và Tên nhân viên từ các bảng khác
    $sql = "SELECT pyc.*, da.da_ten, nv.nv_ten 
            FROM phieu_yeu_cau pyc
            LEFT JOIN du_an da ON pyc.da_ma = da.da_ma
            LEFT JOIN nhan_vien nv ON pyc.nv_lap_phieu = nv.nv_ma
            WHERE pyc.pyc_so_phieu LIKE :keyword 
            ORDER BY pyc.pyc_ma DESC";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['keyword' => '%' . $keyword . '%']);
    return $stmt->fetchAll();
}

    public function insert($data) {
        $sql = "INSERT INTO phieu_yeu_cau (pyc_so_phieu, da_ma, nv_lap_phieu, pyc_ngay_nhan_mau, pyc_trang_thai) 
                VALUES (:pyc_so_phieu, :da_ma, :nv_lap_phieu, :pyc_ngay_nhan_mau, :pyc_trang_thai)";
        return $this->db->prepare($sql)->execute($data);
    }

    public function taoSoPhieuTuDong($ngay_nhan_mau) {
        // Chuyển ngày thành chuỗi, ví dụ: 2026-03-20 -> 20260320
        $ngay_chuoi = date('Ymd', strtotime($ngay_nhan_mau));
        $prefix = "PYC-" . $ngay_chuoi . "-";

        // Tìm số phiếu lớn nhất trong ngày đó
        $sql = "SELECT pyc_so_phieu FROM phieu_yeu_cau 
                WHERE pyc_so_phieu LIKE :prefix 
                ORDER BY pyc_so_phieu DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['prefix' => $prefix . '%']);
        $phieu_cuoi = $stmt->fetchColumn();

        if ($phieu_cuoi) {
            // Cắt lấy 3 số cuối và cộng thêm 1. VD: "001" -> 2
            $so_cuoi = (int) substr($phieu_cuoi, -3);
            $so_moi = $so_cuoi + 1;
        } else {
            // Nếu chưa có phiếu nào trong ngày, bắt đầu là 1
            $so_moi = 1;
        }

        // Ghép lại thành chuỗi, hàm str_pad giúp thêm số 0 đằng trước cho đủ 3 số
        return $prefix . str_pad($so_moi, 3, '0', STR_PAD_LEFT);
    }

    // Lấy chi tiết 1 phiếu yêu cầu theo ID (pyc_ma)
    public function getById($id) {
        $sql = "SELECT pyc.*, da.da_ten, da.da_diachi, nv.nv_ten 
                FROM phieu_yeu_cau pyc
                LEFT JOIN du_an da ON pyc.da_ma = da.da_ma
                LEFT JOIN nhan_vien nv ON pyc.nv_lap_phieu = nv.nv_ma
                WHERE pyc.pyc_ma = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}