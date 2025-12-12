<?php
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
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            flex: 1 0 auto;
        }

        .footer p:last-child {
            margin-bottom: 0 !important;
        }

        .navbar .container-fluid,
        .main-content,
        .footer .container-fluid {
            max-width: 1300px;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .main-content {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }

        .banner-section {
            width: 100%;
            height: auto;
            line-height: 0;
        }

        .banner-section img {
            width: 100%;
            height: auto;
            display: block;
        }

        .bg-bee-green {
            background-color: #009688 !important;
        }

        .nav-link.active {
            background-color: #80CBC4 !important;
            color: #000000 !important;
        }

        .nav-link:hover:not(.active) {
            background-color: #B2DFDB;
            color: #000000;
        }

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
            <a class="navbar-brand text-white fw-bold me-4" href="<?= BASE_URL_HDV . '?act=dashboard' ?>">
                Xin Chào: <?= $_SESSION['user_admin']['ho_ten'] ?? 'Admin' ?>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-nowrap">
                    <li class="nav-item">
                        <a href="<?= BASE_URL_HDV . '?act=dashboard' ?>" class="nav-link <?= (empty($_GET['act']) || $_GET['act'] == 'dashboard') ? 'active' : 'text-white' ?>">
                            <i class="bi bi-speedometer2 me-1"></i> Tổng Quan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL_HDV . '?act=list-danhmuc' ?>" class="nav-link <?= ($_GET['act'] ?? '') == 'list-danhmuc' ? 'active' : 'text-white' ?>">
                            <i class="bi bi-tags me-1"></i> Danh Mục Tour
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-map me-1"></i> Quản Lý Tour
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark shadow">
                            <li><a class="dropdown-item" href="<?= BASE_URL_HDV . '?act=list-tours' ?>">Tất cả Tour</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL_HDV . '?act=list-tours&loai_tour=1' ?>">Tour Trong Nước</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL_HDV . '?act=list-tours&loai_tour=2' ?>">Tour Nước Ngoài</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL_HDV . '?act=list-tours&loai_tour=3' ?>">Tour Theo Yêu Cầu</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="<?= BASE_URL_HDV . '?act=quan-ly-booking' ?>" class="nav-link <?= (strpos($_GET['act'] ?? '', 'booking') !== false) ? 'active' : 'text-white' ?>">
                            <i class="bi bi-book me-1"></i> Quản Lý Booking
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= BASE_URL_HDV . '?act=list-nhacungcap' ?>" class="nav-link <?= ($_GET['act'] ?? '') == 'list-nhacungcap' ? 'active' : 'text-white' ?>">
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
                            <li><a class="dropdown-item" href="<?= BASE_URL_HDV . '?act=logout-hdv' ?>">Đăng Xuất</a></li>
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