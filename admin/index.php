<?php
// ===== HIỂN THỊ LỖI =====
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// =======================

session_start();

$PROJECT_ROOT_PATH = dirname(__DIR__);

require_once $PROJECT_ROOT_PATH . '/commons/env.php';
require_once $PROJECT_ROOT_PATH . '/commons/function.php';

// ================== REQUIRE TOUR ==================
require_once __DIR__ . '/controllers/AdminTourController.php';
require_once __DIR__ . '/models/AdminTour.php';
// ================== REQUIRE TÀI KHOẢN ==================
require_once './models/AdminTaiKhoan.php';
require_once './controllers/AdminTaiKhoanController.php';


// ================== REQUIRE DANH MỤC ==================
require_once __DIR__ . '/controllers/AdmindanhmucController.php';
require_once __DIR__ . '/models/AdminDanhMuc.php';

$act = $_GET['act'] ?? 'dashboard';

match ($act) {
    // --- TOUR ---
    'dashboard'     => (new AdminTourController())->dashboard(),
    'list-tours'    => (new AdminTourController())->listTours(),
    'add-tour'      => (new AdminTourController())->showAddForm(),
    'save-add-tour' => (new AdminTourController())->saveAdd(),

    // --- DANH MỤC ---
    'list-danhmuc'      => (new AdmindanhmucController())->danhsachDanhMuc(),
    'add-danhmuc'       => (new AdmindanhmucController())->postAddDanhMuc(),
    'post-add-danhmuc'  => (new AdmindanhmucController())->postAddDanhMuc(),
    'edit-danhmuc'      => (new AdmindanhmucController())->formEditDanhMuc($_GET['id']),
    'post-edit-danhmuc' => (new AdmindanhmucController())->postEditDanhMuc(),
    'delete-danhmuc'    => (new AdmindanhmucController())->deleteDanhMuc($_GET['id']),

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
