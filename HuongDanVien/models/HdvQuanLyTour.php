<?php
// File: /admin/models/AdminQuanLyTour.php
// (Đã đổi tên class AdminSanPham -> AdminQuanLyTour cho khớp)

class HdvQuanLyTour
{
    public $conn;

    public function __construct()
    {
        // Giả định connectDB() trả về một đối tượng PDO
        $this->conn = connectDB();
    }

    // ===============================================
    // CÁC HÀM QUẢN LÝ TOUR (CỦA BẠN - ĐÃ SỬA TÊN)
    // ===============================================

    /**
     * Lấy tất cả tour (sản phẩm)
     */
    public function getAllTours($search_id = '', $loai_tour_id = '')
    {
        try {
            $sql = 'SELECT 
                        dm_tours.*, 
                        dm_loai_tour.TenLoaiTour,
                        a.UrlAnh -- LẤY URL ẢNH BÌA
                    FROM dm_tours
                    LEFT JOIN dm_loai_tour ON dm_tours.ID_LoaiTour = dm_loai_tour.ID_LoaiTour
                    -- JOIN để lấy ảnh bìa (LoaiAnh = 0)
                    LEFT JOIN dm_anh_tour a ON dm_tours.ID_Tour = a.ID_Tour AND a.LoaiAnh = 0';

            $params = [];
            $conditions = [];

            // === Xử lý điều kiện 1: TÌM KIẾM theo ID ===
            if (!empty($search_id)) {
                $conditions[] = 'dm_tours.ID_Tour LIKE :search_id';
                $params[':search_id'] = '%' . $search_id . '%';
            }

            // === Xử lý điều kiện 2: LỌC theo Loại Tour ===
            if (!empty($loai_tour_id)) {
                $conditions[] = 'dm_tours.ID_LoaiTour = :loai_tour_id';
                $params[':loai_tour_id'] = $loai_tour_id;
            }

            if (!empty($conditions)) {
                $sql .= ' WHERE ' . implode(' AND ', $conditions);
            }

            $sql .= ' ORDER BY dm_tours.ID_Tour DESC';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // error_log("Lỗi truy vấn (getAllTours): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy tour theo ID - Cần sửa để JOIN lấy UrlAnh (Cho form edit)
     */
    public function getTourById($id)
    {
        try {
            // Cần JOIN để lấy UrlAnh cho form edit
            $sql = "SELECT 
                        dm_tours.*, 
                        a.UrlAnh
                    FROM dm_tours
                    LEFT JOIN dm_anh_tour a ON dm_tours.ID_Tour = a.ID_Tour AND a.LoaiAnh = 0
                    WHERE dm_tours.ID_Tour = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi lấy tour theo ID: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Thêm tour mới (ĐÃ LOẠI BỎ DiemKhoiHanh)
     */
    public function insertTour(
        $ID_Tour,
        $TenTour,
        $ID_LoaiTour,
        $GiaNguoiLon,
        $GiaTreEm,
        $SoNgay,
        $SoDem,
        $NoiDungTomTat,
        $NoiDungChiTiet,
        $NgayKhoiHanh, // GIỮ LẠI
        $SoCho,
        $TrangThai,
        $policy_id
    ) {
        try {
            $sql = 'INSERT INTO `dm_tours` (
                         `ID_Tour`, `TenTour`, `ID_LoaiTour`, `GiaNguoiLon`, `GiaTreEm`,
                         `SoNgay`, `SoDem`, `NoiDungTomTat`, `NoiDungChiTiet`, `NgayKhoiHanh`,
                         `SoCho`, `TrangThai`, `policy_id`
                     ) VALUES (
                         :ID_Tour, :TenTour, :ID_LoaiTour, :GiaNguoiLon, :GiaTreEm,
                         :SoNgay, :SoDem, :NoiDungTomTat, :NoiDungChiTiet, :NgayKhoiHanh,
                         :SoCho, :TrangThai, :policy_id
                     )';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ID_Tour' => $ID_Tour,
                ':TenTour' => $TenTour,
                ':ID_LoaiTour' => $ID_LoaiTour,
                ':GiaNguoiLon' => $GiaNguoiLon,
                ':GiaTreEm' => $GiaTreEm,
                ':SoNgay' => $SoNgay,
                ':SoDem' => $SoDem,
                ':NoiDungTomTat' => $NoiDungTomTat,
                ':NoiDungChiTiet' => $NoiDungChiTiet,
                ':NgayKhoiHanh' => $NgayKhoiHanh,
                ':SoCho' => $SoCho,
                ':TrangThai' => $TrangThai,
                ':policy_id' => $policy_id
            ]);
            return $ID_Tour;
        } catch (Exception $e) {
            echo "Lỗi thêm tour: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Cập nhật tour và Ảnh Bìa (Gộp logic)
     */
    public function updateTour(
        $ID_Tour,
        $TenTour,
        $ID_LoaiTour,
        $GiaNguoiLon,
        $GiaTreEm,
        $SoNgay,
        $SoDem,
        $NoiDungTomTat,
        $NoiDungChiTiet,
        $NgayKhoiHanh,
        $SoCho,
        $TrangThai,
        $policy_id,
        $new_image_url = null // THAM SỐ ẢNH MỚI
    ) {
        try {
            // Debug: Hiển thị lỗi chi tiết
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn->beginTransaction();

            // 1. CẬP NHẬT THÔNG TIN CƠ BẢN CỦA TOUR (dm_tours)
            $sql = "UPDATE dm_tours SET 
                        TenTour = :TenTour,
                        ID_LoaiTour = :ID_LoaiTour,
                        GiaNguoiLon = :GiaNguoiLon,
                        GiaTreEm = :GiaTreEm,
                        SoNgay = :SoNgay,
                        SoDem = :SoDem,
                        NoiDungTomTat = :NoiDungTomTat,
                        NoiDungChiTiet = :NoiDungChiTiet,
                        NgayKhoiHanh = :NgayKhoiHanh,
                        SoCho = :SoCho,
                        TrangThai = :TrangThai,
                        policy_id = :policy_id
                     WHERE ID_Tour = :ID_Tour";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ID_Tour' => $ID_Tour,
                ':TenTour' => $TenTour,
                ':ID_LoaiTour' => $ID_LoaiTour,
                ':GiaNguoiLon' => $GiaNguoiLon,
                ':GiaTreEm' => $GiaTreEm,
                ':SoNgay' => $SoNgay,
                ':SoDem' => $SoDem,
                ':NoiDungTomTat' => $NoiDungTomTat,
                ':NoiDungChiTiet' => $NoiDungChiTiet,
                ':NgayKhoiHanh' => $NgayKhoiHanh,
                ':SoCho' => $SoCho,
                ':TrangThai' => $TrangThai,
                ':policy_id' => $policy_id
            ]);

            // 2. CẬP NHẬT ẢNH BÌA (dm_anh_tour) - CHỈ CHẠY NẾU CÓ ẢNH MỚI
            if ($new_image_url) {
                // Xóa bản ghi ảnh bìa cũ (LoaiAnh = 0)
                $sql_delete = "DELETE FROM dm_anh_tour WHERE ID_Tour = :ID_Tour AND LoaiAnh = 0";
                $stmt_delete = $this->conn->prepare($sql_delete);
                $stmt_delete->execute([':ID_Tour' => $ID_Tour]);

                // Thêm ảnh bìa mới vào DB
                $sql_insert = "INSERT INTO dm_anh_tour (ID_Tour, UrlAnh, LoaiAnh) VALUES (:ID_Tour, :UrlAnh, 0)";
                $stmt_insert = $this->conn->prepare($sql_insert);
                $stmt_insert->execute([
                    ':ID_Tour' => $ID_Tour,
                    ':UrlAnh' => $new_image_url
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // HIỂN THỊ LỖI CHI TIẾT TỪ MYSQL
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            echo "LỖI CẬP NHẬT TOUR: " . $e->getMessage();
            exit;
        }
    }

    /**
     * Thêm ảnh tour (dùng cho postAddTour)
     */
    public function insertAnhTour($idTour, $image_url, $is_anh_bia = 0)
    {
        try {
            $sql = "INSERT INTO dm_anh_tour (ID_Tour, UrlAnh, LoaiAnh) VALUES (:idTour, :image_url, :la_anh_bia)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':idTour' => $idTour,
                ':image_url' => $image_url,
                ':la_anh_bia' => $is_anh_bia
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi thêm ảnh tour: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Xóa tour
     */
    public function deleteTour($ID_Tour) // Đổi tên
    {
        try {
            $sql = "DELETE FROM dm_tours WHERE ID_Tour = :ID_Tour";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':ID_Tour' => $ID_Tour]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi xóa tour: " . $e->getMessage();
            return false;
        }
    }



    // ===============================================
    // CÁC HÀM QUẢN LÝ LỊCH TRÌNH (MỚI THÊM)
    // ===============================================

    /**
     * Lấy danh sách lịch trình theo ID tour
     */
    public function getItineraryByTourID($tour_id)
    {
        try {
            $sql = "SELECT * FROM dm_chi_tiet_tour 
                    WHERE ID_Tour = :tour_id 
                    ORDER BY ThuTu ASC, ID_ChiTietTour ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':tour_id' => $tour_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // echo "Lỗi lấy lịch trình: " . $e->getMessage(); // <-- ĐÃ GỠ BỎ
            return []; // Trả về mảng rỗng nếu lỗi
        }
    }
    /**
     * Thêm một mục lịch trình mới
     */
    public function addItineraryItem($tour_id, $day_number, $time_slot, $activity_title, $activity_description)
    {
        try {
            $sql = "INSERT INTO dm_chi_tiet_tour (ID_Tour, ThuTu, KhungGio, TenHoatDong, MoTaHoatDong)
                    VALUES (:tour_id, :ThuTu, :KhungGio, :TenHoatDong, :MoTaHoatDong)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':tour_id' => $tour_id,
                ':ThuTu' => $day_number,
                ':KhungGio' => $time_slot,
                ':TenHoatDong' => $activity_title,
                ':MoTaHoatDong' => $activity_description
            ]);
            return true; // Trả về true nếu thành công
        } catch (Exception $e) {
            // echo "Lỗi thêm mục lịch trình: " . $e->getMessage(); // <-- ĐÃ GỠ BỎ
            return false; // Trả về false nếu thất bại
        }
    }
    /**
     * Xóa một mục lịch trình
     */
    public function deleteItineraryItem($itinerary_id)
    {
        try {
            $sql = "DELETE FROM dm_chi_tiet_tour WHERE ID_ChiTietTour = :itinerary_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':itinerary_id' => $itinerary_id]);
            return true;
        } catch (Exception $e) {
            // echo "Lỗi xóa mục lịch trình: " . $e->getMessage(); // <-- ĐÃ GỠ BỎ
            return false;
        }
    }
    // ===============================================
    // CÁC HÀM QUẢN LÝ NHÀ CUNG CẤP (MỚI THÊM)
    // ===============================================

    /**
     * Lấy danh sách NCC đã liên kết với 1 tour
     */
    public function getLinkedSuppliersByTourID($tour_id)
    {
        try {
            $sql = "SELECT ncc.*, tncc.ghi_chu, tncc.tour_id, tncc.nha_cc_id
                    FROM tour_nha_cung_cap tncc
                    JOIN nha_cung_cap ncc ON tncc.nha_cc_id = ncc.id_nha_cc
                    WHERE tncc.tour_id = :tour_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':tour_id' => $tour_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi lấy NCC đã liên kết: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Tạo liên kết Tour với NCC (Thêm vào bảng trung gian)
     */
    public function linkSupplierToTour($tour_id, $supplier_id, $ghi_chu)
    {
        try {
            $sql = "INSERT IGNORE INTO tour_nha_cung_cap (tour_id, nha_cc_id, ghi_chu) 
                    VALUES (:tour_id, :supplier_id, :ghi_chu)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':tour_id' => $tour_id,
                ':supplier_id' => $supplier_id,
                ':ghi_chu' => $ghi_chu
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi liên kết NCC: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Hủy liên kết Tour với NCC (Xóa khỏi bảng trung gian)
     */
    public function unlinkSupplierFromTour($tour_id, $supplier_id)
    {
        try {
            $sql = "DELETE FROM tour_nha_cung_cap 
                    WHERE tour_id = :tour_id AND nha_cc_id = :supplier_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':tour_id' => $tour_id,
                ':supplier_id' => $supplier_id
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi hủy liên kết NCC: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Lấy 1 mục lịch trình theo ID của nó
     */
    public function getItineraryItemById($itinerary_id)
    {
        try {
            $sql = "SELECT * FROM dm_chi_tiet_tour WHERE ID_ChiTietTour = :id LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $itinerary_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cập nhật 1 mục lịch trình
     */
    public function updateItineraryItem($itinerary_id, $day_number, $time_slot, $activity_title, $activity_description)
    {
        try {
            $sql = "UPDATE dm_chi_tiet_tour SET 
                        ThuTu = :ThuTu,
                        KhungGio = :KhungGio,
                        TenHoatDong = :TenHoatDong,
                        MoTaHoatDong = :MoTaHoatDong
                    WHERE ID_ChiTietTour = :itinerary_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ThuTu' => $day_number,
                ':KhungGio' => $time_slot,
                ':TenHoatDong' => $activity_title,
                ':MoTaHoatDong' => $activity_description,
                ':itinerary_id' => $itinerary_id
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
