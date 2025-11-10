<?php
// routes.php
// File này định nghĩa một mảng $routes
// 'key' là đường dẫn (route) người dùng gõ trên URL (ví dụ: ?route=...)
// 'value' là [Tên Controller, Tên hàm (action) sẽ xử lý]

return [
    // --- Routes cho Khách hàng (Public) ---
    '/' => ['TourController', 'trangChu'], // Trang chủ
    '/tour-chi-tiet' => ['TourController', 'chiTietTour'], // Trang xem chi tiết tour
    '/dat-tour' => ['BookingController', 'datTour'],   // Trang xử lý đặt tour

    // --- Routes cho Đăng nhập/Đăng xuất (Giả sử có UserController) ---
    '/login' => ['UserController', 'showLogin'],    // Hiển thị form đăng nhập
    '/login-submit' => ['UserController', 'handleLogin'],   // Xử lý đăng nhập (POST)
    '/logout' => ['UserController', 'handleLogout'],  // Xử lý đăng xuất

    // --- Routes cho Quản trị (Admin) ---
    '/admin' => ['AdminController', 'dashboard'], // Trang chủ admin (thống kê)
    '/admin/dashboard' => ['AdminController', 'dashboard'],

    // Quản lý Tour (CRUD)
    '/admin/tours' => ['TourController', 'adminDanhSachTour'],     // (R)ead - Xem danh sách
    '/admin/tours/them' => ['TourController', 'adminShowFormThem'], // (C)reate - Hiển thị form
    '/admin/tours/luu' => ['TourController', 'adminHandleThem'],    // (C)reate - Xử lý lưu (POST)
    '/admin/tours/sua' => ['TourController', 'adminShowFormSua'],   // (U)pdate - Hiển thị form
    '/admin/tours/capnhat' => ['TourController', 'adminHandleSua'],   // (U)pdate - Xử lý cập nhật (POST)
    '/admin/tours/xoa' => ['TourController', 'adminHandleXoa'],     // (D)elete - Xử lý xóa

    // Quản lý Booking
    '/admin/bookings' => ['BookingController', 'adminDanhSachBooking'],
    '/admin/bookings/xac-nhan' => ['BookingController', 'adminXacNhanBooking'],
    '/admin/bookings/huy' => ['BookingController', 'adminHuyBooking'],

    // Quản lý Nhân viên/HDV
    '/admin/nhanvien' => ['UserController', 'adminDanhSachNhanVien'],

    // --- Routes cho Hướng dẫn viên (HDV) ---
    '/hdv' => ['HdvController', 'dashboard'], // Trang chủ của HDV
    '/hdv/nhiem-vu' => ['HdvController', 'xemNhiemVu'], // Xem các tour được phân công
    '/hdv/bao-cao' => ['HdvController', 'showFormBaoCao'], // Hiển thị form báo cáo chi phí
    '/hdv/bao-cao/submit' => ['HdvController', 'handleBaoCao'], // Xử lý nộp báo cáo (POST)
];
