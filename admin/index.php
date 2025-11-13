<?php
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
require_once __DIR__ . '/models/AdminTour.php';
require_once __DIR__ . '/controllers/AdminQuanLyTourController.php';
require_once __DIR__ . '/models/AdminQuanLyTour.php';


require_once __DIR__ . '/controllers/AdminQuanLyNhanSuController.php';
require_once __DIR__ . '/models/AdminQuanLyNhanSu.php';
require_once __DIR__ . '/controllers/AdminQuanLyNhaCungCapController.php';
require_once __DIR__ . '/models/AdminNhaCungCap.php';
// ================== REQUIRE TÀI KHOẢN ==================
require_once './models/AdminTaiKhoan.php';
require_once './controllers/AdminTaiKhoanController.php';


// DANH MỤC
require_once __DIR__ . '/controllers/AdmindanhmucController.php';
require_once __DIR__ . '/models/AdminDanhMuc.php';

$act = $_GET['act'] ?? 'dashboard';

match ($act) {
    // --- TOUR ---
    '/'     => (new AdminTourController())->dashboard(),
    'list-tours'      => (new AdminQuanLyTourController())->danhSachSanPham(),
    'add-tour'        => (new AdminQuanLyTourController())->formAddSanPham(),
    'save-add-tour'   => (new AdminQuanLyTourController())->postAddSanPham(),
    'edit-tour'       => (new AdminQuanLyTourController())->formEditSanPham($_GET['id'] ?? 0),
    'save-edit-tour'  => (new AdminQuanLyTourController())->postEditSanPham(),
    'delete-tour'     => (new AdminQuanLyTourController())->deleteSanPham($_GET['id'] ?? 0),


    // --- DANH MỤC ---
    'list-danhmuc'      => (new AdmindanhmucController())->danhsachDanhMuc(),
    'add-danhmuc'       => (new AdmindanhmucController())->postAddDanhMuc(),
    'post-add-danhmuc'  => (new AdmindanhmucController())->postAddDanhMuc(),
    'edit-danhmuc'      => (new AdmindanhmucController())->formEditDanhMuc($_GET['id']),
    'post-edit-danhmuc' => (new AdmindanhmucController())->postEditDanhMuc(),
    'delete-danhmuc'    => (new AdmindanhmucController())->deleteDanhMuc($_GET['id']),


    // ===== NHÂN SỰ =====
    'list-nhansu'     => (new AdminQuanLyNhanSuController())->index(),
    'add-nhansu'      => (new AdminQuanLyNhanSuController())->add(),       // Hiển thị form
    'post-add-nhansu' => (new AdminQuanLyNhanSuController())->add(),       // Xử lý khi submit form
    'edit-nhansu'     => (new AdminQuanLyNhanSuController())->edit(),
    'post-edit-nhansu' => (new AdminQuanLyNhanSuController())->postEditNhanSu(),
    'delete-nhansu'   => (new AdminQuanLyNhanSuController())->delete(),
    'detail-nhansu'   => (new AdminQuanLyNhanSuController())->detail(),

    // ===== NHÀ CUNG CẤP =====
    'list-nhacungcap'   => (new AdminQuanLyNhaCungCapController())->index(),
    'add-nhacungcap'    => (new AdminQuanLyNhaCungCapController())->add(),
    'edit-nhacungcap'   => (new AdminQuanLyNhaCungCapController())->edit(),
    'post-edit-nhacungcap' => (new AdminQuanLyNhaCungCapController())->edit(),
    'delete-nhacungcap' => (new AdminQuanLyNhaCungCapController())->delete(),
    'detail-nhacungcap' => (new AdminQuanLyNhaCungCapController())->detail(),

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
