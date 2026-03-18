<?php
namespace App\Models;
use App\Core\Database;

class User extends BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT u.*, r.role_name FROM users u 
                                    JOIN roles r ON u.role_id = r.id 
                                    WHERE u.username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    // Lấy danh sách tất cả nhân viên
    public function getAll() {
        $stmt = $this->db->query("SELECT u.*, r.role_name FROM users u 
                                  LEFT JOIN roles r ON u.role_id = r.id");
        return $stmt->fetchAll();
    }
}