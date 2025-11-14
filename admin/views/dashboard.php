<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard (Tổng quan)</h1>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Quản lý Tour</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Danh sách</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-suitcase-rolling fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="?act=list-tours" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Danh mục Tour</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Quản lý</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="?act=list-danhmuc" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Khách hàng / Admin</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Tài khoản</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="?act=list-tai-khoan" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Đơn đặt Tour</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Đang cập nhật...</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Chào mừng trở lại!</h6>
                </div>
                <div class="card-body">
                    <p>Xin chào <strong>
                            <?= isset($_SESSION['user_admin']) ? $_SESSION['user_admin']['TenDangNhap'] : 'Admin' ?>
                        </strong>,</p>
                    <p>Chào mừng bạn đến với hệ thống quản lý Tour du lịch <b>Bee Green</b>. Bạn có thể sử dụng menu bên trái hoặc các thẻ bên trên để bắt đầu quản lý hệ thống.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Các Tour Mới Nhất ✨</h6>
                    <a href="?act=list-tours" class="btn btn-sm btn-outline-primary shadow-sm">
                        <i class="fas fa-list fa-sm text-primary-50"></i> Xem tất cả
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php
                    // *********************************************************
                    // CHÚ THÍCH: BIẾN $listRecentTours PHẢI CHỨA DỮ LIỆU ĐỒNG BỘ
                    // *********************************************************

                    // GIẢ ĐỊNH DỮ LIỆU MẪU (Sử dụng cấu trúc đồng bộ)
                    $listRecentTours = [
                        ['ID_Tour' => 'T-9876', 'TenTour' => 'Hạ Long - Cát Bà 3N2Đ', 'GiaNguoiLon' => 2500000, 'NgayKhoiHanh' => '2025-12-01', 'TrangThai' => 1],
                        ['ID_Tour' => 'T-9875', 'TenTour' => 'Đà Lạt Mộng Mơ 3N2Đ', 'GiaNguoiLon' => 3800000, 'NgayKhoiHanh' => '2025-11-20', 'TrangThai' => 1],
                        ['ID_Tour' => 'T-9011', 'TenTour' => 'Tour Nước Ngoài', 'GiaNguoiLon' => 1, 'NgayKhoiHanh' => '2025-11-14', 'TrangThai' => 0],
                    ];
                    ?>

                    <?php if (!empty($listRecentTours)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light text-center">
                                    <tr class="text-xs font-weight-bold text-uppercase">
                                        <th scope="col">ID</th>
                                        <th scope="col">Tên Tour</th>
                                        <th scope="col">Giá (Lớn)</th>
                                        <th scope="col">Khởi Hành</th>
                                        <th scope="col">Trạng Thái</th>
                                        <th scope="col">Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listRecentTours as $tour): ?>
                                        <tr>
                                            <td class="text-center"><?= $tour['ID_Tour']; ?></td>
                                            <td><?= htmlspecialchars($tour['TenTour']); ?></td>
                                            <td><?= number_format($tour['GiaNguoiLon']); ?>₫</td>
                                            <td><?= htmlspecialchars($tour['NgayKhoiHanh']); ?></td>
                                            <td class="text-center">
                                                <?php if ($tour['TrangThai'] == 1): ?>
                                                    <span class="badge bg-success">Hoạt động</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Tạm dừng</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="?act=edit-tour&id=<?= $tour['ID_Tour']; ?>" class="btn btn-info btn-sm">Sửa</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="p-4 text-center text-muted mb-0">Chưa có tour nào được thêm gần đây.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>