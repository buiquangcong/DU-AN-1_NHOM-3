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
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: #f8f9fa;
        }

        :root {
            --brand-green: #198754;
        }

        .login-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }

        .btn-brand-green {
            background-color: var(--brand-green);
            border-color: var(--brand-green);
            color: #ffffff;
            font-weight: 600;
        }

        .btn-brand-green:hover {
            background-color: #146c43;
            border-color: #146c43;
            color: #ffffff;
        }

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

                                <form action="index.php?act=check-login-admin" method="POST">
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
                                    <a href="<?= BASE_URL_NCC . '?act=signup-admin' ?>" class="small text-decoration-none"
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