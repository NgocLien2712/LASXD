<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php 
    $currentPage = 'du-an'; 
    include __DIR__ . '/../layouts/sidebar.php'; 
?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-edit me-2"></i>Cập nhật Dự án</h3>
            <a href="/du-an" class="btn btn-outline-secondary shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
            </a>
        </div>
        
        <div class="bg-white p-4 shadow-sm rounded-3 border-top border-warning border-3" style="max-width: 800px; margin: 0 auto;">
            <form action="/du-an/cap-nhat" method="POST">
                
                <input type="hidden" name="da_ma" value="<?= $duAn['da_ma'] ?>">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên Dự án / Công trình <span class="text-danger">*</span></label>
                    <input type="text" name="da_ten" class="form-control" value="<?= htmlspecialchars($duAn['da_ten']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Địa chỉ thi công</label>
                    <input type="text" name="da_diachi" class="form-control" value="<?= htmlspecialchars($duAn['da_diachi'] ?? '') ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Chủ Đầu Tư</label>
                        <select name="dt_ma_chudautu" class="form-select">
                            <option value="">-- Chọn Chủ đầu tư --</option>
                            <?php if(!empty($danhSachDoiTac)): ?>
                                <?php foreach($danhSachDoiTac as $dt): ?>
                                    <option value="<?= $dt['dt_ma'] ?>" <?= ($duAn['dt_ma_chudautu'] == $dt['dt_ma']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($dt['dt_ten']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Ngày Bắt Đầu</label>
                        <input type="date" name="da_ngay_bat_dau" class="form-control" value="<?= $duAn['da_ngay_bat_dau'] ?>">
                    </div>
                </div>

                <hr class="my-4">
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning px-4 text-dark"><i class="fas fa-save me-1"></i> Lưu Cập nhật</button>
                </div>
            </form>
        </div>

    </div> 
    <?php include __DIR__ . '/../layouts/footer.php'; ?>