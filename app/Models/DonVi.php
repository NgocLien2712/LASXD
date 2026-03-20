<?php
namespace App\Models;

class DonVi extends BaseModel {
    // Lấy danh sách đơn vị cơ bản (để đổ vào thẻ <select> lúc thêm Dự án)
    public function getAll() {
        return $this->db->query("SELECT * FROM don_vi ORDER BY dv_ten ASC")->fetchAll();
    }

    // Thêm đơn vị mới (Chỉ cần tên)
    public function insert($ten) {
        $stmt = $this->db->prepare("INSERT INTO don_vi (dv_ten) VALUES (:ten)");
        return $stmt->execute(['ten' => $ten]);
    }

    // Cập nhật hàm này để nhận thêm từ khóa tìm kiếm
public function getAllWithProjects($keyword = '') {
    $sql = "SELECT dv.dv_ma, dv.dv_ten,
            (SELECT STRING_AGG(da.da_ten || ' - <span class=\"text-danger\">[' || dadv.vai_tro || ']</span>', '<br>') 
             FROM du_an_don_vi dadv 
             JOIN du_an da ON dadv.da_ma = da.da_ma 
             WHERE dadv.dv_ma = dv.dv_ma) AS cac_du_an
            FROM don_vi dv ";
    
    $params = [];
    // Nếu có từ khóa, thêm điều kiện tìm kiếm bằng ILIKE (không phân biệt hoa thường)
    if (!empty($keyword)) {
        $sql .= " WHERE dv.dv_ten ILIKE :keyword ";
        $params['keyword'] = '%' . $keyword . '%';
    }
    
    $sql .= " ORDER BY dv.dv_ma DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Thêm hàm Xóa đơn vị
public function delete($id) {
    // Vì đã set ON DELETE CASCADE trong CSDL, xóa đơn vị sẽ tự xóa các liên kết trong bảng trung gian
    $stmt = $this->db->prepare("DELETE FROM don_vi WHERE dv_ma = :id");
    return $stmt->execute(['id' => $id]);
}

// Lấy thông tin 1 đơn vị theo ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM don_vi WHERE dv_ma = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Cập nhật tên đơn vị
    public function update($id, $ten) {
        $stmt = $this->db->prepare("UPDATE don_vi SET dv_ten = :ten WHERE dv_ma = :id");
        return $stmt->execute(['id' => $id, 'ten' => $ten]);
    }
}