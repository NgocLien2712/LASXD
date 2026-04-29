<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php
$currentPage = 'dashboard';
include __DIR__ . '/../layouts/sidebar.php';

$db = (new \App\Models\BaseModel())->getDb();

// 1. Đếm số lượng tổng quan
$countDuAn = 0;
try {
    $countDuAn = $db->query("SELECT COUNT(*) FROM du_an")->fetchColumn();
} catch (\Exception $e) {}

$countNhanVien = 0;
try {
    $countNhanVien = $db->query("SELECT COUNT(*) FROM nhan_vien")->fetchColumn();
} catch (\Exception $e) {}

$countPhieu = 0;
try {
    $countPhieu = $db->query("SELECT COUNT(*) FROM phieu_yeu_cau")->fetchColumn();
} catch (\Exception $e) {}

$countMau = 0;
try {
    $countMau = $db->query("SELECT COUNT(*) FROM mau_thi_nghiem")->fetchColumn();
} catch (\Exception $e) {}

// 2. Lấy danh sách Dự án mới nhất (Dự án thêm sau hiện lên trước)
$recentProjects = [];
try {
    // Sắp xếp giảm dần theo da_ma để lấy dự án mới nhất, giới hạn 5 dự án
    $sqlProjects = "SELECT * FROM du_an ORDER BY da_ma DESC LIMIT 5";
    $recentProjects = $db->query($sqlProjects)->fetchAll(\PDO::FETCH_ASSOC);
} catch (\Exception $e) {
    echo "<script>console.error('Lỗi lấy danh sách dự án: " . addslashes($e->getMessage()) . "');</script>";
}

?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">

    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-home me-2"></i>Tổng quan hoạt động</h3>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-primary text-white p-3 rounded-3 h-100">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1 opacity-75">Dự án/Công trình</p>
                            <h2 class="mb-0 fw-bold"><?= $countDuAn ?></h2>
                        </div>
                        <i class="fas fa-city fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-success text-white p-3 rounded-3 h-100">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1 opacity-75">Phiếu yêu cầu mới</p>
                            <h2 class="mb-0 fw-bold"><?= $countPhieu ?></h2>
                        </div>
                        <i class="fas fa-file-contract fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-warning text-white p-3 rounded-3 h-100">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1 opacity-75">Mẫu chờ thí nghiệm</p>
                            <h2 class="mb-0 fw-bold"><?= $countMau ?></h2>
                        </div>
                        <i class="fas fa-vial fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-info text-white p-3 rounded-3 h-100">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1 opacity-75">Nhân sự (Tài khoản)</p>
                            <h2 class="mb-0 fw-bold"><?= str_pad($countNhanVien, 2, '0', STR_PAD_LEFT) ?></h2>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 shadow-sm rounded-3 border-top border-primary border-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 text-secondary"><i class="fas fa-building me-2"></i>Dự án / Công trình mới tiếp nhận</h5>
                <a href="/du-an" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="15%">Mã Dự Án</th>
                            <th width="40%">Tên Dự Án / Công Trình</th>
                            <th width="45%">Địa Chỉ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentProjects)): ?>
                            <?php foreach ($recentProjects as $project): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary px-2 py-1">
                                            <?= htmlspecialchars($project['da_ma'] ?? 'N/A') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="text-primary">
                                            <?= htmlspecialchars($project['da_ten'] ?? 'Chưa cập nhật tên') ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                            <?= htmlspecialchars($project['da_diachi'] ?? 'Chưa cập nhật địa chỉ') ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">Chưa có dự án nào trong cơ sở dữ liệu.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</div>