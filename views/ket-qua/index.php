<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php
$currentPage = 'ket-qua';
include __DIR__ . '/../layouts/sidebar.php';

// HÀM GOM NHÓM DỮ LIỆU DÙNG CHUNG CHO CẢ 3 TAB
$gomNhomPhieu = function ($danhSach) {
    $ketQua = [];
    if (!empty($danhSach)) {
        foreach ($danhSach as $item) {
            $pyc_ma = $item['pyc_ma'];
            if (!isset($ketQua[$pyc_ma])) {
                $ketQua[$pyc_ma] = [
                    'pyc_ma'            => $item['pyc_ma'],
                    'pyc_so_phieu'      => $item['pyc_so_phieu'] ?? 'N/A',
                    'da_ten'            => $item['da_ten'] ?? 'Chưa xác định',
                    'nv_ten'            => $item['nv_ten'] ?? 'N/A',
                    'pyc_ngay_nhan_mau' => $item['pyc_ngay_nhan_mau'] ?? null,
                    'vat_lieu'          => [] 
                ];
            }
            // Thêm tên vật liệu vào mảng nếu chưa tồn tại
            $tenVatLieu = $item['cl_ten'] ?? null;
            if ($tenVatLieu && !in_array($tenVatLieu, $ketQua[$pyc_ma]['vat_lieu'])) {
                $ketQua[$pyc_ma]['vat_lieu'][] = $tenVatLieu;
            }
        }
    }
    return $ketQua;
};

// Áp dụng gom nhóm cho 3 biến truyền từ Controller sang
$gomNhomChuaNhap  = $gomNhomPhieu($danhSachChuaNhap ?? []);
$gomNhomChoDuyet  = $gomNhomPhieu($danhSachChoDuyet ?? []);
$gomNhomDaBanHanh = $gomNhomPhieu($danhSachDaBanHanh ?? []);

