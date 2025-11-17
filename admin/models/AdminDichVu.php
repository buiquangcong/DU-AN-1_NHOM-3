<?php
class AdminDichVu
{
    public $conn;

    public function __construct()
    {
        // Phải đảm bảo hàm connectDB() đã được định nghĩa ở đâu đó
        $this->conn = connectDB(); 
    }

    /**
     * Hàm lấy danh sách dịch vụ 
     */
    public function getAllDichVu()
    {
        try {
            // Đảm bảo tên cột và tên bảng khớp với CSDL
            $sql = "SELECT ID_DichVu, TenDichVu FROM dm_dich_vu"; 
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
}
?>