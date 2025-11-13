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

</div>