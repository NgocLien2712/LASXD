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
        // Trong cấu trúc DB mới, phép thử gắn với chủng loại (chung_loai), còn chung_loai gắn với loai_vat_lieu
        $stmt = $this->db->prepare(
            "SELECT pt.* FROM phep_thu pt
             JOIN chung_loai cl ON pt.cl_ma = cl.cl_ma
             WHERE cl.lvl_ma = :lvl_ma
             ORDER BY pt.pt_ten ASC"
        );
        $stmt->execute(['lvl_ma' => $lvl_ma]);
        return $stmt->fetchAll();
    }
}