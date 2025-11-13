<?php
// Kết nối database
require_once '../config/database.php';

// Lấy controller và action từ URL
$controller = $_GET['controller'] ?? 'tour';
$action = $_GET['action'] ?? 'danhSach';

switch ($controller) {
    case 'category':
        require_once '../controllers/CategoryController.php';
        $ctrl = new CategoryController($conn); // ✅ truyền kết nối DB
        break;

    case 'staff':
        require_once '../controllers/StaffController.php';
        $ctrl = new StaffController($conn); // ✅ truyền kết nối DB
        break;

    case 'tour':
    default:
        require_once '../controllers/TourController.php';
        $ctrl = new TourController($conn); // ✅ truyền kết nối DB
        break;
}

// Gọi action tương ứng
if (method_exists($ctrl, $action)) {
    if (isset($_GET['id'])) {
        $ctrl->$action($_GET['id']);
    } else {
        $ctrl->$action();
    }
} else {
    echo "❌ Không tìm thấy action: $action trong controller $controller";
}
