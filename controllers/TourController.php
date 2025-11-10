<?php
// Tải file Model (chúng ta sẽ cần nó)
require_once 'models/Tour.php';

class TourController
{
    // ==================================================
    // CÁC HÀM CHO KHÁCH HÀNG (PUBLIC)
    // ==================================================

    /**
     * Action: Hiển thị trang chủ cho khách hàng
     * Route: /
     */
    public function trangChu()
    {
        $tourModel = new Tour();
        $dsTourNoiBat = $tourModel->getTourNoiBat(); // Lấy 6 tour nổi bật

        require_once 'views/public/header.php';
        require_once 'views/public/trangchu.php'; // View này sẽ dùng $dsTourNoiBat
        require_once 'views/public/footer.php';
    }

    /**
     * Action: Hiển thị trang chi tiết tour
     * Route: /tour-chi-tiet
     */
    public function chiTietTour()
    {
        // 1. Lấy ID từ URL (ví dụ: ?route=tour-chi-tiet&id=5)
        $id = $_GET['id'] ?? 0;

        // 2. Gọi Model
        $tourModel = new Tour();
        $tour = $tourModel->getTourById($id);

        // 3. Tải View
        require_once 'views/public/header.php';
        // require_once 'views/public/chitiet.php'; // View này dùng $tour
        require_once 'views/public/footer.php';
    }

    // ==================================================
    // CÁC HÀM CHO ADMIN
    // ==================================================

    /**
     * Action: Hiển thị trang dashboard
     * Route: /admin/dashboard
     */
    public function adminDashboard()
    {
        // Logic lấy số liệu thống kê...
        require_once 'views/admin/header.php';
        require_once 'views/admin/dashboard.php';
        require_once 'views/admin/footer.php';
    }

    /**
     * Action: (R)ead - Hiển thị danh sách tour
     * Route: /admin/tours
     */
    public function adminDanhSachTour()
    {
        $tourModel = new Tour();
        $danhSachTour = $tourModel->getAllTours(); // Lấy tất cả tour

        require_once 'views/admin/header.php';
        require_once 'views/admin/danh-sach-tour.php'; // View này dùng $danhSachTour
        require_once 'views/admin/footer.php';
    }

    /**
     * Action: (C)reate - Hiển thị form thêm mới
     * Route: /admin/tours/them
     */
    public function adminThemTour()
    {
        require_once 'views/admin/header.php';
        // require_once 'views/admin/them-tour.php'; // Form thêm tour
        require_once 'views/admin/footer.php';
    }

    /**
     * Action: (C)reate - Xử lý lưu dữ liệu từ form thêm
     * Route: /admin/tours/luu
     */
    public function adminLuuThemTour()
    {
        // 1. Lấy dữ liệu từ POST
        $tenTour = $_POST['ten_tour'] ?? '';
        $gia = $_POST['gia'] ?? 0;

        // 2. Gọi Model để lưu
        $tourModel = new Tour();
        $tourModel->createTour($tenTour, $gia);

        // 3. Chuyển hướng về trang danh sách
        header('Location: index.php?route=/admin/tours');
    }

    /**
     * Action: (U)pdate - Hiển thị form sửa
     * Route: /admin/tours/sua
     */
    public function adminSuaTour()
    {
        // 1. Lấy ID cần sửa
        $id = $_GET['id'] ?? 0;

        // 2. Gọi Model lấy thông tin tour cũ
        $tourModel = new Tour();
        $tour = $tourModel->getTourById($id);

        // 3. Tải View
        require_once 'views/admin/header.php';
        // require_once 'views/admin/sua-tour.php'; // View này dùng $tour
        require_once 'views/admin/footer.php';
    }

    /**
     * Action: (U)pdate - Xử lý cập nhật dữ liệu
     * Route: /admin/tours/capnhat
     */
    public function adminCapNhatTour()
    {
        // 1. Lấy dữ liệu từ POST
        $id = $_POST['id'] ?? 0;
        $tenTour = $_POST['ten_tour'] ?? '';
        $gia = $_POST['gia'] ?? 0;

        // 2. Gọi Model
        $tourModel = new Tour();
        $tourModel->updateTour($id, $tenTour, $gia);

        // 3. Chuyển hướng
        header('Location: index.php?route=/admin/tours');
    }

    /**
     * Action: (D)elete - Xử lý xóa
     * Route: /admin/tours/xoa
     */
    public function adminXoaTour()
    {
        // 1. Lấy ID cần xóa
        $id = $_GET['id'] ?? 0;

        // 2. Gọi Model
        $tourModel = new Tour();
        $tourModel->deleteTour($id);

        // 3. Chuyển hướng
        header('Location: index.php?route=/admin/tours');
    }
}
