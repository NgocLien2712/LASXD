<?php
namespace App\Models;

class LoaiVatLieu extends BaseModel
{
    // Lấy tất cả loại vật liệu
    public function getAll()
    {
        $sql = "SELECT * FROM loai_vat_lieu ORDER BY lvl_ten ASC";
        return $this->db->query($sql)->fetchAll();
    }
}