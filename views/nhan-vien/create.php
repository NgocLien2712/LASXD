<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'nhan-vien'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-user-plus me-2"></i>Thêm nhân viên mới</h3>
            <a href="/nhan-vien" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Quay lại</a>
        </div>
        
        <div class="bg-white p-4 shadow-sm rounded-3 border-top border-info border-3" style="max-width: 600px; margin: 0 auto;">
            <form action="/nhan-vien/luu" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Họ và Tên <span class="text-danger">*</span></label>
                    <input type="text" name="nv_ten" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên đăng nhập (Username) <span class="text-danger">*</span></label>
                    <input type="text" name="nv_tendn" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" name="nv_matkhau" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Điện thoại</label>
                        <input type="text" name="nv_sdt" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Chức vụ / Quyền</label>
                        <select name="cv_ma" class="form-select">
                            <option value="">-- Chọn chức vụ --</option>
                            <?php foreach($danhSachChucVu as $cv): ?>
                                <option value="<?= $cv['cv_ma'] ?>"><?= htmlspecialchars($cv['cv_ten']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="text-end">
                    <button type="submit" class="btn btn-info px-4 text-white"><i class="fas fa-save me-1"></i> Lưu Nhân viên</button>
                </div>
            </form>
        </div>
    </div> 
    <?php include __DIR__ . '/../layouts/footer.php'; ?>