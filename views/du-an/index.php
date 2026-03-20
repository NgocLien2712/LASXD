<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'du-an';
include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-project-diagram me-2"></i>Quản Lý Dự Án</h3>
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalThemDuAn">
                <i class="fas fa-plus me-1"></i> Thêm Dự Án Mới
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-3">

            <div class="card-body p-0">
                <div class="bg-white p-3 shadow-sm rounded-3 mb-4 border-top border-info border-3">
                    <form action="/du-an" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo mã dự án hoặc tên dự án..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-info text-dark w-100"><i class="fas fa-filter me-1"></i> Tìm</button>
                            <a href="/du-an" class="btn btn-light border"><i class="fas fa-redo"></i></a>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Mã DA</th>
                                <th>Tên Dự Án</th>
                                <th>Địa Chỉ</th>
                                <th>Nhà Thầu Thi Công</th>
                                <th>Ngày Bắt Đầu</th>
                                <th class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($danhSachDuAn)): ?>
                                <?php foreach ($danhSachDuAn as $da): ?>
                                    <tr>
                                        <td class="ps-3 fw-bold text-primary"><?= htmlspecialchars($da['da_ma_hieu'] ?? '-') ?></td>
                                        <td class="fw-bold text-dark"><?= htmlspecialchars($da['da_ten']) ?></td>
                                        <td><span class="text-truncate d-inline-block" style="max-width: 200px;"><?= htmlspecialchars($da['da_diachi']) ?></span></td>
                                        <td><?= htmlspecialchars($da['nha_thau_thi_cong'] ?? 'Chưa xác định') ?></td>
                                        <td><?= date('d/m/Y', strtotime($da['da_ngay_bat_dau'])) ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></button>
                                            <a href="/du-an/xoa?id=<?= $da['da_ma'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có muốn xóa dự án này không? Các phiếu yêu cầu liên quan sẽ bị xóa theo!');"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Chưa có dữ liệu dự án.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</div>

<div class="modal fade" id="modalThemDuAn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-folder-plus me-2"></i>Thêm Dự Án Mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/du-an/luu" method="POST">
                <div class="modal-body">
                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">1. Thông tin chung</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Mã Dự Án</label>
                            <input type="text" name="da_ma_hieu" class="form-control" placeholder="VD: DA-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tên Dự Án/Công Trình <span class="text-danger">*</span></label>
                            <input type="text" name="da_ten" class="form-control" required placeholder="VD: Tòa nhà hỗn hợp ABC">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Ngày bắt đầu</label>
                            <input type="date" name="da_ngay_bat_dau" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Địa chỉ thi công</label>
                            <input type="text" name="da_diachi" class="form-control" placeholder="Nhập địa chỉ dự án">
                        </div>
                    </div>

                    <h6 class="text-success fw-bold mb-3 border-bottom pb-2">2. Chỉ định Đơn vị (Có thể để trống)</h6>
                    <div class="row g-3">
                        <?php
                        // Mảng chứa các vai trò để render form cho nhanh
                        $roles = [
                            'dv_bqlda' => 'Ban Quản Lý Dự Án',
                            'dv_chudautu' => 'Chủ Đầu Tư',
                            'dv_tvgs' => 'Tư Vấn Giám Sát',
                            'dv_nhathautc' => 'Nhà Thầu Thi Công (Chung)',
                            'dv_nhathauchinh' => 'Nhà Thầu Chính',
                            'dv_nhathauphu' => 'Nhà Thầu Phụ'
                        ];
                        foreach ($roles as $name => $label):
                        ?>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small"><?= $label ?></label>
                                <select name="<?= $name ?>" class="form-select">
                                    <option value="">-- Chọn đơn vị --</option>
                                    <?php foreach ($danhSachDonVi as $dv): ?>
                                        <option value="<?= $dv['dv_ma'] ?>"><?= htmlspecialchars($dv['dv_ten']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Lưu Dự Án</button>
                </div>
            </form>
        </div>
    </div>
</div>