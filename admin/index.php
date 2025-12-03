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
require_once __DIR__ . '/controllers/AdminTourController.php';

require_once __DIR__ . '/controllers/AdminQuanLyTourController.php';
require_once __DIR__ . '/models/AdminQuanLyTour.php';
require_once __DIR__ . '/controllers/AdminBookingController.php';
require_once __DIR__ . '/models/AdminBookingModel.php';
// --- BỔ SUNG LỊCH TRÌNH VÀ ĐIỂM DANH ---
require_once __DIR__ . '/controllers/AdminLichTrinhController.php';
require_once __DIR__ . '/models/AdminLichTrinhModel.php';
require_once __DIR__ . '/controllers/AdminQuanLyNhaCungCapController.php';
require_once __DIR__ . '/models/AdminNhaCungCap.php';
require_once __DIR__ . '/models/AdminDichVu.php';
// ================== REQUIRE TÀI KHOẢN ==================
require_once './models/AdminTaiKhoan.php';
require_once './controllers/AdminTaiKhoanController.php';


// DANH MỤC
require_once __DIR__ . '/controllers/AdmindanhmucController.php';
require_once __DIR__ . '/models/AdminDanhMuc.php';

$act = $_GET['act'] ?? 'login-admin';

match ($act) {
    // --- TOUR ---
    '/'     => (new AdminTourController())->dashboard(),
    'list-tours'      => (new AdminQuanLyTourController())->danhSachTour(),
    'add-tour'        => (new AdminQuanLyTourController())->formAddTour(),
    'save-add-tour'   => (new AdminQuanLyTourController())->postAddTour(),
    'edit-tour'       => (new AdminQuanLyTourController())->formEditTour($_GET['id'] ?? 0),
    'save-edit-tour'  => (new AdminQuanLyTourController())->postEditTour(),
    'delete-tour'     => (new AdminQuanLyTourController())->deleteTour($_GET['id'] ?? 0),
    'tour-detail'       => (new AdminQuanLyTourController())->tourDetailOverview(),
    'history-tours' => (new AdminQuanLyTourController())->historyTours(),
    'history-detail' => (new AdminQuanLyTourController())->historyDetail(),

    // --- DANH MỤC ---
    'list-danhmuc'      => (new AdmindanhmucController())->danhsachDanhMuc(),
    'add-danhmuc'       => (new AdmindanhmucController())->postAddDanhMuc(),
    'post-add-danhmuc'  => (new AdmindanhmucController())->postAddDanhMuc(),
    'edit-danhmuc'      => (new AdmindanhmucController())->formEditDanhMuc($_GET['id']),
    'post-edit-danhmuc' => (new AdmindanhmucController())->postEditDanhMuc(),
    'delete-danhmuc'    => (new AdmindanhmucController())->deleteDanhMuc($_GET['id']),


    // ===== NHÂN SỰ =====
    'list-tai-khoan'     => (new AdminTaiKhoanController())->danhSachTaiKhoan(),
    'add-tai-khoan'      => (new AdminTaiKhoanController())->AddTaiKhoan(),       // Hiển thị form
    'post-add-tai-khoan' => (new AdminTaiKhoanController())->postAddAdmin(),       // Xử lý khi submit form
    'edit-tai-khoan'     => (new AdminTaiKhoanController())->editTaiKhoan($_GET['id'] ?? 0),
    // 'delete-tai-khoan'   => (new AdminTaiKhoanController())->delete(),
    // 'detail-tai-khoan'   => (new AdminTaiKhoanController())->detail(),

    // ===== NHÀ CUNG CẤP =====
    'list-nhacungcap'   => (new AdminQuanLyNhaCungCapController())->index(),
    'add-nhacungcap'    => (new AdminQuanLyNhaCungCapController())->add(),
    'edit-nhacungcap'   => (new AdminQuanLyNhaCungCapController())->edit(),
    'post-edit-nhacungcap' => (new AdminQuanLyNhaCungCapController())->edit(),
    'delete-nhacungcap' => (new AdminQuanLyNhaCungCapController())->delete(),
    'detail-nhacungcap' => (new AdminQuanLyNhaCungCapController())->detail(),


    'manage-itinerary'      => (new AdminQuanLyTourController())->manageItinerary(),
    'add-itinerary-item'    => (new AdminQuanLyTourController())->addItineraryItem(),
    'delete-itinerary-item' => (new AdminQuanLyTourController())->deleteItineraryItem(),
    'edit-itinerary-item'     => (new AdminQuanLyTourController())->formEditItineraryItem(),
    'post-edit-itinerary-item' => (new AdminQuanLyTourController())->postEditItineraryItem(),

    'manage-suppliers'      => (new AdminQuanLyTourController())->manageSuppliers(),
    'link-supplier-to-tour' => (new AdminQuanLyTourController())->linkSupplierToTour(),
    'unlink-supplier'       => (new AdminQuanLyTourController())->unlinkSupplier(),


    // ... (Các route tour của bạn)
    'unlink-supplier' => (new AdminQuanLyTourController())->unlinkSupplier(),


    'quan-ly-booking' => (new AdminBookingController())->danhSachBooking(),
    'manage-guests'   => (new AdminBookingController())->manageGuests(),
    'add-guest'       => (new AdminBookingController())->addGuest(),
    'delete-guest'    => (new AdminBookingController())->deleteGuest(),
    'update-checkin'  => (new AdminBookingController())->updateCheckinStatus(),
    'add-guest'       => (new AdminBookingController())->addGuest(),
    'delete-guest'    => (new AdminBookingController())->deleteGuest(),
    'bulk-update-checkin'  => (new AdminBookingController())->bulkUpdateCheckinStatus(),
    'import-excel-guests' => (new AdminBookingController())->importExcelGuests(),
    'edit-booking' => (new AdminBookingController())->editBooking(),
    'delete-booking' => (new AdminBookingController())->deleteBooking(),
    //Booking
    'chi-tiet-booking' => (new AdminBookingController())->chiTietBooking(),
    'cap-nhat-hdv' => (new AdminBookingController())->assignGuide(),
    'add-booking' => (new AdminBookingController())->addBooking(),
    'list-checkin-lich-trinh' => (new AdminLichTrinhController())->listCheckinLichTrinh(),
    'process-checkin-lich-trinh' => (new AdminLichTrinhController())->processCheckinLichTrinh(),
    // ===============================================


    // ===== TÀI KHOẢN ADMIN =====
    // 1. Đăng nhập - Đăng xuất
    'login-admin'       => (new AdminTaiKhoanController())->formLogin(),
    'check-login-admin' => (new AdminTaiKhoanController())->login(),
    'logout-admin'      => (new AdminTaiKhoanController())->logout(),
    'signup-admin'      => (new AdminTaiKhoanController())->formSignup(),
    'post-signup-admin' => (new AdminTaiKhoanController())->postSignup(),

    // 2. Quản lý tài khoản
    'list-tai-khoan'    => (new AdminTaiKhoanController())->danhSachTaiKhoan(),
    'add-tai-khoan'     => (new AdminTaiKhoanController())->postAddAdmin(),

    default => (new AdminTourController())->dashboard(),
};
