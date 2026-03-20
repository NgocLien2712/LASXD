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

            // 1. Lưu thông tin Dự án
            $da_ma = $duAnModel->insertProject(
                $_POST['da_ma_hieu'],
                $_POST['da_ten'],
                $_POST['da_diachi'],
                $_POST['da_ngay_bat_dau']
            );

            // 2. Danh sách các vai trò được gửi từ Form
            $roles = [
                'Ban quản lý dự án' => $_POST['dv_bqlda'] ?? '',
                'Nhà thầu thi công' => $_POST['dv_nhathautc'] ?? '',
                'Tư vấn giám sát'   => $_POST['dv_tvgs'] ?? '',
                'Chủ đầu tư'        => $_POST['dv_chudautu'] ?? '',
                'Nhà thầu chính'    => $_POST['dv_nhathauchinh'] ?? '',
                'Nhà thầu phụ'      => $_POST['dv_nhathauphu'] ?? ''
            ];

            // 3. Lưu từng vai trò (nếu có chọn) vào bảng trung gian
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

        return $this->render('du-an/index', [
            'danhSachDuAn' => $danhSachDuAn,
            'danhSachDonVi' => $danhSachDonVi,
            'keyword' => $keyword
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

        $roles = $duAnModel->getRolesByProjectId($id); // Lấy các đơn vị đã gán
        $danhSachDonVi = $donViModel->getAll(); // Danh sách để đổ vào <select>

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
                    $_POST['da_ma_hieu'],
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
}
