<?php
class AdminTaiKhoanController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        // Yêu cầu (require) file Model nếu cần, và khởi tạo
        // require_once 'path/to/AdminTaiKhoan.php'; 
        $this->modelTaiKhoan = new AdminTaiKhoan();
    }

    // --- CHỨC NĂNG ĐĂNG NHẬP (Không sửa đổi) ---
    public function formLogin()
    {
        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }

    public function login()
    {
        // ... (Giữ nguyên)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $result = $this->modelTaiKhoan->checkLogin($email, $password);

            if (is_array($result)) {
                $_SESSION['user_admin'] = $result;
                if ($result['ID_Quyen'] == 1) { // 1 là Admin
                    header("Location: " . BASE_URL_ADMIN . '?act=dashboard');
                } else {
                    header("Location: " . BASE_URL);
                }
                exit();
            } else {
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

    // --- QUẢN LÝ DANH SÁCH TÀI KHOẢN (Không sửa đổi) ---

    public function danhSachTaiKhoan()
    {
        $listTaiKhoan = $this->modelTaiKhoan->getAllTaiKhoan();
        // SỬA VIEW NAME: listTaiKhoan.php
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhansu/list-tai-khoan.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // --- THÊM TÀI KHOẢN (ADMIN) ---
    public function postAddAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Lấy dữ liệu từ FORM (Bao gồm SĐT và Địa chỉ mới)
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $idQuyen = $_POST['id_quyen'] ?? 2;

            // LẤY DỮ LIỆU MỚI TỪ FORM
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? null;
            $dia_chi = $_POST['dia_chi'] ?? null;

            // Mật khẩu mặc định và Hash
            $passwordRaw = '123456';
            $passwordHash = password_hash($passwordRaw, PASSWORD_BCRYPT);

            // GỌI MODEL INSERT VỚI ĐỦ CÁC THAM SỐ MỚI
            $this->modelTaiKhoan->insertTaiKhoan(
                $ho_ten,
                $email,
                $passwordHash,
                $idQuyen,
                $so_dien_thoai, // Tham số mới
                $dia_chi        // Tham số mới
            );

            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan');
            exit();
        }
    }

    // --- CHỨC NĂNG ĐĂNG KÝ (CLIENT) ---

    public function formSignup()
    {
        // ... (Giữ nguyên)
    }

    public function postSignup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Lấy dữ liệu SĐT và Địa chỉ (Nếu bạn muốn thêm vào form Đăng ký Client)
            // $so_dien_thoai = $_POST['so_dien_thoai'] ?? null;
            // $dia_chi = $_POST['dia_chi'] ?? null;

            $errors = [];
            // ... (Validate cơ bản, giữ nguyên)

            // Nếu có lỗi -> Trả về form đăng ký
            if (!empty($errors)) {
                $_SESSION['error'] = $errors;
                header("Location: " . BASE_URL_ADMIN . '?act=signup-admin');
                exit();
            }

            // Nếu không có lỗi -> Xử lý thêm vào DB
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $idQuyen = 4; // Mặc định đăng ký mới là Khách hàng (Giả định ID_Quyen=4)

            // GỌI MODEL INSERT VỚI ĐỦ CÁC THAM SỐ MỚI
            // Vì form đăng ký Client thường không có SĐT/Địa chỉ, 
            // ta truyền NULL hoặc chuỗi rỗng cho hai tham số này.
            $this->modelTaiKhoan->insertTaiKhoan(
                $ho_ten,
                $email,
                $passwordHash,
                $idQuyen,
                null, // SĐT mặc định là NULL
                null  // Địa chỉ mặc định là NULL
            );

            $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
            header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
            exit();
        }
    }
}
