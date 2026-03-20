<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'du-an'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-edit me-2"></i>Sửa Dự Án</h3>
            <a href="/du-an" class="btn btn-secondary shadow-sm"><i class="fas fa-arrow-left me-1"></i> Quay lại</a>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <form action="/du-an/cap-nhat" method="POST">
                    <input type="hidden" name="da_ma" value="<?= $duAn['da_ma'] ?>">
                    
                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">1. Thông tin chung</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Mã Dự Án</label>
                            <input type="text" name="da_ma_hieu" class="form-control" value="<?= htmlspecialchars($duAn['da_ma_hieu'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tên Dự Án/Công Trình <span class="text-danger">*</span></label>
                            <input type="text" name="da_ten" class="form-control" required value="<?= htmlspecialchars($duAn['da_ten']) ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Ngày bắt đầu</label>
                            <input type="date" name="da_ngay_bat_dau" class="form-control" value="<?= htmlspecialchars($duAn['da_ngay_bat_dau']) ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Địa chỉ thi công</label>
                            <input type="text" name="da_diachi" class="form-control" value="<?= htmlspecialchars($duAn['da_diachi'] ?? '') ?>">
                        </div>
                    </div>

                    <h6 class="text-success fw-bold mb-3 border-bottom pb-2">2. Chỉ định Đơn vị (Có thể để trống)</h6>
                    <div class="row g-3">
                        <?php 
                        $rolesMap = [
                            'dv_bqlda' => 'Ban quản lý dự án',
                            'dv_chudautu' => 'Chủ đầu tư',
                            'dv_tvgs' => 'Tư vấn giám sát',
                            'dv_nhathautc' => 'Nhà thầu thi công',
                            'dv_nhathauchinh' => 'Nhà thầu chính',
                            'dv_nhathauphu' => 'Nhà thầu phụ'
                        ];
                        foreach ($rolesMap as $inputName => $dbRoleName): 
                            // Kiểm tra xem dự án này đã gán đơn vị nào cho vai trò này chưa
                            $selectedDvMa = $roles[$dbRoleName] ?? null;
                        ?>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small"><?= mb_strtoupper($dbRoleName) ?></label>
                                <select name="<?= $inputName ?>" class="form-select">
                                    <option value="">-- Chọn đơn vị --</option>
                                    <?php foreach($danhSachDonVi as $dv): ?>
                                        <option value="<?= $dv['dv_ma'] ?>" <?= ($selectedDvMa == $dv['dv_ma']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($dv['dv_ten']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Lưu Thay Đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</div>