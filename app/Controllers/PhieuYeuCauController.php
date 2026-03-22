<?php

namespace App\Controllers;

use App\Models\PhieuYeuCau;
use App\Models\DuAn;
use App\Models\MauThiNghiem;
use App\Models\ChiDinhPhepThu;
use App\Models\DanhMuc;

class PhieuYeuCauController extends BaseController
{

    public function index()
    {
        $this->checkAuth();
        $keyword = $_GET['keyword'] ?? '';
        $pycModel = new PhieuYeuCau();
        $duAnModel = new DuAn();

        // --- THÊM DÒNG NÀY ĐỂ LẤY DỰ ÁN CHO MODAL ---
        $danhSachDuAn = $duAnModel->getAll();

        return $this->render('phieu-yeu-cau/index', [
            'title' => 'Danh sách Phiếu yêu cầu',
            'danhSachPYC' => $pycModel->getAll($keyword),
            'danhSachDuAn' => $danhSachDuAn, // --- TRUYỀN RA VIEW Ở ĐÂY ---
            'keyword' => $keyword
        ]);
    }

    public function store()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pycModel = new PhieuYeuCau();

            $ngay_nhan_mau = $_POST['pyc_ngay_nhan_mau'];

            // 1. Tự động sinh số phiếu theo ngày
            $so_phieu_moi = $pycModel->taoSoPhieuTuDong($ngay_nhan_mau);

            // 2. Xử lý người lập phiếu ngầm bên dưới (Không cần truyền qua form nữa)
            // Nếu Session bị lỗi, tạm thời gán cứng ID = 1 (Quản trị viên) để không chết DB
            $nguoi_lap_id = $_SESSION['user']['nv_ma'] ?? $_SESSION['login']['nv_ma'] ?? 1;

            $data = [
                'pyc_so_phieu'      => $so_phieu_moi,
                'da_ma'             => $_POST['da_ma'],
                'nv_lap_phieu'      => $nguoi_lap_id,
                'pyc_ngay_nhan_mau' => $ngay_nhan_mau,
                'pyc_trang_thai'    => $_POST['pyc_trang_thai']
            ];

