<?php

// ===== HIỂN THỊ LỖI (Giữ nguyên) =====
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ===================== START SESSION =====================
session_start();

// ===================== PATH =====================
$PROJECT_ROOT_PATH = dirname(__DIR__);

// ===================== REQUIRE COMMONS =====================
require_once $PROJECT_ROOT_PATH . '/commons/env.php';
require_once $PROJECT_ROOT_PATH . '/commons/function.php';

// ===================== REQUIRE CLIENT MODELS & CONTROLLERS =====================

// 1. TOUR (Tìm kiếm, Chi tiết Tour)
require_once __DIR__ . '/controllers/ClientTourController.php';
require_once __DIR__ . '/models/ClientTour.php'; // Model để lấy dữ liệu tour cho khách hàng

// 2. TÀI KHOẢN (Đăng nhập, Đăng ký, Hồ sơ)
require_once __DIR__ . '/controllers/ClientTaiKhoanController.php';
require_once __DIR__ . '/models/ClientTaiKhoan.php';

// 3. BOOKING/ĐẶT CHỖ (Đặt tour, Xem lịch trình, Theo dõi chuyến đi)
require_once __DIR__ . '/controllers/ClientBookingController.php';
require_once __DIR__ . '/models/ClientBooking.php';


// ===================== XỬ LÝ ROUTING (FRONT CONTROLLER) =====================
$act = $_GET['act'] ?? '/'; // Thiết lập route mặc định là Trang chủ ('/')

match ($act) {
    // --- 1. TRANG CHỦ & TÌM KIẾM TOUR ---
    '/'                 => (new ClientTourController())->home(), // Hiển thị trang chủ với Form tìm kiếm
    'search-tour'       => (new ClientTourController())->searchTours(), // Xử lý tìm kiếm và hiển thị kết quả
    'tour-detail'       => (new ClientTourController())->tourDetail($_GET['id'] ?? ''), // Xem chi tiết tour

    // --- 2. TÀI KHOẢN & XÁC THỰC (Đăng kí, Đăng nhập, Đăng xuất) ---
    'login'             => (new ClientTaiKhoanController())->formLogin(),
    'check-login'       => (new ClientTaiKhoanController())->login(),
    'register'          => (new ClientTaiKhoanController())->formRegister(), // Yêu cầu bạn có chức năng 'đăng kí'
    'post-register'     => (new ClientTaiKhoanController())->register(),
    'logout'            => (new ClientTaiKhoanController())->logout(),
    'profile'           => (new ClientTaiKhoanController())->userProfile(), // Trang quản lý hồ sơ

    // --- 3. CHỨC NĂNG ĐẶT TOUR (Booking) ---
    'book-tour'         => (new ClientBookingController())->formBooking($_GET['tour_id'] ?? 0), // Form điền thông tin khách hàng
    'process-booking'   => (new ClientBookingController())->processBooking(), // Xử lý thanh toán/lưu booking

    // --- 4. THEO DÕI CHUYẾN ĐI & LỊCH TRÌNH ---
    'my-bookings'       => (new ClientBookingController())->listBookings(), // Danh sách các booking của khách hàng
    'view-itinerary'    => (new ClientBookingController())->viewItinerary($_GET['booking_id'] ?? 0), // Xem lịch trình tour đã đặt
    'track-trip'        => (new ClientBookingController())->trackTripStatus($_GET['booking_id'] ?? 0), // Theo dõi trạng thái chuyến đi

    // --- 5. KHÁC ---
    // 'contact'           => (new ClientTourController())->contactPage(),
    // 'about-us'          => (new ClientTourController())->aboutPage(),

    // // --- XỬ LÝ LỖI (404) ---
    // default             => (new ClientTourController())->notFound(),
};
