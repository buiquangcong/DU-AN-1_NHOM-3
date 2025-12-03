<?php
class HdvTaiKhoanController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        // Gọi Model của HDV
        require_once './models/HdvTaiKhoan.php';
        $this->modelTaiKhoan = new HdvTaiKhoan();
    }

    // =========================================================================
    // 1. ĐĂNG NHẬP / ĐĂNG XUẤT (Auth)
    // =========================================================================

    public function formLogin()
    {
        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lưu ý: Form input name="email" nhưng Model check cột "TenDangNhap"
            // Hãy chắc chắn bạn nhập Tên đăng nhập vào ô Email, hoặc sửa input name
            $email = $_POST['email'];
            $password = $_POST['password'];

            // 1. Gọi Model
            $result = $this->modelTaiKhoan->checkLogin($email, $password);

            // 2. Kiểm tra kết quả trả về
            if (is_array($result)) {
                // === TRƯỜNG HỢP ĐĂNG NHẬP THÀNH CÔNG (Trả về mảng user) ===

                $user = $result;

                // Kiểm tra quyền (Cột ID_Quyen trong bảng dm_tai_khoan)
                // Giả sử 2 là quyền HDV. Bạn hãy sửa số 2 này theo DB của bạn.
                $role = $user['ID_Quyen'] ?? $user['id_quyen'] ?? 0;

                if ($role != 2) {
                    $_SESSION['error'] = "Tài khoản này không có quyền Hướng Dẫn Viên!";
                    header("Location: ?act=login-hdv");
                    exit();
                }

                // Lưu Session chuẩn
                $_SESSION['user'] = $user;

                // Chuyển hướng vào Dashboard
                header("Location: ?act=dashboard");
                exit();
            } else {
                // === TRƯỜNG HỢP THẤT BẠI (Trả về chuỗi lỗi) ===
                // $result lúc này là: "Mật khẩu không đúng" hoặc "Email không tồn tại"...
                $_SESSION['error'] = $result;
                $_SESSION['flash'] = true; // Để hiển thị lỗi 1 lần

                header("Location: ?act=login-hdv");
                exit();
            }
        }
    }

    public function logout()
    {
        // Xóa session user
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        // QUAN TRỌNG: Quay ra trang chủ gốc của website (Ra khỏi folder HuongDanVien)
        header('Location: ?act=login-hdv');
        exit();
    }

    // =========================================================================
    // 2. QUẢN LÝ DANH SÁCH (Tùy nghiệp vụ HDV)
    // =========================================================================

    public function danhSachTaiKhoan()
    {
        // HDV thường chỉ xem danh sách Khách hàng trong Tour của mình
        // Nếu logic của bạn cho phép xem hết thì giữ nguyên
        $listTaiKhoan = $this->modelTaiKhoan->getAllTaiKhoan();

        require_once './views/layout/header.php';
        require_once './views/nhansu/list-tai-khoan.php';
        require_once './views/layout/footer.php';
    }

    // =========================================================================
    // 3. THÊM TÀI KHOẢN (Nếu HDV có quyền này)
    // =========================================================================

    public function addTaiKhoan()
    {
        $roles = $this->modelTaiKhoan->getAllQuyen() ?? [];
        deleteSessionError();

        require_once './views/layout/header.php';
        require_once './views/nhansu/add-tai-khoan.php';
        require_once './views/layout/footer.php';
    }

    public function postAddTaiKhoan() // Đổi tên cho đúng chuẩn
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // ... (Logic lấy dữ liệu giữ nguyên như bạn viết) ...
            $ho_ten         = trim($_POST['ho_ten'] ?? '');
            $email          = trim($_POST['email'] ?? '');
            $password       = $_POST['mat_khau'] ?? '';
            $chuc_vu        = trim($_POST['chuc_vu'] ?? '');
            $id_quyen       = $_POST['id_quyen'] ?? '';
            $so_dien_thoai  = trim($_POST['so_dien_thoai'] ?? '');
            $dia_chi        = trim($_POST['dia_chi'] ?? '');
            $trang_thai     = $_POST['trang_thai'] ?? 1;

            $errors = [];
            if (empty($ho_ten)) $errors[] = "Họ tên trống.";
            if (empty($email)) $errors[] = "Email trống.";

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $_POST;
                header("Location: ?act=add-tai-khoan");
                exit();
            }

            // Insert
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $this->modelTaiKhoan->insertTaiKhoan(
                $ho_ten,
                $email,
                $passwordHash,
                $id_quyen,
                $chuc_vu,
                $so_dien_thoai,
                $dia_chi,
                $trang_thai
            );

            $_SESSION['success'] = "Thêm thành công!";
            header("Location: ?act=quan-ly-tai-khoan");
            exit();
        }
    }
}
