<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Quản trị Bee Green</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-image: url('assets/nenLogin5.jpg');

            /* Các thuộc tính này giúp ảnh nền đẹp hơn */
            background-size: cover;
            /* Phủ kín toàn bộ trang */
            background-position: center;
            /* Căn giữa ảnh */
            background-repeat: no-repeat;
            /* Không lặp lại ảnh */
            background-attachment: fixed;
            /* Giữ ảnh nền cố định khi cuộn *
            /* Tạo một nền màu xám nhạt */
            background-color: #f8f9fa;
        }

        /* Lấy màu xanh từ logo của bạn */
        :root {
            --brand-green: #198754;
            /* Bạn có thể đổi mã màu này nếu muốn */
        }

        .login-card {
            border: 0;
            /* Bo tròn và đổ bóng cho đẹp */
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }

        /* Tùy chỉnh nút đăng nhập */
        .btn-brand-green {
            background-color: var(--brand-green);
            border-color: var(--brand-green);
            color: #ffffff;
            font-weight: 600;
        }

        .btn-brand-green:hover {
            background-color: #146c43;
            /* Màu xanh đậm hơn khi hover */
            border-color: #146c43;
            color: #ffffff;
        }

        /* Tùy chỉnh màu khi focus vào input */
        .form-control:focus {
            border-color: var(--brand-green);
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-11 col-sm-9 col-md-8 col-lg-7 col-xl-6">

                <div class="card login-card">
                    <div class="card-body p-4 p-lg-5">
                        <div class="row align-items-center">

                            <div class="col-md-5 text-center mb-4 mb-md-0">
                                <img src="assets/Logo1.png" alt="Bee Green Logo" class="img-fluid" style="max-width: 180px;">
                            </div>

                            <div class="col-md-7">

                                <h5 class="card-title text-center text-md-start mb-4 fs-3">
                                    Đăng nhập
                                </h5>

                                <form action="index.php?act=check-login" method="POST">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control form-control-lg" id="floatingEmail"
                                            name="email" placeholder="name@example.com" required>
                                        <label for="floatingEmail">
                                            <i class="bi bi-envelope-fill me-2"></i>
                                            Địa chỉ Email
                                        </label>
                                    </div>

                                    <div class="form-floating mb-4">
                                        <input type="password" class="form-control form-control-lg" id="floatingPassword"
                                            name="password" placeholder="Password" required>
                                        <label for="floatingPassword">
                                            <i class="bi bi-lock-fill me-2"></i>
                                            Mật khẩu
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">
                                                Ghi nhớ tôi
                                            </label>
                                        </div>
                                        <a href="forgot-password.php" class="small text-decoration-none"
                                            style="color: var(--brand-green);">Quên mật khẩu?</a>
                                    </div>

                                    <div class="d-grid">
                                        <button class="btn btn-brand-green btn-lg" type="submit">
                                            Đăng nhập
                                        </button>
                                    </div>
                                    <a href="<?= BASE_URL_HDV . '?act=signup-hdv' ?>" class="small text-decoration-none"
                                        style="color: var(--brand-green);">Đăng ký Tài Khoản ?</a>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>