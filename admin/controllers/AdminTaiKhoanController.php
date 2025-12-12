<?php
class AdminTaiKhoanController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        require_once 'models/AdminTaiKhoan.php'; // SỬA THÀNH require_once
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

    public function addTaiKhoan()
    {
        // Giả định Model có method này để lấy danh sách quyền cho dropdown
        $roles = $this->modelTaiKhoan->getAllQuyen() ?? [];

        // Khởi tạo $errors và $data (dữ liệu cũ) để truyền vào View
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']); // Xóa lỗi sau khi đã lấy
        $data = [];

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhansu/add-tai-khoan.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // 2. HÀM XỬ LÝ FORM SUBMIT (POST request)
    public function postAddAdmin()
    {
        $errors = [];
        $data = [];
        $roles = $this->modelTaiKhoan->getAllQuyen() ?? [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Lấy dữ liệu và chuẩn hóa từ FORM
            $data = [
                'ho_ten'          => trim($_POST['ho_ten'] ?? ''),
                'email'           => trim($_POST['email'] ?? ''),
                'mat_khau_raw'    => $_POST['mat_khau'] ?? '',
                'id_quyen'        => $_POST['id_quyen'] ?? '',
                'so_dien_thoai'   => trim($_POST['so_dien_thoai'] ?? null),
                'dia_chi'         => trim($_POST['dia_chi'] ?? null),
                'trang_thai'      => $_POST['trang_thai'] ?? 1,
            ];

            // --- VALIDATION ---
            if (empty($data['ho_ten'])) $errors[] = "Họ tên không được để trống.";
            if (empty($data['email'])) $errors[] = "Email không được để trống.";
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Email không hợp lệ.";
            if (empty($data['mat_khau_raw'])) $errors[] = "Mật khẩu không được để trống.";
            if (strlen($data['mat_khau_raw']) < 6) $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
            if (empty($data['id_quyen'])) $errors[] = "Vui lòng chọn Phân quyền.";


            if (empty($errors)) {
                // Xử lý Hash mật khẩu
                $passwordHash = password_hash($data['mat_khau_raw'], PASSWORD_BCRYPT);

                $result = $this->modelTaiKhoan->insertTaiKhoan(
                    $data['ho_ten'],
                    $data['email'],
                    $passwordHash,
                    $data['id_quyen'],
                    $data['so_dien_thoai'],
                    $data['dia_chi'],
                    $data['trang_thai'] // Tham số mới
                );

                if ($result) {
                    $_SESSION['success'] = "Thêm tài khoản thành công!";
                    header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan');
                    exit();
                } else {
                    // Nếu Model trả về lỗi DB/lỗi logic
                    $errors[] = "Lỗi khi thêm tài khoản (Lỗi Model/Database).";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                // Lưu dữ liệu POST vào session để đổ lại form (tùy chọn)
                $_SESSION['data_old'] = $data;

                // Redirect về chính form để hiển thị lỗi
                header("Location: " . BASE_URL_ADMIN . '?act=add-tai-khoan');
                exit();
            }
        }
    }


    public function editTaiKhoan()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) { /* ... (xử lý lỗi ID) ... */
        }

        $errors = $_SESSION['errors'] ?? [];
        $data_old = $_SESSION['data_old'] ?? [];
        unset($_SESSION['errors'], $_SESSION['data_old']);
        $roles = $this->modelTaiKhoan->getAllQuyen() ?? [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- XỬ LÝ POST (CẬP NHẬT DỮ LIỆU) ---
            $data = [
                'ho_ten'          => trim($_POST['ho_ten'] ?? ''),
                'email'           => trim($_POST['email'] ?? ''),
                'mat_khau_moi'    => $_POST['mat_khau_moi'] ?? '',
                'id_quyen'        => $_POST['id_quyen'] ?? '',
                'so_dien_thoai'   => trim($_POST['so_dien_thoai'] ?? null),
                'dia_chi'         => trim($_POST['dia_chi'] ?? null),
                'trang_thai'      => $_POST['trang_thai'] ?? 1,
            ];

            // 2. VALIDATION
            if (empty($data['ho_ten'])) $errors[] = "Họ tên không được để trống.";
            if (empty($data['email'])) $errors[] = "Email không được để trống.";
            if (empty($data['id_quyen'])) $errors[] = "Vui lòng chọn Phân quyền.";

            // 3. XỬ LÝ MẬT KHẨU
            $passwordHash = null;
            if (!empty($data['mat_khau_moi'])) {
                if (strlen($data['mat_khau_moi']) < 6) {
                    $errors[] = "Mật khẩu mới phải có ít nhất 6 ký tự.";
                } else {
                    $passwordHash = password_hash($data['mat_khau_moi'], PASSWORD_BCRYPT);
                }
            }

            if (empty($errors)) {
                // GỌI MODEL CẬP NHẬT
                $result = $this->modelTaiKhoan->updateTaiKhoan(
                    $id,
                    $data['ho_ten'],
                    $data['email'],
                    $data['id_quyen'],
                    $data['so_dien_thoai'],
                    $data['dia_chi'],
                    $data['trang_thai'],
                    $passwordHash
                );

                if ($result) {
                    $_SESSION['success'] = "Cập nhật tài khoản thành công!";
                    header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan');
                    exit();
                } else {
                    $errors[] = "Lỗi khi cập nhật tài khoản (Database/Model).";
                }
            }
            // Xử lý lỗi sau POST (Redirect)
            $_SESSION['errors'] = $errors;
            $_SESSION['data_old'] = $data;
            header("Location: " . BASE_URL_ADMIN . '?act=edit-tai-khoan&id=' . $id);
            exit();
        } else {
            // --- XỬ LÝ GET (HIỂN THỊ DỮ LIỆU CŨ) ---
            $taiKhoan = $this->modelTaiKhoan->getDetailAdmin($id);

            if (!$taiKhoan) { /* ... (xử lý lỗi không tìm thấy) ... */
            }

            // Ghi đè dữ liệu nếu có lỗi từ POST redirect
            if (!empty($data_old)) {
                $taiKhoan = (object) array_merge($taiKhoan, $data_old);
            }
        }

        // Tải View
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhansu/edit-tai-khoan.php';
        require_once __DIR__ . '/../views/layout/footer.php';
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

            $chuc_vu = 'Khách hàng'; // Khách hàng không có chức vụ cụ thể
            $trang_thai = 1;          // Mặc định tài khoản mới là Hoạt động
            $so_dien_thoai = null;    // Lấy từ form (nếu có) hoặc đặt mặc định NULL
            $dia_chi = null;          // Lấy từ form (nếu có) hoặc đặt mặc định NULL
            // --- Kết thúc định nghĩa ---

            $this->modelTaiKhoan->insertTaiKhoan(
                $ho_ten,
                $email,
                $passwordHash,
                $idQuyen,
                $chuc_vu,           // THAM SỐ 5 (MỚI)
                $so_dien_thoai,     // THAM SỐ 6
                $dia_chi,           // THAM SỐ 7
                $trang_thai         // THAM SỐ 8 (MỚI)
            );

            $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
            header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
            exit();
        }
    }

    function chiTietTaiKhoan()
    {
        // 1. Kiểm tra tham số trên URL
        // QUAN TRỌNG: Phải bắt đúng tên 'ID_Taikhoan' như trong thẻ <a> của bạn
        if (isset($_GET['ID_Taikhoan']) && $_GET['ID_Taikhoan'] > 0) {
            $id = $_GET['ID_Taikhoan'];

            // 2. Gọi Model lấy dữ liệu
            $taikhoan = getDetailTaiKhoan($id);

            // 3. Kiểm tra xem có dữ liệu không
            if (is_array($taikhoan)) {
                // Xử lý hiển thị chức vụ cho đẹp (nếu cần)
                $chuc_vu = '';
                if ($taikhoan['ID_Quyen'] == 1) $chuc_vu = 'Quản trị viên';
                elseif ($taikhoan['ID_Quyen'] == 2) $chuc_vu = 'Hướng Dẫn Viên (HDV)';
                elseif ($taikhoan['ID_Quyen'] == 3) $chuc_vu = 'Nhà Cung Cấp (NCC)';
                else $chuc_vu = 'Khách hàng';

                // Gán thêm key 'ten_chuc_vu' vào mảng để View dùng luôn
                $taikhoan['ten_chuc_vu'] = $chuc_vu;

                // 4. Gọi View chi tiết
                // Lưu ý: Biến $taikhoan sẽ được dùng bên file view
                require_once __DIR__ . '/../views/layout/header.php';
                require_once __DIR__ . '/../views/nhansu/detail-tai-khoan.php';
                require_once __DIR__ . '/../views/layout/footer.php';
            } else {
                // Nếu ID không tồn tại trong DB
                echo "Không tìm thấy tài khoản này.";
            }
        } else {
            // Nếu URL không có ID_Taikhoan -> Quay về danh sách
            header("Location: ?act=list-tai-khoan");
            exit();
        }
    }
}
