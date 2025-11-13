<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* CSS tối thiểu để giữ sidebar cố định */
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .wrapper {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            flex-shrink: 0;
            background-color: #212529;
            /* Màu bg-dark */
        }

        .main-content {
            flex-grow: 1;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <nav class="sidebar d-flex flex-column p-3 text-white">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Xin Chào: <strong><?= $_SESSION['user_admin']['ho_ten'] ?></strong></span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="<?= BASE_URL_ADMIN . '?act=dashboard'  ?>" class="nav-link active" aria-current="page">
                        <i class="bi bi-speedometer2 me-2"></i> Tổng Quan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL_ADMIN . '?act=list-danhmuc' ?>" class="nav-link text-white" aria-current="page">
                        <i class="bi bi-speedometer2 me-2"></i> Danh Mục Tour
                    </a>
                </li>
                <ul class="nav nav-pills flex-column mb-auto">

                    <li class="nav-item">
                        <a href="#tourSubMenu" data-bs-toggle="collapse" class="nav-link text-white" aria-expanded="false">
                            <i class="bi bi-map me-2"></i> Quản Lý Tour
                            <i class="bi bi-chevron-down ms-auto float-end" style="font-size: 0.8rem;"></i>
                        </a>

                        <div class="collapse" id="tourSubMenu">
                            <ul class="nav nav-pills flex-column">

                                <li class="nav-item">
                                    <a href="<?= BASE_URL_ADMIN . '?act=list-tours' ?>" class="nav-link text-white ps-4">
                                        <i class="bi bi-dot me-2"></i> Tour Trong Nước
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= BASE_URL_ADMIN . '?act=tour-trong-nuoc' ?>" class="nav-link text-white ps-4">
                                        <i class="bi bi-dot me-2"></i> Tour Trong Nước
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= BASE_URL_ADMIN . '?act=tour-nuoc-ngoai' ?>" class="nav-link text-white ps-4">
                                        <i class="bi bi-dot me-2"></i> Tour Nước Ngoài
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= BASE_URL_ADMIN . '?act=tour-nuoc-ngoai' ?>" class="nav-link text-white ps-4">
                                        <i class="bi bi-dot me-2"></i> Tour Theo Yêu Cầu
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                </ul>
                <li>
                    <a href="<?= BASE_URL_ADMIN . '?act=quan-ly-booking'  ?>" class="nav-link text-white">
                        <i class="bi bi-book me-2"></i> Quản Lý Booking
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL_ADMIN . '?act=list-nhansu'  ?>" class="nav-link text-white">
                        <i class="bi bi-people me-2"></i> Nhân Sự
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2"></i>

                    Xin Chào: <strong><?= $_SESSION['user_admin']['ho_ten'] ?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#">Cài Đặt</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="<?= BASE_URL_ADMIN . '?act=logout-admin' ?>">Đăng Xuất</a></li>
                </ul>
            </div>
        </nav>

        <main class="main-content p-4"></main>