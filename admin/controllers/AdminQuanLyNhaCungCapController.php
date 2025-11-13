<?php
require_once __DIR__ . '/../models/AdminNhaCungCap.php';

class AdminQuanLyNhaCungCapController
{
    private $model;

    // --- SỬA LỖI TẠI ĐÂY ---
    // Xóa tham số $db để khớp với index.php
    public function __construct()
    {
        // Khởi tạo Model (Lưu ý: File Model AdminNhaCungCap cũng phải sửa để không nhận tham số)
        $this->model = new AdminNhaCungCap();
    }

    // ====== Danh sách nhà cung cấp ======
    public function index()
    {
        $listNCC = $this->model->getAll();
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhacungcap/list.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // ====== Thêm nhà cung cấp ======
    public function add()
    {
        $error = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ten_nha_cc'    => trim($_POST['ten_nha_cc'] ?? ''),
                'dia_chi'       => trim($_POST['dia_chi'] ?? ''),
                'email'         => trim($_POST['email'] ?? ''),
                'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? '')
            ];

            if (empty($data['ten_nha_cc'])) $error['ten_nha_cc'] = "Tên nhà cung cấp không được để trống";
            if (empty($data['dia_chi'])) $error['dia_chi'] = "Địa chỉ không được để trống";
            // Validate email chỉ khi người dùng có nhập
            if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Email không hợp lệ";
            }
            if (empty($data['so_dien_thoai'])) $error['so_dien_thoai'] = "Số điện thoại không được để trống";

            if (empty($error)) {
                $this->model->insert($data);
                header('Location: ' . BASE_URL_ADMIN . '?act=list-nhacungcap');
                exit();
            }
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhacungcap/add.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // ====== Sửa nhà cung cấp ======
    public function edit()
    {
        $id = $_GET['id_nha_cc'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhacungcap');
            exit();
        }

        $ncc = $this->model->getById($id);
        if (!$ncc) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhacungcap');
            exit();
        }

        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ten_nha_cc'    => trim($_POST['ten_nha_cc'] ?? ''),
                'dia_chi'       => trim($_POST['dia_chi'] ?? ''),
                'email'         => trim($_POST['email'] ?? ''),
                'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? '')
            ];

            if (empty($data['ten_nha_cc'])) $error['ten_nha_cc'] = "Tên nhà cung cấp không được để trống";
            if (empty($data['dia_chi'])) $error['dia_chi'] = "Địa chỉ không được để trống";
            if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Email không hợp lệ";
            }
            if (empty($data['so_dien_thoai'])) $error['so_dien_thoai'] = "Số điện thoại không được để trống";

            if (empty($error)) {
                $this->model->update($id, $data);
                header('Location: ' . BASE_URL_ADMIN . '?act=list-nhacungcap');
                exit();
            }
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhacungcap/edit.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // ====== Chi tiết nhà cung cấp ======
    public function detail()
    {
        $id = $_GET['id_nha_cc'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhacungcap');
            exit();
        }

        $ncc = $this->model->getById($id);
        if (!$ncc) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhacungcap');
            exit();
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhacungcap/detail.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // ====== Xóa nhà cung cấp ======
    public function delete()
    {
        $id = $_GET['id_nha_cc'] ?? null;
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: ' . BASE_URL_ADMIN . '?act=list-nhacungcap');
        exit();
    }
}
