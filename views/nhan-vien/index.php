<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php
$currentPage = 'nhan-vien'; // Để Sidebar làm sáng menu này lên
include __DIR__ . '/../layouts/sidebar.php';
?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-users me-2"></i>Danh sách Nhân sự & Phân quyền</h3>
            <a href="/nhan-vien/tao-moi" class="btn btn-primary shadow-sm"><i class="fas fa-user-plus me-1"></i> Thêm nhân viên</a>
        </div>



        <div class="bg-white p-4 shadow-sm rounded-3 border-top border-info border-3">
            <div class="bg-white p-3 shadow-sm rounded-3 mb-4">
                <form action="/nhan-vien" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="keyword" class="form-control" placeholder="Tìm tên, SĐT, tên đăng nhập..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="cv_ma" class="form-select">
                            <option value="">-- Tất cả chức vụ --</option>
                            <?php if (!empty($danhSachChucVu)): ?>
                                <?php foreach ($danhSachChucVu as $cv): ?>
                                    <option value="<?= $cv['cv_ma'] ?>" <?= (isset($cv_ma_filter) && $cv_ma_filter == $cv['cv_ma']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cv['cv_ten']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-info text-dark w-100"><i class="fas fa-filter me-1"></i> Lọc</button>
                        <a href="/nhan-vien" class="btn btn-light border"><i class="fas fa-redo"></i></a>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã NV</th>
                            <th>Họ và Tên</th>
                            <th>Chức vụ / Vai trò</th>
                            <th>Điện thoại</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($danhSachNhanVien)): ?>
                            <?php foreach ($danhSachNhanVien as $nv): ?>
                                <tr>
                                    <td><strong>NV-<?= sprintf('%03d', $nv['nv_ma'] ?? 0) ?></strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-secondary"></i>
                                            </div>
                                            <span class="fw-bold text-dark"><?= htmlspecialchars($nv['nv_ten'] ?? 'Chưa cập nhật') ?></span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-info text-dark rounded-pill px-3"><?= htmlspecialchars($nv['cv_ten'] ?? 'Chưa phân quyền') ?></span></td>
                                    <td><?= htmlspecialchars($nv['nv_sdt'] ?? '') ?></td>
                                    <td class="text-end">
                                        <a href="/nhan-vien/sua?id=<?= $nv['nv_ma'] ?>" class="btn btn-sm btn-outline-info" title="Sửa"><i class="fas fa-edit"></i></a>
                                        <a href="/nhan-vien/xoa?id=<?= $nv['nv_ma'] ?>" class="btn btn-sm btn-outline-danger" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-users-slash fa-3x mb-3 opacity-50"></i>
                                    <p class="mb-0">Chưa có dữ liệu nhân viên nào trong hệ thống.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../layouts/footer.php'; ?>