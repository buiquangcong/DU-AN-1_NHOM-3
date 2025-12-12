<?php

require_once __DIR__ . '/../vendor/autoload.php';
// ===== HIỂN THỊ LỖI =====
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

// ===================== REQUIRE CONTROLLERS & MODELS =====================

// TOUR
require_once __DIR__ . '/controllers/NccTourController.php';

require_once __DIR__ . '/controllers/NccQuanLyTourController.php';
require_once __DIR__ . '/models/NccQuanLyTour.php';
require_once __DIR__ . '/controllers/NccBookingController.php';
require_once __DIR__ . '/models/NccBookingModel.php';

require_once __DIR__ . '/controllers/NccNhaCungCapController.php';
require_once __DIR__ . '/models/NccNhaCungCap.php';

// ================== REQUIRE TÀI KHOẢN ==================
require_once './models/NccTaiKhoan.php';
require_once './controllers/NccTaiKhoanController.php';


// DANH MỤC
require_once __DIR__ . '/controllers/NccdanhmucController.php';
require_once __DIR__ . '/models/NccDanhMuc.php';

$act = $_GET['act'] ?? 'login-admin';

match ($act) {
    // --- TOUR ---
    '/'     => (new NccTourController())->dashboard(),
    'list-tours'      => (new NccQuanLyTourController())->danhSachTour(),
    // 'add-tour'        => (new NccQuanLyTourController())->formAddTour(),
    // 'save-add-tour'   => (new NccQuanLyTourController())->postAddTour(),
    // 'edit-tour'       => (new NccQuanLyTourController())->formEditTour($_GET['id'] ?? 0),
    // 'save-edit-tour'  => (new NccQuanLyTourController())->postEditTour(),
    // 'delete-tour'     => (new NccQuanLyTourController())->deleteTour($_GET['id'] ?? 0),

    // --- DANH MỤC ---
    'list-danhmuc'      => (new NccdanhmucController())->danhsachDanhMuc(),
    // 'add-danhmuc'       => (new NccdanhmucController())->postAddDanhMuc(),
    // 'post-add-danhmuc'  => (new NccdanhmucController())->postAddDanhMuc(),
    // 'edit-danhmuc'      => (new NccdanhmucController())->formEditDanhMuc($_GET['id']),
    // 'post-edit-danhmuc' => (new NccdanhmucController())->postEditDanhMuc(),
    // 'delete-danhmuc'    => (new NccdanhmucController())->deleteDanhMuc($_GET['id']),


    // ===== NHÂN SỰ =====
    // 'list-tai-khoan'     => (new NccTaiKhoanController())->danhSachTaiKhoan(),
    // 'add-tai-khoan'      => (new NccTaiKhoanController())->AddTaiKhoan(),       // Hiển thị form
    // 'post-add-tai-khoan' => (new NccTaiKhoanController())->postAddTaiKhoan(),       // Xử lý khi submit form
    // 'edit-tai-khoan'     => (new NccTaiKhoanController())->formEditTaiKhoan($_GET['id'] ?? 0),
    // 'post-edit-tai-khoan' => (new NccTaiKhoanController())->postEditTaiKhoan(),
    // 'delete-tai-khoan'   => (new NccTaiKhoanController())->delete(),
    // 'detail-tai-khoan'   => (new NccTaiKhoanController())->detail(),

    // ===== NHÀ CUNG CẤP =====
    'list-nhacungcap'   => (new NccNhaCungCapController())->index(),
    // 'add-nhacungcap'    => (new NccQuanLyNhaCungCapController())->add(),
    // 'edit-nhacungcap'   => (new NccQuanLyNhaCungCapController())->edit(),
    // 'post-edit-nhacungcap' => (new NccQuanLyNhaCungCapController())->edit(),
    // 'delete-nhacungcap' => (new NccQuanLyNhaCungCapController())->delete(),
    'detail-nhacungcap' => (new NccNhaCungCapController())->detail(),
    'ncc-tour-history'      => (new NccNhaCungCapController())->tourHistory(),
    'ncc-tour-list'      => (new NccNhaCungCapController())->DanhSach(),



    'manage-itinerary'      => (new NccQuanLyTourController())->manageItinerary(),
    // 'add-itinerary-item'    => (new NccQuanLyTourController())->addItineraryItem(),
    'delete-itinerary-item' => (new NccQuanLyTourController())->deleteItineraryItem(),
    // 'edit-itinerary-item'     => (new NccQuanLyTourController())->formEditItineraryItem(),
    // 'post-edit-itinerary-item' => (new NccQuanLyTourController())->postEditItineraryItem(),

    'manage-suppliers'      => (new NccQuanLyTourController())->manageSuppliers(),
    // 'link-supplier-to-tour' => (new NccQuanLyTourController())->linkSupplierToTour(),
    // 'unlink-supplier'       => (new NccQuanLyTourController())->unlinkSupplier(),


    // ... (Các route tour của bạn)
    // 'unlink-supplier' => (new NccQuanLyTourController())->unlinkSupplier(),

    // ===============================================
    // THÊM CÁC ROUTE BOOKING MỚI VÀO ĐÂY
    // ===============================================
    'quan-ly-booking' => (new NccBookingController())->danhSachBooking(),
    // 'manage-guests'   => (new NccBookingController())->manageGuests(),
    // 'add-guest'       => (new NccBookingController())->addGuest(),
    // 'delete-guest'    => (new NccBookingController())->deleteGuest(),
    // 'update-checkin'  => (new NccBookingController())->updateCheckinStatus(),
    // 'add-guest'       => (new NccBookingController())->addGuest(),
    // 'delete-guest'    => (new NccBookingController())->deleteGuest(),
    // 'bulk-update-checkin'  => (new NccBookingController())->bulkUpdateCheckinStatus(),
    // 'import-excel-guests' => (new NccBookingController())->importExcelGuests(),

    //Booking
    'chi-tiet-booking' => (new NccBookingController())->chiTietBooking(),
    // 'add-booking' => (new NccBookingController())->addBooking(),

    // ===============================================


    // ===== TÀI KHOẢN ADMIN =====
    // 1. Đăng nhập - Đăng xuất
    'login-admin'       => (new NccTaiKhoanController())->formLogin(),
    'check-login-admin' => (new NccTaiKhoanController())->login(),
    'logout-admin'      => (new NccTaiKhoanController())->logout(),
    // 'signup-admin'      => (new NccTaiKhoanController())->formSignup(),
    // 'post-signup-admin' => (new NccTaiKhoanController())->postSignup(),

    // 2. Quản lý tài khoản
    // 'list-tai-khoan'    => (new NccTaiKhoanController())->danhSachTaiKhoan(),
    // 'add-tai-khoan'     => (new NccTaiKhoanController())->postAddAdmin(),

    default => (new NccTourController())->dashboard(),
};
