<?php

namespace App\Models;

class DuAn extends BaseModel
{
    // Lấy danh sách dự án và tên Nhà thầu thi công
    public function getAllWithNhaThau($keyword = '')
    {
        $sql = "SELECT da.*, 
            (SELECT dv.dv_ten FROM du_an_don_vi dadv 
             JOIN don_vi dv ON dadv.dv_ma = dv.dv_ma 
             WHERE dadv.da_ma = da.da_ma AND dadv.vai_tro = 'Nhà thầu thi công' LIMIT 1) as nha_thau_thi_cong
            FROM du_an da ";

        $params = [];
        if (!empty($keyword)) {
            $sql .= " WHERE da.da_ten ILIKE :keyword OR da.da_ma_hieu ILIKE :keyword ";
            $params['keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY da.da_ma DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Thêm dự án mới (Trả về ID dự án vừa thêm)
    public function insertProject($ma_hieu, $ten, $diachi, $ngay_bat_dau)
    {
        $sql = "INSERT INTO du_an (da_ma_hieu, da_ten, da_diachi, da_ngay_bat_dau) 
                VALUES (:ma_hieu, :ten, :diachi, :ngay_bat_dau) RETURNING da_ma";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'ma_hieu' => $ma_hieu,
            'ten' => $ten,
            'diachi' => $diachi,
            'ngay_bat_dau' => $ngay_bat_dau
        ]);
        return $stmt->fetchColumn();
    }

    // Gắn đơn vị vào dự án với vai trò cụ thể
    public function insertProjectRole($da_ma, $dv_ma, $vai_tro)
    {
        $sql = "INSERT INTO du_an_don_vi (da_ma, dv_ma, vai_tro) VALUES (:da_ma, :dv_ma, :vai_tro)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['da_ma' => $da_ma, 'dv_ma' => $dv_ma, 'vai_tro' => $vai_tro]);
    }


    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM du_an WHERE da_ma = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Lấy thông tin dự án cơ bản
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM du_an WHERE da_ma = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Lấy danh sách các đơn vị đã được gán vào dự án này
    public function getRolesByProjectId($id)
    {
        $stmt = $this->db->prepare("SELECT dv_ma, vai_tro FROM du_an_don_vi WHERE da_ma = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetchAll();

        // Chuyển mảng thành dạng Key-Value: ['Ban quản lý dự án' => 1, 'Nhà thầu thi công' => 5...]
        $roles = [];
        foreach ($result as $row) {
            $roles[$row['vai_tro']] = $row['dv_ma'];
        }
        return $roles;
    }

    // Cập nhật thông tin dự án
    public function updateProject($id, $ma_hieu, $ten, $diachi, $ngay_bat_dau)
    {
        $sql = "UPDATE du_an SET da_ma_hieu = :ma_hieu, da_ten = :ten, da_diachi = :diachi, da_ngay_bat_dau = :ngay_bat_dau WHERE da_ma = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'ma_hieu' => $ma_hieu,
            'ten' => $ten,
            'diachi' => $diachi,
            'ngay_bat_dau' => $ngay_bat_dau,
            'id' => $id
        ]);
    }

    // Xóa toàn bộ liên kết đơn vị cũ của dự án (để chuẩn bị thêm cái mới)
    public function clearProjectRoles($da_ma)
    {
        $stmt = $this->db->prepare("DELETE FROM du_an_don_vi WHERE da_ma = :id");
        return $stmt->execute(['id' => $da_ma]);
    }

    public function getAll() {
    $stmt = $this->db->prepare("SELECT * FROM du_an ORDER BY da_ma DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}
}
