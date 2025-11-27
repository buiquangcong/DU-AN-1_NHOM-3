<?php

class ClientBooking
{
    protected $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    /**
     * Tạo một Booking mới.
     */
    public function createBooking($bookingData)
    {
        $sql = "INSERT INTO booking (ID_Tour, ID_KhachHang, NgayDatTour, SoLuongNguoiLon, SoLuongTreEm, TongTien, TrangThai) 
                VALUES (:tour_id, :user_id, NOW(), :sl_nl, :sl_te, :total, 0)";

        // Thay thế bằng logic insert thực tế của bạn
        // $stmt = $this->db->prepare($sql);
        // $stmt->execute([...]);
        // return $this->db->lastInsertId();

        return 12345; // ID Booking mẫu
    }

    /**
     * Lấy danh sách Booking của người dùng hiện tại (JOIN với dm_tour).
     */
    public function getUserBookings($userId)
    {
        $sql = "SELECT b.ID_Booking, t.TenTour, b.NgayDatTour, b.TrangThai 
                FROM booking b
                JOIN dm_tour t ON b.ID_Tour = t.ID_Tour
                WHERE b.ID_KhachHang = :user_id
                ORDER BY b.NgayDatTour DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy Lịch trình chi tiết của một Booking (Cần bảng dm_chi_tiet_tour).
     * Giả định bảng dm_chi_tiet_tour có liên kết đến dm_tour qua ID_Tour.
     */
    public function getItineraryByBookingId($bookingId)
    {
        $sql = "SELECT ctt.noi_dung_lich_trinh, ctt.ngay_trong_tour 
                FROM dm_chi_tiet_tour ctt
                JOIN booking b ON b.ID_Tour = ctt.ID_Tour
                WHERE b.ID_Booking = :booking_id
                ORDER BY ctt.ngay_trong_tour ASC";

        // Thay thế tên trường và logic với bảng dm_chi_tiet_tour thực tế của bạn

        // $stmt = $this->db->prepare($sql);
        // $stmt->execute([':booking_id' => $bookingId]);
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            ['ngay' => 1, 'noi_dung' => 'Đón khách tại sân bay, tham quan Phố Cổ Hội An.'],
            ['ngay' => 2, 'noi_dung' => 'Trải nghiệm du lịch sinh thái Cù Lao Chàm.'],
        ];
    }

    /**
     * Lấy Trạng thái chuyến đi.
     */
    public function getTripStatus($bookingId)
    {
        $sql = "SELECT TrangThai FROM booking WHERE ID_Booking = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $bookingId]);

        $statusId = $stmt->fetchColumn();

        $statusMap = [
            0 => 'Chờ xác nhận',
            1 => 'Đã xác nhận',
            2 => 'Đã hủy',
            // ... Thêm các trạng thái khác của bạn
        ];
        return $statusMap[$statusId] ?? 'Trạng thái không rõ';
    }
}
