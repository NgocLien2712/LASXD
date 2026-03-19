<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php 
    $currentPage = 'dashboard'; 
    include __DIR__ . '/../layouts/sidebar.php'; 
?>

<div class="content-right flex-grow-1 bg-light d-flex flex-column overflow-hidden">
    
    <div class="p-4 flex-grow-1 overflow-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fas fa-home me-2"></i>Tổng quan hoạt động</h3>
            <button class="btn btn-primary shadow-sm"><i class="fas fa-plus me-1"></i> Tạo phiếu mới</button>
        </div>
        
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-primary text-white p-3 rounded-3 h-100">
                    <div class="d-flex justify-content-between">
                        <div><p class="mb-1 opacity-75">Dự án/Công trình</p><h2 class="mb-0">12</h2></div>
                        <i class="fas fa-city fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-success text-white p-3 rounded-3 h-100">
                    <div class="d-flex justify-content-between">
                        <div><p class="mb-1 opacity-75">Phiếu yêu cầu mới</p><h2 class="mb-0">28</h2></div>
                        <i class="fas fa-file-contract fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-warning text-white p-3 rounded-3 h-100">
                    <div class="d-flex justify-content-between">
                        <div><p class="mb-1 opacity-75">Mẫu chờ thí nghiệm</p><h2 class="mb-0">45</h2></div>
                        <i class="fas fa-vial fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-info text-white p-3 rounded-3 h-100">
                    <div class="d-flex justify-content-between">
                        <div><p class="mb-1 opacity-75">Nhân viên trực</p><h2 class="mb-0">08</h2></div>
                        <i class="fas fa-hard-hat fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 shadow-sm rounded-3 border-top border-primary border-3">
            <h5 class="mb-3 text-secondary">Hoạt động thí nghiệm gần đây</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Mã Phiếu</th><th>Dự án</th><th>Phép thử</th><th>Người thực hiện</th><th>Trạng thái</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>PYC-001</strong></td>
                            <td>Cầu Mỹ Thuận 2</td>
                            <td>Nén Bê Tông R28</td>
                            <td><img src="https://ui-avatars.com/api/?name=Thử&background=random" class="rounded-circle me-2" width="25">Lê Văn Thử</td>
                            <td><span class="badge bg-success rounded-pill px-3">Hoàn thành</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <?php include __DIR__ . '/../layouts/footer.php'; ?>