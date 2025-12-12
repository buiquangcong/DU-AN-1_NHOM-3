<?php


class NccQuanLyTour
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function getAllTours($search_id = '', $loai_tour_id = '')
    {
        try {
            $sql = 'SELECT 
                        dm_tours.*, 
                        dm_loai_tour.TenLoaiTour,
                        a.UrlAnh 
                    FROM dm_tours
                    LEFT JOIN dm_loai_tour ON dm_tours.ID_LoaiTour = dm_loai_tour.ID_LoaiTour
                    LEFT JOIN dm_anh_tour a ON dm_tours.ID_Tour = a.ID_Tour AND a.LoaiAnh = 0';

            $params = [];
            $conditions = [];

            if (!empty($search_id)) {
                $conditions[] = 'dm_tours.ID_Tour LIKE :search_id';
                $params[':search_id'] = '%' . $search_id . '%';
            }

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
            return [];
        }
    }

    public function getTourById($id)
    {
        try {
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
            return []; 
        }
    }
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
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function deleteItineraryItem($itinerary_id)
    {
        try {
            $sql = "DELETE FROM dm_chi_tiet_tour WHERE ID_ChiTietTour = :itinerary_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':itinerary_id' => $itinerary_id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
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
}
