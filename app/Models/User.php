<?php
namespace App\Models;
use App\Core\Database;

class User extends BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Tìm nhân viên theo tên đăng nhập (nv_tendn)
     */
    public function findByUsername($username) {
        $stmt = $this->db->prepare(
            "SELECT nv.*, cv.cv_ten AS role_name
             FROM nhan_vien nv
             LEFT JOIN chuc_vu cv ON nv.cv_ma = cv.cv_ma
             WHERE nv.nv_tendn = ?"
        );
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    /**
     * Lấy danh sách tất cả nhân viên kèm tên chức vụ
     */
    public function getAll() {
        $stmt = $this->db->query(
            "SELECT nv.*, cv.cv_ten AS role_name
             FROM nhan_vien nv
             LEFT JOIN chuc_vu cv ON nv.cv_ma = cv.cv_ma"
        );
        return $stmt->fetchAll();
    }
}