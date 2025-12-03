<?php

$pageTitle = $pageTitle ?? 'Bee Green - Du lịch Xanh';
$currentPage = $currentPage ?? 'home';

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css">

    <style>
        :root {
            --bee-green-primary: #4CAF50;
            /* Xanh lá chính */
            --bee-green-dark: #2E7D32;
            /* Xanh lá đậm */
            --bee-green-light: #E8F5E9;
            /* Xanh lá nhạt */
            --text-color-dark: #333;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        /* Tùy chỉnh Header Bootstrap */
        .navbar-bee-green {
            background-color: #ffffff !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Bóng đổ Traveloka */
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo-section img {
            height: 40px;
        }

        .logo-section .navbar-brand {
            color: var(--bee-green-dark) !important;
            font-size: 24px;
            font-weight: 700;
        }

        /* Tùy chỉnh Nav Link */
        .navbar-nav .nav-link {
            color: var(--text-color-dark) !important;
            font-weight: 500;
            padding: 8px 15px;
            margin: 0 5px;
        }

        .navbar-nav .nav-link:hover {
            color: var(--bee-green-primary) !important;
        }

        .navbar-nav .nav-link.active {
            border-bottom: 3px solid var(--bee-green-primary);
            color: var(--bee-green-primary) !important;
        }

        /* Tùy chỉnh nút Đăng nhập/Đăng ký */
        .btn-login {
            border: 1px solid var(--bee-green-primary);
            color: var(--bee-green-primary) !important;
            background-color: transparent;
            font-weight: 500;
        }

        .btn-login:hover {
            background-color: var(--bee-green-light);
        }

        .btn-register {
            background-color: var(--bee-green-primary);
            color: white !important;
            font-weight: 500;
        }

        .btn-register:hover {
            background-color: var(--bee-green-dark);
        }

        /* Cần thiết để căn giữa nội dung chính */
        .container-content {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 15px;
            /* Thêm padding ngang cho responsive */
        }
    </style>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light navbar-bee-green">
            <div class="container-fluid px-4">

                <div class="logo-section">
                    <a class="navbar-brand" href="<?= BASE_URL ?>">
                        <img src="assets/Logo1.png" alt="Bee Green Logo" class="d-inline-block align-text-top">
                        Bee Green
                    </a>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">

                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $currentPage == 'home' ? 'active' : ''; ?>" href="/">Trang Chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $currentPage == 'tour' ? 'active' : ''; ?>" href="/tour">Tour Du Lịch</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $currentPage == 'bookings' ? 'active' : ''; ?>" href="/bookings">Tour Đã Đặt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/support">Hỗ Trợ</a>
                        </li>
                    </ul>

                    <div class="d-flex auth-buttons">
                        <?php if (!isset($_SESSION['user_logged_in'])): ?>
                            <a class="btn btn-sm btn-login me-2" href="<?= BASE_URL . '?act=login' ?>">Đăng nhập</a>
                            <a class="btn btn-sm btn-register" href="<?= BASE_URL . '?act=register' ?>">Đăng ký</a>
                        <?php else: ?>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user me-1"></i> Chào, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Khách hàng'); ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                    <li><a class="dropdown-item" href="/profile"><i class="fa fa-cog me-2"></i>Hồ sơ</a></li>
                                    <li><a class="dropdown-item" href="/my-bookings"><i class="fa fa-ticket me-2"></i>Booking của tôi</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL . '?act=logout' ?>"><i class="fa fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container-content">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>