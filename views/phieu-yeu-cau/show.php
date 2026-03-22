<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'phieu-yeu-cau';
include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary">
                <i class="fas fa-file-alt me-2"></i>Chi tiết Phiếu Yêu Cầu: <span class="text-primary"><?= htmlspecialchars($phieu['pyc_so_phieu']) ?></span>
            </h3>
            <div class="d-flex gap-2">
                <a href="/phieu-yeu-cau/in?id=<?= $phieu['pyc_ma'] ?>" target="_blank" class="btn btn-outline-success shadow-sm">
                    <i class="fas fa-print me-1"></i> In Phiếu
                </a>
                <a href="/phieu-yeu-cau" class="btn btn-outline-secondary shadow-sm"><i class="fas fa-arrow-left me-1"></i> Quay lại</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 border-top border-primary border-3 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-dark fw-bold"><i class="fas fa-info-circle me-2 text-primary"></i>Thông Tin Chung</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">Mã hệ thống:</span><strong>#<?= $phieu['pyc_ma'] ?></strong>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">Ngày nhận:</span><strong><?= date('d/m/Y', strtotime($phieu['pyc_ngay_nhan_mau'])) ?></strong>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">Trạng thái:</span>
                                <span class="badge bg-<?= $phieu['pyc_trang_thai'] == 'Mới tạo' ? 'info' : 'warning' ?>">
                                    <?= htmlspecialchars($phieu['pyc_trang_thai']) ?>
                                </span>
                            </li>
                            <li class="list-group-item px-0 d-flex flex-column align-items-start mt-2 border-0">
                                <span class="text-muted mb-1">Người lập phiếu:</span>
                                <div class="d-flex align-items-center bg-light p-2 rounded w-100">
                                    <i class="fas fa-user-circle fa-2x text-secondary me-2"></i>
                                    <span class="fw-bold"><?= htmlspecialchars($phieu['nv_ten'] ?? 'Chưa cập nhật') ?></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-3 border-top border-success border-3">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-dark fw-bold"><i class="fas fa-building me-2 text-success"></i>Dự Án / Công Trình</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="text-primary mb-2"><?= htmlspecialchars($phieu['da_ten'] ?? 'Chưa xác định') ?></h5>
                        <p class="text-muted mb-0 small"><i class="fas fa-map-marker-alt me-2 text-danger"></i><?= htmlspecialchars($phieu['da_diachi'] ?? 'Đang cập nhật...') ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3 border-top border-warning border-3 h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark fw-bold"><i class="fas fa-vials me-2 text-warning"></i>Danh Sách Mẫu Thí Nghiệm</h5>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalThemMau">
                            <i class="fas fa-plus me-1"></i> Thêm Mẫu Mới
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($danhSachMau)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3" style="width: 25%;">Tên Mẫu / Kích thước</th>
                                            <th style="width: 35%;">Phép thử & Tiêu chuẩn</th>
                                            <th class="text-center" style="width: 10%;">Số Lượng</th>
                                            <th class="text-center" style="width: 10%;">Ngày Lấy</th>
                                            <th class="text-center" style="width: 20%;">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($danhSachMau as $mau): ?>
                                            <tr>
                                                <td class="ps-3">
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($mau['mtn_ten']) ?></div>
                                                    <div class="text-muted small">KT: <?= htmlspecialchars($mau['mtn_quy_cach'] ?? '-') ?></div>
                                                </td>
                                                <td>
                                                    <?php if (!empty($mau['danh_sach_phep_thu'])): ?>
                                                        <ul class="list-unstyled mb-0 small">
                                                            <?php foreach ($mau['danh_sach_phep_thu'] as $pt): ?>
                                                                <li class="mb-1 d-flex align-items-start">
                                                                    <i class="fas fa-check-square text-success me-2 mt-1"></i>
                                                                    <span><strong><?= htmlspecialchars($pt['ten_phep_thu']) ?></strong> <br> <small class="text-muted"><?= htmlspecialchars($pt['tieu_chuan']) ?></small></span>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php else: ?>
                                                        <span class="text-muted small fst-italic">Chưa chỉ định</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><span class="badge bg-secondary"><?= $mau['mtn_so_luong'] ?></span></td>
                                                <td class="text-center small"><?= !empty($mau['mtn_ngay_lay']) ? date('d/m/Y', strtotime($mau['mtn_ngay_lay'])) : '-' ?></td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <button class="btn btn-sm btn-outline-success shadow-sm btn-phep-thu"
                                                            data-bs-toggle="modal" data-bs-target="#modalThemPhepThu"
                                                            data-mtn-ma="<?= $mau['mtn_ma'] ?>"
                                                            data-mtn-ten="<?= htmlspecialchars($mau['mtn_ten']) ?>"
                                                            data-lvl-ma="<?= $mau['lvl_ma'] ?>"
                                                            title="Chỉ định phép thử">
                                                            <i class="fas fa-flask"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-info shadow-sm btn-sua-mau"
                                                            data-bs-toggle="modal" data-bs-target="#modalSuaMau"
                                                            data-id="<?= $mau['mtn_ma'] ?>" data-lvl="<?= $mau['lvl_ma'] ?>" data-cl="<?= $mau['cl_ma'] ?>"
                                                            data-sl="<?= $mau['mtn_so_luong'] ?>" data-ngay="<?= $mau['mtn_ngay_lay'] ?>" data-ghichu="<?= htmlspecialchars($mau['mtn_ghi_chu'] ?? '', ENT_QUOTES) ?>" title="Sửa mẫu">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a href="/phieu-yeu-cau/xoa-mau?id=<?= $mau['mtn_ma'] ?>&pyc_ma=<?= $phieu['pyc_ma'] ?>"
                                                            class="btn btn-sm btn-outline-danger shadow-sm"
                                                            onclick="return confirm('Bạn có chắc muốn xóa mẫu này? Toàn bộ phép thử liên quan cũng sẽ bị xóa!');" title="Xóa mẫu">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-flask fa-3x mb-3 text-muted opacity-25"></i>
                                <p class="mb-0 text-muted">Phiếu yêu cầu này chưa có mẫu thí nghiệm nào.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</div>

