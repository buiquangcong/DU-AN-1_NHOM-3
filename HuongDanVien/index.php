<?php
session_start();

// =========================================================================
// 1. CẤU HÌNH & HÀM CHUNG
// =========================================================================
// Đi ngược ra 1 cấp thư mục để lấy file trong commons
require_once '../commons/env.php';
require_once '../commons/function.php';

// =========================================================================
// 2. REQUIRE CONTROLLERS & MODELS
// =========================================================================

// --- AUTH & ACCOUNT ---
require_once './controllers/HdvTaiKhoanController.php';
require_once './models/HdvTaiKhoan.php';

// --- TOUR & BOOKING ---
require_once './controllers/HdvTourController.php';
require_once './controllers/HdvQuanLyTourController.php';
require_once './models/HdvQuanLyTour.php';
require_once './controllers/HdvBookingController.php';
require_once './models/HdvBookingModel.php';
require_once './models/AdminLichTrinhModel.php';
require_once './controllers/AdminLichTrinhController.php';
// --- NHÀ CUNG CẤP ---
require_once './controllers/HdvQuanLyNhaCungCapController.php';
require_once './models/HdvNhaCungCap.php';

// --- DANH MỤC ---
require_once './controllers/HdvdanhmucController.php';
require_once './models/HdvDanhMuc.php';


// =========================================================================
// 3. ĐIỀU HƯỚNG (ROUTING)
// =========================================================================

$act = $_GET['act'] ?? 'login-hdv';

match ($act) {
    // ===================================================
    // DASHBOARD
    // ===================================================
    'login-hdv'                 => (new HdvTaiKhoanController())->formLogin(),
    'dashboard'         => (new HdvTourController())->dashboard(),

    // ===================================================
    // AUTH (ĐĂNG NHẬP / ĐĂNG XUẤT / ĐĂNG KÝ)
    // ===================================================
    'check-login-hdv'   => (new HdvTaiKhoanController())->login(),
    'logout-hdv'        => (new HdvTaiKhoanController())->logout(),
    // 'signup-hdv'        => (new HdvTaiKhoanController())->formSignup(),
    // 'post-signup-hdv'   => (new HdvTaiKhoanController())->postSignup(),

    // ===================================================
    // QUẢN LÝ TOUR
    // ===================================================
    'list-tours'        => (new HdvQuanLyTourController())->danhSachTour(),
    'add-tour'          => (new HdvQuanLyTourController())->formAddTour(),
    'save-add-tour'     => (new HdvQuanLyTourController())->postAddTour(),
    'edit-tour'         => (new HdvQuanLyTourController())->formEditTour($_GET['id'] ?? 0),
    'save-edit-tour'    => (new HdvQuanLyTourController())->postEditTour(),
    'delete-tour'       => (new HdvQuanLyTourController())->deleteTour($_GET['id'] ?? 0),

    // Lịch trình & NCC trong Tour
    'manage-itinerary'          => (new HdvQuanLyTourController())->manageItinerary(),
    'add-itinerary-item'        => (new HdvQuanLyTourController())->addItineraryItem(),
    'delete-itinerary-item'     => (new HdvQuanLyTourController())->deleteItineraryItem(),
    'edit-itinerary-item'       => (new HdvQuanLyTourController())->formEditItineraryItem(),
    'post-edit-itinerary-item'  => (new HdvQuanLyTourController())->postEditItineraryItem(),

    'manage-suppliers'          => (new HdvQuanLyTourController())->manageSuppliers(),
    'link-supplier-to-tour'     => (new HdvQuanLyTourController())->linkSupplierToTour(),
    'unlink-supplier'           => (new HdvQuanLyTourController())->unlinkSupplier(),

    // ===================================================
    // QUẢN LÝ DANH MỤC
    // ===================================================
    'list-danhmuc'      => (new HdvdanhmucController())->danhsachDanhMuc(),
    'add-danhmuc'       => (new HdvdanhmucController())->postAddDanhMuc(), // Lưu ý: check lại Controller xem hàm này render form hay submit
    'post-add-danhmuc'  => (new HdvdanhmucController())->postAddDanhMuc(),
    'edit-danhmuc'      => (new HdvdanhmucController())->formEditDanhMuc($_GET['id'] ?? 0),
    'post-edit-danhmuc' => (new HdvdanhmucController())->postEditDanhMuc(),

    // ===================================================
    // QUẢN LÝ TÀI KHOẢN (NHÂN SỰ / KHÁCH)
    // ===================================================
    'list-tai-khoan'    => (new HdvTaiKhoanController())->danhSachTaiKhoan(),
    'add-tai-khoan'     => (new HdvTaiKhoanController())->addTaiKhoan(),      // Form thêm
    'post-add-tai-khoan' => (new HdvTaiKhoanController())->postAddTaiKhoan(),  // Xử lý thêm

    // ===================================================
    // QUẢN LÝ NHÀ CUNG CẤP (CRUD)
    // ===================================================
    'list-nhacungcap'   => (new HdvQuanLyNhaCungCapController())->index(),
    'detail-nhacungcap' => (new HdvQuanLyNhaCungCapController())->detail(),
    // 'add-nhacungcap' => (new HdvQuanLyNhaCungCapController())->add(), ... (Mở nếu cần)

    // ===================================================
    // QUẢN LÝ BOOKING
    // ===================================================
    'quan-ly-booking'   => (new HdvBookingController())->danhSachBooking(),
    'add-booking'       => (new HdvBookingController())->addBooking(),
    'chi-tiet-booking'  => (new HdvBookingController())->chiTietBooking(),
    'list-checkin-lich-trinh' => (new AdminLichTrinhController())->listCheckinLichTrinh(),
    'process-checkin-lich-trinh' => (new AdminLichTrinhController())->processCheckinLichTrinh(),

    // Khách hàng trong Booking
    'manage-guests'     => (new HdvBookingController())->manageGuests(),
    'add-guest'         => (new HdvBookingController())->addGuest(),
    'delete-guest'      => (new HdvBookingController())->deleteGuest(),
    'update-checkin'    => (new HdvBookingController())->updateCheckinStatus(),
    'bulk-update-checkin' => (new HdvBookingController())->bulkUpdateCheckinStatus(),
    'import-excel-guests' => (new HdvBookingController())->importExcelGuests(),

    // ===================================================
    // MẶC ĐỊNH (404)
    // ===================================================
    default => (new HdvTourController())->dashboard(),
};
