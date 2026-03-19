<?php

namespace App\Models;

use App\Core\Database;

class DuAn
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll($keyword = '') {
        $sql = "SELECT da.*, dt.dt_ten 
                FROM du_an da 
                LEFT JOIN doi_tac dt ON da.dt_ma_chudautu = dt.dt_ma 
                WHERE 1=1";
        $params = [];
        
        if (!empty($keyword)) {
            $sql .= " AND (da.da_ten ILIKE :keyword OR da.da_diachi ILIKE :keyword)";
            $params['keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY da.da_ma DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    // Hàm lấy danh sách Chủ đầu tư (để đổ vào thẻ <select> dropdown)
    public function getAllDoiTac()
    {
        try {
            $stmt = $this->db->query("SELECT dt_ma, dt_ten FROM doi_tac ORDER BY dt_ten ASC");
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            return []; // Trả về mảng rỗng nếu bảng doi_tac chưa có dữ liệu hoặc chưa tạo
        }
    }

    // Hàm thực thi lệnh INSERT vào CSDL
    public function insert($data)
    {
        $sql = "INSERT INTO du_an (da_ten, da_diachi, dt_ma_chudautu, da_ngay_bat_dau) 
                VALUES (:da_ten, :da_diachi, :dt_ma_chudautu, :da_ngay_bat_dau)";

        $stmt = $this->db->prepare($sql);

        // Gán dữ liệu vào các biến an toàn (chống hack SQL Injection)
        return $stmt->execute([
            'da_ten' => $data['da_ten'],
            'da_diachi' => $data['da_diachi'],
            'dt_ma_chudautu' => $data['dt_ma_chudautu'] ?: null,
            'da_ngay_bat_dau' => $data['da_ngay_bat_dau'] ?: date('Y-m-d')
        ]);
    }

    // Lấy thông tin chi tiết của 1 dự án dựa vào ID
    public function getById($id) {
        $sql = "SELECT * FROM du_an WHERE da_ma = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(); // Trả về 1 dòng dữ liệu duy nhất
    }

    // Thực thi lệnh UPDATE vào CSDL
    public function update($id, $data) {
        $sql = "UPDATE du_an 
                SET da_ten = :da_ten, 
                    da_diachi = :da_diachi, 
                    dt_ma_chudautu = :dt_ma_chudautu, 
                    da_ngay_bat_dau = :da_ngay_bat_dau 
                WHERE da_ma = :id";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'da_ten' => $data['da_ten'],
            'da_diachi' => $data['da_diachi'],
            'dt_ma_chudautu' => $data['dt_ma_chudautu'] ?: null, 
            'da_ngay_bat_dau' => $data['da_ngay_bat_dau'] ?: null,
            'id' => $id
        ]);
    }
    
    // Thực thi lệnh DELETE trong CSDL
    public function delete($id) {
        // Lưu ý: Nếu dự án này đã có Phiếu yêu cầu (khóa ngoại), 
        // tùy thuộc vào thiết lập CSDL của bạn (ON DELETE CASCADE hay không) mà nó có cho phép xóa hay không.
        $sql = "DELETE FROM du_an WHERE da_ma = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
