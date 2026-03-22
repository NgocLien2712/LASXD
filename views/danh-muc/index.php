<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $currentPage = 'danh-muc'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    <div class="p-4 flex-grow-1 overflow-auto">
        <h3 class="mb-4 text-secondary"><i class="fas fa-list me-2"></i>Quản lý Danh mục Vật liệu</h3>
        
        <div class="row">
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0 border-top border-warning border-3 mb-3">
                    <div class="card-header bg-white fw-bold">1. Thêm Nhóm Vật Liệu (Thư mục)</div>
                    <div class="card-body">
                        <form action="/danh-muc/nhom/save" method="POST">
                            <div class="input-group">
                                <input type="text" name="nvl_ten" class="form-control" placeholder="VD: Bê tông, Cát, Đá..." required>
                                <button type="submit" class="btn btn-warning fw-bold text-dark"><i class="fas fa-plus"></i> Thêm</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
                            <div class="input-group input-group-sm w-75">
                                <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" id="searchNhom" class="form-control" placeholder="Lọc theo tên nhóm..." onkeyup="filterTable('searchNhom', 'tableNhom', 1)">
                            </div>
                            <button class="btn btn-sm btn-outline-secondary w-25" onclick="sortTable('tableNhom', 1)"><i class="fas fa-sort me-1"></i> Sắp xếp</button>
                        </div>

                        <table class="table table-hover table-bordered mb-0 align-middle" id="tableNhom">
                            <thead class="table-light">
                                <tr>
                                    <th width="60" class="text-center">Mã</th>
                                    <th>Tên nhóm vật liệu</th>
                                    <th width="100" class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($nhomList)): ?>
                                    <?php foreach($nhomList as $n): ?>
                                        <tr>
                                            <td class="text-center"><?= $n['nvl_ma'] ?></td>
                                            <td class="fw-bold text-warning-emphasis"><i class="fas fa-folder text-warning me-2"></i><?= htmlspecialchars($n['nvl_ten']) ?></td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button class="btn btn-sm btn-outline-primary py-0 px-2" title="Sửa" onclick="editNhom(<?= $n['nvl_ma'] ?>, '<?= htmlspecialchars($n['nvl_ten'], ENT_QUOTES) ?>')"><i class="fas fa-edit"></i></button>
                                                    <a href="/danh-muc/nhom/delete?id=<?= $n['nvl_ma'] ?>" class="btn btn-sm btn-outline-danger py-0 px-2" title="Xóa" onclick="return confirm('Xóa nhóm này? Các vật liệu bên trong sẽ chuyển thành Chưa phân nhóm.');"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center text-muted">Chưa có nhóm nào</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-7 mb-4">
                <div class="card shadow-sm border-0 border-top border-primary border-3 mb-3">
                    <div class="card-header bg-white fw-bold">2. Thêm Vật Liệu (Chủng loại)</div>
                    <div class="card-body">
                        <form action="/danh-muc/vat-lieu/save" method="POST">
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <label class="form-label small text-muted fw-bold">Thuộc nhóm:</label>
                                    <select name="nvl_ma" class="form-select">
                                        <option value="">-- Chưa phân nhóm --</option>
                                        <?php foreach($nhomList as $n): ?>
                                            <option value="<?= $n['nvl_ma'] ?>"><?= htmlspecialchars($n['nvl_ten']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small text-muted fw-bold">Tên vật liệu:</label>
                                    <input type="text" name="cl_ten" class="form-control" placeholder="VD: Đá 1x2, Cát san lấp..." required>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="fas fa-save"></i> Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-3 table-responsive">
                         <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
                            <div class="input-group input-group-sm w-50">
                                <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" id="searchVatLieu" class="form-control" placeholder="Lọc theo tên vật liệu..." onkeyup="filterTable('searchVatLieu', 'tableVatLieu', 1)">
                            </div>
                            <button class="btn btn-sm btn-outline-secondary" onclick="sortTable('tableVatLieu', 1)"><i class="fas fa-sort me-1"></i> Sắp xếp A-Z</button>
                        </div>

                        <table class="table table-hover table-bordered mb-0 align-middle" id="tableVatLieu">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="text-center">Mã</th>
                                    <th>Tên vật liệu</th>
                                    <th>Thuộc nhóm</th>
                                    <th width="100" class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($vatLieuList)): ?>
                                    <?php foreach($vatLieuList as $v): ?>
                                        <tr>
                                            <td class="text-center"><?= $v['cl_ma'] ?></td>
                                            <td class="fw-bold"><?= htmlspecialchars($v['cl_ten']) ?></td>
                                            <td>
                                                <?php if($v['ten_nhom'] === 'Chưa phân nhóm'): ?>
                                                    <span class="badge bg-secondary">Chưa phân nhóm</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark"><i class="fas fa-folder me-1"></i><?= htmlspecialchars($v['ten_nhom']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button class="btn btn-sm btn-outline-primary py-0 px-2" title="Sửa" onclick="editVatLieu(<?= $v['cl_ma'] ?>, '<?= htmlspecialchars($v['cl_ten'], ENT_QUOTES) ?>', '<?= $v['nvl_ma'] ?>')"><i class="fas fa-edit"></i></button>
                                                    <a href="/danh-muc/vat-lieu/delete?id=<?= $v['cl_ma'] ?>" class="btn btn-sm btn-outline-danger py-0 px-2" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa vật liệu này? Mọi cấu hình liên quan cũng sẽ bị xóa!');"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center text-muted">Chưa có vật liệu nào</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</div>

