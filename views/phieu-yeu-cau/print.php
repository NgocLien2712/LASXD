<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Thiết lập nền xám cho chế độ xem trên Web để làm nổi bật tờ giấy A4 */
        body { 
            background-color: #f0f2f5; 
            font-family: "Times New Roman", Times, serif; 
            margin: 0;
            padding: 0;
        }

        /* Thanh công cụ xem trước */
        .preview-toolbar {
            background: #343a40;
            padding: 10px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        /* Thiết lập khung trang A4 */
        .page-a4 {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 20mm;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            color: #000;
        }

        /* Kẻ bảng đen đậm để in ra cho rõ */
        .table-bordered th, .table-bordered td {
            border: 1px solid #000 !important;
            padding: 8px;
            font-size: 13pt;
        }

        .header-title { font-size: 16pt; font-weight: bold; }
        .info-section p { margin-bottom: 5px; font-size: 13pt; }

        /* CẤU HÌNH KHI IN THỰC TẾ */
        @media print {
            body { background: none; }
            .preview-toolbar { display: none !important; } /* Ẩn thanh công cụ khi in */
            .page-a4 {
                margin: 0;
                box-shadow: none;
                width: 100%;
                padding: 10mm; /* Giảm lề một chút khi in thực tế */
            }
            @page {
                size: A4;
                margin: 0;
            }
        }
    </style>
</head>
<body>

<div class="preview-toolbar no-print">
    <span class="text-white me-3">CHẾ ĐỘ XEM TRƯỚC PHIẾU YÊU CẦU</span>
    <button onclick="window.print()" class="btn btn-success btn-sm px-4">
        <i class="fas fa-print"></i> XÁC NHẬN IN / XUẤT PDF
    </button>
    <button onclick="window.close()" class="btn btn-outline-light btn-sm px-3">Đóng</button>
</div>

<div class="page-a4">
    <div class="row text-center mb-4">
        <div class="col-5">
            <h6 class="fw-bold mb-0">PHÒNG THÍ NGHIỆM LAS-XD</h6>
            <p class="mb-0 small">CÔNG TY KIỂM ĐỊNH XÂY DỰNG LBN</p>
            <hr class="mx-auto my-1" style="width: 50%; border-top: 1px solid #000;">
        </div>
        <div class="col-7">
            <h6 class="fw-bold mb-0">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h6>
            <p class="mb-0 fw-bold small">Độc lập - Tự do - Hạnh phúc</p>
            <p class="mb-0 small">-------------------</p>
        </div>
    </div>

    <h4 class="text-center fw-bold mb-1">PHIẾU YÊU CẦU THÍ NGHIỆM</h4>
    <p class="text-center mb-4">Số phiếu: <strong><?= htmlspecialchars($phieu['pyc_so_phieu']) ?></strong></p>

    <div class="info-section mb-4">
        <p><strong>Dự án:</strong> <?= htmlspecialchars($phieu['da_ten'] ?? '..........................................................') ?></p>
        <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($phieu['da_diachi'] ?? '..........................................................') ?></p>
        <p><strong>Ngày nhận mẫu:</strong> <?= date('d/m/Y', strtotime($phieu['pyc_ngay_nhan_mau'])) ?></p>
    </div>

    <table class="table table-bordered align-middle">
        <thead class="text-center">
            <tr>
                <th style="width: 8%;">STT</th>
                <th style="width: 35%;">Tên mẫu / Quy cách</th>
                <th style="width: 12%;">Số lượng</th>
                <th style="width: 45%;">Nội dung thí nghiệm (Tiêu chuẩn)</th>
            </tr>
        </thead>
        <tbody>
            <?php $stt = 1; foreach ($danhSachMau as $mau): ?>
            <tr>
                <td class="text-center"><?= $stt++ ?></td>
                <td>
                    <strong><?= htmlspecialchars($mau['mtn_ten']) ?></strong><br>
                    <small>KT: <?= htmlspecialchars($mau['mtn_quy_cach'] ?? '-') ?></small>
                </td>
                <td class="text-center"><?= $mau['mtn_so_luong'] ?></td>
                <td>
                    <?php if (!empty($mau['danh_sach_phep_thu'])): ?>
                        <ul class="mb-0 ps-3">
                            <?php foreach ($mau['danh_sach_phep_thu'] as $pt): ?>
                                <li><?= htmlspecialchars($pt['ten_phep_thu']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <span class="fst-italic small text-muted">Chưa chỉ định phép thử</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="row mt-5 text-center">
        <div class="col-6">
            <h6 class="fw-bold">NGƯỜI GIAO MẪU</h6>
            <p class="small fst-italic">(Ký và ghi rõ họ tên)</p>
            <br><br><br>
            <p>.......................................</p>
        </div>
        <div class="col-6">
            <h6 class="fw-bold">NGƯỜI NHẬN MẪU</h6>
            <p class="small fst-italic">(Ký và ghi rõ họ tên)</p>
            <br><br><br>
            <p>.......................................</p>
        </div>
    </div>
</div>

</body>
</html>