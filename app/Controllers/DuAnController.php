<?php

namespace App\Controllers;

use App\Models\DuAn;
use App\Models\DonVi;

class DuAnController extends BaseController
{

    public function store()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $duAnModel = new DuAn();

            // 1. Lấy mã dự án chuỗi tự động
            $da_ma_tu_dong = $duAnModel->getNextMaDuAn();

            // 2. Lưu thông tin Dự án và lấy về ID dạng số nguyên (VD: 5)
            $da_ma = $duAnModel->insertProject(
                $da_ma_tu_dong,
                $_POST['da_ten'],
                $_POST['da_diachi'],
                $_POST['da_ngay_bat_dau']
            );

            // 3. Danh sách các vai trò được gửi từ Form
            $roles = [
                'Ban quản lý dự án' => $_POST['dv_bqlda'] ?? '',
                'Nhà thầu thi công' => $_POST['dv_nhathautc'] ?? '',
                'Tư vấn giám sát'   => $_POST['dv_tvgs'] ?? '',
                'Chủ đầu tư'        => $_POST['dv_chudautu'] ?? '',
                'Nhà thầu chính'    => $_POST['dv_nhathauchinh'] ?? '',
                'Nhà thầu phụ'      => $_POST['dv_nhathauphu'] ?? ''
            ];

            // 4. Lưu từng vai trò vào bảng trung gian
            foreach ($roles as $vai_tro => $dv_ma) {
                if (!empty($dv_ma)) {
                    $duAnModel->insertProjectRole($da_ma, $dv_ma, $vai_tro);
                }
            }

            header('Location: /du-an');
            exit;
        }
    }

    public function index()
    {
        $this->checkAuth();
        $duAnModel = new DuAn();
        $donViModel = new DonVi();

        $keyword = $_GET['keyword'] ?? '';

        $danhSachDuAn = $duAnModel->getAllWithNhaThau($keyword);
        $danhSachDonVi = $donViModel->getAll();

        $nextMaDuAn = $duAnModel->getNextMaDuAn();

        return $this->render('du-an/index', [
            'danhSachDuAn' => $danhSachDuAn,
            'danhSachDonVi' => $danhSachDonVi,
            'keyword' => $keyword,
            'nextMaDuAn' => $nextMaDuAn
        ]);
    }

    public function delete()
    {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $duAnModel = new DuAn();
            $duAnModel->delete($id);
        }
        header('Location: /du-an');
        exit;
    }

    public function edit()
    {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /du-an');
            exit;
        }

        $duAnModel = new DuAn();
        $donViModel = new DonVi();

        $duAn = $duAnModel->getById($id);
        if (!$duAn) {
            header('Location: /du-an');
            exit;
        }

        $roles = $duAnModel->getRolesByProjectId($id); 
        $danhSachDonVi = $donViModel->getAll(); 

        return $this->render('du-an/edit', [
            'duAn' => $duAn,
            'roles' => $roles,
            'danhSachDonVi' => $danhSachDonVi
        ]);
    }

    public function update()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $da_ma = $_POST['da_ma'] ?? null;
            if ($da_ma) {
                $duAnModel = new DuAn();

                // 1. Cập nhật thông tin cơ bản
                $duAnModel->updateProject(
                    $da_ma,
                    $_POST['da_ma_hieu'] ?? $da_ma, // Giữ nguyên mã hoặc lấy form
                    $_POST['da_ten'],
                    $_POST['da_diachi'],
                    $_POST['da_ngay_bat_dau']
                );

                // 2. Xóa các đơn vị cũ trong bảng du_an_don_vi
                $duAnModel->clearProjectRoles($da_ma);

                // 3. Insert lại các đơn vị mới
                $rolesToSave = [
                    'Ban quản lý dự án' => $_POST['dv_bqlda'] ?? '',
                    'Nhà thầu thi công' => $_POST['dv_nhathautc'] ?? '',
                    'Tư vấn giám sát'   => $_POST['dv_tvgs'] ?? '',
                    'Chủ đầu tư'        => $_POST['dv_chudautu'] ?? '',
                    'Nhà thầu chính'    => $_POST['dv_nhathauchinh'] ?? '',
                    'Nhà thầu phụ'      => $_POST['dv_nhathauphu'] ?? ''
                ];

                foreach ($rolesToSave as $vai_tro => $dv_ma) {
                    if (!empty($dv_ma)) {
                        $duAnModel->insertProjectRole($da_ma, $dv_ma, $vai_tro);
                    }
                }
            }
            header('Location: /du-an');
            exit;
        }
    }

    public function create()
    {
        $this->checkAuth();

        $duAnModel = new \App\Models\DuAn();

        // Lấy mã dự án tự động tăng
        $nextMaDuAn = $duAnModel->getNextMaDuAn();

        // Truyền biến $nextMaDuAn sang View (create.php)
        require __DIR__ . '/../../views/du_an/create.php';
    }
}
