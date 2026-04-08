<?php

namespace App\Models;

class KetQua extends BaseModel
{
    /**
     * Hàm lưu kết quả thí nghiệm vào database
     */
    public function insertKetQua($pyc_ma, $mtn_ma, $pt_ma, $nv_thuc_hien, $kq_du_lieu_tho, $kq_ket_luan, $cong_thuc_su_dung, $ngay_thi_nghiem)
    {
        // 1. XÓA KẾT QUẢ CŨ
        $sqlDelete = "DELETE FROM ket_qua_thi_nghiem WHERE mtn_ma = ? AND pt_ma = ?";
        $stmtDel = $this->db->prepare($sqlDelete);
        $stmtDel->execute([$mtn_ma, $pt_ma]);

        // 2. THÊM KẾT QUẢ MỚI (Đã bổ sung ngay_thi_nghiem)
        $sql = "INSERT INTO ket_qua_thi_nghiem 
                (pyc_ma, mtn_ma, pt_ma, nv_thuc_hien, kq_du_lieu_tho, kq_ket_luan, cong_thuc_su_dung, ngay_thi_nghiem) 
                VALUES (?, ?, ?, ?, ?::jsonb, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            $pyc_ma, $mtn_ma, $pt_ma, $nv_thuc_hien, $kq_du_lieu_tho, $kq_ket_luan, $cong_thuc_su_dung, $ngay_thi_nghiem
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
        $sql = "SELECT pyc.*, da.da_ten, da.da_diachi, 
                       kq.ngay_thi_nghiem,
                       
                       -- Lấy thông tin người nhập (từ bảng ket_qua_thi_nghiem)
                       nv_nhap.nv_ten AS ten_nguoi_nhap, 
                       cv_nhap.cv_ten AS chuc_vu_nguoi_nhap,
                       
                       -- Lấy thông tin người duyệt (từ bảng phieu_yeu_cau)
                       nv_duyet.nv_ten AS ten_nguoi_duyet, 
                       cv_duyet.cv_ten AS chuc_vu_nguoi_duyet
                       
                FROM phieu_yeu_cau pyc
                LEFT JOIN du_an da ON pyc.da_ma = da.da_ma
                LEFT JOIN ket_qua_thi_nghiem kq ON pyc.pyc_ma = kq.pyc_ma
                
                -- Nối bảng để lấy tên + chức vụ NGƯỜI NHẬP
                LEFT JOIN nhan_vien nv_nhap ON kq.nv_thuc_hien = nv_nhap.nv_ma
                LEFT JOIN chuc_vu cv_nhap ON nv_nhap.cv_ma = cv_nhap.cv_ma
                
                -- Nối bảng để lấy tên + chức vụ NGƯỜI DUYỆT (dùng cột nguoi_duyet_id trong CSDL của bạn)
                LEFT JOIN nhan_vien nv_duyet ON pyc.nguoi_duyet_id = nv_duyet.nv_ma
                LEFT JOIN chuc_vu cv_duyet ON nv_duyet.cv_ma = cv_duyet.cv_ma
                
                WHERE pyc.pyc_ma = ?
                LIMIT 1";
                
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

    // 2. Lấy danh sách phiếu CHỜ DUYỆT (Đã join để lấy cl_ten cho nhãn Vật Liệu)
    public function getDanhSachChoDuyet()
    {
        $sql = "SELECT 
                    pyc.pyc_ma, 
                    pyc.pyc_so_phieu, 
                    da.da_ten, 
                    cl.cl_ten, 
                    pyc.pyc_ngay_nhan_mau, 
                    nv.nv_ten 
                FROM phieu_yeu_cau pyc
                LEFT JOIN du_an da ON pyc.da_ma = da.da_ma
                LEFT JOIN nhan_vien nv ON pyc.nv_lap_phieu = nv.nv_ma
                LEFT JOIN mau_thi_nghiem mtn ON pyc.pyc_ma = mtn.pyc_ma
                LEFT JOIN chung_loai cl ON mtn.cl_ma = cl.cl_ma
                WHERE pyc.pyc_trang_thai = 'Chờ duyệt'
                ORDER BY pyc.pyc_ma DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // 3. Lấy danh sách phiếu ĐÃ BAN HÀNH (Đã join để lấy cl_ten cho nhãn Vật Liệu)
    public function getDanhSachDaBanHanh()
    {
        $sql = "SELECT 
                    pyc.pyc_ma, 
                    pyc.pyc_so_phieu, 
                    da.da_ten, 
                    cl.cl_ten, 
                    pyc.pyc_ngay_nhan_mau, 
                    nv.nv_ten 
                FROM phieu_yeu_cau pyc
                LEFT JOIN du_an da ON pyc.da_ma = da.da_ma
                LEFT JOIN nhan_vien nv ON pyc.nv_lap_phieu = nv.nv_ma
                LEFT JOIN mau_thi_nghiem mtn ON pyc.pyc_ma = mtn.pyc_ma
                LEFT JOIN chung_loai cl ON mtn.cl_ma = cl.cl_ma
                WHERE pyc.pyc_trang_thai = 'Đã ban hành'
                ORDER BY pyc.pyc_ma DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Cập nhật trạng thái của Phiếu Yêu Cầu (Chờ duyệt, Đã ban hành...)
     */
    public function updateTrangThaiPhieu($pyc_ma, $trang_thai)
    {
        $sql = "UPDATE phieu_yeu_cau SET pyc_trang_thai = ? WHERE pyc_ma = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$trang_thai, $pyc_ma]);
    }

    /**
     * Lấy danh sách phiếu theo Trạng thái để hiển thị ra các Tab
     */
    public function getDanhSachTheoTrangThai($trang_thai)
    {
        $sql = "SELECT pyc.*, da.da_ten, nv.nv_ten, cl.cl_ten 
                FROM phieu_yeu_cau pyc
                LEFT JOIN du_an da ON pyc.da_ma = da.da_ma
                LEFT JOIN nhan_vien nv ON pyc.nv_lap_phieu = nv.nv_ma
                LEFT JOIN mau_thi_nghiem mtn ON pyc.pyc_ma = mtn.pyc_ma
                LEFT JOIN chung_loai cl ON mtn.cl_ma = cl.cl_ma
                WHERE pyc.pyc_trang_thai = ?
                ORDER BY pyc.pyc_ma DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trang_thai]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách mẫu + phép thử + KẾT QUẢ của từng phép thử
     */
    /**
     * Lấy danh sách mẫu + phép thử + KẾT QUẢ của từng phép thử
     */
    public function getDanhSachMauVaKetQua($pyc_ma)
    {
        // 1. Lấy danh sách mẫu thuộc phiếu
        $sqlMau = "SELECT mtn.*, cl.cl_ten, mtn.mtn_ghi_chu AS mtn_quy_cach
                   FROM mau_thi_nghiem mtn
                   LEFT JOIN chung_loai cl ON mtn.cl_ma = cl.cl_ma
                   WHERE mtn.pyc_ma = ?";
        $stmtMau = $this->db->prepare($sqlMau);
        $stmtMau->execute([$pyc_ma]);
        $danhSachMau = $stmtMau->fetchAll(\PDO::FETCH_ASSOC);

        // 2. Với mỗi mẫu, lấy các phép thử VÀ KẾT QUẢ tương ứng
        foreach ($danhSachMau as &$mau) {
            // Đã bổ sung lấy kq.kq_du_lieu_tho để in số liệu ra giấy
            $sqlPT = "SELECT pt.pt_ma, pt.pt_ten AS ten_phep_thu, kq.kq_ket_luan, kq.kq_du_lieu_tho
                      FROM chi_dinh_phep_thu cdpt
                      JOIN phep_thu pt ON cdpt.pt_ma = pt.pt_ma
                      LEFT JOIN ket_qua_thi_nghiem kq ON (cdpt.mtn_ma = kq.mtn_ma AND cdpt.pt_ma = kq.pt_ma)
                      WHERE cdpt.mtn_ma = ?";
            $stmtPT = $this->db->prepare($sqlPT);
            $stmtPT->execute([$mau['mtn_ma']]);
            $mau['danh_sach_phep_thu'] = $stmtPT->fetchAll(\PDO::FETCH_ASSOC);

            // 3. DUYỆT LẤY CẤU HÌNH TRƯỜNG (BẢN TRƯỚC BỊ THIẾU ĐOẠN NÀY)
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
    
    /**
     * Cập nhật trạng thái phiếu thành Đã ban hành và lưu thông tin người duyệt
     */
    public function xacNhanDuyetPhieu($pyc_ma, $nguoi_duyet_id, $ngay_duyet)
    {
        $sql = "UPDATE phieu_yeu_cau 
                SET pyc_trang_thai = 'Đã ban hành', 
                    nguoi_duyet_id = ?, 
                    ngay_duyet = ? 
                WHERE pyc_ma = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nguoi_duyet_id, $ngay_duyet, $pyc_ma]);
    }
}