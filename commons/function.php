<!-- <?php
// File: commors/function.php

        /**
         * Include file env.php để lấy các hằng số kết nối DB
         */
        // require_once __DIR__ . '/env.php';

        // /**
        //  * Hàm tạo kết nối PDO
        //  * Chỉ khai báo nếu chưa tồn tại
        //  */
        // if (!function_exists('pdo_get_connection')) {
        //     function pdo_get_connection() {
        //         $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        //         $username = DB_USERNAME;
        //         $password = DB_PASSWORD;

        //         try {
        //             $conn = new PDO($dsn, $username, $password);
        //             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //             return $conn;
        //         } catch (PDOException $e) {
        //             throw new Exception("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
        //         }
        //     }
        // }

        // /**
        //  * Thực thi INSERT, UPDATE, DELETE
        //  */
        // if (!function_exists('pdo_execute')) {
        //     function pdo_execute($sql, ...$args) {
        //         try {
        //             $conn = pdo_get_connection();
        //             $stmt = $conn->prepare($sql);
        //             $stmt->execute($args);
        //         } catch (PDOException $e) {
        //             throw new Exception("Lỗi thực thi SQL: " . $e->getMessage());
        //         } finally {
        //             $conn = null;
        //         }
        //     }
        // }

        // /**
        //  * SELECT nhiều dòng
        //  */
        // if (!function_exists('pdo_query')) {
        //     function pdo_query($sql, ...$args) {
        //         try {
        //             $conn = pdo_get_connection();
        //             $stmt = $conn->prepare($sql);
        //             $stmt->execute($args);
        //             return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //         } catch (PDOException $e) {
        //             throw new Exception("Lỗi truy vấn SQL: " . $e->getMessage());
        //         } finally {
        //             $conn = null;
        //         }
        //     }
        // }

        // /**
        //  * SELECT 1 dòng
        //  */
        // if (!function_exists('pdo_query_one')) {
        //     function pdo_query_one($sql, ...$args) {
        //         try {
        //             $conn = pdo_get_connection();
        //             $stmt = $conn->prepare($sql);
        //             $stmt->execute($args);
        //             return $stmt->fetch(PDO::FETCH_ASSOC);
        //         } catch (PDOException $e) {
        //             throw new Exception("Lỗi truy vấn SQL (one row): " . $e->getMessage());
        //         } finally {
        //             $conn = null;
        //         }
        //     }
        // }
        ?> -->
<?php
// File: commons/functions.php

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
