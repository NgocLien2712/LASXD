<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'don-vi';
include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-building me-2"></i>Quản Lý Đơn Vị</h3>
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalThemDonVi">
                <i class="fas fa-plus me-1"></i> Thêm Đơn Vị Mới
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="bg-white p-3 shadow-sm rounded-3 mb-4 border-top border-info border-3">
                    <form action="/don-vi" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm tên đơn vị..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-info text-dark w-100"><i class="fas fa-filter me-1"></i> Tìm</button>
                            <a href="/don-vi" class="btn btn-light border"><i class="fas fa-redo"></i></a>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3" style="width: 30%">Tên Đơn Vị</th>
                                <th style="width: 50%">Các Dự Án Liên Quan (Vai trò)</th>
                                <th class="text-center" style="width: 20%">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($danhSachDonVi)): ?>
                                <?php foreach ($danhSachDonVi as $dv): ?>
                                    <tr>
                                        <td class="ps-3 fw-bold text-dark"><?= htmlspecialchars($dv['dv_ten']) ?></td>
                                        <td>
                                            <?= $dv['cac_du_an'] ? $dv['cac_du_an'] : '<span class="text-muted fst-italic">Chưa tham gia dự án nào</span>' ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-info btn-sua-donvi"
                                                data-id="<?= $dv['dv_ma'] ?>"
                                                data-ten="<?= htmlspecialchars($dv['dv_ten']) ?>"
                                                data-bs-toggle="modal" data-bs-target="#modalSuaDonVi">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="/don-vi/xoa?id=<?= $dv['dv_ma'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn vị này? Mọi dữ liệu liên quan sẽ bị ảnh hưởng.');"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Chưa có dữ liệu đơn vị.</td>
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

<div class="modal fade" id="modalThemDonVi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Thêm Đơn Vị</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/don-vi/luu" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên đơn vị <span class="text-danger">*</span></label>
                        <input type="text" name="dv_ten" class="form-control" placeholder="VD: Công ty CP Xây dựng ABC..." required>
                        <div class="form-text">Chỉ cần nhập tên đơn vị. Vai trò và dự án sẽ được thiết lập khi thêm Dự án mới.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Lưu lại</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modalSuaDonVi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-info text-dark">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Cập nhật Đơn Vị</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/don-vi/cap-nhat" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="dv_ma" id="edit_dv_ma">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên đơn vị <span class="text-danger">*</span></label>
                            <input type="text" name="dv_ten" id="edit_dv_ten" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-info text-dark"><i class="fas fa-save me-1"></i> Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.btn-sua-donvi');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('edit_dv_ma').value = this.getAttribute('data-id');
                    document.getElementById('edit_dv_ten').value = this.getAttribute('data-ten');
                });
            });
        });
    </script>
</div>