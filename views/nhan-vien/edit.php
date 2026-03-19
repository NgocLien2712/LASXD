<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'nhan-vien'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-user-edit me-2"></i>Cập nhật nhân viên</h3>
            <a href="/nhan-vien" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Quay lại</a>
        </div>
        
        <div class="bg-white p-4 shadow-sm rounded-3 border-top border-warning border-3" style="max-width: 600px; margin: 0 auto;">
            <form action="/nhan-vien/cap-nhat" method="POST">
                <input type="hidden" name="nv_ma" value="<?= $nhanVien['nv_ma'] ?>">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Họ và Tên <span class="text-danger">*</span></label>
                    <input type="text" name="nv_ten" class="form-control" value="<?= htmlspecialchars($nhanVien['nv_ten']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên đăng nhập</label>
                    <input type="text" name="nv_tendn" class="form-control" value="<?= htmlspecialchars($nhanVien['nv_tendn']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-danger">Mật khẩu mới (Để trống nếu không muốn đổi)</label>
                    <input type="password" name="nv_matkhau" class="form-control" placeholder="Nhập mật khẩu mới...">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Điện thoại</label>
                        <input type="text" name="nv_sdt" class="form-control" value="<?= htmlspecialchars($nhanVien['nv_sdt'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Chức vụ / Quyền</label>
                        <select name="cv_ma" class="form-select">
                            <option value="">-- Chọn chức vụ --</option>
                            <?php foreach($danhSachChucVu as $cv): ?>
                                <option value="<?= $cv['cv_ma'] ?>" <?= ($nhanVien['cv_ma'] == $cv['cv_ma']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cv['cv_ten']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="text-end">
                    <button type="submit" class="btn btn-warning px-4"><i class="fas fa-save me-1"></i> Lưu Cập nhật</button>
                </div>
            </form>
        </div>
    </div> 
    <?php include __DIR__ . '/../layouts/footer.php'; ?>