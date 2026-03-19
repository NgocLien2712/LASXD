<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'doi-tac'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-handshake me-2"></i>Quản lý Đối tác</h3>
            <a href="/doi-tac/tao-moi" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Thêm đối tác</a>
        </div>

        <div class="bg-white p-3 shadow-sm rounded-3 mb-4">
            <form action="/doi-tac" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm tên, mã số thuế, địa chỉ..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <select name="loai" class="form-select">
                        <option value="">-- Tất cả loại đối tác --</option>
                        <?php foreach($loaiDoiTacList as $loai): ?>
                            <option value="<?= $loai ?>" <?= (isset($loai_filter) && $loai_filter == $loai) ? 'selected' : '' ?>><?= $loai ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-info text-dark w-100"><i class="fas fa-search me-1"></i> Lọc</button>
                    <a href="/doi-tac" class="btn btn-light border"><i class="fas fa-redo"></i></a>
                </div>
            </form>
        </div>

        <div class="bg-white p-4 shadow-sm rounded-3 border-top border-primary border-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tên Đối Tác</th>
                        <th>Loại</th>
                        <th>Mã Số Thuế</th>
                        <th>Địa Chỉ</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($danhSachDoiTac)): ?>
                        <?php foreach($danhSachDoiTac as $dt): ?>
                        <tr>
                            <td class="fw-bold text-dark"><?= htmlspecialchars($dt['dt_ten']) ?></td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($dt['dt_loai']) ?></span></td>
                            <td><?= htmlspecialchars($dt['dt_mst'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($dt['dt_diachi'] ?? '') ?></td>
                            <td class="text-end">
                                <a href="/doi-tac/sua?id=<?= $dt['dt_ma'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                <a href="/doi-tac/xoa?id=<?= $dt['dt_ma'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa đối tác này?');"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-4">Chưa có dữ liệu.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>