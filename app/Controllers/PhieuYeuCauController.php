<?php
namespace App\Controllers;
use App\Models\PhieuYeuCau;
use App\Models\DuAn;
use App\Models\MauThiNghiem;
use App\Models\ChiDinhPhepThu;

class PhieuYeuCauController extends BaseController {
    
    public function index() {
        $this->checkAuth();
        $keyword = $_GET['keyword'] ?? '';
        $pycModel = new PhieuYeuCau();
        $duAnModel = new DuAn();
        
        return $this->render('phieu-yeu-cau/index', [
            'title' => 'Danh sách Phiếu yêu cầu',
            'danhSachPYC' => $pycModel->getAll($keyword),
            'keyword' => $keyword
        ]);
    }

    public function store() {
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

    public function show() {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: /phieu-yeu-cau'); exit; }

        $pycModel = new PhieuYeuCau();
        $phieu = $pycModel->getById($id);
        if (!$phieu) { exit; } // (Bạn giữ nguyên đoạn báo lỗi cũ của bạn nhé)

        $mauModel = new MauThiNghiem();
        $danhSachMau = $mauModel->getByPhieuId($id);

        // --- ĐOẠN CODE MỚI: Lấy phép thử cho từng mẫu ---
        $chiDinhModel = new ChiDinhPhepThu();
        foreach ($danhSachMau as $key => $mau) {
            // Nhét danh sách phép thử vào mảng của mẫu đó
            $danhSachMau[$key]['danh_sach_phep_thu'] = $chiDinhModel->getByMauId($mau['mtn_ma']);
        }

        return $this->render('phieu-yeu-cau/show', [
            'title' => 'Chi tiết Phiếu Yêu Cầu',
            'phieu' => $phieu,
            'danhSachMau' => $danhSachMau
        ]);
    }

    public function luuMau() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mauModel = new MauThiNghiem();
            $pyc_ma = $_POST['pyc_ma'];

            $data = [
                'pyc_ma'       => $pyc_ma,
                'mtn_ten'      => $_POST['mtn_ten'],
                'mtn_quy_cach' => $_POST['mtn_quy_cach'],
                'mtn_so_luong' => $_POST['mtn_so_luong'],
                'mtn_ngay_lay' => !empty($_POST['mtn_ngay_lay']) ? $_POST['mtn_ngay_lay'] : null,
                'mtn_ghi_chu'  => $_POST['mtn_ghi_chu']
            ];

            $mauModel->insert($data);
            
            // Lưu xong thì quay lại đúng trang chi tiết của Phiếu đó
            header('Location: /phieu-yeu-cau/xem?id=' . $pyc_ma);
            exit;
        }
    }

    public function luuPhepThu() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $chiDinhModel = new ChiDinhPhepThu();

            $data = [
                'mtn_ma'       => $_POST['mtn_ma'],
                'ten_phep_thu' => $_POST['ten_phep_thu'],
                'tieu_chuan'   => $_POST['tieu_chuan'],
                'cdpt_ghi_chu' => $_POST['cdpt_ghi_chu']
            ];
            $chiDinhModel->insert($data);

            // Quay lại trang chi tiết phiếu
            header('Location: /phieu-yeu-cau/xem?id=' . $_POST['pyc_ma']);
            exit;
        }
    }

}