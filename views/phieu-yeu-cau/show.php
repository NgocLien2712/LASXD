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
                <button class="btn btn-outline-success shadow-sm"><i class="fas fa-print me-1"></i> In Phiếu</button>
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
                                <span class="text-muted">Mã hệ thống:</span>
                                <strong>#<?= $phieu['pyc_ma'] ?></strong>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">Ngày nhận:</span>
                                <strong><?= date('d/m/Y', strtotime($phieu['pyc_ngay_nhan_mau'])) ?></strong>
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
            <th class="ps-3" style="width: 30%;">Tên Mẫu / Kích thước</th>
            <th style="width: 35%;">Phép thử & Tiêu chuẩn</th>
            <th class="text-center" style="width: 10%;">Số Lượng</th>
            <th class="text-center" style="width: 10%;">Ngày Lấy</th> <th class="text-center" style="width: 15%;">Thao Tác</th>
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
                                    <i class="fas fa-check text-success me-2 mt-1"></i>
                                    <span><strong><?= htmlspecialchars($pt['ten_phep_thu']) ?></strong> <br> <small class="text-muted"><?= htmlspecialchars($pt['tieu_chuan']) ?></small></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <span class="text-muted small fst-italic">Chưa chỉ định</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <span class="badge bg-secondary"><?= $mau['mtn_so_luong'] ?></span>
                </td>
                <td class="text-center small">
                    <?= !empty($mau['mtn_ngay_lay']) ? date('d/m/Y', strtotime($mau['mtn_ngay_lay'])) : '-' ?>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-primary shadow-sm" 
                            data-bs-toggle="modal" data-bs-target="#modalThemPhepThu"
                            data-mtn-ma="<?= $mau['mtn_ma'] ?>"
                            data-mtn-ten="<?= htmlspecialchars($mau['mtn_ten']) ?>">
                        <i class="fas fa-plus-circle me-1"></i> Phép thử
                    </button>
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
                                <p class="small text-muted">Bấm nút "Thêm Mẫu Mới" ở góc trên để bắt đầu.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div> <?php include __DIR__ . '/../layouts/footer.php'; ?>
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
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Tên mẫu thí nghiệm <span class="text-danger">*</span></label>
                            <input type="text" name="mtn_ten" class="form-control" placeholder="VD: Bê tông thương phẩm mác 250..." required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kích thước</label>
                            <input type="text" name="mtn_quy_cach" class="form-control" placeholder="VD: Lăng trụ 15x15x15 cm">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Số lượng <span class="text-danger">*</span></label>
                            <input type="number" name="mtn_so_luong" class="form-control" value="1" min="1" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Ngày đúc/lấy mẫu</label>
                            <input type="date" name="mtn_ngay_lay" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Ghi chú thêm</label>
                            <textarea name="mtn_ghi_chu" class="form-control" rows="2" placeholder="Vị trí lấy mẫu, tình trạng mẫu..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Lưu Mẫu</button>
                </div>
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
                    <div class="alert alert-success py-2">
                        Đang chỉ định thử nghiệm cho mẫu: <br>
                        <strong id="display_mtn_ten" class="fs-6">...</strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên Phép Thử <span class="text-danger">*</span></label>
                        <input type="text" name="ten_phep_thu" class="form-control" placeholder="VD: Thử cường độ nén..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu chuẩn áp dụng</label>
                        <input type="text" name="tieu_chuan" class="form-control" placeholder="VD: TCVN 3118:2022">
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold">Ghi chú (Nếu có)</label>
                        <textarea name="cdpt_ghi_chu" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Lưu Phép Thử</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalThemPhepThu = document.getElementById('modalThemPhepThu');
        if (modalThemPhepThu) {
            modalThemPhepThu.addEventListener('show.bs.modal', function(event) {
                // Nút vừa được bấm
                var button = event.relatedTarget;
                // Lấy thông tin từ các thuộc tính data-
                var mtnMa = button.getAttribute('data-mtn-ma');
                var mtnTen = button.getAttribute('data-mtn-ten');

                // Cập nhật vào Modal
                modalThemPhepThu.querySelector('#input_mtn_ma').value = mtnMa;
                modalThemPhepThu.querySelector('#display_mtn_ten').textContent = mtnTen;
            });
        }
    });
</script>