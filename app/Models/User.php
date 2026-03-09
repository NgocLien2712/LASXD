<?php
namespace App\Models;

class User extends BaseModel {
    // Tìm người dùng theo username để đăng nhập
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

    // Thêm nhân viên mới (có mã hóa mật khẩu)
    public function create($data) {
        $sql = "INSERT INTO users (username, password, full_name, phone, role_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT), // Bảo mật theo tài liệu 4
            $data['full_name'],
            $data['phone'],
            $data['role_id']
        ]);
    }
}