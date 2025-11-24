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
    /**
     * Lấy tất cả Tour để dùng cho dropdown
     */
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

    /**
     * Lấy tất cả Khách hàng để dùng cho dropdown
     */
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

    /**
     * Tính tổng tiền booking theo số lượng và giá tour
     */
    public function calculateTotal($tour_id, $so_luong_nl, $so_luong_te)
    {
        try {
            $sql = "SELECT GiaNL, GiaTE FROM dm_tours WHERE ID_Tour = :tour_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':tour_id' => $tour_id]);
            $tour = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$tour) return 0;
            return ($so_luong_nl * $tour['GiaNL']) + ($so_luong_te * $tour['GiaTE']);
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Thêm booking mới
     */
    public function addBookingSimple($data)
    {
        try {
            // 1. Luôn luôn tìm theo tên khách
            $stmt = $this->conn->prepare("SELECT ID_KhachHang FROM dm_khach_hang WHERE TenKhachHang = :name");
            $stmt->execute([':name' => $data['TenKhachHang']]);
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);

            // 2. Nếu chưa tồn tại → tạo mới khách
            if ($customer) {
                $customerID = $customer['ID_KhachHang'];
            } else {
                $stmt = $this->conn->prepare("INSERT INTO dm_khach_hang (TenKhachHang) VALUES (:name)");
                $stmt->execute([':name' => $data['TenKhachHang']]);
                $customerID = $this->conn->lastInsertId();
            }

            // 3. Tính tổng tiền
            $tong_tien = $this->calculateTotal(
                $data['TourID'],
                $data['SoLuongNguoiLon'],
                $data['SoLuongTreEm']
            );

            // 4. Thêm booking
            $stmt = $this->conn->prepare("
            INSERT INTO booking (ID_Tour, ID_KhachHang, NgayDatTour, 
                                 SoLuongNguoiLon, SoLuongTreEm, TongTien, TrangThai)
            VALUES (:TourID, :CID, :NgayDat, :NL, :TE, :Total, :Status)
        ");

            $stmt->execute([
                ':TourID'  => $data['TourID'],
                ':CID'     => $customerID,
                ':NgayDat' => $data['NgayDatTour'],
                ':NL'      => $data['SoLuongNguoiLon'],
                ':TE'      => $data['SoLuongTreEm'],
                ':Total'   => $tong_tien,
                ':Status'  => $data['TrangThai'],
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
