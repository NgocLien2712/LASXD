<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php
$currentPage = 'du-an';
include __DIR__ . '/../layouts/sidebar.php';
?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-building me-2"></i>Danh sách Dự án & Công trình</h3>
            <a href="/du-an/tao-moi" class="btn btn-primary shadow-sm"><i class="fas fa-plus me-1"></i> Thêm dự án mới</a>
        </div>

        <div class="bg-white p-4 shadow-sm rounded-3 border-top border-primary border-3">
            <div class="bg-white p-3 shadow-sm rounded-3 mb-4">
                <form action="/du-an" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="keyword" class="form-control" placeholder="Nhập tên dự án hoặc địa chỉ để tìm..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Tìm kiếm</button>
                        <a href="/du-an" class="btn btn-light border"><i class="fas fa-redo"></i></a>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã DA</th>
                            <th style="width: 25%;">Tên Dự Án</th>
                            <th>Địa chỉ</th>
                            <th>Chủ Đầu Tư</th>
                            <th>Ngày bắt đầu</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($danhSachDuAn)): ?>
                            <?php foreach ($danhSachDuAn as $da): ?>
                                <tr>
                                    <td><strong>DA-<?= sprintf('%03d', $da['da_ma']) ?></strong></td>
                                    <td><span class="fw-bold text-primary"><?= htmlspecialchars($da['da_ten']) ?></span></td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        <?= htmlspecialchars($da['da_diachi'] ?? 'Chưa cập nhật') ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-user-tie text-secondary me-1"></i>
                                        <?= htmlspecialchars($da['dt_ten'] ?? 'Mã CĐT: ' . $da['dt_ma_chudautu']) ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt text-success me-1"></i>
                                        <?= date('d/m/Y', strtotime($da['da_ngay_bat_dau'])) ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="/du-an/sua?id=<?= $da['da_ma'] ?>" class="btn btn-sm btn-outline-info" title="Sửa"><i class="fas fa-edit"></i></a>
                                        <a href="/du-an/xoa?id=<?= $da['da_ma'] ?>" class="btn btn-sm btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa dự án này?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                    <p class="mb-0">Chưa có dữ liệu dự án nào trong hệ thống.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../layouts/footer.php'; ?>