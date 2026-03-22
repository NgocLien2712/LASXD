<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'phieu-yeu-cau';
include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light p-4">
    <div class="container-fluid">
        <h3 class="mb-4 text-secondary"><i class="fas fa-plus-circle me-2"></i>Lập Phiếu Yêu Cầu Thí Nghiệm</h3>

        <form action="/phieu-yeu-cau/luu" method="POST" class="bg-white p-4 shadow-sm rounded-3 border-top border-primary border-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Thuộc Dự án / Công trình <span class="text-danger">*</span></label>
                    <select name="da_ma" id="select-du-an" class="form-select" required>
                        <option value="">-- Chọn dự án --</option>
                        <?php if (!empty($danhSachDuAn)): ?>
                            <?php foreach ($danhSachDuAn as $da): ?>
                                <option value="<?= $da['da_ma'] ?>">
                                    <?= htmlspecialchars(($da['da_ma_hieu'] ?? '') . ' - ' . $da['da_ten']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>Chưa có dự án nào trong hệ thống</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Ngày nhận mẫu</label>
                    <input type="date" name="pyc_ngay_nhan_mau" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Trạng thái ban đầu</label>
                    <select name="pyc_trang_thai" class="form-select">
                        <option value="Mới tạo">Mới tạo</option>
                        <option value="Đang chờ mẫu">Đang chờ mẫu</option>
                    </select>
                </div>

                <div class="col-12 mt-3">
                    <div class="alert alert-info py-2 mb-0" style="font-size: 0.9rem;">
                        <i class="fas fa-info-circle me-1"></i> Số phiếu và thông tin người lập sẽ được hệ thống tạo tự động khi bạn bấm Lưu.
                    </div>
                </div>

                <div class="col-12 mt-4 border-top pt-3">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Lưu phiếu yêu cầu</button>
                    <a href="/phieu-yeu-cau" class="btn btn-light border px-4">Hủy bỏ</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#select-du-an').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Chọn dự án hoặc gõ để tìm kiếm --',
            allowClear: true,
            width: '100%'
        });
    });
</script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>