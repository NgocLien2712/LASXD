<?php
namespace App\Models;

class ChiDinhPhepThu extends BaseModel {
    
    // Lấy danh sách phép thử của 1 Mẫu cụ thể
    public function getByMauId($mtn_ma) {
        $sql = "SELECT * FROM chi_dinh_phep_thu WHERE mtn_ma = :mtn_ma ORDER BY cdpt_ma ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['mtn_ma' => $mtn_ma]);
        return $stmt->fetchAll();
    }

    // Lưu phép thử mới
    public function insert($data) {
        $sql = "INSERT INTO chi_dinh_phep_thu (mtn_ma, ten_phep_thu, tieu_chuan, cdpt_ghi_chu) 
                VALUES (:mtn_ma, :ten_phep_thu, :tieu_chuan, :cdpt_ghi_chu)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'mtn_ma'       => $data['mtn_ma'],
            'ten_phep_thu' => $data['ten_phep_thu'],
            'tieu_chuan'   => $data['tieu_chuan'],
            'cdpt_ghi_chu' => $data['cdpt_ghi_chu']
        ]);
    }
}