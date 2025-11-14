<?php
// File: /admin/models/AdminBookingModel.php

class AdminBookingModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB(); // Giả định hàm connectDB()
    }

    /**
     * Lấy tất cả các đơn hàng (booking)
     * (Join với tour và khách hàng để lấy tên)
     */
    public function getAllBookings()
    {
        try {
            // SỬA LỖI Ở DÒNG NÀY: đổi kh.ho_ten thành kh.TenKhachHang
            $sql = "SELECT b.*, t.TenTour, kh.TenKhachHang AS TenKhachHang
                    FROM booking b
                    LEFT JOIN dm_tours t ON b.ID_Tour = t.ID_Tour
                    LEFT JOIN dm_khach_hang kh ON b.ID_KhachHang = kh.ID_KhachHang
                    ORDER BY b.NgayDatTour DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Ghi log lỗi thay vì echo
            // error_log("Lỗi lấy danh sách booking: " . $e->getMessage());
            return [];
        }
    }

    public function getBookingById($booking_id)
    {
        try {
            $sql = "SELECT b.*, t.TenTour 
                    FROM booking b 
                    LEFT JOIN dm_tours t ON b.ID_Tour = t.ID_Tour
                    WHERE b.ID_Booking = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $booking_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Lấy danh sách khách theo ID Booking
     */
    public function getGuestsByBookingID($booking_id)
    {
        try {
            $sql = "SELECT * FROM chi_tiet_khach WHERE ID_Booking = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $booking_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Thêm khách mới vào bảng chi_tiet_khach
     */
    public function addGuest($data)
    {
        try {
            $sql = "INSERT INTO chi_tiet_khach 
                        (ID_Booking, TenNguoiDi, GioiTinh, NgaySinh, LienHe, CCCD_Passport, GhiChu)
                    VALUES 
                        (:ID_Booking, :TenNguoiDi, :GioiTinh, :NgaySinh, :LienHe, :CCCD_Passport, :GhiChu)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Xóa 1 khách khỏi đoàn
     */
    public function deleteGuest($guest_id)
    {
        try {
            $sql = "DELETE FROM chi_tiet_khach WHERE ID_ChiTiet = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $guest_id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function updateCheckinStatus($guest_id, $status)
    {
        try {
            $sql = "UPDATE chi_tiet_khach 
                    SET TrangThaiCheckin = :status 
                    WHERE ID_ChiTiet = :guest_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':status' => $status,
                ':guest_id' => $guest_id
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
