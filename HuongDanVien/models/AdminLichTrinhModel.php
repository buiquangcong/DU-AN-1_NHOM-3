<?php

class AdminLichTrinhModel
{
    public $db;
    public $tableLichTrinh = "dm_chi_tiet_tour";
    public $tableDiemDanh = "diem_danh_lich_trinh";
    public $tableChiTietKhach = "chi_tiet_khach";
    public $tableBooking = "booking";

    public function __construct()
    {
        $this->db = connectDB();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getItineraryByTourId($tourId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->tableLichTrinh} 
            WHERE ID_Tour = :tour_id 
            ORDER BY ThuTu ASC, KhungGio ASC
        ");
        $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGuestsAndCheckinStatus($tourId, $lichTrinhId)
    {
        $sql = "
        SELECT 
            ctk.ID_ChiTiet, 
            ctk.TenNguoiDi AS HoTen, /* Dùng TenNguoiDi và alias thành HoTen cho View */
            ctk.GioiTinh, ctk.NgaySinh, ctk.ID_Booking,
            ddlt.trang_thai, ddlt.thoi_gian_dd,
            lt.TenHoatDong
        FROM 
            {$this->tableChiTietKhach} ctk
        JOIN 
            {$this->tableBooking} b ON ctk.ID_Booking = b.ID_Booking
        JOIN
            /* Sửa lỗi JOIN: Dùng ID_ChiTietTour (Khóa chính của bảng Lịch trình) */
            {$this->tableLichTrinh} lt ON lt.ID_ChiTietTour = :lich_trinh_id 
        LEFT JOIN 
            {$this->tableDiemDanh} ddlt 
            ON ctk.ID_ChiTiet = ddlt.id_khach 
            AND ddlt.id_lich_trinh = :lich_trinh_id_join 
        WHERE
            b.ID_Tour = :tour_id
        ORDER BY
            ctk.TenNguoiDi ASC 
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_STR);
        $stmt->bindParam(':lich_trinh_id', $lichTrinhId, PDO::PARAM_INT);
        $stmt->bindParam(':lich_trinh_id_join', $lichTrinhId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCheckinStatusLichTrinh($lichTrinhId, $guestId, $status)
    {
        try {
            $sql = "
                INSERT INTO {$this->tableDiemDanh} (id_lich_trinh, id_khach, trang_thai, thoi_gian_dd)
                VALUES (:lich_trinh_id, :id_khach, :trang_thai, NOW())
                ON DUPLICATE KEY UPDATE 
                    trang_thai = :trang_thai_update, 
                    thoi_gian_dd = NOW();
            ";

            $stmt = $this->db->prepare($sql);

            $params = [
                ':lich_trinh_id' => $lichTrinhId,
                ':id_khach' => $guestId,
                ':trang_thai' => $status,
                ':trang_thai_update' => $status
            ];

            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }
}
