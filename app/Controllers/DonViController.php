<?php

namespace App\Controllers;

use App\Models\DonVi;

class DonViController extends BaseController
{
    public function index()
    {
        $this->checkAuth();
        $donViModel = new DonVi();

        // Lấy từ khóa từ thanh địa chỉ (nếu có)
        $keyword = $_GET['keyword'] ?? '';

        $danhSachDonVi = $donViModel->getAllWithProjects($keyword);
        return $this->render('don-vi/index', [
            'danhSachDonVi' => $danhSachDonVi,
            'keyword' => $keyword
        ]);
    }

    public function delete()
    {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $donViModel = new DonVi();
            $donViModel->delete($id);
        }
        header('Location: /don-vi');
        exit;
    }

    public function store()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['dv_ten'])) {
            $donViModel = new DonVi();
            $donViModel->insert($_POST['dv_ten']);
            header('Location: /don-vi');
            exit;
        }
    }

    public function update() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['dv_ma'] ?? null;
            $ten = $_POST['dv_ten'] ?? '';
            
            if ($id && $ten) {
                $donViModel = new DonVi();
                $donViModel->update($id, $ten);
            }
            header('Location: /don-vi');
            exit;
        }
    }
}
