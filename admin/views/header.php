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
                <span class="fs-4">Admin Panel</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-2"></i> Tổng Quan
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link active" aria-current="page">
                        <i class="bi bi-map me-2"></i> Quản Lý Tour
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-book me-2"></i> Quản Lý Booking
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-people me-2"></i> Khách Hàng
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2"></i>
                    <strong>Chào, Admin!</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#">Cài Đặt</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Đăng Xuất</a></li>
                </ul>
            </div>
        </nav>

        <main class="main-content p-4"></main>