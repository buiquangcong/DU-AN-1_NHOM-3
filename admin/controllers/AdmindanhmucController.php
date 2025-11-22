<?php

class AdmindanhmucController
{
    private $modelDanhmuc;

    public function __construct()
    {
        $this->modelDanhmuc = new AdminDanhMuc();
    }

    // Danh sách danh mục
    public function danhsachDanhMuc()
    {
        $listdanhmuc = $this->modelDanhmuc->getAllDanhMuc();

        require_once __DIR__ . '/../views/layout/header.php';          // Load header/sidebar
        require_once __DIR__ . '/../views/danhmuc/listdanhmuc.php'; // Nội dung chính
        require_once __DIR__ . '/../views/layout/footer.php';          // Load footer

    }

    // Thêm danh mục (GET + POST)
    public function postAddDanhMuc()
    {
        $error = [];
        $TenLoaiTour = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $TenLoaiTour = $_POST['TenLoaiTour'] ?? '';
            if (empty($TenLoaiTour)) {
                $error['TenLoaiTour'] = "Tên loại tour không được để trống";
            }

            if (empty($error)) {
                $this->modelDanhmuc->insertDanhMuc($TenLoaiTour);
                header("Location: index.php?act=list-danhmuc");
                exit();
            }
        }

        // Chỉ include view form thêm
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/danhmuc/adddanhmuc.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // Hiển thị form sửa danh mục
    public function formEditDanhMuc()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=list-danhmuc");
            exit();
        }

        $danhmuc = $this->modelDanhmuc->getDetailDanhMuc($id);
        if (!$danhmuc) {
            header("Location: index.php?act=list-danhmuc");
            exit();
        }

        $error = [];
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/danhmuc/editdanhmuc.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // Sửa danh mục
    public function postEditDanhMuc()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=list-danhmuc");
            exit();
        }

        $danhmuc = $this->modelDanhmuc->getDetailDanhMuc($id);
        $TenLoaiTour = $_POST['TenLoaiTour'] ?? '';
        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($TenLoaiTour)) {
                $error['TenLoaiTour'] = "Tên loại tour không được để trống";
            }

            if (empty($error)) {
                $this->modelDanhmuc->updateDanhMuc($id, $TenLoaiTour);
                header("Location: index.php?act=list-danhmuc");
                exit();
            }
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/danhmuc/editdanhmuc.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // Xóa danh mục
   public function deleteDanhMuc($id)
{
    $result = $this->modelDanhmuc->deleteDanhMuc($id);

    if ($result === true) {
        $_SESSION['success'] = "Xóa danh mục thành công!";
    } else {
        $_SESSION['error'] = $result; // nhận thông báo từ model
    }

    header("Location: index.php?act=listDanhMuc");
    exit;
}
}
