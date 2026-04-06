<?php

namespace App\Models;

class KetQua extends BaseModel
{
    /**
     * Hàm lưu kết quả thí nghiệm vào database
     */
    public function insertKetQua($pyc_ma, $mtn_ma, $pt_ma, $nv_thuc_hien, $kq_du_lieu_tho, $kq_ket_luan, $cong_thuc_su_dung)
    {
        $sql = "INSERT INTO ket_qua_thi_nghiem 
                (pyc_ma, mtn_ma, pt_ma, nv_thuc_hien, kq_du_lieu_tho, kq_ket_luan, cong_thuc_su_dung) 
                VALUES (?, ?, ?, ?, ?::jsonb, ?, ?)";
        
        // $this->db được kế thừa từ BaseModel
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            $pyc_ma, 
            $mtn_ma, 
            $pt_ma, 
            $nv_thuc_hien, 
            $kq_du_lieu_tho, 
            $kq_ket_luan,
            $cong_thuc_su_dung
        ]);
    }

    /**
     * (Tùy chọn) Sau này bạn có thể viết thêm hàm getAll() ở đây 
     * để lấy danh sách hiển thị ra trang index
     */
    public function getAll()
    {
        // $sql = "SELECT * FROM ket_qua_thi_nghiem";
        // $stmt = $this->db->query($sql);
        // return $stmt->fetchAll();
    }

    /**
     * Lấy danh sách các mẫu chưa được nhập kết quả
     */
    /**
     * Lấy danh sách các mẫu chưa được nhập kết quả
     */
    /**
     * Lấy danh sách các mẫu chưa được nhập kết quả
     */
    public function getDanhSachChuaNhap()
    {
        // Thêm lại bảng chung_loai để lấy Tên vật liệu (cl_ten)
        $sql = "SELECT 
                    pyc.pyc_ma, 
                    pyc.pyc_so_phieu, 
                    da.da_ten, 
                    cl.cl_ten, -- Lấy tên vật liệu
                    pyc.pyc_ngay_nhan_mau, 
                    nv.nv_ten 
                FROM mau_thi_nghiem mtn
                JOIN phieu_yeu_cau pyc ON mtn.pyc_ma = pyc.pyc_ma
                JOIN du_an da ON pyc.da_ma = da.da_ma
                JOIN chi_dinh_phep_thu cdpt ON mtn.mtn_ma = cdpt.mtn_ma
                JOIN chung_loai cl ON mtn.cl_ma = cl.cl_ma
                LEFT JOIN nhan_vien nv ON pyc.nv_lap_phieu = nv.nv_ma 
                LEFT JOIN ket_qua_thi_nghiem kq ON mtn.mtn_ma = kq.mtn_ma AND cdpt.pt_ma = kq.pt_ma
                WHERE kq.kq_ma IS NULL";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getChiTietPhieu($pyc_ma)
    {
        $sql = "SELECT pyc.*, da.da_ten, da.da_diachi 
                FROM phieu_yeu_cau pyc
                LEFT JOIN du_an da ON pyc.da_ma = da.da_ma
                WHERE pyc.pyc_ma = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$pyc_ma]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách Mẫu, Phép thử và Các trường cấu hình tương ứng
     */
    public function getDanhSachMauVaPhepThu($pyc_ma)
    {
        // 1. Lấy danh sách mẫu thuộc phiếu
        $sqlMau = "SELECT mtn.mtn_ma, mtn.mtn_so_luong, cl.cl_ten AS mtn_ten, mtn.mtn_ghi_chu AS mtn_quy_cach
                   FROM mau_thi_nghiem mtn
                   LEFT JOIN chung_loai cl ON mtn.cl_ma = cl.cl_ma
                   WHERE mtn.pyc_ma = ?";
        $stmtMau = $this->db->prepare($sqlMau);
        $stmtMau->execute([$pyc_ma]);
        $danhSachMau = $stmtMau->fetchAll(\PDO::FETCH_ASSOC);

        // 2. Duyệt qua từng mẫu để lấy phép thử được chỉ định
        foreach ($danhSachMau as &$mau) {
            $sqlPT = "SELECT pt.pt_ma, pt.pt_ten AS ten_phep_thu, pt.pt_cong_thuc, pt.pt_don_vi
                      FROM chi_dinh_phep_thu cdpt
                      JOIN phep_thu pt ON cdpt.pt_ma = pt.pt_ma
                      WHERE cdpt.mtn_ma = ?";
            $stmtPT = $this->db->prepare($sqlPT);
            $stmtPT->execute([$mau['mtn_ma']]);
            $mau['danh_sach_phep_thu'] = $stmtPT->fetchAll(\PDO::FETCH_ASSOC);

            // 3. Duyệt qua từng phép thử để lấy cấu hình trường (như L, B, P...)
            foreach ($mau['danh_sach_phep_thu'] as &$pt) {
                $sqlTruong = "SELECT cht_ten_hien_thi, cht_ten_bien 
                              FROM cau_hinh_truong 
                              WHERE pt_ma = ? ORDER BY cht_ma ASC";
                $stmtTruong = $this->db->prepare($sqlTruong);
                $stmtTruong->execute([$pt['pt_ma']]);
                $pt['danh_sach_truong'] = $stmtTruong->fetchAll(\PDO::FETCH_ASSOC);
            }
        }

        return $danhSachMau;
    }
}