<?php
// D:\laragon\www\DU-AN-1_NHOM-3\KhachHang\Controllers\ClientTourController.php

class ClientTourController
{

    public $modelTour;

    public function __construct()
    {
        try {
            // Model ClientTour tự gọi connectDB() bên trong nó.
            $this->modelTour = new ClientTour();
        } catch (Exception $e) {
            // Xử lý nếu Model gặp lỗi nghiêm trọng (ví dụ: connectDB() bị lỗi cấu hình)
            echo "Lỗi khởi tạo Model: " . $e->getMessage();
            exit;
        }
    }

    /**
     * Hiển thị Trang chủ (Route: /).
     */
    public function home()
    {
        // 1. Chuẩn bị các biến cho View
        $pageTitle = 'Du lịch Xanh cùng Bee Green';
        $currentPage = 'home';

        try {
            // 2. Gọi Model để lấy dữ liệu (Sử dụng tên biến rõ ràng)
            $featuredTours = $this->modelTour->getFeaturedTours();
            $tourCategories = $this->modelTour->getAllTourCategories();

            require_once __DIR__ . '/../views/layout/header.php';
            require_once __DIR__ . '/../views/home.php';
            require_once __DIR__ . '/../views/layout/footer.php';
        } catch (Exception $e) {
            error_log("Lỗi tải dữ liệu Trang chủ: " . $e->getMessage());
            echo "Lỗi tải dữ liệu Trang chủ.";
        }
    }

    /**
     * Xử lý tìm kiếm Tour. Route: /search-tour.
     * Áp dụng phong cách require_once của hàm danhSachTour().
     */
    public function searchTours()
    {
        // 1. Lấy tham số tìm kiếm (sử dụng tên biến rõ ràng như Controller Admin)
        $search_destination = $_GET['destination'] ?? '';
        $search_date = $_GET['date'] ?? null;
        $search_loai_tour = $_GET['loai_tour'] ?? null;

        $criteria = [
            'destination' => $search_destination,
            'date' => $search_date,
            'loai_tour' => $search_loai_tour,
        ];

        // 2. Gọi Model (sử dụng tên biến rõ ràng như Controller Admin)
        $listTours = $this->modelTour->searchTours($criteria);

        // 3. Chuẩn bị các biến cho View
        $pageTitle = 'Kết quả Tìm kiếm Tour';
        $currentPage = 'tour'; // Đánh dấu tab Tour là active

        // 4. Tải View theo phong cách require_once
        // (Giả định View list-tour.php sẽ sử dụng biến $listTours)
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/client/list-tour.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Hiển thị chi tiết Tour. Route: /tour-detail?id=....
     */
    public function tourDetail()
    {
        $tourId = $_GET['id'] ?? null;
        if (!$tourId) {
            header('Location: /');
            return;
        }

        try {
            // 1. Gọi Model
            $tourDetail = $this->modelTour->getTourDetail($tourId);

            if (!$tourDetail) {
                echo "Không tìm thấy Tour.";
                return;
            }

            // 2. Chuẩn bị biến và tải View
            $pageTitle = $tourDetail['TenTour'] ?? 'Chi tiết Tour';
            $currentPage = 'tour';

            require_once __DIR__ . '/../views/layout/header.php';
            require_once __DIR__ . '/../views/client/tour-detail.php';
            require_once __DIR__ . '/../views/layout/footer.php';
        } catch (Exception $e) {
            error_log("Lỗi tải chi tiết Tour: " . $e->getMessage());
            echo "Lỗi tải chi tiết Tour. Vui lòng kiểm tra ID.";
        }
    }
}
