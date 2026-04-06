<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php
$currentPage = 'ket-qua';
include __DIR__ . '/../layouts/sidebar.php';

// === GOM NHÓM DỮ LIỆU THEO PHIẾU VÀ LỌC VẬT LIỆU ===
$danhSachGomNhom = [];
if (!empty($danhSach)) {
    foreach ($danhSach as $item) {
        $pyc_ma = $item['pyc_ma'];
        
        // Nếu mã phiếu này chưa có trong mảng thì tạo mới dòng
        if (!isset($danhSachGomNhom[$pyc_ma])) {
            $danhSachGomNhom[$pyc_ma] = [
                'pyc_ma'            => $item['pyc_ma'],
                'pyc_so_phieu'      => $item['pyc_so_phieu'] ?? 'N/A',
                'da_ten'            => $item['da_ten'] ?? 'Chưa xác định',
                'nv_ten'            => $item['nv_ten'] ?? 'N/A',
                'pyc_ngay_nhan_mau' => $item['pyc_ngay_nhan_mau'] ?? null,
                'vat_lieu'          => [] // Mảng chứa các loại vật liệu
            ];
        }
        
        // Thêm tên vật liệu vào mảng (nếu có và chưa bị trùng)
        $tenVatLieu = $item['cl_ten'] ?? null;
        if ($tenVatLieu && !in_array($tenVatLieu, $danhSachGomNhom[$pyc_ma]['vat_lieu'])) {
            $danhSachGomNhom[$pyc_ma]['vat_lieu'][] = $tenVatLieu;
        }
    }
}
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <h4 class="mb-4 text-secondary"><i class="fas fa-poll me-2"></i>Chờ nhập kết quả</h4>

        <div class="bg-white p-3 shadow-sm rounded-3 border-top border-primary border-3">
            <div class="table-responsive">
                <table id="myTable" class="table table-hover table-sm align-middle table-bordered mb-0" style="font-size: 0.95rem;">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 12%">Mã Phiếu</th>
                            <th style="width: 25%">Tên công trình</th>
                            <th style="width: 20%">Vật liệu thí nghiệm</th>
                            <th style="width: 15%">Người lập</th>
                            <th style="width: 15%">Ngày nhận</th>
                            <th style="width: 13%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($danhSachGomNhom)): ?>
                            <?php foreach($danhSachGomNhom as $item): ?>
                            <tr>
                                <td class="text-center fw-bold text-primary"><?= htmlspecialchars($item['pyc_so_phieu']) ?></td>
                                <td><?= htmlspecialchars($item['da_ten']) ?></td>
                                
                                <td>
                                    <?php if(!empty($item['vat_lieu'])): ?>
                                        <?php foreach($item['vat_lieu'] as $vl): ?>
                                            <span class="badge bg-success bg-opacity-75 text-white me-1 mb-1" style="font-size: 0.85rem; font-weight: normal;">
                                                <?= htmlspecialchars($vl) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="text-muted">Chưa có</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center"><?= htmlspecialchars($item['nv_ten']) ?></td>
                                <td class="text-center">
                                    <?= !empty($item['pyc_ngay_nhan_mau']) ? date('d/m/Y', strtotime($item['pyc_ngay_nhan_mau'])) : 'N/A' ?>
                                </td>
                                <td class="text-center">
                                    <a href="/ket-qua/nhap?pyc_ma=<?= $item['pyc_ma'] ?>" class="btn btn-sm btn-primary">
                                        Nhập số liệu <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
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
        $('#myTable').DataTable({
            language: {
                "sLengthMenu":   "Xem _MENU_ dòng",
                "sZeroRecords":  "Không tìm thấy mẫu nào cần nhập kết quả",
                "sInfo":         "Hiển thị _START_ - _END_ / _TOTAL_",
                "sSearch":       "Tìm kiếm nhanh:",
                "oPaginate": {
                    "sPrevious": "Trước",
                    "sNext":     "Sau"
                }
            },
            // Sắp xếp mã phiếu mới nhất lên đầu
            "order": [[ 0, "desc" ]] 
        });
    });
</script>