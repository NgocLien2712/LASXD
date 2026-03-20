<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'phieu-yeu-cau';
include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light p-4">
    <div class="container-fluid">
        <h3 class="mb-4 text-secondary"><i class="fas fa-plus-circle me-2"></i>Lập Phiếu Yêu Cầu Thí Nghiệm</h3>

        <form action="/phieu-yeu-cau/luu" method="POST" class="bg-white p-4 shadow-sm rounded-3 border-top border-primary border-3">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Số phiếu <span class="text-danger">*</span></label>
                    <input type="text" name="pyc_so_phieu" class="form-control" placeholder="Ví dụ: PYC-2026-001" required>
                </div>

                <div class="col-md-8">
                    <label class="form-label fw-bold">Dự án / Công trình <span class="text-danger">*</span></label>
                    <select name="da_ma" id="select-du-an" class="form-select" required>
                        <option value="">-- Chọn dự án hoặc gõ để tìm kiếm --</option>
                        <?php foreach ($danhSachDuAn as $da): ?>
                            <option value="<?= $da['da_ma'] ?>"><?= htmlspecialchars($da['da_ten']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Ngày nhận mẫu</label>
                    <input type="date" name="pyc_ngay_nhan_mau" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Người lập phiếu</label>
                    <input type="text" class="form-control bg-light" value="<?= $_SESSION['user']['nv_ten'] ?? 'Lỗi session' ?>" readonly>
                    <input type="hidden" name="nv_lap_phieu" value="<?= $_SESSION['user']['nv_ma'] ?? '' ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Trạng thái ban đầu</label>
                    <select name="pyc_trang_thai" class="form-select">
                        <option value="Mới tạo">Mới tạo</option>
                        <option value="Đang chờ mẫu">Đang chờ mẫu</option>
                    </select>
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