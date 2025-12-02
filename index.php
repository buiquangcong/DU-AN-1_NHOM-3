<?php
// File: /DU-AN-1_NHOM-3/index.php
session_start();

// === 1. TẢI FILE CONTROLLER ===
// Dựa trên cấu trúc của bạn, chúng ta tải các Controller ở thư mục /controllers/
require_once './controllers/TourController.php';
require_once './controllers/CategoryController.php';

// (!!) Ghi chú: Khi nào bạn tạo thêm các Controller khác (như User, Booking)
// trong thư mục /controllers/, bạn hãy thêm chúng vào đây.
// Ví dụ:
// require_once './controllers/UserController.php';
// require_once './controllers/BookingController.php';

// (!!) Ghi chú: Các file Model (ví dụ: Tour.php) sẽ được gọi
// bên TRONG file Controller (ví dụ: TourController.php), không cần gọi ở index.php.


// === 2. ROUTER (BỘ ĐỊNH TUYẾN) ===

// Lấy tham số 'act' từ URL, nếu không có thì mặc định là '/' (trang chủ)
$act = $_GET['act'] ?? '/';

// Dùng match để gọi hàm Controller tương ứng
// File này chỉ xử lý các route của KHÁCH HÀNG (public)
match ($act) {
    // === Routes cho Tour (TourController) ===
    '/'                 => (new TourController())->trangChu(),
    'tour-chi-tiet'     => (new TourController())->chiTietTour(),
    'gioi-thieu'        => (new TourController())->trangGioiThieu(),

    // === Routes cho Đăng nhập/Đăng xuất (UserController) ===
    // (Hãy mở comment này khi bạn đã tạo file UserController.php)
    // 'login'             => (new UserController())->showLogin(),
    // 'login-submit'      => (new UserController())->handleLogin(),
    // 'logout'            => (new UserController())->handleLogout(),

    // === Routes cho Đặt tour (BookingController) ===
    // (Hãy mở comment này khi bạn đã tạo file BookingController.php)
    // 'dat-tour'          => (new BookingController())->datTour(),
    // 'dat-tour-submit'   => (new BookingController())->handleDatTour(),
    // 'lich-su-dat-tour'  => (new BookingController())->lichSuDatTour(),

    // === Route mặc định (404 Not Found) ===
    default => (new TourController())->e404(), // Bạn cần tạo hàm e404() trong TourController
};

/*
 * ====================================================================
 * GHI CHÚ VỀ THƯ MỤC /admin CỦA BẠN
 * ====================================================================
 * * Cấu trúc file của bạn có một thư mục /admin riêng biệt (chứa controllers, models, views riêng).
 * Đây là cách làm RẤT TỐT để tách biệt hệ thống quản trị và trang khách hàng.
 * * Vì vậy, file index.php GỐC này sẽ KHÔNG xử lý các route của admin.
 * * Khi người dùng truy cập: localhost/DU-AN-1_NHOM-3/admin/
 * -> Máy chủ sẽ tự động gọi file index.php (hoặc file khác) NẰM TRONG thư mục /admin.
 * * Bạn sẽ cần tạo một file index.php VÀ một router khác NẰM TRONG thư mục /admin
 * để xử lý các route admin (ví dụ: 'admin/tours', 'admin/bookings',...).
 * ====================================================================
 */