<?php
// header.php (Đã áp dụng giới hạn chiều rộng, khắc phục lỗi Footer, và thêm BANNER)
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bee Green</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* THÊM CSS NÀY ĐỂ KHẮC PHỤC LỖI KHOẢNG TRẮNG DƯỚI FOOTER */
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            /* Đảm bảo html và body có chiều cao tối thiểu 100% */
        }

        body {
            display: flex;
            flex-direction: column;
            /* Thiết lập body như một Flex Container dọc */
        }

        /* Đảm bảo nội dung chính (wrapper) chiếm hết không gian còn lại */
        .wrapper {
            flex: 1 0 auto;
            /* flex: 1 (co giãn), 0 (không co lại), auto (dựa trên nội dung) */
        }

        /* Xóa Margin-Bottom của phần tử cuối cùng trong footer (rất quan trọng) */
        .footer p:last-child {
            margin-bottom: 0 !important;
        }

        /* Custom CSS để tạo hiệu ứng margin 150px ở hai bên trên màn hình lớn */
        /* CSS này sẽ giới hạn nội dung Navbar, Footer và Main-Content ở 1300px và căn giữa */
        .navbar .container-fluid,
        .main-content,
        .footer .container-fluid {
            max-width: 1300px;
            /* Chiều rộng tối đa cho nội dung */
            margin-left: auto !important;
            margin-right: auto !important;
        }

        /* Đảm bảo padding mặc định cho nội dung chính */
        .main-content {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }

        /* CSS cho Banner - ĐÃ ĐIỀU CHỈNH ĐỂ HIỂN THỊ THẺ <img> */
        .banner-section {
            width: 100%;
            /* Bỏ background-image, background-size, v.v. cũ đi */
            /* Đảm bảo thẻ <img> lấp đầy div */
            height: auto;
            /* Chiều cao tự động theo ảnh */
            line-height: 0;
            /* Loại bỏ khoảng trắng dưới ảnh */
        }

        .banner-section img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* TÙY CHỈNH MÀU SẮC ĐỒNG BỘ (BEE GREEN EMERALD THEME) */

        /* 1. Màu nền Xanh Lá Chủ Đạo (Emerald Dark) cho Navbar và Footer */
        .bg-bee-green {
            background-color: #009688 !important;
        }

        /* 2. Màu nền cho Liên kết Hoạt động (.active) - Màu Mint Pale */
        .nav-link.active {
            background-color: #80CBC4 !important;
            color: #000000 !important;
        }

        /* 3. Màu hover cho các liên kết (Teal Light) */
        .nav-link:hover:not(.active) {
            background-color: #B2DFDB;
            color: #000000;
        }

        /* 4. Điều chỉnh Dropdown */
        .dropdown-menu-dark {
            background-color: #009688;
        }

        .dropdown-menu-dark .dropdown-item:hover {
            background-color: #80CBC4;
            color: #000000 !important;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-bee-green shadow">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold me-4" href="<?= BASE_URL_ADMIN . '?act=dashboard' ?>">
                Xin Chào: <?= $_SESSION['user_admin']['ho_ten'] ?? 'Admin' ?>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-nowrap">
                    <li class="nav-item">
                        <a href="<?= BASE_URL_ADMIN . '?act=dashboard' ?>" class="nav-link <?= (empty($_GET['act']) || $_GET['act'] == 'dashboard') ? 'active' : 'text-white' ?>">
                            <i class="bi bi-speedometer2 me-1"></i> Tổng Quan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL_ADMIN . '?act=list-danhmuc' ?>" class="nav-link <?= ($_GET['act'] ?? '') == 'list-danhmuc' ? 'active' : 'text-white' ?>">
                            <i class="bi bi-tags me-1"></i> Danh Mục Tour
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-map me-1"></i> Quản Lý Tour
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark shadow">
                            <li><a class="dropdown-item" href="<?= BASE_URL_ADMIN . '?act=list-tours' ?>">Tất cả Tour</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL_ADMIN . '?act=list-tours&loai_tour=1' ?>">Tour Trong Nước</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL_ADMIN . '?act=list-tours&loai_tour=2' ?>">Tour Nước Ngoài</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL_ADMIN . '?act=list-tours&loai_tour=3' ?>">Tour Theo Yêu Cầu</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="<?= BASE_URL_ADMIN . '?act=quan-ly-booking' ?>" class="nav-link <?= (strpos($_GET['act'] ?? '', 'booking') !== false) ? 'active' : 'text-white' ?>">
                            <i class="bi bi-book me-1"></i> Quản Lý Booking
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL_ADMIN . '?act=list-tai-khoan' ?>" class="nav-link <?= ($_GET['act'] ?? '') == 'list-tai-khoan' ? 'active' : 'text-white' ?>">
                            <i class="bi bi-people me-1"></i> Tài Khoản
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL_ADMIN . '?act=list-nhacungcap' ?>" class="nav-link <?= ($_GET['act'] ?? '') == 'list-nhacungcap' ? 'active' : 'text-white' ?>">
                            <i class="bi bi-truck me-1"></i> Nhà Cung Cấp
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> Tài khoản
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark shadow">
                            <li><a class="dropdown-item" href="#">Cài Đặt</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= BASE_URL_ADMIN . '?act=logout-admin' ?>">Đăng Xuất</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="banner-section">
        <img src="./assets/banner.png" alt="Bee Green - Khám Phá Thế Giới" class="img-fluid">
    </div>

    <div class="wrapper">
        <main class="main-content p-4">