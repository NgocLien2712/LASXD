<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Nhập số liệu') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .table-tho th, .table-tho td { vertical-align: middle; text-align: center; }
        .table-tho th { background-color: #e9ecef !important; }
        .input-tho { border: 1px solid #ced4da; border-radius: 4px; padding: 6px 10px; width: 100%; text-align: center; }
        .input-tho:focus { border-color: #0d6efd; outline: 0; box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25); }
        .readonly-input { background-color: #e9ecef; cursor: not-allowed; font-weight: bold; }
        .row-ket-qua td { background-color: #fff3cd !important; }
    </style>
</head>
<body>

    <div class="container-fluid py-4 px-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">NHẬP SỐ LIỆU ĐO ĐẠC THÍ NGHIỆM</h5>
                <a href="/ket-qua" class="btn btn-sm btn-light">Quay lại danh sách</a>
            </div>
            
            <div class="card-body">
                <div class="row mb-4 bg-light p-3 rounded border">
                    <div class="col-md-6">
                        <p class="mb-1">Mã phiếu YC: <strong class="text-danger"><?= htmlspecialchars($phieu['pyc_so_phieu'] ?? 'Không xác định / Chưa có pyc_ma trên URL') ?></strong></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1">Dự án/Công trình: <strong><?= htmlspecialchars($phieu['da_ten'] ?? '........................') ?></strong></p>
                    </div>
                </div>

                <form action="/ket-qua/luu" method="POST">
                    <input type="hidden" name="pyc_ma" value="<?= htmlspecialchars($phieu['pyc_ma'] ?? '') ?>">

                    <?php if (!empty($danhSachMau)): ?>
                        <?php foreach ($danhSachMau as $index => $mau): ?>
                            <div class="border rounded p-3 mb-4 border-primary">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="fa-solid fa-vial"></i> Thông tin: <?= htmlspecialchars($mau['mtn_ten'] ?? 'Chưa rõ') ?> 
                                    <span class="badge bg-secondary">Số lượng: <?= htmlspecialchars($mau['mtn_so_luong'] ?? 0) ?></span>
                                </h6>

                                <?php $soLuongMau = (int)($mau['mtn_so_luong'] ?? 3); ?>

                                <?php if (!empty($mau['danh_sach_phep_thu'])): ?>
                                    <?php foreach ($mau['danh_sach_phep_thu'] as $pt): ?>
                                        <div class="mb-2">
                                            <span class="fw-bold text-success">Phép thử: <?= htmlspecialchars($pt['ten_phep_thu'] ?? '') ?></span>
                                            <?php if(empty($pt['danh_sach_truong'])): ?>
                                                <span class="text-danger fst-italic ms-3">(Chưa cấu hình trường đo đạc/biến số cho phép thử này)</span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <table class="table table-bordered table-tho mb-4 phep-thu-table" data-cong-thuc="<?= htmlspecialchars($pt['pt_cong_thuc'] ?? '') ?>">
                                            <thead>
                                                <tr>
                                                    <th width="5%">TT</th>
                                                    <th width="15%">Ký hiệu mẫu</th>
                                                    
                                                    <?php if (!empty($pt['danh_sach_truong'])): ?>
                                                        <?php foreach ($pt['danh_sach_truong'] as $truong): ?>
                                                            <th>
                                                                <?= htmlspecialchars($truong['cht_ten_hien_thi']) ?><br>
                                                                <small class="text-muted">(<?= htmlspecialchars($truong['cht_ten_bien']) ?>)</small>
                                                            </th>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    
                                                    <th width="20%">Kết quả ( <?= htmlspecialchars($pt['pt_don_vi'] ?? '') ?> )</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($pt['danh_sach_truong'])): ?>
                                                    <?php $soCotDaiLuong = count($pt['danh_sach_truong']); ?>
                                                    
                                                    <?php for ($v = 1; $v <= $soLuongMau; $v++): ?>
                                                        <tr class="mau-row">
                                                            <td><?= $v ?></td>
                                                            <td class="fw-bold">Mẫu <?= $v ?></td>
                                                            
                                                            <?php foreach ($pt['danh_sach_truong'] as $truong): ?>
                                                                <td>
                                                                    <input type="number" step="any" class="input-tho var-input" data-var="<?= htmlspecialchars($truong['cht_ten_bien']) ?>" required
                                                                           name="du_lieu[<?= $mau['mtn_ma'] ?>][<?= $pt['pt_ma'] ?>][<?= $v ?>][<?= $truong['cht_ten_bien'] ?>]">
                                                                </td>
                                                            <?php endforeach; ?>
                                                            
                                                            <td>
                                                                <input type="text" class="input-tho readonly-input kq-mau text-primary" readonly tabindex="-1">
                                                            </td>
                                                        </tr>
                                                    <?php endfor; ?>
                                                    
                                                    <tr class="row-ket-qua">
                                                        <td colspan="2" class="fw-bold text-danger text-end pe-3">TRUNG BÌNH MẪU:</td>
                                                        <td colspan="<?= $soCotDaiLuong ?>"></td>
                                                        <td>
                                                            <input type="text" class="input-tho readonly-input text-danger fw-bold kq-tong" readonly 
                                                                   name="ket_qua_cuoi[<?= $mau['mtn_ma'] ?>][<?= $pt['pt_ma'] ?>]">
                                                        </td>
                                                    </tr>
                                                <?php else: ?>
                                                    <tr><td colspan="4" class="text-center text-muted">Vui lòng thêm cấu hình trường cho phép thử trong CSDL.</td></tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="alert alert-warning py-2 mb-0">Mẫu này chưa được chỉ định phép thử nào. (Kiểm tra bảng chi_dinh_phep_thu)</div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-5"><i class="fas fa-save me-2"></i> LƯU TẤT CẢ DỮ LIỆU</button>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger text-center">
                            <h5>Không có mẫu nào trong phiếu này.</h5>
                            <p class="mb-0">Bạn vui lòng kiểm tra lại URL (đã có ?pyc_ma= chưa) hoặc kiểm tra dữ liệu trong bảng <strong>mau_thi_nghiem</strong>.</p>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('input', '.var-input', function() {
                let $table = $(this).closest('.phep-thu-table');
                let congThucGoc = $table.attr('data-cong-thuc');
                
                if (!congThucGoc) return;

                let tongKqCacMau = 0;
                let soMauDaNhapHopLe = 0;

                $table.find('.mau-row').each(function() {
                    let $row = $(this);
                    let congThucToan = congThucGoc;
                    let duLieuDayDu = true;

                    $row.find('.var-input').each(function() {
                        let tenBien = $(this).attr('data-var');
                        let giaTri = $(this).val();

                        if (giaTri === '') {
                            duLieuDayDu = false;
                        } else {
                            let regex = new RegExp('\\b' + tenBien + '\\b', 'g');
                            congThucToan = congThucToan.replace(regex, giaTri);
                        }
                    });

                    if (duLieuDayDu) {
                        try {
                            let kqMau = eval(congThucToan);
                            $row.find('.kq-mau').val(kqMau.toFixed(2));
                            tongKqCacMau += kqMau;
                            soMauDaNhapHopLe++;
                        } catch (e) {
                            $row.find('.kq-mau').val('Lỗi CT');
                        }
                    } else {
                        $row.find('.kq-mau').val('');
                    }
                });

                if (soMauDaNhapHopLe > 0) {
                    let kqTrungBinh = tongKqCacMau / soMauDaNhapHopLe;
                    $table.find('.kq-tong').val(kqTrungBinh.toFixed(2));
                } else {
                    $table.find('.kq-tong').val('');
                }
            });
        });
    </script>
</body>
</html>