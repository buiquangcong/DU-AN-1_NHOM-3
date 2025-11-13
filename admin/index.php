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
    // ================== REQUIRE TOUR ==================
require_once __DIR__ . '/controllers/AdminquanlytourController.php';
require_once __DIR__ . '/controllers/AdminTourController.php';
require_once __DIR__ . '/models/Adminquanly.php';
require_once __DIR__ . '/models/AdminTour.php';


    // ================== REQUIRE DANH MỤC ==================
    require_once __DIR__ . '/controllers/AdmindanhmucController.php';
    require_once __DIR__ . '/models/AdminDanhMuc.php';

    $act = $_GET['act'] ?? 'dashboard';

    match ($act) {
        // --- TOUR ---
    'dashboard'       => (new AdminquanlytourController())->danhSachSanPham(),
    'list-tours'      => (new AdminquanlytourController())->danhSachSanPham(),
    'add-tour'        => (new AdminquanlytourController())->formAddSanPham(),
    'save-add-tour'   => (new AdminquanlytourController())->postAddSanPham(),
    'edit-tour'       => (new AdminquanlytourController())->formEditSanPham($_GET['id'] ?? 0),
    'save-edit-tour'  => (new AdminquanlytourController())->postEditSanPham(),
    'delete-tour'     => (new AdminquanlytourController())->deleteSanPham($_GET['id'] ?? 0),

        // --- DANH MỤC ---
        'list-danhmuc'      => (new AdmindanhmucController())->danhsachDanhMuc(),
        'add-danhmuc'       => (new AdmindanhmucController())->postAddDanhMuc(),
        'post-add-danhmuc'  => (new AdmindanhmucController())->postAddDanhMuc(),
        'edit-danhmuc'      => (new AdmindanhmucController())->formEditDanhMuc($_GET['id']),
        'post-edit-danhmuc' => (new AdmindanhmucController())->postEditDanhMuc(),
        'delete-danhmuc'    => (new AdmindanhmucController())->deleteDanhMuc($_GET['id']),
        
        default => (new AdminTourController())->dashboard(),
    };
    ?>