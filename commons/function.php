
<?php
// File: commons/function.php
// require_once __DIR__ . '/env.php';


/**
 * Kết nối cơ sở dữ liệu qua PDO
 */
function connectDB(): PDO|null
{
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8";
        $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD);

        // Cài đặt chế độ lỗi và fetch mode
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $conn;
    } catch (PDOException $e) {
        // Dùng die để debug nhanh, production nên throw
        die("❌ Connection failed: " . $e->getMessage());
    }
}

/**
 * Upload file
 * @param array $file $_FILES['...']
 * @param string $folderUpload Thư mục lưu file (tính từ PATH_ROOT)
 * @return string|null Trả về đường dẫn file lưu thành công hoặc null
 */
function uploadFile(array $file, string $folderUpload): ?string
{
    $pathStorage = $folderUpload . time() . '_' . basename($file['name']);
    $from = $file['tmp_name'];
    $to = PATH_ROOT . $pathStorage;

    return move_uploaded_file($from, $to) ? $pathStorage : null;
}

/**
 * Upload nhiều file album (ví dụ: input type="file[]" multiple)
 * @param array $file $_FILES['...']
 * @param string $folderUpload Thư mục lưu file
 * @param int $key Chỉ số của file trong mảng
 * @return string|null
 */
function uploadFileAlbum(array $file, string $folderUpload, int $key): ?string
{
    $pathStorage = $folderUpload . time() . '_' . basename($file['name'][$key]);
    $from = $file['tmp_name'][$key];
    $to = PATH_ROOT . $pathStorage;

    return move_uploaded_file($from, $to) ? $pathStorage : null;
}

/**
 * Xóa file
 */
function deleteFile(string $file): void
{
    $pathDelete = PATH_ROOT . $file;
    if (file_exists($pathDelete)) {
        unlink($pathDelete);
    }
}

/**
 * Xóa session flash và errors sau khi load trang
 */
function deleteSessionError(): void
{
    if (isset($_SESSION['flash'])) {
        unset($_SESSION['flash'], $_SESSION['errors']);
    }
}

/**
 * Format ngày từ DB thành d-m-y
 */
function formatDate(string $date): string
{
    return date("d-m-y", strtotime($date));
}

/**
 * Kiểm tra login admin, nếu chưa login thì require form login
 */
function checkLoginAdmin(): void
{
    if (!isset($_SESSION['user_admin'])) {
        require_once './views/auth/formLogin.php';
        exit();
    }
}
