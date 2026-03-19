<?php
namespace App\Models;
use App\Core\Database;

class DoiTac {
    protected $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Lấy danh sách có hỗ trợ tìm kiếm và lọc theo loại
    public function getAll($keyword = '', $loai = '') {
        $sql = "SELECT * FROM doi_tac WHERE 1=1";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (dt_ten ILIKE :keyword OR dt_mst ILIKE :keyword OR dt_diachi ILIKE :keyword)";
            $params['keyword'] = '%' . $keyword . '%';
        }

        if (!empty($loai)) {
            $sql .= " AND dt_loai = :loai";
            $params['loai'] = $loai;
        }

        $sql .= " ORDER BY dt_ma DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM doi_tac WHERE dt_ma = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function insert($data) {
        $sql = "INSERT INTO doi_tac (dt_ten, dt_mst, dt_diachi, dt_loai) 
                VALUES (:dt_ten, :dt_mst, :dt_diachi, :dt_loai)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $sql = "UPDATE doi_tac SET dt_ten = :dt_ten, dt_mst = :dt_mst, 
                dt_diachi = :dt_diachi, dt_loai = :dt_loai WHERE dt_ma = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM doi_tac WHERE dt_ma = :id");
        return $stmt->execute(['id' => $id]);
    }
}