<?php
namespace App\Controllers;
use App\Models\DoiTac;

class DoiTacController extends BaseController {
    
    public function index() {
        $this->checkAuth();
        $keyword = $_GET['keyword'] ?? '';
        $loai = $_GET['loai'] ?? '';

        $doiTacModel = new DoiTac();
        $danhSachDoiTac = $doiTacModel->getAll($keyword, $loai);

        // Lấy danh sách các loại đối tác duy nhất để làm bộ lọc
        $loaiDoiTacList = ['Chủ đầu tư', 'Nhà thầu', 'Tư vấn giám sát', 'Khác'];

        return $this->render('doi-tac/index', [
            'title' => 'Quản lý Đối tác',
            'danhSachDoiTac' => $danhSachDoiTac,
            'loaiDoiTacList' => $loaiDoiTacList,
            'keyword' => $keyword,
            'loai_filter' => $loai
        ]);
    }

    public function create() {
        $this->checkAuth();
        return $this->render('doi-tac/create', ['title' => 'Thêm Đối tác']);
    }

    public function store() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'dt_ten' => $_POST['dt_ten'] ?? '',
                'dt_mst' => !empty($_POST['dt_mst']) ? $_POST['dt_mst'] : null,
                'dt_diachi' => $_POST['dt_diachi'] ?? '',
                'dt_loai' => $_POST['dt_loai'] ?? 'Khác'
            ];
            (new DoiTac())->insert($data);
            header('Location: /doi-tac');
            exit;
        }
    }

    public function edit() {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        $doiTac = (new DoiTac())->getById($id);
        if (!$doiTac) { header('Location: /doi-tac'); exit; }

        return $this->render('doi-tac/edit', [
            'title' => 'Cập nhật Đối tác',
            'doiTac' => $doiTac
        ]);
    }

    public function update() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['dt_ma'] ?? null;
            $data = [
                'dt_ten' => $_POST['dt_ten'] ?? '',
                'dt_mst' => !empty($_POST['dt_mst']) ? $_POST['dt_mst'] : null,
                'dt_diachi' => $_POST['dt_diachi'] ?? '',
                'dt_loai' => $_POST['dt_loai'] ?? 'Khác'
            ];
            if ($id) (new DoiTac())->update($id, $data);
            header('Location: /doi-tac');
            exit;
        }
    }

    public function delete() {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if ($id) (new DoiTac())->delete($id);
        header('Location: /doi-tac');
        exit;
    }
}