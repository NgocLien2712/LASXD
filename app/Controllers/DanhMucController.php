<?php
namespace App\Controllers;
use App\Models\BaseModel;

class DanhMucController extends BaseController {
    
    // Hàm hiển thị giao diện chính
    public function index() {
        $this->checkAuth();
        $db = (new BaseModel())->getDb();
        
        // Lấy danh sách Nhóm vật liệu (VD: Bê tông, Cát, Đá...)
        $nhomList = $db->query("SELECT * FROM nhom_vat_lieu ORDER BY nvl_ma DESC")->fetchAll();
        
        // Lấy danh sách Vật liệu kèm theo Tên nhóm của nó
        $vatLieuList = $db->query("
            SELECT c.*, COALESCE(n.nvl_ten, 'Chưa phân nhóm') AS ten_nhom 
            FROM chung_loai c 
            LEFT JOIN nhom_vat_lieu n ON c.nvl_ma = n.nvl_ma 
            ORDER BY c.cl_ma DESC
        ")->fetchAll();

        return $this->render('danh-muc/index', [
            'title' => 'Quản lý Danh mục Vật liệu',
            'nhomList' => $nhomList,
            'vatLieuList' => $vatLieuList
        ]);
    }

    // Hàm xử lý Thêm Nhóm Vật Liệu mới
    public function saveNhom() {
        $this->checkAuth();
        $db = (new BaseModel())->getDb();
        $nvl_ten = $_POST['nvl_ten'] ?? '';
        
        if (!empty($nvl_ten)) {
            $stmt = $db->prepare("INSERT INTO nhom_vat_lieu (nvl_ten) VALUES (?)");
            $stmt->execute([$nvl_ten]);
        }
        header("Location: /danh-muc");
        exit;
    }

    // Hàm xử lý Thêm Vật Liệu (Chủng loại) mới
    public function saveVatLieu() {
        $this->checkAuth();
        $db = (new BaseModel())->getDb();
        $cl_ten = $_POST['cl_ten'] ?? '';
        $nvl_ma = $_POST['nvl_ma'] ?? null;
        
        if (!empty($cl_ten)) {
            // Lưu tên vật liệu và mã nhóm nó thuộc về
            $stmt = $db->prepare("INSERT INTO chung_loai (cl_ten, nvl_ma) VALUES (?, ?)");
            $stmt->execute([$cl_ten, empty($nvl_ma) ? null : $nvl_ma]);
        }
        header("Location: /danh-muc");
        exit;
    }

    // Hàm xử lý Xóa Nhóm
    public function deleteNhom() {
        $this->checkAuth();
        $db = (new BaseModel())->getDb();
        $nvl_ma = $_GET['id'] ?? null;
        
        if ($nvl_ma) {
            $stmt = $db->prepare("DELETE FROM nhom_vat_lieu WHERE nvl_ma = ?");
            $stmt->execute([$nvl_ma]);
        }
        header("Location: /danh-muc");
        exit;
    }

    // Hàm xử lý Xóa Vật liệu
    public function deleteVatLieu() {
        $this->checkAuth();
        $db = (new BaseModel())->getDb();
        $cl_ma = $_GET['id'] ?? null;
        
        if ($cl_ma) {
            $stmt = $db->prepare("DELETE FROM chung_loai WHERE cl_ma = ?");
            $stmt->execute([$cl_ma]);
        }
        header("Location: /danh-muc");
        exit;
    }

    // Hàm xử lý Lưu dữ liệu khi Sửa Nhóm
    public function updateNhom() {
        $this->checkAuth();
        $db = (new BaseModel())->getDb();
        $nvl_ma = $_POST['nvl_ma'] ?? null;
        $nvl_ten = $_POST['nvl_ten'] ?? '';
        
        if ($nvl_ma && !empty($nvl_ten)) {
            $stmt = $db->prepare("UPDATE nhom_vat_lieu SET nvl_ten = ? WHERE nvl_ma = ?");
            $stmt->execute([$nvl_ten, $nvl_ma]);
        }
        header("Location: /danh-muc");
        exit;
    }

    // Hàm xử lý Lưu dữ liệu khi Sửa Vật liệu
    public function updateVatLieu() {
        $this->checkAuth();
        $db = (new BaseModel())->getDb();
        $cl_ma = $_POST['cl_ma'] ?? null;
        $cl_ten = $_POST['cl_ten'] ?? '';
        $nvl_ma = $_POST['nvl_ma'] ?? null;
        
        if ($cl_ma && !empty($cl_ten)) {
            $stmt = $db->prepare("UPDATE chung_loai SET cl_ten = ?, nvl_ma = ? WHERE cl_ma = ?");
            $stmt->execute([$cl_ten, empty($nvl_ma) ? null : $nvl_ma, $cl_ma]);
        }
        header("Location: /danh-muc");
        exit;
    }
}