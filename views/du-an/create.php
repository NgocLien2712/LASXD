<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php 
    $currentPage = 'du-an'; 
    include __DIR__ . '/../layouts/sidebar.php'; 
?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-plus-circle me-2"></i>Thêm Dự án mới</h3>
            <a href="/du-an" class="btn btn-outline-secondary shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
            </a>
        </div>
        
        <div class="bg-white p-4 shadow-sm rounded-3 border-top border-primary border-3" style="max-width: 800px; margin: 0 auto;">
            <form action="/du-an/luu" method="POST">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên Dự án / Công trình <span class="text-danger">*</span></label>
                    <input type="text" name="da_ten" class="form-control" placeholder="Nhập tên công trình..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Địa chỉ thi công</label>
                    <input type="text" name="da_diachi" class="form-control" placeholder="Nhập địa chỉ chi tiết...">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Chủ Đầu Tư</label>
                        <select name="dt_ma_chudautu" class="form-select">
                            <option value="">-- Chọn Chủ đầu tư --</option>
                            <?php if(!empty($danhSachDoiTac)): ?>
                                <?php foreach($danhSachDoiTac as $dt): ?>
                                    <option value="<?= $dt['dt_ma'] ?>"><?= htmlspecialchars($dt['dt_ten']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Ngày Bắt Đầu</label>
                        <input type="date" name="da_ngay_bat_dau" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>

                <hr class="my-4">
                
                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-light border me-2"><i class="fas fa-eraser me-1"></i> Nhập lại</button>
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Lưu Dự án</button>
                </div>
            </form>
        </div>

    </div> 
    <?php include __DIR__ . '/../layouts/footer.php'; ?>