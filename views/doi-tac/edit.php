<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'doi-tac'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light p-4">
    <h3 class="mb-4 text-secondary">Cập nhật Đối tác</h3>
    <form action="/doi-tac/cap-nhat" method="POST" class="bg-white p-4 shadow-sm rounded-3">
        <input type="hidden" name="dt_ma" value="<?= $doiTac['dt_ma'] ?>">
        
        <div class="mb-3">
            <label class="fw-bold">Tên Đối Tác <span class="text-danger">*</span></label>
            <input type="text" name="dt_ten" class="form-control" value="<?= htmlspecialchars($doiTac['dt_ten']) ?>" required>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="fw-bold">Mã Số Thuế</label>
                <input type="text" name="dt_mst" class="form-control" value="<?= htmlspecialchars($doiTac['dt_mst'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="fw-bold">Loại Đối Tác</label>
                <select name="dt_loai" class="form-select">
                    <?php 
                    $loaiList = ['Chủ đầu tư', 'Nhà thầu', 'Tư vấn giám sát', 'Khác'];
                    foreach($loaiList as $loai): 
                    ?>
                        <option value="<?= $loai ?>" <?= ($doiTac['dt_loai'] == $loai) ? 'selected' : '' ?>><?= $loai ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="mb-3">
            <label class="fw-bold">Địa Chỉ</label>
            <textarea name="dt_diachi" class="form-control" rows="3"><?= htmlspecialchars($doiTac['dt_diachi'] ?? '') ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Lưu Thay Đổi</button>
        <a href="/doi-tac" class="btn btn-light border">Hủy</a>
    </form>
</div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>