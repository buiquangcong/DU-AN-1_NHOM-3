<?php

class ClientUserController
{
    protected $userModel;

    public function __construct()
    {
        global $dbConnection;
        // Khởi tạo Model Khách hàng
        $this->userModel = new ClientUser($dbConnection ?? null);
    }

    // --- VIEW FUNCTIONS ---

    /**
     * Hiển thị form Đăng nhập (Route: /login)
     */
    public function formLogin()
    {
        // Kiểm tra nếu đã đăng nhập thì chuyển hướng
        if (isset($_SESSION['user_logged_in'])) {
            header('Location: /profile');
            exit;
        }
        // Giả định hàm renderView() sẽ tải view login_form
        // renderView('client/login_form', ['pageTitle' => 'Đăng nhập']); 
        echo "<h1>Đăng nhập Bee Green</h1><p>Hiển thị form Đăng nhập.</p>";
    }

    /**
     * Hiển thị form Đăng ký (Route: /register)
     */
    public function formRegister()
    {
        // renderView('client/register_form', ['pageTitle' => 'Đăng ký']);
        echo "<h1>Đăng ký tài khoản</h1><p>Hiển thị form Đăng ký.</p>";
    }

    // --- AUTHENTICATION LOGIC ---

    /**
     * Xử lý Đăng nhập (Route: /check-login)
     */
    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            // renderView('client/login_form', ['error' => 'Vui lòng nhập đầy đủ Email và Mật khẩu.']);
            echo "Lỗi: Vui lòng nhập đầy đủ thông tin. <a href='/login'>Thử lại</a>";
            return;
        }

        $user = $this->userModel->getUserByEmail($email);

        // 1. Kiểm tra người dùng có tồn tại không
        if ($user) {
            // 2. Kiểm tra Mật khẩu (Quan trọng: SỬ DỤNG HASH BẢO MẬT)

            // Trường hợp TỐT NHẤT: Mật khẩu được lưu bằng password_hash()
            // if (password_verify($password, $user['MatKhau'])) { 

            // Trường hợp TỆ NHẤT: Mật khẩu lưu Plain Text hoặc Hash đơn giản như MD5/SHA
            if ($password === $user['MatKhau']) { // Cần HASH MẬT KHẨU trước khi so sánh nếu bạn dùng MD5/SHA

                // Đăng nhập thành công, lưu session
                $_SESSION['user_id'] = $user['ID_KhachHang']; // Dùng tên trường CSDL
                $_SESSION['user_name'] = $user['TenKhachHang']; // Dùng tên trường CSDL
                $_SESSION['user_logged_in'] = true;

                // Chuyển hướng về Trang chủ hoặc trang mà người dùng muốn đến trước đó
                $redirectUrl = $_SESSION['redirect_to'] ?? '/';
                unset($_SESSION['redirect_to']);

                header("Location: $redirectUrl");
                exit;
            }
        }

        // Đăng nhập thất bại
        // renderView('client/login_form', ['error' => 'Email hoặc mật khẩu không đúng.']);
        echo "Đăng nhập thất bại. <a href='/login'>Thử lại</a>";
    }

    /**
     * Xử lý Đăng ký (Route: /post-register)
     */
    public function register()
    {
        $data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
        ];

        // Kiểm tra email đã tồn tại chưa
        if ($this->userModel->getUserByEmail($data['email'])) {
            // renderView('client/register_form', ['error' => 'Email đã được sử dụng.']);
            echo "Đăng ký thất bại: Email đã tồn tại. <a href='/register'>Trở lại</a>";
            return;
        }

        // TỐT NHẤT: Hash mật khẩu trước khi gửi vào Model
        // $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($this->userModel->createNewUser($data)) {
            // Đăng ký thành công
            header('Location: /login?success=1');
            exit;
        } else {
            // Đăng ký thất bại
            // renderView('client/register_form', ['error' => 'Đăng ký thất bại, vui lòng thử lại.']);
            echo "Đăng ký thất bại. Vui lòng kiểm tra lại dữ liệu.";
        }
    }

    /**
     * Đăng xuất (Route: /logout)
     */
    public function logout()
    {
        session_unset(); // Xóa tất cả các biến session
        session_destroy(); // Hủy session
        setcookie(session_name(), '', time() - 3600, '/'); // Xóa cookie session

        header('Location: /');
        exit;
    }

    /**
     * Hiển thị trang Hồ sơ cá nhân (Route: /profile)
     */
    public function userProfile()
    {
        if (!isset($_SESSION['user_logged_in'])) {
            $_SESSION['redirect_to'] = '/profile';
            header('Location: /login');
            exit;
        }

        // Lấy thông tin chi tiết người dùng
        $userId = $_SESSION['user_id'];
        $profile = $this->userModel->getUserProfileById($userId); // Phương thức cần thêm vào Model

        // renderView('client/user_profile', compact('profile'));
        echo "<h1>Hồ sơ của " . htmlspecialchars($_SESSION['user_name']) . "</h1>";
        echo "<p>Đây là trang quản lý thông tin tài khoản.</p>";
    }
}
