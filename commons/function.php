<?php
// Kết nối file env để lấy cấu hình DB và PATH_ROOT
require_once __DIR__ . '/env.php';

// =========================================================================
// 1. KẾT NỐI DATABASE (Core)
// =========================================================================

/**
 * Kết nối cơ sở dữ liệu qua PDO
 */
function connectDB(): PDO|null
{
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8";
        $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD);

        // Cài đặt chế độ lỗi và fetch mode mặc định
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $conn;
    } catch (PDOException $e) {
        die("❌ Lỗi kết nối CSDL: " . $e->getMessage());
    }
}

// =========================================================================
// 2. CÁC HÀM THỰC THI SQL (Giúp viết Model nhanh hơn)
// =========================================================================

/**
 * Thực thi câu lệnh SELECT lấy NHIỀU dòng
 * Dùng cho: Danh sách tour, danh sách user...
 */
function pdo_query(string $sql, array $args = []): array
{
    try {
        $conn = connectDB();
        $stmt = $conn->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Lỗi truy vấn: " . $e->getMessage());
    } finally {
        unset($conn); // Đóng kết nối
    }
}

/**
 * Thực thi câu lệnh SELECT lấy 1 dòng
 * Dùng cho: Chi tiết tour, Xem thông tin 1 user, Login...
 */
function pdo_query_one(string $sql, array $args = []): array|false
{
    try {
        $conn = connectDB();
        $stmt = $conn->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetch();
    } catch (PDOException $e) {
        die("Lỗi truy vấn one: " . $e->getMessage());
    } finally {
        unset($conn);
    }
}

/**
 * Thực thi INSERT, UPDATE, DELETE
 * Dùng cho: Thêm tour, sửa tour, xóa tour...
 */
function pdo_execute(string $sql, array $args = []): void
{
    try {
        $conn = connectDB();
        $stmt = $conn->prepare($sql);
        $stmt->execute($args);
    } catch (PDOException $e) {
        die("Lỗi thực thi: " . $e->getMessage());
    } finally {
        unset($conn);
    }
}

function deleteSessionError(): void
{
    if (isset($_SESSION['flash'])) {
        unset($_SESSION['flash']);
        unset($_SESSION['errors']);
        unset($_SESSION['error']); // Xóa cả biến lỗi số ít (nếu có dùng)
        unset($_SESSION['old_data']); // Xóa dữ liệu form cũ
    }
}

// =========================================================================
// 3. TIỆN ÍCH FILE & SESSION
// =========================================================================

/**
 * Upload file
 * @param array $file $_FILES['...']
 * @param string $folderUpload Thư mục lưu (VD: 'uploads/tours/')
 */
function uploadFile(array $file, string $folderUpload): ?string
{
    // Kiểm tra nếu không có file upload hoặc có lỗi
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    // Đặt tên file mới để tránh trùng: time_tenfile
    $pathStorage = $folderUpload . time() . '_' . basename($file['name']);

    // Lưu ý: PATH_ROOT phải được define trong env.php
    $from = $file['tmp_name'];
    $to = PATH_ROOT . $pathStorage;

    if (move_uploaded_file($from, $to)) {
        return $pathStorage; // Trả về đường dẫn để lưu vào DB
    }
    return null;
}

/**
 * Xóa file vật lý
 */
function deleteFile(?string $file): void
{
    if (!$file) return; // Nếu file rỗng thì bỏ qua

    $pathDelete = PATH_ROOT . $file;
    if (file_exists($pathDelete)) {
        unlink($pathDelete);
    }
}

/**
 * Format ngày (View Helper)
 */
function formatDate(string $date): string
{
    return date("d-m-Y", strtotime($date));
}

// =========================================================================
// 4. KIỂM TRA ĐĂNG NHẬP & PHÂN QUYỀN (Middleware)
// =========================================================================

/**
 * Kiểm tra xem có phải ADMIN không?
 * Dùng ở đầu các file Controller trong thư mục /admin
 */
function checkLoginAdmin(): void
{
    // Kiểm tra có session user không VÀ role_id có phải là 1 (Admin) không
    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {

        // Nếu không phải Admin -> Đá về trang login hoặc trang chủ
        // Lưu ý đường dẫn '..' để ra khỏi thư mục admin
        header("Location: ../index.php?act=login");
        exit();
    }
}

/**
 * Kiểm tra xem có phải HƯỚNG DẪN VIÊN không?
 */
function checkLoginHDV(): void
{
    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 2) {
        header("Location: ../index.php?act=login");
        exit();
    }
}
