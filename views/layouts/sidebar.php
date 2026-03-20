<nav id="sidebar" class="overflow-auto h-100 shadow-sm">
    <ul class="list-unstyled components mt-3">
        <li class="<?= ($currentPage == 'dashboard') ? 'active' : '' ?>">
            <a href="/dashboard"><i class="fas fa-chart-pie"></i> Bảng điều khiển</a>
        </li>
        <li class="<?= ($currentPage == 'du-an') ? 'active' : '' ?>">
            <a href="/du-an"><i class="fas fa-building"></i> Quản lý Dự án</a>
        </li>
        <li class="<?= ($currentPage == 'don-vi') ? 'active' : '' ?>">
            <a href="/don-vi"><i class="fas fa-file-signature"></i> Quản lý Đơn vị</a>
        </li>
        <li class="<?= ($currentPage == 'bieu-mau') ? 'active' : '' ?>">
            <a href="/bieu-mau"><i class="fas fa-file-signature"></i> Tiêu chuẩn Thí nghiệm</a>
        </li>
        <li class="<?= ($currentPage == 'phieu-yeu-cau') ? 'active' : '' ?>">
            <a href="/phieu-yeu-cau"><i class="fas fa-flask"></i> Phiếu yêu cầu</a>
        </li>
        <li class="<?= ($currentPage == 'nhan-vien') ? 'active' : '' ?>">
            <a href="/nhan-vien"><i class="fas fa-users-cog"></i> Nhân sự & Phân quyền</a>
        </li>
    </ul>
</nav>