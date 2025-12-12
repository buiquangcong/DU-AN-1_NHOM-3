<?php
require_once __DIR__ . '/../models/AdminNhaCungCap.php';

require_once __DIR__ . '/../models/AdminDichVu.php';

class AdminQuanLyNhaCungCapController
{
    public $model;
    public $modelDichVu;

    public function __construct()
    {
        $this->model = new AdminNhaCungCap();
        $this->modelDichVu = new AdminDichVu();
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
        $listDichVu = $this->modelDichVu->getAllDichVu();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ten_nha_cc'    => trim($_POST['ten_nha_cc'] ?? ''),
                'id_dichvu'    => $_POST['id_dichvu'] ?? null,
                'dia_chi'       => trim($_POST['dia_chi'] ?? ''),
                'email'         => trim($_POST['email'] ?? ''),
                'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? '')
            ];

            if (empty($data['ten_nha_cc'])) $error['ten_nha_cc'] = "Tên nhà cung cấp không được để trống";
            if (empty($data['id_dichvu'])) $error['id_dichvu'] = "Vui lòng chọn dịch vụ cung cấp";
            if (empty($data['dia_chi'])) $error['dia_chi'] = "Địa chỉ không được để trống";
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

    // ====== Sửa nhà cung cấp (Đã sửa lỗi lấy ID POST) ======
    public function edit()
    {
        // 1. Lấy ID từ GET (khi load form)
        $id = $_GET['id_nha_cc'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 2. Lấy ID từ POST (trường ẩn) hoặc giữ ID cũ
            $id = $_POST['id_nha_cc'] ?? $id;
        }

        if (!$id) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhacungcap');
            exit();
        }

        $ncc = $this->model->getById($id);
        if (!$ncc) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhacungcap');
            exit();
        }

        $listDichVu = $this->modelDichVu->getAllDichVu();

        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ten_nha_cc'    => trim($_POST['ten_nha_cc'] ?? ''),
                'id_dichvu'    => $_POST['id_dichvu'] ?? null,
                'dia_chi'       => trim($_POST['dia_chi'] ?? ''),
                'email'         => trim($_POST['email'] ?? ''),
                'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? '')
            ];

            if (empty($data['id_dichvu'])) $error['id_dichvu'] = "Vui lòng chọn dịch vụ cung cấp";

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
