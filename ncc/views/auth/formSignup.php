<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - Bee Green</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-image: url('../../img/nenLogin5.webp');
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

        .auth-link {
            color: var(--brand-green);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-11 col-sm-10 col-md-9 col-lg-8 col-xl-7">

                <div class="card login-card">
                    <div class="card-body p-4 p-lg-5">
                        <div class="row align-items-center">

                            <div class="col-md-5 text-center mb-4 mb-md-0 d-none d-md-block">
                                <img src="assets/Logo1.png" alt="Bee Green Logo" class="img-fluid" style="max-width: 100%;">
                            </div>

                            <div class="col-md-7">

                                <h5 class="card-title text-center text-md-start mb-4 fs-3">
                                    Đăng ký tài khoản
                                </h5>

                                <form action="index.php?act=post-signup-admin" method="POST">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingName"
                                            name="ho_ten" placeholder="Nguyễn Văn A" required>
                                        <label for="floatingName">
                                            <i class="bi bi-person-fill me-2"></i> Họ và tên
                                        </label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingEmail"
                                            name="email" placeholder="name@example.com" required>
                                        <label for="floatingEmail">
                                            <i class="bi bi-envelope-fill me-2"></i> Địa chỉ Email
                                        </label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="floatingPassword"
                                            name="password" placeholder="Password" required>
                                        <label for="floatingPassword">
                                            <i class="bi bi-lock-fill me-2"></i> Mật khẩu
                                        </label>
                                    </div>

                                    <div class="form-floating mb-4">
                                        <input type="password" class="form-control" id="floatingConfirmPassword"
                                            name="confirm_password" placeholder="Confirm Password" required>
                                        <label for="floatingConfirmPassword">
                                            <i class="bi bi-shield-lock-fill me-2"></i> Nhập lại mật khẩu
                                        </label>
                                    </div>

                                    <div class="d-grid mb-3">
                                        <button class="btn btn-brand-green btn-lg" type="submit">
                                            Đăng ký ngay
                                        </button>
                                    </div>

                                    <div class="text-center">
                                        <span class="text-muted">Bạn đã có tài khoản?</span>
                                        <a href="index.php?act=login-admin" class="auth-link ms-1">
                                            Đăng nhập tại đây
                                        </a>
                                    </div>
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