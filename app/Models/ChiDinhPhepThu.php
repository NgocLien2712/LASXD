<?php
namespace App\Models;

class ChiDinhPhepThu extends BaseModel {
    
    // Lấy danh sách phép thử đã được chỉ định cho 1 mẫu
    public function getByMauId($mtn_ma) {
        $sql = "SELECT cd.*, pt.pt_ten AS ten_phep_thu, pt.pt_tieu_chuan AS tieu_chuan 
                FROM chi_dinh_phep_thu cd
                JOIN danh_muc_phep_thu pt ON cd.pt_ma = pt.pt_ma
                WHERE cd.mtn_ma = :mtn_ma";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['mtn_ma' => $mtn_ma]);
        return $stmt->fetchAll();
    }

    // Xóa toàn bộ phép thử cũ của mẫu trước khi lưu cái mới (để tránh trùng lặp khi edit)
    public function deleteByMauId($mtn_ma) {
        $stmt = $this->db->prepare("DELETE FROM chi_dinh_phep_thu WHERE mtn_ma = :mtn_ma");
        return $stmt->execute(['mtn_ma' => $mtn_ma]);
    }

    // Thêm phép thử mới vào mẫu
    public function insert($mtn_ma, $pt_ma) {
        $sql = "INSERT INTO chi_dinh_phep_thu (mtn_ma, pt_ma) VALUES (:mtn_ma, :pt_ma)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['mtn_ma' => $mtn_ma, 'pt_ma' => $pt_ma]);
    }
}