?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-poll me-2"></i>Quản lý kết quả thí nghiệm</h3>
        </div>

        <ul class="nav nav-tabs fw-bold" id="ketQuaTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-primary" id="cho-nhap-tab" data-bs-toggle="tab" data-bs-target="#cho-nhap" type="button" role="tab">
                    <i class="fas fa-keyboard me-1"></i> Chờ nhập kết quả
                    <span class="badge bg-danger rounded-pill ms-1"><?= count($gomNhomChuaNhap) ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-warning" id="cho-duyet-tab" data-bs-toggle="tab" data-bs-target="#cho-duyet" type="button" role="tab">
                    <i class="fas fa-clipboard-check me-1"></i> Chờ duyệt
                    <span class="badge bg-warning text-dark rounded-pill ms-1"><?= count($gomNhomChoDuyet) ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-success" id="da-ban-hanh-tab" data-bs-toggle="tab" data-bs-target="#da-ban-hanh" type="button" role="tab">
                    <i class="fas fa-stamp me-1"></i> Đã ban hành
                    <span class="badge bg-success rounded-pill ms-1"><?= count($gomNhomDaBanHanh) ?></span>
                </button>
            </li>
        </ul>

        <div class="tab-content bg-white p-3 shadow-sm rounded-bottom border border-top-0" id="ketQuaTabsContent">

            <div class="tab-pane fade show active" id="cho-nhap" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle table-bordered mb-0 myTable" style="font-size: 0.95rem;">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 12%">Mã Phiếu</th>
                                <th style="width: 25%">Tên Dự Án</th>
                                <th style="width: 20%">Vật liệu thí nghiệm</th>
                                <th style="width: 15%">Người lập</th>
                                <th style="width: 15%">Ngày nhận</th>
                                <th style="width: 13%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gomNhomChuaNhap as $item): ?>
                                <tr>
                                    <td class="text-center fw-bold text-primary"><?= htmlspecialchars($item['pyc_so_phieu']) ?></td>
                                    <td><?= htmlspecialchars($item['da_ten']) ?></td>
                                    <td>
                                        <?php if (!empty($item['vat_lieu'])): ?>
                                            <?php foreach ($item['vat_lieu'] as $vl): ?>
                                                <span class="badge bg-success bg-opacity-75 text-white me-1 mb-1" style="font-size: 0.85rem; font-weight: normal;">
                                                    <?= htmlspecialchars($vl) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Chưa có</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?= htmlspecialchars($item['nv_ten']) ?></td>
                                    <td class="text-center"><?= !empty($item['pyc_ngay_nhan_mau']) ? date('d/m/Y', strtotime($item['pyc_ngay_nhan_mau'])) : 'N/A' ?></td>
                                    <td class="text-center">
                                        <a href="/ket-qua/nhap?pyc_ma=<?= $item['pyc_ma'] ?>" class="btn btn-sm btn-primary">
                                            Nhập số liệu <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="cho-duyet" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle table-bordered mb-0 myTable" style="font-size: 0.95rem;">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 12%">Mã Phiếu</th>
                                <th style="width: 30%; min-width: 250px;">Tên Dự Án</th>
                                <th style="width: 20%">Vật liệu thí nghiệm</th>
                                <th style="width: 15%">Người lập</th>
                                <th style="width: 15%">Ngày nhận</th>
                                <th style="width: 8%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gomNhomChoDuyet as $item): ?>
                                <tr>
                                    <td class="text-center fw-bold text-primary"><?= htmlspecialchars($item['pyc_so_phieu']) ?></td>

                                    <td><?= htmlspecialchars($item['da_ten']) ?></td>

                                    <td>
                                        <?php if (!empty($item['vat_lieu'])): ?>
                                            <?php foreach ($item['vat_lieu'] as $vl): ?>
                                                <span class="badge bg-success bg-opacity-75 text-white me-1 mb-1" style="font-size: 0.85rem; font-weight: normal;">
                                                    <?= htmlspecialchars($vl) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Chưa có</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center"><?= htmlspecialchars($item['nv_ten']) ?></td>

                                    <td class="text-center"><?= !empty($item['pyc_ngay_nhan_mau']) ? date('d/m/Y', strtotime($item['pyc_ngay_nhan_mau'])) : 'N/A' ?></td>

                                    <td class="text-center">
                                        <div class="btn-group shadow-sm" role="group">
                                            <a href="/ket-qua/xem?pyc_ma=<?= $item['pyc_ma'] ?>" class="btn btn-sm btn-info text-white" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="/ket-qua/nhap?pyc_ma=<?= $item['pyc_ma'] ?>" class="btn btn-sm btn-primary mx-1" title="Sửa kết quả">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="/ket-qua/duyet?pyc_ma=<?= $item['pyc_ma'] ?>" class="btn btn-sm btn-warning fw-bold text-dark" onclick="return confirm('Xác nhận duyệt kết quả và ban hành phiếu này?');" title="Duyệt kết quả">
                                                <i class="fas fa-check-double"></i> Duyệt
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="da-ban-hanh" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle table-bordered mb-0 myTable" style="font-size: 0.95rem;">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 12%">Mã Phiếu</th>
                                <th style="width: 30%; min-width: 250px;">Tên Dự Án</th>
                                <th style="width: 20%">Vật liệu thí nghiệm</th>
                                <th style="width: 15%">Người lập</th>
                                <th style="width: 15%">Ngày nhận</th>
                                <th style="width: 13%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gomNhomDaBanHanh as $item): ?>
                                <tr>
                                    <td class="text-center fw-bold text-primary"><?= htmlspecialchars($item['pyc_so_phieu']) ?></td>
                                    <td><?= htmlspecialchars($item['da_ten']) ?></td>
                                    <td>
                                        <?php if (!empty($item['vat_lieu'])): ?>
                                            <?php foreach ($item['vat_lieu'] as $vl): ?>
                                                <span class="badge bg-success bg-opacity-75 text-white me-1 mb-1" style="font-size: 0.85rem; font-weight: normal;">
                                                    <?= htmlspecialchars($vl) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Chưa có</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?= htmlspecialchars($item['nv_ten']) ?></td>
                                    <td class="text-center"><?= !empty($item['pyc_ngay_nhan_mau']) ? date('d/m/Y', strtotime($item['pyc_ngay_nhan_mau'])) : 'N/A' ?></td>
                                    <td class="text-center">
                                        <a href="/ket-qua/xem?pyc_ma=<?= $item['pyc_ma'] ?>" class="btn btn-sm btn-success">
                                            Xem bản in <i class="fas fa-print ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('.myTable').DataTable({
            language: {
                "sLengthMenu": "Xem _MENU_ dòng",
                "sZeroRecords": "Không có dữ liệu trong mục này",
                "sInfo": "Hiển thị _START_ - _END_ / _TOTAL_",
                "sSearch": "Tìm kiếm nhanh:",
                "oPaginate": {
                    "sPrevious": "Trước",
                    "sNext": "Sau"
                }
            },
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>