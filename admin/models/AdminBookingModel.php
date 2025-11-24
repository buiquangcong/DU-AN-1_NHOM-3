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
            // Lấy giá người lớn và trẻ em từ database
            $sql = "SELECT GiaNguoiLon, GiaTreEm FROM dm_tours WHERE ID_Tour = :tour_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':tour_id' => $tour_id]);
            $tour = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$tour) return 0;

            // Chuẩn hóa giá trị từ database sang số thực (float) để tính toán an toàn
            $gia_nl = (float)$tour['GiaNguoiLon'];
            $gia_te = (float)$tour['GiaTreEm'];

            // Chuẩn hóa số lượng đầu vào sang số nguyên (int)
            $so_nl = (int)$so_luong_nl;
            $so_te = (int)$so_luong_te;

            // Trả về tổng tiền
            return ($so_nl * $gia_nl) + ($so_te * $gia_te);
        } catch (Exception $e) {
            // Ghi log lỗi nếu cần
            // error_log("Lỗi tính tổng tiền: " . $e->getMessage()); 
            return 0;
        }
    }

    /**
     * Thêm booking mới
     */
    public function addBookingSimple($data)
    {
        $customerID = null;
        $params = [];
        $stmt = null;

        // Đặt mật khẩu mặc định an toàn cho khách hàng tạo qua admin
        $default_password = '123456';

        // Bắt đầu Transaction
        $this->conn->beginTransaction();

        try {
            // --- 1 & 2: Xử lý Khách Hàng ---
            // 1. Tìm theo tên khách hàng
            $stmt = $this->conn->prepare("SELECT ID_KhachHang FROM dm_khach_hang WHERE TenKhachHang = :name");
            $stmt->execute([':name' => $data['TenKhachHang']]);
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($customer) {
                $customerID = (int)$customer['ID_KhachHang'];
            } else {
                // 2. Thêm khách hàng mới (ĐÃ SỬA: Bổ sung cột MatKhau)
                $stmt = $this->conn->prepare("INSERT INTO dm_khach_hang (TenKhachHang, Email, MatKhau) VALUES (:name, :email, :matkhau)");

                $stmt->execute([
                    ':name' => $data['TenKhachHang'],
                    ':email' => $data['Email'],
                    ':matkhau' => $default_password // <--- CUNG CẤP GIÁ TRỊ MẶC ĐỊNH
                ]);
                $customerID = (int)$this->conn->lastInsertId();
            }

            // Kiểm tra an toàn
            if (!$customerID || $customerID <= 0) {
                throw new Exception("ID Khách hàng không xác định.");
            }

            // --- 3: Tính tổng tiền ---
            $tong_tien = $this->calculateTotal(
                $data['TourID'],
                $data['SoLuongNguoiLon'],
                $data['SoLuongTreEm']
            );

            // --- 4: Thêm booking ---
            $sql_insert = "
            INSERT INTO booking (ID_Tour, ID_KhachHang, NgayDatTour, 
                                 SoLuongNguoiLon, SoLuongTreEm, TongTien, TrangThai)
            VALUES (:TourID, :CID, :NgayDat, :NL, :TE, :Total, :Status)
        ";

            $params = [
                ':TourID'  => $data['TourID'],
                ':CID'     => $customerID,
                ':NgayDat' => $data['NgayDatTour'],
                ':NL'      => (int)$data['SoLuongNguoiLon'],
                ':TE'      => (int)$data['SoLuongTreEm'],
                ':Total'   => $tong_tien,
                ':Status'  => (int)$data['TrangThai'],
            ];

            $stmt = $this->conn->prepare($sql_insert);
            $stmt->execute($params);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            // --- CƠ CHẾ BÁO LỖI SQL CHI TIẾT ---
            $errorInfo = (isset($stmt) && $stmt instanceof PDOStatement) ? $stmt->errorInfo() : ['Không thể lấy thông tin lỗi PDO'];

            echo "<h1>LỖI SQL KHI THÊM BOOKING</h1>";
            echo "<h3>Nguyên nhân PHP: " . htmlspecialchars($e->getMessage()) . "</h3>";
            echo "<h3>Thông tin lỗi DB:</h3>";
            echo "<pre>";
            print_r($errorInfo);
            echo "</pre>";

            if (!empty($params)) {
                echo "<h3>Tham số gửi đi:</h3>";
                echo "<pre>";
                print_r($params);
                echo "</pre>";
            }

            die(); // Dừng lại để xem lỗi

            return false;
        }
    }
}
