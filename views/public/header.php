<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bee Green - Du Lịch Khám Phá</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .hero-banner {
            height: 500px;
            background: url('./img/tambo.jpg') no-repeat center center;
            background-size: cover;
        }

        .hero-banner .overlay {
            background-color: rgba(0, 0, 0, 0.4);
        }

        .tour-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        /* Màu chủ đạo 'Green' cho thương hiệu */
        .navbar-brand,
        .text-brand {
            color: #198754 !important;
            /* Lấy màu 'success' của Bootstrap */
        }
    </style>
</head>

<body>

    <div class="top-bar bg-light border-bottom py-2 d-none d-md-block">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="contact-info small">
                    <a href="tel:19001234" class="text-decoration-none text-muted me-3">
                        <i class="bi bi-telephone-fill"></i> 1900.1234
                    </a>
                    <a href="mailto:info@beegreen.vn" class="text-decoration-none text-muted">
                        <i class="bi bi-envelope-fill"></i> info@beegreen.vn
                    </a>
                </div>
                <div class="social-icons">
                    <a href="#" class="text-muted me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-muted me-2"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-muted"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">

            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="index.php" style="margin-left: -15px;">
                <img src="./img/Logo1.png" alt="Bee Green Logo"
                    style="height: 100px; margin-top: -25px; margin-bottom: -25px;"
                    class="me-2">
                Bee Green
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Trang Chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./gioithieu.php">Giới Thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tour Trong Nước</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tour Nước Ngoài</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tin Tức</a>
                    </li>
                </ul>

                <div class="d-flex">
                    <a href="tel:19001234" class="btn btn-danger rounded-pill">
                        <i class="bi bi-telephone-fill me-1"></i> Hotline: 1900.1234
                    </a>
                </div>
            </div>
        </div>
    </nav>

    </nav>

    <header class="hero-banner position-relative">

        <div class="overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <div class="container h-100 d-flex align-items-center position-relative">
            <h1 class="text-white display-4 fw-bold">Khám phá Việt Nam</h1>
        </div>
    </header>
    <main>
    </main>
</body>

</html>