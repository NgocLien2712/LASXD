<?php
// Gọi Model DuAn để lấy danh sách các đơn vị tham gia dự án này
$cacDonVi = [];
if (!empty($phieu['da_ma'])) {
    $duAnModel = new \App\Models\DuAn();
    $cacDonVi = $duAnModel->getChiTietDonVi($phieu['da_ma']);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Phiếu kết quả' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .preview-toolbar {
            background: #343a40;
            padding: 10px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .page-a4 {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 20mm;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .table-tho th,
        .table-tho td {
            border: 1px solid #000 !important;
            padding: 8px;
            vertical-align: middle;
        }

        .table-tho th {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
            }

            .preview-toolbar {
                display: none;
            }

            .page-a4 {
                width: 100%;
                min-height: auto;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }

            .page-break {
                page-break-before: always;
            }
        }

        .dot-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            width: 100%;
            min-height: 20px;
        }
    </style>
</head>

<body>

    <div class="preview-toolbar">
        <button onclick="window.print()" class="btn btn-light fw-bold">🖨️ IN PHIẾU KẾT QUẢ</button>
        <button onclick="history.back()" class="btn btn-outline-light ms-2">Quay lại</button>
    </div>

    <div class="page-a4">
        <div class="row border-bottom border-dark pb-3 mb-4 align-items-center">
            <div class="col-2 text-center">
                <img src="/img/logolasxd.png" alt="Logo" style="width: 100%; max-width: 90px;" onerror="this.style.display='none'">
            </div>
            <div class="col-10 text-center pe-5">
                <h5 class="fw-bold mb-0">PHÒNG THÍ NGHIỆM CHUYÊN NGÀNH XÂY DỰNG LAS-XD</h5>
            </div>
        </div>

        <div class="text-center mb-4">
            <h4 class="fw-bold mb-1">KẾT QUẢ THÍ NGHIỆM</h4>
            <p class="fst-italic mb-0">Mã phiếu YC: <strong><?= htmlspecialchars($phieu['pyc_so_phieu'] ?? '') ?></strong></p>
        </div>

        <div class="mb-4">
            <div class="row mb-2">
                <div class="col-12"><strong>Tên dự án/Công trình:</strong> <?= htmlspecialchars($phieu['da_ten'] ?? '..........................................................') ?></div>
            </div>

            <div class="row mb-2">
                <div class="col-12"><strong>Địa chỉ công trình:</strong> <?= htmlspecialchars($phieu['da_diachi'] ?? '..........................................................') ?></div>
            </div>

            <?php $stt = 1; ?>

            <?php if (!empty($cacDonVi)): ?>
                <?php foreach ($cacDonVi as $dv): ?>
                    <div class="row mb-2">
                        <div class="col-12">
                            <strong><?= $stt++ ?>. <?= htmlspecialchars($dv['vai_tro']) ?>:</strong>
                            <?= htmlspecialchars($dv['dv_ten']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="row mb-2">
                    <div class="col-12"><strong><?= $stt++ ?>. Chủ đầu tư:</strong> ..........................................................</div>
                </div>
            <?php endif; ?>

            <div class="row mb-2">
                <div class="col-6"><strong><?= $stt ?>. Ngày nhận mẫu:</strong> <?= !empty($phieu['pyc_ngay_nhan_mau']) ? date('d/m/Y', strtotime($phieu['pyc_ngay_nhan_mau'])) : '....................' ?></div>
                <div class="col-6"><strong><?= $stt + 1 ?>. Ngày thí nghiệm:</strong> <?= !empty($phieu['ngay_thi_nghiem']) ? date('d/m/Y', strtotime($phieu['ngay_thi_nghiem'])) : '<span class="dot-line" style="width: 150px;"></span>' ?></div>
            </div>
        </div>

        <h6 class="fw-bold text-decoration-underline mb-3">KẾT QUẢ ĐO ĐẠC:</h6>

        <?php if (!empty($danhSachMau)): ?>
            <?php foreach ($danhSachMau as $index => $mau): ?>
                <div class="mb-4">
                    <p class="fw-bold mb-2">Mẫu số <?= $index + 1 ?>: <?= htmlspecialchars($mau['mtn_ten'] ?? $mau['cl_ten'] ?? 'Chưa xác định') ?> (SL: <?= htmlspecialchars($mau['mtn_so_luong'] ?? '....') ?> - <?= htmlspecialchars($mau['mtn_quy_cach'] ?? '......') ?>)</p>

                    <?php
                    // Lấy số lượng viên/mẫu để in số hàng
                    $soLuongVien = (int)($mau['mtn_so_luong'] ?? 3);
                    if ($soLuongVien <= 0) $soLuongVien = 3;
                    ?>

                    <?php if (!empty($mau['danh_sach_phep_thu'])): ?>
                        <?php foreach ($mau['danh_sach_phep_thu'] as $pt): ?>
                            <p class="fst-italic mb-1 fw-bold ps-3">
                                - Phép thử: <?= htmlspecialchars($pt['ten_phep_thu'] ?? $pt['bm_ten_phep_thu'] ?? 'Chưa có tên') ?>
                            </p>
                            
                            <table class="table table-tho mb-3 w-100">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center align-middle">TT</th>
                                        <th width="15%" class="text-center align-middle">Ký hiệu mẫu</th>
                                        
                                        <?php if (!empty($pt['danh_sach_truong'])): ?>
                                            <?php foreach ($pt['danh_sach_truong'] as $truong): ?>
                                                <th class="text-center align-middle">
                                                    <?= htmlspecialchars($truong['cht_ten_hien_thi']) ?><br>
                                                    (<strong><?= htmlspecialchars($truong['cht_ten_bien']) ?></strong>)
                                                </th>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <th class="text-center align-middle">Đại lượng đo</th>
                                        <?php endif; ?>
                                        
                                        <th width="15%" class="text-center align-middle">Kết quả</th>
                                        <th width="15%" class="text-center align-middle">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pt['danh_sach_truong'])): ?>
                                        <?php 
                                            // GIẢI MÃ JSON ĐỂ IN SỐ LIỆU ĐÃ NHẬP
                                            $duLieuTho = json_decode($pt['kq_du_lieu_tho'] ?? '{}', true); 
                                            
                                            $colspanTrungBinh = 2 + count($pt['danh_sach_truong']);
                                        ?>
                                        
                                        <?php for ($v = 1; $v <= $soLuongVien; $v++): ?>
                                            <tr>
                                                <td class="text-center"><?= $v ?></td>
                                                <td class="text-center fw-bold">Mẫu <?= $v ?></td>
                                                
                                                <?php foreach ($pt['danh_sach_truong'] as $truong): ?>
                                                    <?php $tenBien = $truong['cht_ten_bien']; ?>
                                                    <td class="text-center">
                                                        <?= htmlspecialchars($duLieuTho[$v][$tenBien] ?? '') ?>
                                                    </td>
                                                <?php endforeach; ?>
                                                
                                                <td class="text-center fw-bold text-primary">
                                                    <?= htmlspecialchars($duLieuTho[$v]['kq_mau'] ?? '') ?>
                                                </td>

                                                <td class="text-center">
                                                    <?= htmlspecialchars($duLieuTho[$v]['ghi_chu'] ?? '') ?>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                        
                                        <tr>
                                            <td colspan="<?= $colspanTrungBinh ?>" class="text-center fw-bold text-uppercase">
                                                Kết quả trung bình
                                            </td>
                                            <td class="text-center fw-bold text-danger fs-6">
                                                <?= htmlspecialchars($pt['kq_ket_luan'] ?? '') ?>
                                            </td>
                                            <td class="text-center"></td>
                                        </tr>

                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center py-3" colspan="6">
                                                <i class="text-muted">(Phép thử này chưa được cấu hình các tham số đo đạc)</i>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="ps-3 fst-italic text-danger">Chưa có phép thử nào được chỉ định.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="row mt-5 text-center justify-content-center">
            <div class="col-6">
                <p class="fw-bold mb-0 text-uppercase"><?= htmlspecialchars($phieu['chuc_vu_nguoi_nhap'] ?? 'Người nhập') ?></p>
                <br><br><br><br>
                <p class="fst-italic mb-0"><?= htmlspecialchars($phieu['ten_nguoi_nhap'] ?? '.......................................') ?></p>
            </div>

            <div class="col-6">
                <p class="fw-bold mb-0 text-uppercase"><?= htmlspecialchars($phieu['chuc_vu_nguoi_duyet'] ?? 'Người duyệt') ?></p>
                <br><br><br><br>
                <p class="fst-italic mb-0"><?= htmlspecialchars($phieu['ten_nguoi_duyet'] ?? '.......................................') ?></p>
            </div>
        </div>
    </div>

</body>

</html>