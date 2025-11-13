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

// DANH MỤC
require_once __DIR__ . '/controllers/AdmindanhmucController.php';
require_once __DIR__ . '/models/AdminDanhMuc.php';

// NHÂN SỰ
require_once __DIR__ . '/controllers/AdminQuanLyNhanSuController.php';
require_once __DIR__ . '/models/NhanSu.php';

// NHÀ CUNG CẤP
require_once __DIR__ . '/controllers/AdminQuanLyNhaCungCapController.php';
require_once __DIR__ . '/models/NhaCungCap.php';


// ===================== KẾT NỐI DATABASE =====================
try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USERNAME,
        DB_PASSWORD
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// ===================== KHỞI TẠO CONTROLLER =====================
$tourController      = new AdminTourController($db);
$danhmucController   = new AdmindanhmucController($db);
$nhansuController    = new AdminQuanLyNhanSuController($db);
$nccController = new AdminQuanLyNhaCungCapController($db);

// ===================== ROUTER =====================
$act = $_GET['act'] ?? 'dashboard';

match ($act) {
    // ===== TOUR =====
    'dashboard'     => $tourController->dashboard(),
    'list-tours'    => $tourController->listTours(),
    'add-tour'      => $tourController->showAddForm(),
    'save-add-tour' => $tourController->saveAdd(),

    // ===== DANH MỤC =====
    'list-danhmuc'      => $danhmucController->danhsachDanhMuc(),
    'add-danhmuc'       => $danhmucController->postAddDanhMuc(),
    'post-add-danhmuc'  => $danhmucController->postAddDanhMuc(),
    'edit-danhmuc'      => $danhmucController->formEditDanhMuc($_GET['id'] ?? null),
    'post-edit-danhmuc' => $danhmucController->postEditDanhMuc(),
    'delete-danhmuc'    => $danhmucController->deleteDanhMuc($_GET['id'] ?? null),

    // ===== NHÂN SỰ =====
    'list-nhansu'     => $nhansuController->index(),
    'add-nhansu'      => $nhansuController->add(),       // Hiển thị form
    'post-add-nhansu' => $nhansuController->add(),       // Xử lý khi submit form
    'edit-nhansu'     => $nhansuController->edit(),
    'post-edit-nhansu' => $nhansuController->postEditNhanSu(),
    'delete-nhansu'   => $nhansuController->delete(),
    'detail-nhansu'   => $nhansuController->detail(),

    // ===== NHÀ CUNG CẤP =====
    'list-nhacungcap'   => $nccController->index(),
    'add-nhacungcap'    => $nccController->add(),
    'edit-nhacungcap'   => $nccController->edit(),
    'post-edit-nhacungcap' => $nccController->edit(),
    'delete-nhacungcap' => $nccController->delete(),
    'detail-nhacungcap' => $nccController->detail(),

    // ===== DEFAULT =====
    default => $tourController->dashboard(),
};
