<?php
class NccDichVu
{
    public $conn;

    public function __construct()
    {
       
        $this->conn = connectDB(); 
    }

    
    public function getAllDichVu()
    {
        try {
           
            $sql = "SELECT ID_DichVu, TenDichVu FROM dm_dich_vu"; 
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getTourHistoryByNCC($id_ncc)
    {
        $sql = "SELECT t.ID_Tour, t.TenTour, t.ID_LoaiTour, t.GiaNguoiLon, t.GiaTreEm, 
                  t.SoNgay, t.SoDem, t.NgayKhoiHanh, t.SoCho, t.TrangThai
            FROM dm_tours t
            INNER JOIN tour_nha_cung_cap tncc ON t.ID_Tour = tncc.tour_id 
            WHERE tncc.nha_cc_id = :nha_cc_id 
            ORDER BY t.NgayKhoiHanh DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':nha_cc_id' => $id_ncc]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLiveToursByNCC($id_ncc)
    {
        try {
            $sql = "SELECT t.ID_Tour, t.TenTour, t.ID_LoaiTour, t.GiaNguoiLon, t.GiaTreEm, 
                      t.SoNgay, t.SoDem, t.NgayKhoiHanh, t.SoCho, t.TrangThai
                FROM dm_tours t
                INNER JOIN tour_nha_cung_cap tncc ON t.ID_Tour = tncc.tour_id
                WHERE tncc.`ncc_cc_id` = :id_ncc
                AND t.TrangThai = 'Đang hoạt động' 
                ORDER BY t.NgayKhoiHanh ASC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id_ncc' => $id_ncc]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
}
?>