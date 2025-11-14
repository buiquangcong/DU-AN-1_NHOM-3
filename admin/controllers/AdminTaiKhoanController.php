<?php
class AdminTaiKhoanController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        $this->modelTaiKhoan = new AdminTaiKhoan();
    }

    // --- CHỨC NĂNG ĐĂNG NHẬP ---

    public function formLogin()
    {
        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 1. SỬA: Lấy Email thay vì user_name
            $email = $_POST['email'];
            $password = $_POST['password'];

            // 2. Gọi model kiểm tra theo Email
            $result = $this->modelTaiKhoan->checkLogin($email, $password);

            if (is_array($result)) {
                // Đăng nhập thành công -> Lưu session
                $_SESSION['user_admin'] = $result;

                // Kiểm tra quyền (Ví dụ: ID_Quyen = 1 là Admin)
                // Lưu ý: Bạn cần chắc chắn DB trả về cột ID_Quyen
                if ($result['ID_Quyen'] == 1) {
                    header("Location: " . BASE_URL_ADMIN . '?act=dashboard');
                } else {
                    // Nếu là khách hàng thì đá về trang chủ client
                    header("Location: " . BASE_URL);
                }
                exit();
            } else {
                // Đăng nhập thất bại -> Lưu lỗi
                $_SESSION['error'] = $result;
                $_SESSION['flash'] = true;
                header('Location: ' . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }
        }
    }

    public function logout()
    {
        if (isset($_SESSION['user_admin'])) {
            unset($_SESSION['user_admin']);
        }
        header('Location: ' . BASE_URL_ADMIN . '?act=login-admin');
        exit();
    }

    // --- QUẢN LÝ DANH SÁCH TÀI KHOẢN ---

    public function danhSachTaiKhoan()
    {
        $listTaiKhoan = $this->modelTaiKhoan->getAllTaiKhoan();
        require_once './views/taikhoan/listTaiKhoan.php';
    }

    // --- THÊM TÀI KHOẢN ---
    public function postAddAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy email làm tên đăng nhập
            $email = $_POST['email'];
            $ho_ten = $_POST['ho_ten'];
            // Mật khẩu mặc định
            $passwordRaw = '123456';
            $passwordHash = password_hash($passwordRaw, PASSWORD_BCRYPT);

            $idQuyen = $_POST['id_quyen'] ?? 2;

            // Gọi model insert (Lưu ý Model phải nhận tham số là email)
            $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $passwordHash, $idQuyen);

            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan');
        }
    }

    // --- CHỨC NĂNG ĐĂNG KÝ (Thêm mới) ---

    // 1. Hiển thị form đăng ký
    public function formSignup()
    {
        if (isset($_SESSION['user_admin'])) {
            header("Location: " . BASE_URL_ADMIN . '?act=dashboard');
            exit();
        }

        require_once './views/auth/formSignup.php';
        deleteSessionError(); // Xóa thông báo lỗi cũ nếu có
    }

    // 2. Xử lý dữ liệu đăng ký
    public function postSignup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Tạo mảng chứa lỗi
            $errors = [];

            // Validate cơ bản
            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Vui lòng nhập họ tên';
            }
            if (empty($email)) {
                $errors['email'] = 'Vui lòng nhập email';
            }
            if (empty($password)) {
                $errors['password'] = 'Vui lòng nhập mật khẩu';
            }
            if ($password !== $confirm_password) {
                $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp';
            }

            // Kiểm tra xem Email đã tồn tại chưa (Gọi Model)
            // Lưu ý: Bạn cần có hàm checkEmail trong Model, nếu chưa có thì bỏ qua dòng này hoặc thêm sau
            // if ($this->modelTaiKhoan->checkEmail($email)) {
            //     $errors['email'] = 'Email này đã được sử dụng';
            // }

            // Nếu có lỗi -> Trả về form đăng ký
            if (!empty($errors)) {
                $_SESSION['error'] = $errors;
                header("Location: " . BASE_URL_ADMIN . '?act=signup-admin');
                exit();
            }

            // Nếu không có lỗi -> Xử lý thêm vào DB

            // Mã hóa mật khẩu
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            // ID Quyền: Mặc định đăng ký mới là Khách hàng (thường là số 2 hoặc số cao nhất, tùy DB của bạn)
            $idQuyen = 2;

            // Gọi Model để insert (LƯU Ý: Phải cập nhật Model để nhận thêm biến $ho_ten)
            $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $passwordHash, $idQuyen);

            // Thông báo thành công (Tùy chọn)
            $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";

            // Chuyển hướng về trang đăng nhập
            header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
            exit();
        }
    }
}
