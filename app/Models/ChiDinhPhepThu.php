<?php
namespace App\Models;

class ChiDinhPhepThu extends BaseModel {
    
    // Lấy danh sách phép thử đã được chỉ định cho 1 mẫu
    public function getByMauId($mtn_ma) {
        // 1. Lấy danh sách phép thử từ bảng mới: phep_thu
        $sql = "SELECT cd.*, pt.pt_ten AS ten_phep_thu, pt.pt_tieu_chuan AS tieu_chuan 
                FROM chi_dinh_phep_thu cd
                JOIN phep_thu pt ON cd.pt_ma = pt.pt_ma
                WHERE cd.mtn_ma = :mtn_ma";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['mtn_ma' => $mtn_ma]);
        $danhSachPhepThu = $stmt->fetchAll();

        // 2. Lấy luôn cấu hình các trường (Kích thước a, Lực P...) cho từng phép thử
        foreach ($danhSachPhepThu as &$pt) {
            $sqlTruong = "SELECT * FROM cau_hinh_truong WHERE pt_ma = :pt_ma ORDER BY cht_ma ASC";
            $stmtTruong = $this->db->prepare($sqlTruong);
            $stmtTruong->execute(['pt_ma' => $pt['pt_ma']]);
            $pt['danh_sach_truong'] = $stmtTruong->fetchAll();
        }

        return $danhSachPhepThu;
    }

    // Xóa toàn bộ phép thử cũ của mẫu trước khi lưu cái mới
    public function deleteByMauId($mtn_ma) {
        $stmt = $this->db->prepare("DELETE FROM chi_dinh_phep_thu WHERE mtn_ma = :mtn_ma");
        return $stmt->execute(['mtn_ma' => $mtn_ma]);
    }

    // Thêm phép thử mới vào mẫu
    public function insert($mtn_ma, $pt_ma) {
        $sql = "INSERT INTO chi_dinh_phep_thu (mtn_ma, pt_ma) VALUES (:mtn_ma, :pt_ma)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'mtn_ma' => $mtn_ma,
            'pt_ma' => $pt_ma
        ]);
    }
}