            $pycModel->insert($data);
            header('Location: /phieu-yeu-cau');
            exit;
        }
    }

    public function show()
    {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /phieu-yeu-cau');
            exit;
        }

        $pycModel = new PhieuYeuCau();
        $phieu = $pycModel->getById($id);

        $mauModel = new MauThiNghiem();
        $danhSachMau = $mauModel->getByPhieuId($id);

        $chiDinhModel = new ChiDinhPhepThu();
        foreach ($danhSachMau as $key => $mau) {
            $danhSachMau[$key]['danh_sach_phep_thu'] = $chiDinhModel->getByMauId($mau['mtn_ma']);
        }

        // ĐOẠN MỚI THÊM: Lấy danh sách Vật liệu truyền ra Modal
        $danhMucModel = new DanhMuc();
        $danhSachVatLieu = $danhMucModel->getTatCaLoaiVatLieu();

        return $this->render('phieu-yeu-cau/show', [
            'phieu' => $phieu,
            'danhSachMau' => $danhSachMau,
            'danhSachVatLieu' => $danhSachVatLieu
        ]);
    }

    public function luuMau()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mauModel = new MauThiNghiem();
            $data = [
                'pyc_ma'       => $_POST['pyc_ma'],
                'lvl_ma'       => $_POST['lvl_ma'],  // Lấy ID Vật Liệu
                'cl_ma'        => $_POST['cl_ma'],   // Lấy ID Chủng Loại
                'mtn_so_luong' => $_POST['mtn_so_luong'],
                'mtn_ngay_lay' => empty($_POST['mtn_ngay_lay']) ? null : $_POST['mtn_ngay_lay'],
                'mtn_ghi_chu'  => $_POST['mtn_ghi_chu']
            ];
            $mauModel->insert($data);
            header('Location: /phieu-yeu-cau/xem?id=' . $_POST['pyc_ma']);
            exit;
        }
    }

    // Hàm xuất dữ liệu JSON cho Javascript gọi ngầm
    public function getChungLoaiAjax()
    {
        header('Content-Type: application/json');
        $lvl_ma = $_GET['lvl_ma'] ?? 0;
        $danhMucModel = new DanhMuc();
        echo json_encode($danhMucModel->getChungLoaiByVatLieu($lvl_ma));
        exit;
    }

    public function luuPhepThu()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $chiDinhModel = new ChiDinhPhepThu();

            $pyc_ma = $_POST['pyc_ma'];
            $mtn_ma = $_POST['mtn_ma'];
            $danh_sach_chon = $_POST['pt_ma'] ?? []; // Mảng các ID phép thử được tích

            // 1. Xóa hết các phép thử cũ của mẫu này
            $chiDinhModel->deleteByMauId($mtn_ma);

            // 2. Lưu lại các phép thử mới được tích
            foreach ($danh_sach_chon as $pt_ma) {
                $chiDinhModel->insert($mtn_ma, $pt_ma);
            }

            header('Location: /phieu-yeu-cau/xem?id=' . $pyc_ma);
            exit;
        }
    }

    // Nhớ use Model ở đầu file nếu chưa có
    // use App\Models\DuAn;

    public function create()
    { // Hoặc index()
        $this->checkAuth();

        // 1. Gọi Model Dự án
        $duAnModel = new DuAn();

        // Lấy danh sách tất cả dự án (nếu bạn chưa có hàm getAll() trong DuAn.php thì tạo thêm nhé)
        // Câu SQL đơn giản: SELECT * FROM du_an ORDER BY da_ma DESC
        $danhSachDuAn = $duAnModel->getAll();

        // 2. Truyền biến $danhSachDuAn ra View
        return $this->render('phieu-yeu-cau/create', [
            'danhSachDuAn' => $danhSachDuAn
            // ... các biến khác nếu có
        ]);
    }

    // Hàm xử lý Xóa mẫu
    public function xoaMau()
    {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        $pyc_ma = $_GET['pyc_ma'] ?? null;

        if ($id) {
            $mauModel = new MauThiNghiem();
            $mauModel->delete($id);
        }
        // Xóa xong quay lại trang chi tiết phiếu
        header('Location: /phieu-yeu-cau/xem?id=' . $pyc_ma);
        exit;
    }

    // Hàm xử lý Lưu dữ liệu khi Sửa mẫu
    public function capNhatMau()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mauModel = new MauThiNghiem();
            $data = [
                'mtn_ma'       => $_POST['mtn_ma'],
                'lvl_ma'       => $_POST['lvl_ma'],
                'cl_ma'        => $_POST['cl_ma'],
                'mtn_so_luong' => $_POST['mtn_so_luong'],
                'mtn_ngay_lay' => empty($_POST['mtn_ngay_lay']) ? null : $_POST['mtn_ngay_lay'],
                'mtn_ghi_chu'  => $_POST['mtn_ghi_chu']
            ];
            $mauModel->update($data);

            header('Location: /phieu-yeu-cau/xem?id=' . $_POST['pyc_ma']);
            exit;
        }
    }

    public function getPhepThuAjax()
    {
        header('Content-Type: application/json');
        $lvl_ma = $_GET['lvl_ma'] ?? 0;
        $mtn_ma = $_GET['mtn_ma'] ?? 0; // Để biết mẫu này đã chọn những phép thử nào rồi

        // Lấy tất cả phép thử của vật liệu này
        $danhMucModel = new \App\Models\DanhMuc();
        $tatCaPhepThu = $danhMucModel->getPhepThuByVatLieu($lvl_ma);

        // Lấy các phép thử đã được tích từ trước (nếu có)
        $chiDinhModel = new ChiDinhPhepThu();
        $daChiDinh = $chiDinhModel->getByMauId($mtn_ma);
        $daChiDinhIds = array_column($daChiDinh, 'pt_ma');

        // Trộn dữ liệu: Đánh dấu phép thử nào đã được check
        $result = [];
        foreach ($tatCaPhepThu as $pt) {
            $pt['checked'] = in_array($pt['pt_ma'], $daChiDinhIds);
            $result[] = $pt;
        }

        echo json_encode($result);
        exit;
    }

    // Hàm hiển thị bản in Phiếu Yêu Cầu
    public function inPhieu() {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /phieu-yeu-cau');
            exit;
        }

        $pycModel = new PhieuYeuCau();
        $mauModel = new MauThiNghiem();
        $chiDinhModel = new \App\Models\ChiDinhPhepThu(); // Gọi model chi tiết

        $phieu = $pycModel->getById($id);
        if (!$phieu) {
            header('Location: /phieu-yeu-cau');
            exit;
        }

        $danhSachMau = $mauModel->getByPhieuId($id);
        
        // Lấy danh sách phép thử cho từng mẫu (y hệt như hàm xem chi tiết)
        foreach ($danhSachMau as &$mau) {
            $mau['danh_sach_phep_thu'] = $chiDinhModel->getByMauId($mau['mtn_ma']);
        }

        // Render ra file giao diện in (không dùng chung layout có sidebar)
        return $this->render('phieu-yeu-cau/print', [
            'title' => 'In Phiếu Yêu Cầu - ' . $phieu['pyc_so_phieu'],
            'phieu' => $phieu,
            'danhSachMau' => $danhSachMau
        ]);
    }
}
