<?php
namespace App\Models;

class DanhMuc extends BaseModel {
    // Lấy danh sách Loại vật liệu
    public function getTatCaLoaiVatLieu() {
        return $this->db->query("SELECT * FROM loai_vat_lieu ORDER BY lvl_ten ASC")->fetchAll();
    }

    // Lấy Chủng loại (Quy cách) dựa theo ID của Loại vật liệu
    public function getChungLoaiByVatLieu($lvl_ma) {
        $stmt = $this->db->prepare("SELECT * FROM chung_loai WHERE lvl_ma = :lvl_ma ORDER BY cl_ten ASC");
        $stmt->execute(['lvl_ma' => $lvl_ma]);
        return $stmt->fetchAll();
    }

    // Lấy danh sách phép thử dựa theo ID của Loại vật liệu
    public function getPhepThuByVatLieu($lvl_ma) {
        $stmt = $this->db->prepare("SELECT * FROM danh_muc_phep_thu WHERE lvl_ma = :lvl_ma ORDER BY pt_ten ASC");
        $stmt->execute(['lvl_ma' => $lvl_ma]);
        return $stmt->fetchAll();
    }
}