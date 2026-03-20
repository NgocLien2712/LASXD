<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'phieu-yeu-cau';
include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-file-invoice me-2"></i>Quản lý Phiếu yêu cầu</h3>
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTaoPhieu">
                <i class="fas fa-plus me-1"></i> Tạo phiếu mới
            </button>
        </div>

        <div class="bg-white p-4 shadow-sm rounded-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Số Phiếu</th>
                        <th>Tên Dự Án</th>
                        <th>Người Lập</th>
                        <th>Ngày Nhận</th>
                        <th>Trạng Thái</th>
                        <th class="text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($danhSachPYC)): ?>
                        <?php foreach ($danhSachPYC as $pyc): ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($pyc['pyc_so_phieu']) ?></span></td>

                                <td class="fw-bold text-primary"><?= htmlspecialchars($pyc['da_ten'] ?? 'Chưa xác định') ?></td>
                                <td><i class="fas fa-user-circle text-muted me-1"></i> <?= htmlspecialchars($pyc['nv_ten'] ?? 'Ẩn danh') ?></td>

                                <td><?= date('d/m/Y', strtotime($pyc['pyc_ngay_nhan_mau'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= $pyc['pyc_trang_thai'] == 'Mới tạo' ? 'info' : 'warning' ?>">
                                        <?= htmlspecialchars($pyc['pyc_trang_thai']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="/phieu-yeu-cau/xem?id=<?= $pyc['pyc_ma'] ?>" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Chưa có phiếu yêu cầu nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</div>

<div class="modal fade" id="modalTaoPhieu" tabindex="-1" aria-labelledby="modalTaoPhieuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTaoPhieuLabel"><i class="fas fa-plus-circle me-2"></i>Tạo Phiếu Nhanh</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/phieu-yeu-cau/luu" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dự án / Công trình <span class="text-danger">*</span></label>
                        <select name="da_ma" id="select-du-an-modal" class="form-select" required>
                            <option value="">-- Chọn dự án --</option>
                            <?php foreach ($danhSachDuAn as $da): ?>
                                <option value="<?= $da['da_ma'] ?>"><?= htmlspecialchars($da['da_ten']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ngày nhận mẫu</label>
                        <input type="date" name="pyc_ngay_nhan_mau" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Trạng thái ban đầu</label>
                        <select name="pyc_trang_thai" class="form-select">
                            <option value="Mới tạo">Mới tạo</option>
                            <option value="Đang chờ mẫu">Đang chờ mẫu</option>
                        </select>
                    </div>

                    <div class="alert alert-info py-2 mb-0" role="alert" style="font-size: 0.85rem;">
                        <i class="fas fa-info-circle me-1"></i> Số phiếu và người lập sẽ được hệ thống tạo tự động.
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Lưu phiếu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#select-du-an-modal').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modalTaoPhieu'),
            width: '100%'
        });
    });
</script>