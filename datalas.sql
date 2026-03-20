-- =============================================================
-- 1. XÓA DỮ LIỆU CŨ (Để tránh xung đột)
-- =============================================================
DROP TABLE IF EXISTS ket_qua_thi_nghiem CASCADE;
DROP TABLE IF EXISTS phan_cong_cong_viec CASCADE;
DROP TABLE IF EXISTS phieu_yeu_cau CASCADE;
DROP TABLE IF EXISTS bieu_mau_tieu_chuan CASCADE;
DROP TABLE IF EXISTS hop_dong CASCADE;
DROP TABLE IF EXISTS du_an_don_vi CASCADE;
DROP TABLE IF EXISTS du_an CASCADE;
DROP TABLE IF EXISTS don_vi CASCADE;
DROP TABLE IF EXISTS nhan_vien CASCADE;
DROP TABLE IF EXISTS chuc_vu CASCADE;

-- =============================================================
-- 2. TẠO CƠ SỞ DỮ LIỆU MỚI
-- =============================================================

-- Bảng Chức vụ (Phân quyền Admin, Trưởng phòng, Thí nghiệm viên)
CREATE TABLE chuc_vu (
    cv_ma SERIAL PRIMARY KEY,
    cv_ten VARCHAR(50) NOT NULL UNIQUE
);

-- Bảng Nhân viên (Thông tin đăng nhập và hồ sơ)
CREATE TABLE nhan_vien (
    nv_ma SERIAL PRIMARY KEY,
    nv_tendn VARCHAR(50) NOT NULL UNIQUE,
    nv_matkhau VARCHAR(255) NOT NULL,
    nv_ten VARCHAR(100) NOT NULL,
    nv_sdt VARCHAR(15),
    cv_ma INT REFERENCES chuc_vu(cv_ma) ON DELETE SET NULL
);

-- Bảng Đối tác (Chủ đầu tư, Nhà thầu, Đơn vị tư vấn)
CREATE TABLE don_vi (
    dv_ma SERIAL PRIMARY KEY,
    dv_ten VARCHAR(255) NOT NULL,
    dv_mst VARCHAR(20), -- Mã số thuế
    dv_diachi TEXT,
    dv_loai VARCHAR(50) -- Ví dụ: Chủ đầu tư, Nhà thầu
);

-- Bảng Dự án / Công trình (Nơi diễn ra thí nghiệm)
CREATE TABLE du_an (
    da_ma SERIAL PRIMARY KEY,
    da_ten VARCHAR(255) NOT NULL,
    da_diachi TEXT,
    dt_ma_chudautu INT REFERENCES don_vi(dv_ma),
    da_ngay_bat_dau DATE DEFAULT CURRENT_DATE
);

-- Bảng trung gian Dự án - Đơn vị (Liên kết nhiều-nhiều với vai trò)
CREATE TABLE du_an_don_vi (
    da_ma INT REFERENCES du_an(da_ma) ON DELETE CASCADE,
    dv_ma INT REFERENCES don_vi(dv_ma) ON DELETE CASCADE,
    vai_tro VARCHAR(100) NOT NULL, -- Ví dụ: Chủ đầu tư, Nhà thầu, Tư vấn
    PRIMARY KEY (da_ma, dv_ma)
);

