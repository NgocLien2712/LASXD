<?php
namespace App\Models;

class MauThiNghiem extends BaseModel {
    
    // Lấy danh sách mẫu thuộc về 1 Phiếu yêu cầu cụ thể
    public function getByPhieuId($pyc_ma) {
        $sql = "SELECT * FROM mau_thi_nghiem WHERE pyc_ma = :pyc_ma ORDER BY mtn_ma ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['pyc_ma' => $pyc_ma]);
        return $stmt->fetchAll();
    }

    // Thêm mẫu mới
    public function insert($data) {
        $sql = "INSERT INTO mau_thi_nghiem (pyc_ma, mtn_ten, mtn_quy_cach, mtn_so_luong, mtn_ngay_lay, mtn_ghi_chu) 
                VALUES (:pyc_ma, :mtn_ten, :mtn_quy_cach, :mtn_so_luong, :mtn_ngay_lay, :mtn_ghi_chu)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'pyc_ma'       => $data['pyc_ma'],
            'mtn_ten'      => $data['mtn_ten'],
            'mtn_quy_cach' => $data['mtn_quy_cach'],
            'mtn_so_luong' => $data['mtn_so_luong'],
            'mtn_ngay_lay' => $data['mtn_ngay_lay'],
            'mtn_ghi_chu'  => $data['mtn_ghi_chu']
        ]);
    }
}