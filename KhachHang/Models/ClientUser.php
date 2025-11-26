<?php

class ClientUser
{
    protected $db;

    /**
     * Khởi tạo Model với kết nối cơ sở dữ liệu.
     * @param PDO|null $dbConnection Đối tượng kết nối PDO.
     */
    public function __construct($dbConnection)
    {
        // Trong môi trường thực tế, $dbConnection sẽ là đối tượng PDO hoặc ORM instance
        $this->db = $dbConnection;
    }

    /**
     * Tìm người dùng (Khách hàng) bằng Email để xác thực đăng nhập.
     * * @param string $email
     * @return array|null Thông tin người dùng hoặc null nếu không tìm thấy.
     */
    public function getUserByEmail($email)
    {
        // Lấy các trường cần thiết cho quá trình Đăng nhập và Session
        $sql = "SELECT ID_KhachHang, TenKhachHang, Email, MatKhau 
                FROM dm_khach_hang 
                WHERE Email = :email";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);

        // Trả về một mảng kết quả
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy toàn bộ thông tin Hồ sơ của Khách hàng bằng ID.
     * * @param int $userId ID_KhachHang của người dùng.
     * @return array|null Thông tin hồ sơ.
     */
    public function getUserProfileById($userId)
    {
        // Lấy tất cả thông tin hồ sơ để hiển thị trên trang Profile
        $sql = "SELECT ID_KhachHang, TenKhachHang, Email, NgaySinh, CCCD_Passport
                FROM dm_khach_hang 
                WHERE ID_KhachHang = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo tài khoản Khách hàng mới (Đăng ký).
     * * @param array $data Thông tin đăng ký (name, email, password)
     * @return bool
     */
    public function createNewUser($data)
    {
        // Lưu ý: Cần đảm bảo mật khẩu đã được HASH an toàn trong Controller 
        // trước khi truyền vào đây nếu bạn muốn bảo mật.

        $sql = "INSERT INTO dm_khach_hang (TenKhachHang, Email, MatKhau) 
                VALUES (:name, :email, :password)";

        $stmt = $this->db->prepare($sql);

        // Giả sử $data['password'] đã là mật khẩu đã được xử lý (hash/plain)
        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $data['password']
        ]);
    }

    /**
     * Cập nhật thông tin hồ sơ của Khách hàng.
     * * @param int $userId ID_KhachHang.
     * @param array $data Dữ liệu cần cập nhật (Tên, Ngày sinh, CCCD...).
     * @return bool
     */
    public function updateProfile($userId, $data)
    {
        $sql = "UPDATE dm_khach_hang SET 
                    TenKhachHang = :name, 
                    NgaySinh = :ngaysinh, 
                    CCCD_Passport = :cccd 
                WHERE ID_KhachHang = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $data['name'],
            ':ngaysinh' => $data['ngay_sinh'] ?? null,
            ':cccd' => $data['cccd'] ?? null,
            ':id' => $userId
        ]);
    }
}