-- Bảng Biểu mẫu & Tiêu chuẩn (Lưu công thức thí nghiệm)
-- Đáp ứng yêu cầu: Lưu lịch sử công thức (phiên bản)
CREATE TABLE bieu_mau_tieu_chuan (
    bm_ma SERIAL PRIMARY KEY,
    bm_ky_hieu VARCHAR(50) NOT NULL, -- Ví dụ: TCVN 7570:2006
    bm_ten_phep_thu VARCHAR(255) NOT NULL, -- Ví dụ: Thử độ nén bê tông
    bm_cong_thuc TEXT, -- Lưu công thức tính toán hoặc cấu trúc JSON
    bm_version INT DEFAULT 1,
    is_active BOOLEAN DEFAULT TRUE,
    ngay_cap_nhat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng Phiếu yêu cầu thí nghiệm (Kết nối Dự án và Tiêu chuẩn)
CREATE TABLE phieu_yeu_cau (
    pyc_ma SERIAL PRIMARY KEY,
    pyc_so_phieu VARCHAR(50) UNIQUE NOT NULL,
    da_ma INT REFERENCES du_an(da_ma) ON DELETE CASCADE,
    nv_lap_phieu INT REFERENCES nhan_vien(nv_ma),
    pyc_ngay_nhan_mau DATE DEFAULT CURRENT_DATE,
    pyc_trang_thai VARCHAR(50) DEFAULT 'Chờ thí nghiệm'
);

-- Bảng Kết quả thí nghiệm (Lưu số liệu thô và kết quả cuối cùng)
CREATE TABLE ket_qua_thi_nghiem (
    kq_ma SERIAL PRIMARY KEY,
    pyc_ma INT REFERENCES phieu_yeu_cau(pyc_ma) ON DELETE CASCADE,
    bm_ma INT REFERENCES bieu_mau_tieu_chuan(bm_ma),
    nv_thuc_hien INT REFERENCES nhan_vien(nv_ma),
    kq_du_lieu_tho JSONB, -- Lưu các số liệu cân, đong, đo, đếm
    kq_ket_luan TEXT,
    ngay_ky_duyet DATE
);



--Bảng mẫu thi nghiem
CREATE TABLE mau_thi_nghiem (
    mtn_ma SERIAL PRIMARY KEY,
    pyc_ma INTEGER NOT NULL,
    mtn_ten VARCHAR(255) NOT NULL,       -- Ví dụ: Bê tông thương phẩm mác 250
    mtn_quy_cach VARCHAR(100),           -- Ví dụ: Hình trụ 15x15x15 cm
    mtn_so_luong INTEGER DEFAULT 1,      -- Số lượng mẫu (VD: 3 viên)
    mtn_ngay_lay DATE,                   -- Ngày đúc/lấy mẫu hiện trường
    mtn_ghi_chu TEXT,
    CONSTRAINT fk_pyc FOREIGN KEY (pyc_ma) REFERENCES phieu_yeu_cau(pyc_ma) ON DELETE CASCADE
);

CREATE TABLE chi_dinh_phep_thu (
    cdpt_ma SERIAL PRIMARY KEY,
    mtn_ma INTEGER NOT NULL,
    ten_phep_thu VARCHAR(255) NOT NULL, -- VD: Thử cường độ nén
    tieu_chuan VARCHAR(100),            -- VD: TCVN 3118:2022
    cdpt_ghi_chu TEXT,
    CONSTRAINT fk_mtn FOREIGN KEY (mtn_ma) REFERENCES mau_thi_nghiem(mtn_ma) ON DELETE CASCADE
);
=============================================================
-- 3. CHÈN DỮ LIỆU MẪU ĐỂ TEST GIAO DIỆN
-- =============================================================

INSERT INTO chuc_vu (cv_ten) VALUES ('Admin'), ('Trưởng phòng'), ('Thí nghiệm viên');

-- Pass mặc định: 123456
INSERT INTO nhan_vien (nv_tendn, nv_matkhau, nv_ten, cv_ma) VALUES 
('admin', '$2y$12$dsVJ51hqk4dJisoUrqZb1Ob9FfA5BlnF9KNhUZWh6oQ6QVVQzdNAe', 'Quản trị viên', 1),
('truongphong', '$2y$12$dsVJ51hqk4dJisoUrqZb1Ob9FfA5BlnF9KNhUZWh6oQ6QVVQzdNAe', 'Nguyễn Văn Trưởng', 2),
('kythuat01', '$2y$12$dsVJ51hqk4dJisoUrqZb1Ob9FfA5BlnF9KNhUZWh6oQ6QVVQzdNAe', 'Lê Văn Thử', 3);

INSERT INTO don_vi (dv_ten, dv_loai) VALUES ('Tập đoàn Xây dựng A', 'Nhà thầu'), ('Sở Giao thông Vận tải', 'Chủ đầu tư');

INSERT INTO bieu_mau_tieu_chuan (bm_ky_hieu, bm_ten_phep_thu, bm_cong_thuc) VALUES 
('TCVN 7570:2006', 'Thử cốt liệu cho bê tông', '{"rong": 0.5, "chat": "da"}'),
('TCVN 1916:1995', 'Thử kéo thép', '{"f": "P/A"}');