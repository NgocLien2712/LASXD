<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'cau-hinh'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <h3 class="mb-4 text-secondary"><i class="fas fa-cogs me-2"></i>Cấu hình Thí nghiệm</h3>
        
        <div class="row">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 border-top border-dark border-3 mb-3">
                    <div class="card-header bg-white fw-bold">1. Chọn Vật liệu</div>
                    <div class="accordion accordion-flush" id="accordionVatTu">
                        <?php $i = 0; foreach($allVatTuGrouped as $tenNhom => $danhSach): $i++; ?>
                            <?php 
                                // Tự động mở menu nếu vật liệu đang chọn nằm trong nhóm này
                                $isExpanded = false;
                                foreach($danhSach as $item) {
                                    if(isset($vattu) && $vattu['cl_ma'] == $item['cl_ma']) {
                                        $isExpanded = true; break;
                                    }
                                }
                            ?>
                            <div class="accordion-item border-bottom">
                                <h2 class="accordion-header" id="heading-<?= $i ?>">
                                    <button class="accordion-button <?= $isExpanded ? '' : 'collapsed' ?> py-2 fw-bold bg-light" 
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $i ?>">
                                        <i class="fas fa-folder text-warning me-2"></i> <?= htmlspecialchars($tenNhom) ?>
                                    </button>
                                </h2>
                                <div id="collapse-<?= $i ?>" 
                                     class="accordion-collapse collapse <?= $isExpanded ? 'show' : '' ?>" 
                                     data-bs-parent="#accordionVatTu">
                                    <div class="list-group list-group-flush">
                                        <?php foreach($danhSach as $v): ?>
                                            <a href="/cau-hinh?cl_ma=<?= $v['cl_ma'] ?>" 
                                               class="list-group-item list-group-item-action ps-4 <?= (isset($vattu['cl_ma']) && $vattu['cl_ma'] == $v['cl_ma']) ? 'active fw-bold' : '' ?>">
                                                <i class="fas fa-angle-right me-1 small"></i> <?= htmlspecialchars($v['cl_ten']) ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <?php if(!$vattu): ?>
                    <div class="alert alert-secondary shadow-sm">
                        <i class="fas fa-hand-point-left me-2"></i> Vui lòng chọn một loại vật liệu bên trái.
                    </div>
                <?php else: ?>
                    
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-header bg-white fw-bold text-primary">2. Chọn Phép thử của: <?= htmlspecialchars($vattu['cl_ten']) ?></div>
                        <div class="card-body py-2">
                            <ul class="nav nav-pills">
                                <?php foreach($phepThuList as $pt): ?>
                                    <li class="nav-item me-2 mb-2">
                                        <a class="nav-link border <?= ($pt_ma == $pt['pt_ma']) ? 'active' : 'text-dark' ?>" 
                                           href="/cau-hinh?cl_ma=<?= $vattu['cl_ma'] ?>&pt_ma=<?= $pt['pt_ma'] ?>">
                                            <?= htmlspecialchars($pt['pt_ten']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                <li class="nav-item mb-2">
                                    <a class="nav-link btn btn-outline-success <?= ($pt_ma == 'new') ? 'active text-white' : '' ?>" 
                                       href="/cau-hinh?cl_ma=<?= $vattu['cl_ma'] ?>&pt_ma=new">
                                        <i class="fas fa-plus"></i> Thêm phép thử mới
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <?php if($pt_ma): ?>
                    <form action="/cau-hinh/save" method="POST" class="card shadow-sm border-0 border-top border-primary border-3">
                        <input type="hidden" name="cl_ma" value="<?= $vattu['cl_ma'] ?>">
                        <input type="hidden" name="pt_ma" value="<?= $pt_ma ?>">
                        
                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                            <div class="flex-grow-1 me-3">
                                <label class="fw-bold small text-muted">Tên Phép thử (Chỉ tiêu):</label>
                                <input type="text" name="pt_ten" class="form-control form-control-lg fw-bold text-primary" 
                                       placeholder="Ví dụ: Thử cường độ nén" value="<?= htmlspecialchars($currentPhepThu['pt_ten'] ?? '') ?>" required>
                            </div>
                            <?php if($pt_ma !== 'new'): ?>
                                <a href="/cau-hinh/delete-test?cl_ma=<?= $vattu['cl_ma'] ?>&pt_ma=<?= $pt_ma ?>" 
                                   class="btn btn-outline-danger btn-sm mt-4" onclick="return confirm('Bạn có chắc chắn muốn xóa phép thử này? Toàn bộ cấu hình của nó sẽ mất.')">
                                    <i class="fas fa-trash"></i> Xóa phép thử
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-dark mb-0">Các trường dữ liệu cần nhập:</h6>
                                <button type="button" class="btn btn-primary btn-sm" onclick="addField()"><i class="fas fa-plus me-1"></i> Thêm trường</button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" id="table-fields">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Tên hiển thị (VD: Cạnh a)</th>
                                            <th>Biến (VD: a)</th>
                                            <th>Kiểu dữ liệu</th>
                                            <th>Giá trị mặc định</th>
                                            <th style="width: 50px;">Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($fields)): ?>
                                            <?php foreach($fields as $f): ?>
                                            <tr>
                                                <td><input type="text" name="cht_ten_hien_thi[]" class="form-control" value="<?= htmlspecialchars($f['cht_ten_hien_thi']) ?>" required></td>
                                                <td><input type="text" name="cht_ten_bien[]" class="form-control text-center text-danger fw-bold" value="<?= htmlspecialchars($f['cht_ten_bien']) ?>" required></td>
                                                <td>
                                                    <select name="cht_kieu_du_lieu[]" class="form-select">
                                                        <option value="number" <?= $f['cht_kieu_du_lieu']=='number'?'selected':'' ?>>Số</option>
                                                        <option value="text" <?= $f['cht_kieu_du_lieu']=='text'?'selected':'' ?>>Chữ</option>
                                                        <option value="date" <?= $f['cht_kieu_du_lieu']=='date'?'selected':'' ?>>Ngày</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="cht_mac_dinh[]" class="form-control" value="<?= htmlspecialchars($f['cht_mac_dinh'] ?? '') ?>" placeholder="(tùy chọn)"></td>
                                                <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="mt-4 fw-bold text-dark">Công thức tính & Đơn vị:</h6>
                            <div class="row g-2 mb-2">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light fw-bold text-success">Kết quả = </span>
                                        <input type="text" name="pt_cong_thuc" class="form-control font-monospace text-primary" 
                                               placeholder="Ví dụ: (P * 1000) / (a * b)" value="<?= htmlspecialchars($currentPhepThu['pt_cong_thuc'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light fw-bold">Đơn vị</span>
                                        <input type="text" name="pt_don_vi" class="form-control text-center fw-bold text-danger" 
                                               placeholder="VD: MPa" value="<?= htmlspecialchars($currentPhepThu['pt_don_vi'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-end py-3">
                            <button type="submit" class="btn btn-success px-5"><i class="fas fa-save me-2"></i>Lưu cấu hình</button>
                        </div>
                    </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</div>

<script>
function addField() {
    const row = `<tr>
        <td><input type="text" name="cht_ten_hien_thi[]" class="form-control" placeholder="Tên hiện lên form" required></td>
        <td><input type="text" name="cht_ten_bien[]" class="form-control text-center text-danger fw-bold" placeholder="Ví dụ: P" required></td>
        <td>
            <select name="cht_kieu_du_lieu[]" class="form-select">
                <option value="number">Số</option>
                <option value="text">Chữ</option>
                <option value="date">Ngày</option>
            </select>
        </td>
        <td><input type="text" name="cht_mac_dinh[]" class="form-control" placeholder="Tùy chọn"></td>
        <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button></td>
    </tr>`;
    document.querySelector('#table-fields tbody').insertAdjacentHTML('beforeend', row);
}
</script>