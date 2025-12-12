<?php

class NccBookingModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllBookings()
    {
        try {
            $sql = "SELECT b.*, t.TenTour, kh.TenKhachHang AS TenKhachHang
                    FROM booking b
                    LEFT JOIN dm_tours t ON b.ID_Tour = t.ID_Tour
                    LEFT JOIN dm_khach_hang kh ON b.ID_KhachHang = kh.ID_KhachHang
                    ORDER BY b.NgayDatTour DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getBookingById($booking_id)
    {
        try {
            $sql = "SELECT b.*, t.TenTour, kh.TenKhachHang
                FROM booking b
                LEFT JOIN dm_tours t ON b.ID_Tour = t.ID_Tour
                LEFT JOIN dm_khach_hang kh ON b.ID_KhachHang = kh.ID_KhachHang
                WHERE b.ID_Booking = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $booking_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

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
    public function getAllTours()
    {
        try {
            $sql = "SELECT * FROM dm_tours ORDER BY TenTour ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getAllCustomers()
    {
        try {
            $sql = "SELECT * FROM dm_khach_hang ORDER BY TenKhachHang ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function calculateTotal($tour_id, $so_luong_nl, $so_luong_te)
    {
        try {
            $sql = "SELECT GiaNguoiLon, GiaTreEm FROM dm_tours WHERE ID_Tour = :tour_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':tour_id' => $tour_id]);
            $tour = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$tour) return 0;
            $gia_nl = (float)$tour['GiaNguoiLon'];
            $gia_te = (float)$tour['GiaTreEm'];
            $so_nl = (int)$so_luong_nl;
            $so_te = (int)$so_luong_te;

            return ($so_nl * $gia_nl) + ($so_te * $gia_te);
        } catch (Exception $e) {
            return 0;
        }
    }
}
