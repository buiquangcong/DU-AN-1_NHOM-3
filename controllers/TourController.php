<?php
// File: /controllers/TourController.php
// (Nằm ở thư mục /controllers/ gốc, không phải trong /admin/)

// (SỬA 1) Sửa đường dẫn:
// Vì file này nằm trong /controllers/, chúng ta cần đi lùi 1 cấp (../)
// để thấy thư mục /models/ và /views/
require_once './models/Tour.php';

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

        // (SỬA 2) Sửa đường dẫn View
        require_once './views/public/header.php';
        require_once './views/public/trangchu.php'; // View này sẽ dùng $dsTourNoiBat
        require_once './views/public/footer.php';
    }

    /**
     * Action: Hiển thị trang chi tiết tour
     * Route: /tour-chi-tiet
     */
    public function chiTietTour()
    {
        // 1. Lấy ID từ URL (ví dụ: ?act=tour-chi-tiet&id=5)
        $id = $_GET['id'] ?? 0;

        // 2. Gọi Model
        $tourModel = new Tour();
        $tour = $tourModel->getTourById($id);

        // 3. Tải View
        // (SỬA 2) Sửa đường dẫn View
        require_once './views/public/header.php';
        require_once './views/public/chitiet.php'; // (Tôi bỏ comment file này cho bạn)
        require_once './views/public/footer.php';
    }

    /**
     * (THÊM MỚI) Thêm hàm này để xử lý route 'gioi-thieu'
     * trong file index.php của bạn
     */
    public function trangGioiThieu()
    {
        // Trang này chỉ cần tải view, không cần model
        require_once './views/public/header.php';
        require_once './views/public/gioithieu.php';
        require_once './views/public/footer.php';
    }

    /**
     * (THÊM MỚI) Thêm hàm này để xử lý route 'default' (lỗi 404)
     * trong file index.php của bạn
     */
    public function e404()
    {
        require_once './views/public/header.php';
        // (Bạn có thể tạo file e404.php hoặc chỉ echo)
        echo '<h1 style="text-align: center; margin: 50px;">404 - Trang không tìm thấy</h1>';
        require_once './views/public/footer.php';
    }


    // ==================================================
    // CÁC HÀM CHO ADMIN
    // (ĐÃ XÓA TOÀN BỘ)
    // ==================================================

    // (Đã xóa các hàm: adminDashboard, adminDanhSachTour, 
    // adminThemTour, adminLuuThemTour, adminSuaTour, 
    // adminCapNhatTour, adminXoaTour)
}
