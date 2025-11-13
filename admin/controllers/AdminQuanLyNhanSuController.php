<?php
// Đảm bảo đường dẫn file Model đúng
require_once __DIR__ . '/../models/AdminQuanLyNhanSu.php';

class AdminQuanLyNhanSuController
{
    public $model;

    // SỬA LẠI: Phải nhận biến kết nối $db từ index.php truyền vào
    public function __construct()
    {
        // Cách 1: Nếu dự án dùng biến toàn cục $conn (ít dùng nhưng phổ biến ở bài lab)
        // global $conn; 
        // $this->model = new AdminQuanLyNhanSu($conn);

        // Cách 2: (Chuẩn hơn) Tự tạo kết nối hoặc lấy từ file connection chung
        // Giả sử bạn có file connectDB.php trả về kết nối
        $this->model = new AdminQuanLyNhanSu(connectDB());

        // HOẶC Cách 3 (Phổ biến nhất): 
        // Nếu file Model tự lo việc kết nối bên trong nó, 
        // thì bạn phải mở file AdminQuanLyNhanSu.php ra và xóa tham số trong __construct đi.
    }
    // ====== Danh sách nhân sự ======
    public function index()
    {
        // Gọi hàm getAll() từ Model
        $listNhanSu = $this->model->getAll();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhansu/list.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // ====== Thêm nhân sự ======
    public function add()
    {
        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Dùng ?? '' để tránh lỗi nếu không có dữ liệu gửi lên
            $data = [
                'ho_ten'        => trim($_POST['ho_ten'] ?? ''),
                'chuc_vu'       => trim($_POST['chuc_vu'] ?? ''),
                'email'         => trim($_POST['email'] ?? ''),
                'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? '')
            ];

            // Validate
            if (empty($data['ho_ten'])) {
                $error['ho_ten'] = "Họ tên không được để trống";
            }
            if (empty($data['chuc_vu'])) {
                $error['chuc_vu'] = "Chức vụ không được để trống";
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Email không hợp lệ";
            }
            if (empty($data['so_dien_thoai'])) {
                $error['so_dien_thoai'] = "Số điện thoại không được để trống";
            }

            // Nếu không có lỗi -> Insert
            if (empty($error)) {
                // Gọi Model
                $this->model->insert($data);

                // Chuyển hướng về danh sách
                header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
                exit();
            }
        }

        // Nếu có lỗi hoặc chưa submit thì hiện form
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhansu/add.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // ====== Form Sửa (Hiển thị form) ======
    public function edit()
    {
        $id = $_GET['id_nhan_su'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
            exit();
        }

        // Lấy thông tin cũ để điền vào form
        $nhansu = $this->model->getById($id);

        if (!$nhansu) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
            exit();
        }

        // Logic POST xử lý ngay tại đây (hoặc tách ra postEditNhanSu đều được)
        // Ở đây tôi giữ nguyên logic của bạn là gộp chung
        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ho_ten'        => trim($_POST['ho_ten'] ?? ''),
                'chuc_vu'       => trim($_POST['chuc_vu'] ?? ''),
                'email'         => trim($_POST['email'] ?? ''),
                'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? '')
            ];

            if (empty($data['ho_ten'])) $error['ho_ten'] = "Họ tên không được để trống";
            if (empty($data['chuc_vu'])) $error['chuc_vu'] = "Chức vụ không được để trống";
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $error['email'] = "Email không hợp lệ";
            if (empty($data['so_dien_thoai'])) $error['so_dien_thoai'] = "Số điện thoại không được để trống";

            if (empty($error)) {
                $this->model->update($id, $data);
                header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
                exit();
            }
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhansu/edit.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // ====== Hàm xử lý POST Sửa (Nếu bạn tách riêng route) ======
    // Nếu bạn dùng chung hàm edit() ở trên để xử lý thì hàm này có thể bỏ hoặc dùng làm backup
    public function postEditNhanSu()
    {
        $this->edit(); // Gọi lại hàm edit để tái sử dụng logic
    }

    // ====== Xóa nhân sự ======
    public function delete()
    {
        $id = $_GET['id_nhan_su'] ?? null;
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
        exit();
    }

    // ====== Chi tiết nhân sự ======
    public function detail()
    {
        $id = $_GET['id_nhan_su'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
            exit();
        }

        $nhansu = $this->model->getById($id);

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhansu/detail.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
