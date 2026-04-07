<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'phieu-yeu-cau';
include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-edit me-2"></i>Chỉnh sửa Phiếu yêu cầu</h3>
            <a href="/phieu-yeu-cau" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="mb-0 fw-bold">Thông tin phiếu số: <?= htmlspecialchars($phieu['pyc_so_phieu']) ?></h5>
            </div>
            
            <div class="card-body p-4">
                <form action="/phieu-yeu-cau/luu-sua" method="POST">
                    <input type="hidden" name="pyc_ma" value="<?= htmlspecialchars($phieu['pyc_ma']) ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Dự án / Công trình <span class="text-danger">*</span></label>
                            <select name="da_ma" id="select-du-an" class="form-select" required>
                                <option value="">-- Chọn dự án --</option>
                                <?php foreach ($danhSachDuAn as $da): ?>
                                    <option value="<?= $da['da_ma'] ?>" <?= ($da['da_ma'] == $phieu['da_ma']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($da['da_ten']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Ngày nhận mẫu</label>
                            <input type="date" name="pyc_ngay_nhan_mau" class="form-control" value="<?= htmlspecialchars($phieu['pyc_ngay_nhan_mau']) ?>" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <select name="pyc_trang_thai" class="form-select">
                                <option value="Mới tạo" <?= ($phieu['pyc_trang_thai'] == 'Mới tạo') ? 'selected' : '' ?>>Mới tạo</option>
                                <option value="Đang chờ mẫu" <?= ($phieu['pyc_trang_thai'] == 'Đang chờ mẫu') ? 'selected' : '' ?>>Đang chờ mẫu</option>
                                <option value="Đã nhận mẫu" <?= ($phieu['pyc_trang_thai'] == 'Đã nhận mẫu') ? 'selected' : '' ?>>Đã nhận mẫu</option>
                                <option value="Đã có kết quả" <?= ($phieu['pyc_trang_thai'] == 'Đã có kết quả') ? 'selected' : '' ?>>Đã có kết quả</option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex mt-4">
                        <button type="submit" class="btn btn-warning px-4 py-2 fw-bold text-dark me-2">
                            <i class="fas fa-save me-1"></i> Cập nhật phiếu
                        </button>
                        <a href="/phieu-yeu-cau" class="btn btn-light px-4 py-2 border">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</div>

<script>
    $(document).ready(function() {
        // Tích hợp thư viện tìm kiếm dự án như lúc tạo mới
        $('#select-du-an').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });
    });
</script>