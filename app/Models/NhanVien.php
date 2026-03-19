<?php
namespace App\Models;
use App\Core\Database;

class NhanVien {
    protected $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Thêm tham số $keyword và $cv_ma vào hàm
    public function getAll($keyword = '', $cv_ma = '') {
        $sql = "SELECT nv.*, cv.cv_ten 
                FROM nhan_vien nv 
                LEFT JOIN chuc_vu cv ON nv.cv_ma = cv.cv_ma 
                WHERE 1=1"; // WHERE 1=1 là mẹo để nối thêm các điều kiện AND phía sau cho dễ
        
        $params = [];

        // Nếu có nhập từ khóa tìm kiếm (Tìm theo Tên, Tên ĐN hoặc SĐT)
        if (!empty($keyword)) {
            $sql .= " AND (nv.nv_ten ILIKE :keyword OR nv.nv_sdt ILIKE :keyword OR nv.nv_tendn ILIKE :keyword)";
            $params['keyword'] = '%' . $keyword . '%';
        }

        // Nếu có chọn bộ lọc Chức vụ
        if (!empty($cv_ma)) {
            $sql .= " AND nv.cv_ma = :cv_ma";
            $params['cv_ma'] = $cv_ma;
        }

        $sql .= " ORDER BY nv.nv_ma DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Lấy danh sách chức vụ để đổ vào thẻ <select>
    public function getAllChucVu() {
        try {
            return $this->db->query("SELECT * FROM chuc_vu ORDER BY cv_ma ASC")->fetchAll();
        } catch (\Exception $e) {
            return [];
        }
    }

    // Lấy 1 nhân viên theo ID
    public function getById($id) {
        $sql = "SELECT * FROM nhan_vien WHERE nv_ma = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Thêm nhân viên mới
    public function insert($data) {
        $sql = "INSERT INTO nhan_vien (nv_tendn, nv_matkhau, nv_ten, nv_sdt, cv_ma) 
                VALUES (:nv_tendn, :nv_matkhau, :nv_ten, :nv_sdt, :cv_ma)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Cập nhật nhân viên
    public function update($id, $data) {
        // Nếu có nhập mật khẩu mới thì cập nhật cả mật khẩu, không thì giữ nguyên
        if (isset($data['nv_matkhau'])) {
            $sql = "UPDATE nhan_vien SET nv_tendn = :nv_tendn, nv_matkhau = :nv_matkhau, 
                    nv_ten = :nv_ten, nv_sdt = :nv_sdt, cv_ma = :cv_ma WHERE nv_ma = :id";
        } else {
            $sql = "UPDATE nhan_vien SET nv_tendn = :nv_tendn, 
                    nv_ten = :nv_ten, nv_sdt = :nv_sdt, cv_ma = :cv_ma WHERE nv_ma = :id";
        }
        
        $data['id'] = $id; // Thêm id vào mảng data để truyền vào execute
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa nhân viên
    public function delete($id) {
        $sql = "DELETE FROM nhan_vien WHERE nv_ma = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}