<?php
namespace App\Controllers;

class DashboardController extends BaseController {
    
    public function index() {
        // 1. Kiểm tra đăng nhập (Nếu chưa đăng nhập sẽ bị đẩy về trang /login)
        $this->checkAuth(); 

        // 2. Chuẩn bị dữ liệu để hiển thị (Tạm thời dùng dữ liệu mẫu)
        $data = [
            'title' => 'Bảng điều khiển LAS-XD',
            'stats' => [
                'projects' => 12,
                'requests' => 28,
                'pending' => 45,
                'staff' => 8
            ],
            'recent_activities' => [
                ['id' => 'PYC-001', 'project' => 'Cầu Mỹ Thuận 2', 'test' => 'Nén Bê Tông R28', 'user' => 'Lê Văn Thử', 'status' => 'Hoàn thành'],
                ['id' => 'PYC-002', 'project' => 'Cao tốc Bắc Nam', 'test' => 'Thử kéo thép', 'user' => 'Nguyễn Văn Kỹ', 'status' => 'Đang chờ'],
            ]
        ];

        // 3. Đổ dữ liệu ra view
        return $this->render('dashboard/index', $data);
    }
}