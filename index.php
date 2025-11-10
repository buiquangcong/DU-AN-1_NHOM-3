<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

// 1. Tải file routes
$routes = require_once 'routes.php';

// 2. Lấy route từ URL
// Chúng ta sẽ dùng một tham số ?route=...
// Ví dụ: index.php?route=/admin/tours
$route = $_GET['route'] ?? '/'; // Mặc định là trang chủ

// 3. Tìm route trong mảng $routes
if (array_key_exists($route, $routes)) {
    $controllerName = $routes[$route][0]; // Ví dụ: 'TourController'
    $actionName = $routes[$route][1];     // Ví dụ: 'adminDanhSachTour'

    // 4. Tải và gọi Controller
    $controllerFile = 'controllers/' . $controllerName . '.php';
    if (file_exists($controllerFile)) {
        require_once $controllerFile;

        if (class_exists($controllerName)) {
            $controller = new $controllerName();

            if (method_exists($controller, $actionName)) {
                // 5. Gọi hàm (action) để xử lý
                $controller->$actionName();
            } else {
                die("Lỗi: Không tìm thấy action '{$actionName}'");
            }
        } else {
            die("Lỗi: Không tìm thấy class '{$controllerName}'");
        }
    } else {
        die("Lỗi: Không tìm thấy file controller '{$controllerFile}'");
    }
} else {
    // 404 Not Found
    die("Lỗi 404: Không tìm thấy trang cho route '{$route}'");
}