<div class="modal fade" id="modalEditNhom" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/danh-muc/nhom/update" method="POST">
        <div class="modal-header bg-warning">
          <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit me-2"></i>Sửa Nhóm Vật Liệu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="nvl_ma" id="edit_nvl_ma">
          <div class="mb-3">
              <label class="form-label fw-bold">Tên nhóm:</label>
              <input type="text" name="nvl_ten" id="edit_nvl_ten" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-warning fw-bold text-dark"><i class="fas fa-save me-1"></i> Cập nhật</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditVatLieu" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/danh-muc/vat-lieu/update" method="POST">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Sửa Vật Liệu</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="cl_ma" id="edit_cl_ma">
          <div class="mb-3">
              <label class="form-label fw-bold">Thuộc nhóm:</label>
              <select name="nvl_ma" id="edit_cl_nvl_ma" class="form-select">
                  <option value="">-- Chưa phân nhóm --</option>
                  <?php foreach($nhomList as $n): ?>
                      <option value="<?= $n['nvl_ma'] ?>"><?= htmlspecialchars($n['nvl_ten']) ?></option>
                  <?php endforeach; ?>
              </select>
          </div>
          <div class="mb-3">
              <label class="form-label fw-bold">Tên vật liệu:</label>
              <input type="text" name="cl_ten" id="edit_cl_ten" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary fw-bold"><i class="fas fa-save me-1"></i> Cập nhật</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// ---- KÍCH HOẠT POPUP SỬA ----
function editNhom(id, ten) {
    document.getElementById('edit_nvl_ma').value = id;
    document.getElementById('edit_nvl_ten').value = ten;
    var modal = new bootstrap.Modal(document.getElementById('modalEditNhom'));
    modal.show();
}

function editVatLieu(id, ten, idNhom) {
    document.getElementById('edit_cl_ma').value = id;
    document.getElementById('edit_cl_ten').value = ten;
    document.getElementById('edit_cl_nvl_ma').value = idNhom ? idNhom : "";
    var modal = new bootstrap.Modal(document.getElementById('modalEditVatLieu'));
    modal.show();
}

// ---- LOGIC LỌC VÀ SẮP XẾP ----
function filterTable(inputId, tableId, colIndex) {
    let input = document.getElementById(inputId);
    let filter = input.value.toUpperCase();
    let table = document.getElementById(tableId);
    let tr = table.getElementsByTagName("tr");
    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName("td")[colIndex];
        if (td) {
            let txtValue = td.textContent || td.innerText;
            tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }       
    }
}

function sortTable(tableId, colIndex) {
    let table = document.getElementById(tableId), rows, switching = true, i, x, y, shouldSwitch, dir = "asc", switchcount = 0;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[colIndex];
            y = rows[i + 1].getElementsByTagName("TD")[colIndex];
            if (dir == "asc") { 
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) { shouldSwitch = true; break; } 
            } else if (dir == "desc") { 
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) { shouldSwitch = true; break; } 
            }
        }
        if (shouldSwitch) { 
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]); 
            switching = true; 
            switchcount ++; 
        } else { 
            if (switchcount == 0 && dir == "asc") { dir = "desc"; switching = true; } 
        }
    }
}
</script>