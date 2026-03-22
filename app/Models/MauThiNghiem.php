<?php

namespace App\Models;

class MauThiNghiem extends BaseModel
{

    public function getByPhieuId($pyc_ma)
    {
        $sql = "SELECT mtn.*, lvl.lvl_ten AS mtn_ten, cl.cl_ten AS mtn_quy_cach
                FROM mau_thi_nghiem mtn
                JOIN loai_vat_lieu lvl ON mtn.lvl_ma = lvl.lvl_ma
                JOIN chung_loai cl ON mtn.cl_ma = cl.cl_ma
                WHERE mtn.pyc_ma = :pyc_ma ORDER BY mtn.mtn_ma ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['pyc_ma' => $pyc_ma]);
        return $stmt->fetchAll();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO mau_thi_nghiem (pyc_ma, lvl_ma, cl_ma, mtn_so_luong, mtn_ngay_lay, mtn_ghi_chu)
                VALUES (:pyc_ma, :lvl_ma, :cl_ma, :mtn_so_luong, :mtn_ngay_lay, :mtn_ghi_chu)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'pyc_ma' => $data['pyc_ma'],
            'lvl_ma' => $data['lvl_ma'],
            'cl_ma' => $data['cl_ma'],
            'mtn_so_luong' => $data['mtn_so_luong'],
            'mtn_ngay_lay' => $data['mtn_ngay_lay'],
            'mtn_ghi_chu' => $data['mtn_ghi_chu']
        ]);
    }

    // Cập nhật thông tin mẫu thí nghiệm
    public function update($data) {
        $sql = "UPDATE mau_thi_nghiem 
                SET lvl_ma = :lvl_ma, cl_ma = :cl_ma, mtn_so_luong = :mtn_so_luong, 
                    mtn_ngay_lay = :mtn_ngay_lay, mtn_ghi_chu = :mtn_ghi_chu
                WHERE mtn_ma = :mtn_ma";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'mtn_ma' => $data['mtn_ma'],
            'lvl_ma' => $data['lvl_ma'],
            'cl_ma' => $data['cl_ma'],
            'mtn_so_luong' => $data['mtn_so_luong'],
            'mtn_ngay_lay' => $data['mtn_ngay_lay'],
            'mtn_ghi_chu' => $data['mtn_ghi_chu']
        ]);
    }

    // Xóa mẫu thí nghiệm (sẽ tự động xóa luôn các phép thử bên trong nhờ ON DELETE CASCADE)
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM mau_thi_nghiem WHERE mtn_ma = :id");
        return $stmt->execute(['id' => $id]);
    }
}
