<?php

namespace App\Controllers;

use App\Models\BaseModel;

class CauHinhController extends BaseController
{

    public function index()
    {
        $this->checkAuth();
        $db = (new BaseModel())->getDb();

        $cl_ma = $_GET['cl_ma'] ?? null;
        $pt_ma = $_GET['pt_ma'] ?? null; // ID của phép thử đang chọn

        // --- BẮT ĐẦU ĐOẠN XỬ LÝ GỘP NHÓM MỚI ---
        // Câu lệnh SQL chuẩn: Nối 2 bảng để lấy Vật liệu kèm theo Tên Nhóm của nó
        $stmt = $db->query("
            SELECT c.*, COALESCE(n.nvl_ten, 'Chưa phân nhóm') AS ten_nhom 
            FROM chung_loai c 
            LEFT JOIN nhom_vat_lieu n ON c.nvl_ma = n.nvl_ma 
            ORDER BY n.nvl_ten, c.cl_ten
        ");
        $allVatTuRaw = $stmt->fetchAll();

        // Vòng lặp này tự động nhóm các vật liệu có cùng ten_nhom lại với nhau
        $allVatTuGrouped = [];
        foreach ($allVatTuRaw as $v) {
            $allVatTuGrouped[$v['ten_nhom']][] = $v;
        }
        // --- KẾT THÚC ĐOẠN XỬ LÝ GỘP NHÓM ---

        $vattu = null;
        $phepThuList = [];
        $currentPhepThu = null;
        $fields = [];

        if ($cl_ma) {
            // Lấy thông tin vật liệu
            $stmt = $db->prepare("SELECT * FROM chung_loai WHERE cl_ma = ?");
            $stmt->execute([$cl_ma]);
            $vattu = $stmt->fetch();

            // Lấy danh sách các phép thử của vật liệu này
            $stmt = $db->prepare("SELECT * FROM phep_thu WHERE cl_ma = ? ORDER BY pt_ma");
            $stmt->execute([$cl_ma]);
            $phepThuList = $stmt->fetchAll();

            // Tự động chọn phép thử đầu tiên nếu có mà chưa click
            if (!$pt_ma && count($phepThuList) > 0) {
                $pt_ma = $phepThuList[0]['pt_ma'];
            }

            // Nếu đang chọn 1 phép thử cụ thể (hoặc vừa bấm Thêm mới)
            if ($pt_ma && $pt_ma !== 'new') {
                $stmt = $db->prepare("SELECT * FROM phep_thu WHERE pt_ma = ?");
                $stmt->execute([$pt_ma]);
                $currentPhepThu = $stmt->fetch();

                // Lấy các trường của phép thử đó
                $stmt = $db->prepare("SELECT * FROM cau_hinh_truong WHERE pt_ma = ? ORDER BY cht_ma");
                $stmt->execute([$pt_ma]);
                $fields = $stmt->fetchAll();
            }
        }

        return $this->render('cau-hinh/index', [
            'title' => 'Cấu hình thông số thí nghiệm',
            'allVatTuGrouped' => $allVatTuGrouped, // Đã đổi biến allVatTu thành allVatTuGrouped
            'vattu' => $vattu,
            'phepThuList' => $phepThuList,
            'currentPhepThu' => $currentPhepThu,
            'fields' => $fields,
            'pt_ma' => $pt_ma
        ]);
    }

    public function save()
    {
        $this->checkAuth();
        $db = (new BaseModel())->getDb();

        $cl_ma = $_POST['cl_ma'];
        $pt_ma = $_POST['pt_ma'] ?? null;
        $pt_ten = $_POST['pt_ten'];
        $pt_cong_thuc = $_POST['pt_cong_thuc'] ?? '';
        $pt_don_vi = $_POST['pt_don_vi'] ?? '';

        if ($pt_ma == 'new' || empty($pt_ma)) {
            // Thêm mới phép thử (Dùng RETURNING của PostgreSQL để lấy ID vừa tạo)
            $stmt = $db->prepare("INSERT INTO phep_thu (cl_ma, pt_ten, pt_cong_thuc, pt_don_vi) VALUES (?, ?, ?, ?) RETURNING pt_ma");
            $stmt->execute([$cl_ma, $pt_ten, $pt_cong_thuc, $pt_don_vi]);
            $pt_ma = $stmt->fetchColumn();
        } else {
            // Cập nhật phép thử cũ
            $stmt = $db->prepare("UPDATE phep_thu SET pt_ten = ?, pt_cong_thuc = ?, pt_don_vi = ? WHERE pt_ma = ?");
            $stmt->execute([$pt_ten, $pt_cong_thuc, $pt_don_vi, $pt_ma]);

            // Xóa cấu hình trường cũ để lưu lại từ đầu
            $db->prepare("DELETE FROM cau_hinh_truong WHERE pt_ma = ?")->execute([$pt_ma]);
        }

        // Lưu các cấu hình trường (a, b, P...)
        if (!empty($_POST['cht_ten_hien_thi'])) {
            foreach ($_POST['cht_ten_hien_thi'] as $key => $ten) {
                if (empty($ten)) continue;
                $stmt = $db->prepare("INSERT INTO cau_hinh_truong (pt_ma, cht_ten_hien_thi, cht_ten_bien, cht_kieu_du_lieu, cht_mac_dinh) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([
                    $pt_ma,
                    $ten,
                    $_POST['cht_ten_bien'][$key],
                    $_POST['cht_kieu_du_lieu'][$key],
                    $_POST['cht_mac_dinh'][$key] ?? null
                ]);
            }
        }

        // Trở về trang cấu hình đúng ngay tab phép thử vừa lưu
        header("Location: /cau-hinh?cl_ma=" . $cl_ma . "&pt_ma=" . $pt_ma);
        exit;
    }

    public function deleteTest()
    {
        $this->checkAuth();
        $db = (new BaseModel())->getDb();
        $cl_ma = $_GET['cl_ma'];
        $pt_ma = $_GET['pt_ma'];

        $stmt = $db->prepare("DELETE FROM phep_thu WHERE pt_ma = ?");
        $stmt->execute([$pt_ma]);

        header("Location: /cau-hinh?cl_ma=" . $cl_ma);
        exit;
    }
}
