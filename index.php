<?php
// File: /index.php (Nằm ngoài cùng, ngang hàng với admin, HuongDanVien, KhachHang)
session_start();

/**
 * CẤU HÌNH ROLE ID
 * Bạn hãy sửa các số này khớp với Database của bạn (bảng roles/users)
 */
define('ROLE_ADMIN', 1);       // Ví dụ: 1 là Admin
define('ROLE_HDV', 2);         // Ví dụ: 2 là Hướng dẫn viên
define('ROLE_KHACH', 3);       // Ví dụ: 3 là Khách hàng (hoặc user thường)

// Lấy thông tin user từ session (nếu đã đăng nhập)
// Giả sử khi login bạn lưu: $_SESSION['user'] = ['id'=>..., 'role_id'=>...];
$user = $_SESSION['user'] ?? null;

// =========================================================================
// LOGIC ĐIỀU HƯỚNG
// =========================================================================

if ($user) {
    // 1. NGƯỜI DÙNG ĐÃ ĐĂNG NHẬP
    $role = $user['role_id'] ?? 0; // Lấy role_id, nếu ko có thì bằng 0

    switch ($role) {
        // --- ADMIN ---
        case ROLE_ADMIN:
            header("Location: ./admin/");
            exit();

            // --- HƯỚNG DẪN VIÊN ---
        case ROLE_HDV:
            // Tên thư mục trong ảnh của bạn là "HuongDanVien" (viết hoa H, D, V)
            header("Location: ./HuongDanVien/");
            exit();

            // --- KHÁCH HÀNG / NCC / KHÁC ---
        default:
            // Khách hàng đăng nhập rồi thì vẫn vào trang KhachHang để xem/đặt tour
            header("Location: ./KhachHang/");
            exit();
    }
} else {
    // 2. KHÁCH VÃNG LAI (CHƯA ĐĂNG NHẬP)
    // Chuyển ngay vào thư mục KhachHang để họ xem trang chủ và form login
    header("Location: ./KhachHang/");
    exit();
}
