<?php
// File: /admin/models/AdminBookingModel.php

class AdminBookingModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB(); // Giả định hàm connectDB()
        // Đặt PDO error mode để dễ debug
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // =========================================================================
    // I. QUẢN LÝ BOOKING (CRUD & Helpers)
    // =========================================================================

    public function getAllBookings($keyword = null)
    {
        try {
            // Thêm cột Email vào câu SQL để hiển thị và tìm kiếm
            $sql = "SELECT b.*, t.TenTour, kh.TenKhachHang, kh.Email
                      FROM booking b
                      LEFT JOIN dm_tours t ON b.ID_Tour = t.ID_Tour
                      LEFT JOIN dm_khach_hang kh ON b.ID_KhachHang = kh.ID_KhachHang";

            // Xử lý tìm kiếm
            if ($keyword) {
                // Tìm theo Email hoặc ID Booking hoặc Tên Khách
                $sql .= " WHERE kh.Email LIKE :keyword 
                          OR b.ID_Booking LIKE :keyword 
                          OR kh.TenKhachHang LIKE :keyword";
            }

            $sql .= " ORDER BY b.NgayDatTour DESC";

            $stmt = $this->conn->prepare($sql);

            if ($keyword) {
                $stmt->execute([':keyword' => "%$keyword%"]);
            } else {
                $stmt->execute();
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    // THÊM: Hàm xóa booking
    public function deleteBooking($id)
    {
        try {
            // Xóa khách trong chi_tiet_khach trước (nếu chưa có ràng buộc CASCADE khóa ngoại)
            $sqlDetail = "DELETE FROM chi_tiet_khach WHERE ID_Booking = :id";
            $stmtDetail = $this->conn->prepare($sqlDetail);
            $stmtDetail->execute([':id' => $id]);

            // Sau đó xóa Booking chính
            $sql = "DELETE FROM booking WHERE ID_Booking = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function getBookingById($booking_id)
    {
        try {
            $sql = "SELECT b.*, t.TenTour, kh.TenKhachHang, kh.Email
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

    /**
     * Thêm booking mới (có Transaction)
     * QUAN TRỌNG: Hàm này đã được sửa để trả về ID Booking
     */
    public function addBookingSimple($data)
    {
        $customerID = null;
        $params = [];
        $stmt = null;
        $default_password = password_hash('123456', PASSWORD_DEFAULT);

        $this->conn->beginTransaction();

        try {
            // --- BƯỚC 1: TÌM KHÁCH HÀNG (SỬA LOGIC: TÌM THEO EMAIL) ---
            // Tìm xem email này đã có trong hệ thống chưa (Email là duy nhất)
            $stmt = $this->conn->prepare("SELECT ID_KhachHang FROM dm_khach_hang WHERE Email = :email");
            $stmt->execute([':email' => $data['Email']]);
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($customer) {
                // Nếu tìm thấy Email -> Lấy ID cũ
                $customerID = (int)$customer['ID_KhachHang'];
            } else {
                // Nếu chưa có Email -> Thêm khách hàng mới
                $stmt = $this->conn->prepare("INSERT INTO dm_khach_hang (TenKhachHang, Email, MatKhau) VALUES (:name, :email, :matkhau)");
                $stmt->execute([
                    ':name' => $data['TenKhachHang'],
                    ':email' => $data['Email'],
                    ':matkhau' => $default_password
                ]);
                $customerID = (int)$this->conn->lastInsertId();
            }

            if (!$customerID || $customerID <= 0) {
                throw new Exception("ID Khách hàng không xác định.");
            }

            // --- BƯỚC 2: TÍNH TỔNG TIỀN ---
            $tong_tien = $this->calculateTotal(
                $data['TourID'],
                $data['SoLuongNguoiLon'],
                $data['SoLuongTreEm']
            );

            // --- BƯỚC 3: THÊM BOOKING ---
            $sql_insert = "INSERT INTO booking (ID_Tour, ID_KhachHang, NgayDatTour, 
                                     SoLuongNguoiLon, SoLuongTreEm, TongTien, TrangThai)
                           VALUES (:TourID, :CID, :NgayDat, :NL, :TE, :Total, :Status)";

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

            // Lấy ID booking vừa tạo
            $newBookingId = $this->conn->lastInsertId();

            $this->conn->commit();

            // Trả về ID để Controller sử dụng
            return $newBookingId;
        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            // Đã bỏ phần hiện lỗi màu hồng để code chạy bình thường, 
            // nếu lỗi sẽ trả về false cho Controller xử lý.
            return false;
        }
    }


    // =========================================================================
    // II. QUẢN LÝ KHÁCH HÀNG CHI TIẾT (Guest CRUD)
    // =========================================================================

    public function getGuestsByBookingID($booking_id)
    {
        try {
            // Lưu ý: Tên bảng là chi_tiet_khach (như code bạn gửi)
            $sql = "SELECT * FROM chi_tiet_khach WHERE ID_Booking = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $booking_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getGuestDetail($guest_id)
    {
        try {
            $sql = "SELECT * FROM chi_tiet_khach WHERE ID_ChiTiet = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $guest_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Thêm khách mới
     * [SỬA ĐỔI]: Tương thích với key 'TenNguoiDi' từ Controller
     */
    public function addGuest($data)
    {
        try {
            // SỬA: Đổi HoTen -> TenNguoiDi
            $sql = "INSERT INTO chi_tiet_khach 
                         (ID_Booking, TenNguoiDi, GioiTinh, NgaySinh, LienHe, CCCD_Passport, GhiChu)
                      VALUES 
                         (:ID_Booking, :TenNguoiDi, :GioiTinh, :NgaySinh, :LienHe, :CCCD_Passport, :GhiChu)";
            $stmt = $this->conn->prepare($sql);

            // Kiểm tra dữ liệu đầu vào (phòng hờ)
            $ten = isset($data['TenNguoiDi']) ? $data['TenNguoiDi'] : (isset($data['HoTen']) ? $data['HoTen'] : '');

            $stmt->execute([
                ':ID_Booking'    => $data['ID_Booking'],
                ':TenNguoiDi'    => $ten, // SỬA: Map đúng vào cột TenNguoiDi
                ':GioiTinh'      => $data['GioiTinh'],
                ':NgaySinh'      => !empty($data['NgaySinh']) ? $data['NgaySinh'] : null,
                ':LienHe'        => $data['LienHe'] ?? '',
                ':CCCD_Passport' => $data['CCCD_Passport'] ?? '',
                ':GhiChu'        => $data['GhiChu'] ?? ''
            ]);
            return true;
        } catch (Exception $e) {
            // Bật debug để xem nếu còn lỗi khác
            echo "<div style='background: red; color: white; padding: 20px;'>Lỗi thêm khách: " . $e->getMessage() . "</div>";
            die();
            // return false;
        }
    }
    public function updateGuest($guest_id, $data)
    {
        try {
            // SỬA: Đổi HoTen -> TenNguoiDi
            $sql = "UPDATE chi_tiet_khach SET 
                        TenNguoiDi = :TenNguoiDi,
                        GioiTinh = :GioiTinh,
                        NgaySinh = :NgaySinh,
                        LienHe = :LienHe,
                        CCCD_Passport = :CCCD_Passport,
                        GhiChu = :GhiChu
                    WHERE ID_ChiTiet = :id";
            $stmt = $this->conn->prepare($sql);

            $ten = isset($data['TenNguoiDi']) ? $data['TenNguoiDi'] : (isset($data['HoTen']) ? $data['HoTen'] : '');

            $stmt->execute([
                ':TenNguoiDi'    => $ten, // SỬA: Map đúng vào cột TenNguoiDi
                ':GioiTinh'      => $data['GioiTinh'],
                ':NgaySinh'      => !empty($data['NgaySinh']) ? $data['NgaySinh'] : null,
                ':LienHe'        => $data['LienHe'],
                ':CCCD_Passport' => $data['CCCD_Passport'],
                ':GhiChu'        => $data['GhiChu'],
                ':id'            => $guest_id
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

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
            // Lưu ý: Kiểm tra lại tên cột 'TrangThaiCheckin' trong bảng chi_tiet_khach của bạn có đúng không
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

    // =========================================================================
    // III. KHÁCH HÀNG & TOUR (Helpers cho Dropdown)
    // =========================================================================

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

    public function updateBooking($id, $data)
    {
        try {
            $this->conn->beginTransaction();

            // 1. Cập nhật thông tin Khách hàng (Sửa tên/email nếu sai)
            // Lấy ID_KhachHang từ bảng booking hiện tại để đảm bảo đúng người
            $stmt = $this->conn->prepare("SELECT ID_KhachHang FROM booking WHERE ID_Booking = :id");
            $stmt->execute([':id' => $id]);
            $booking = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($booking) {
                $sqlKhach = "UPDATE dm_khach_hang SET TenKhachHang = :ten, Email = :email WHERE ID_KhachHang = :cid";
                $stmtKhach = $this->conn->prepare($sqlKhach);
                $stmtKhach->execute([
                    ':ten' => $data['TenKhachHang'],
                    ':email' => $data['Email'],
                    ':cid' => $booking['ID_KhachHang']
                ]);
            }

            // 2. Tính lại tổng tiền (Vì có thể thay đổi số lượng hoặc Tour)
            $tong_tien = $this->calculateTotal(
                $data['TourID'],
                $data['SoLuongNguoiLon'],
                $data['SoLuongTreEm']
            );

            // 3. Cập nhật Booking
            $sql = "UPDATE booking SET 
                        ID_Tour = :tour_id,
                        NgayDatTour = :ngay_dat,
                        SoLuongNguoiLon = :sl_nl,
                        SoLuongTreEm = :sl_te,
                        TongTien = :tong_tien,
                        TrangThai = :trang_thai
                    WHERE ID_Booking = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':tour_id' => $data['TourID'],
                ':ngay_dat' => $data['NgayDatTour'],
                ':sl_nl' => $data['SoLuongNguoiLon'],
                ':sl_te' => $data['SoLuongTreEm'],
                ':tong_tien' => $tong_tien,
                ':trang_thai' => $data['TrangThai'],
                ':id' => $id
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            // echo $e->getMessage(); die(); // Bật lên nếu muốn debug
            return false;
        }
    }
}