<div class="modal fade" id="modalThemMau" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Thêm Mẫu Thí Nghiệm</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/phieu-yeu-cau/luu-mau" method="POST">
                <input type="hidden" name="pyc_ma" value="<?= $phieu['pyc_ma'] ?>">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Loại vật liệu <span class="text-danger">*</span></label>
                            <select name="lvl_ma" id="select_lvl" class="form-select" required>
                                <option value="">-- Chọn vật liệu --</option>
                                <?php foreach ($danhSachVatLieu as $vl): ?>
                                    <option value="<?= $vl['lvl_ma'] ?>"><?= htmlspecialchars($vl['lvl_ten']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Chủng loại / Quy cách <span class="text-danger">*</span></label>
                            <select name="cl_ma" id="select_cl" class="form-select" required>
                                <option value="">-- Vui lòng chọn vật liệu trước --</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label fw-bold">Số lượng</label><input type="number" name="mtn_so_luong" class="form-control" value="1" min="1" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Ngày đúc/lấy mẫu</label><input type="date" name="mtn_ngay_lay" class="form-control"></div>
                        <div class="col-md-12"><label class="form-label fw-bold">Ghi chú thêm</label><textarea name="mtn_ghi_chu" class="form-control" rows="2"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer bg-light"><button type="submit" class="btn btn-primary">Lưu Mẫu</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSuaMau" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info text-dark">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Cập nhật Mẫu Thí Nghiệm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/phieu-yeu-cau/cap-nhat-mau" method="POST">
                <input type="hidden" name="pyc_ma" value="<?= $phieu['pyc_ma'] ?>">
                <input type="hidden" name="mtn_ma" id="edit_mtn_ma">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Loại vật liệu <span class="text-danger">*</span></label>
                            <select name="lvl_ma" id="edit_lvl_ma" class="form-select" required>
                                <option value="">-- Chọn vật liệu --</option>
                                <?php foreach ($danhSachVatLieu as $vl): ?>
                                    <option value="<?= $vl['lvl_ma'] ?>"><?= htmlspecialchars($vl['lvl_ten']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Chủng loại / Quy cách <span class="text-danger">*</span></label>
                            <select name="cl_ma" id="edit_cl_ma" class="form-select" required></select>
                        </div>
                        <div class="col-md-6"><label class="form-label fw-bold">Số lượng</label><input type="number" name="mtn_so_luong" id="edit_mtn_so_luong" class="form-control" min="1" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Ngày đúc/lấy mẫu</label><input type="date" name="mtn_ngay_lay" id="edit_mtn_ngay_lay" class="form-control"></div>
                        <div class="col-md-12"><label class="form-label fw-bold">Ghi chú</label><textarea name="mtn_ghi_chu" id="edit_mtn_ghi_chu" class="form-control" rows="2"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer bg-light"><button type="submit" class="btn btn-info">Cập nhật</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalThemPhepThu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-tasks me-2"></i>Chỉ Định Phép Thử</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/phieu-yeu-cau/luu-phep-thu" method="POST">
                <input type="hidden" name="pyc_ma" value="<?= $phieu['pyc_ma'] ?>">
                <input type="hidden" name="mtn_ma" id="input_mtn_ma" value="">

                <div class="modal-body">
                    <div class="alert alert-success py-2 mb-3">
                        Đang chỉ định cho mẫu: <strong id="display_mtn_ten">...</strong>
                    </div>

                    <h6 class="fw-bold text-secondary border-bottom pb-2">Danh sách phép thử khả dụng:</h6>

                    <div id="checklist_phep_thu" class="bg-white border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                        <div class="text-center text-muted py-3">
                            <div class="spinner-border spinner-border-sm text-success" role="status"></div> Đang tải dữ liệu...
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Lưu Chỉ Định</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- 1 & 2. AJAX LOAD CHỦNG LOẠI (Cho Thêm và Sửa) ---
        const selectLvl = document.getElementById('select_lvl');
        const selectCl = document.getElementById('select_cl');
        if (selectLvl && selectCl) {
            selectLvl.addEventListener('change', function() {
                loadChungLoaiAJAX(this.value, selectCl, '');
            });
        }

        const btnSuaMau = document.querySelectorAll('.btn-sua-mau');
        const selectLvlEdit = document.getElementById('edit_lvl_ma');
        const selectClEdit = document.getElementById('edit_cl_ma');
        btnSuaMau.forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('edit_mtn_ma').value = this.getAttribute('data-id');
                document.getElementById('edit_mtn_so_luong').value = this.getAttribute('data-sl');
                document.getElementById('edit_mtn_ngay_lay').value = this.getAttribute('data-ngay');
                document.getElementById('edit_mtn_ghi_chu').value = this.getAttribute('data-ghichu');
                let lvl_ma_cu = this.getAttribute('data-lvl');
                let cl_ma_cu = this.getAttribute('data-cl');
                selectLvlEdit.value = lvl_ma_cu;
                loadChungLoaiAJAX(lvl_ma_cu, selectClEdit, cl_ma_cu);
            });
        });

        if (selectLvlEdit && selectClEdit) {
            selectLvlEdit.addEventListener('change', function() {
                loadChungLoaiAJAX(this.value, selectClEdit, '');
            });
        }

        function loadChungLoaiAJAX(lvl_ma, targetSelect, selectedValue) {
            targetSelect.innerHTML = '<option value="">-- Đang tải... --</option>';
            if (!lvl_ma) return targetSelect.innerHTML = '<option value="">-- Vui lòng chọn vật liệu trước --</option>';
            fetch('/ajax/chung-loai?lvl_ma=' + lvl_ma)
                .then(response => response.json())
                .then(data => {
                    targetSelect.innerHTML = '<option value="">-- Chọn chủng loại / quy cách --</option>';
                    data.forEach(item => {
                        let isSelected = (item.cl_ma == selectedValue) ? 'selected' : '';
                        targetSelect.innerHTML += `<option value="${item.cl_ma}" ${isSelected}>${item.cl_ten}</option>`;
                    });
                }).catch(error => {
                    targetSelect.innerHTML = '<option value="">-- Lỗi tải dữ liệu --</option>';
                });
        }

        // --- 3. AJAX LOAD CHECKLIST PHÉP THỬ ---
        const btnPhepThu = document.querySelectorAll('.btn-phep-thu');
        const checklistContainer = document.getElementById('checklist_phep_thu');
        const displayMtnTen = document.getElementById('display_mtn_ten');
        const inputMtnMa = document.getElementById('input_mtn_ma');

        btnPhepThu.forEach(btn => {
            btn.addEventListener('click', function() {
                let mtn_ma = this.getAttribute('data-mtn-ma');
                let mtn_ten = this.getAttribute('data-mtn-ten');
                let lvl_ma = this.getAttribute('data-lvl-ma'); // Lấy loại vật liệu của mẫu này

                inputMtnMa.value = mtn_ma;
                displayMtnTen.textContent = mtn_ten;

                // Hiển thị loading
                checklistContainer.innerHTML = '<div class="text-center text-muted py-3"><div class="spinner-border spinner-border-sm text-success"></div> Đang tải dữ liệu...</div>';

                // Gọi AJAX để lấy danh sách phép thử
                fetch(`/ajax/phep-thu?lvl_ma=${lvl_ma}&mtn_ma=${mtn_ma}`)
                    .then(response => response.json())
                    .then(data => {
                        checklistContainer.innerHTML = '';
                        if (data.length === 0) {
                            checklistContainer.innerHTML = '<div class="text-muted fst-italic">Không có phép thử nào cho vật liệu này.</div>';
                            return;
                        }

                        // Vẽ ra các Checkbox
                        data.forEach(item => {
                            let isChecked = item.checked ? 'checked' : '';
                            let html = `
                                <div class="form-check mb-2 pb-2 border-bottom">
                                    <input class="form-check-input" type="checkbox" name="pt_ma[]" value="${item.pt_ma}" id="pt_${item.pt_ma}" ${isChecked}>
                                    <label class="form-check-label w-100" style="cursor: pointer;" for="pt_${item.pt_ma}">
                                        <div class="fw-bold text-dark">${item.pt_ten}</div>
                                        <div class="small text-muted">Tiêu chuẩn: ${item.pt_tieu_chuan}</div>
                                    </label>
                                </div>
                            `;
                            checklistContainer.innerHTML += html;
                        });
                    })
                    .catch(error => {
                        checklistContainer.innerHTML = '<div class="text-danger">Lỗi khi tải dữ liệu phép thử!</div>';
                    });
            });
        });
    });
</script>