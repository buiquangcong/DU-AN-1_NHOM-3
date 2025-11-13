<?php
require_once __DIR__ . '/../models/NhanSu.php';

class AdminQuanLyNhanSuController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new NhanSu($db);
    }

    // ====== Danh sách nhân sự ======
    public function index()
    {
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
            $data = [
                'ho_ten'        => trim($_POST['ho_ten']),
                'chuc_vu'       => trim($_POST['chuc_vu']),
                'email'         => trim($_POST['email']),
                'so_dien_thoai' => trim($_POST['so_dien_thoai'])
            ];

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

            if (empty($error)) {
                $this->model->insert($data);
                header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
                exit();
            }
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhansu/add.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // ====== Sửa nhân sự ======
    public function edit()
    {
        $id = $_GET['id_nhan_su'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
            exit();
        }

        $nhansu = $this->model->getById($id);
        if (!$nhansu) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
            exit();
        }

        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ho_ten'        => trim($_POST['ho_ten']),
                'chuc_vu'       => trim($_POST['chuc_vu']),
                'email'         => trim($_POST['email']),
                'so_dien_thoai' => trim($_POST['so_dien_thoai'])
            ];

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

    public function postEditNhanSu()
    {
        $id = $_GET['id_nhan_su'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
            exit();
        }

        $nhansu = $this->model->getById($id);
        if (!$nhansu) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
            exit();
        }

        $data = [
            'ho_ten' => trim($_POST['ho_ten'] ?? ''),
            'chuc_vu' => trim($_POST['chuc_vu'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? '')
        ];

        $error = [];
        if (empty($data['ho_ten'])) $error['ho_ten'] = "Họ tên không được để trống";
        if (empty($data['chuc_vu'])) $error['chuc_vu'] = "Chức vụ không được để trống";
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $error['email'] = "Email không hợp lệ";
        if (empty($data['so_dien_thoai'])) $error['so_dien_thoai'] = "Số điện thoại không được để trống";

        if (empty($error)) {
            $this->model->update($id, $data);
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
            exit();
        } else {
            // Hiển thị lại form với lỗi
            require_once __DIR__ . '/../views/layout/header.php';
            require_once __DIR__ . '/../views/nhansu/edit.php';
            require_once __DIR__ . '/../views/layout/footer.php';
        }
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
        if (!$nhansu) {
            header('Location: ' . BASE_URL_ADMIN . '?act=list-nhansu');
            exit();
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhansu/detail.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
