<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php 
    $currentPage = 'dashboard'; 
    include __DIR__ . '/../layouts/sidebar.php'; 

    // =========================================================
    // CODE LẤY SỐ LIỆU THỰC TẾ TỪ DATABASE
    // =========================================================
    $db = (new \App\Models\BaseModel())->getDb();
    
    // 1. Đếm số lượng
    $countDuAn = 0;
    try { $countDuAn = $db->query("SELECT COUNT(*) FROM du_an")->fetchColumn(); } catch (\Exception $e) {}
    
    $countNhanVien = 0;
    try { $countNhanVien = $db->query("SELECT COUNT(*) FROM nhan_vien")->fetchColumn(); } catch (\Exception $e) {}
    
    $countPhieu = 0;
    try { $countPhieu = $db->query("SELECT COUNT(*) FROM phieu_yeu_cau")->fetchColumn(); } catch (\Exception $e) {}
    
    $countMau = 0;
    try { $countMau = $db->query("SELECT COUNT(*) FROM mau_thi_nghiem")->fetchColumn(); } catch (\Exception $e) {}

    // 2. Lấy danh sách 5 hoạt động gần đây nhất
    $recentActivities = [];
    try { 
        // Lưu ý: Tên cột (ma_phieu, ten_phep_thu...) có thể cần điều chỉnh lại cho khớp đúng với Database thực tế của bạn
        $sql = "SELECT p.*, d.Ten_Du_An, n.Ho_Ten 
                FROM phieu_yeu_cau p 
                LEFT JOIN du_an d ON p.id_du_an = d.ID 
                LEFT JOIN nhan_vien n ON p.id_nhan_vien = n.ID 
                ORDER BY p.id DESC LIMIT 5";
        $recentActivities = $db->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
    } catch (\Exception $e) {
        // Nếu bảng chưa tồn tại hoặc sai tên cột, mảng sẽ rỗng và không gây lỗi
    }
?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    
    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-home me-2"></i>Tổng quan hoạt động</h3>
            <a href="/phieu-yeu-cau/create" class="btn btn-primary shadow-sm"><i class="fas fa-plus me-1"></i> Tạo phiếu mới</a>
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
            <h5 class="mb-3 text-secondary">Hoạt động thí nghiệm gần đây</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã Phiếu</th>
                            <th>Dự án</th>
                            <th>Phép thử</th>
                            <th>Người thực hiện</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentActivities)): ?>
                            <?php foreach ($recentActivities as $activity): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($activity['ma_phieu'] ?? 'N/A') ?></strong></td>
                                    <td><?= htmlspecialchars($activity['Ten_Du_An'] ?? 'Chưa xác định') ?></td>
                                    <td><?= htmlspecialchars($activity['ten_phep_thu'] ?? 'Chưa xác định') ?></td>
                                    <td>
                                        <?php $tenNV = htmlspecialchars($activity['Ho_Ten'] ?? 'Ẩn danh'); ?>
                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($tenNV) ?>&background=random" class="rounded-circle me-2" width="25">
                                        <?= $tenNV ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $trangThai = $activity['trang_thai'] ?? 'Chờ xử lý';
                                            $badgeClass = 'bg-secondary';
                                            if ($trangThai === 'Hoàn thành') $badgeClass = 'bg-success';
                                            elseif ($trangThai === 'Đang xử lý') $badgeClass = 'bg-warning text-dark';
                                        ?>
                                        <span class="badge <?= $badgeClass ?> rounded-pill px-3"><?= htmlspecialchars($trangThai) ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 opacity-50"></i>
                                    <p class="mb-0">Chưa có hoạt động thí nghiệm nào gần đây.</p>
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