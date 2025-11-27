<?php

class ClientTour
{

    public $conn;

    public function __construct()
    {
        // GIẢ ĐỊNH hàm connectDB() nằm trong function.php đã được load
        // và nó trả về đối tượng PDO hoặc dừng chương trình nếu thất bại.
        $this->conn = connectDB();

        // Kiểm tra lỗi nếu connectDB() được sửa để trả về null thay vì die()
        if ($this->conn === null) {
            throw new Exception("Lỗi CSDL: Không thể khởi tạo kết nối CSDL trong ClientTour Model.");
        }
    }

    /**
     * Lấy danh sách các Loại Tour (Danh mục).
     * @return array Danh sách Loại Tour hoặc mảng rỗng.
     */
    public function getAllTourCategories()
    {
        try {
            $sql = "SELECT ID_LoaiTour, TenLoaiTour FROM dm_loai_tour";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi truy vấn danh mục tour: " . $e->getMessage());
            return [];
        }
    }

    // Các phương thức khác...

    /**
     * Lấy danh sách các Tour nổi bật.
     */
    public function getFeaturedTours()
    {
        try {
            $sql = "SELECT ID_Tour, TenTour, GiaNguoiLon, SoNgay, SoDem, NoiDungTomTat 
                    FROM dm_tour 
                    WHERE TrangThai = 1 
                    ORDER BY ID_Tour DESC LIMIT 6";

            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi truy vấn Tour nổi bật: " . $e->getMessage());
            return [];
        }
    }

    // ... (Giữ nguyên các phương thức searchTours và getTourDetail đã có, 
    //      chúng sử dụng $this->conn và try/catch, không cần thay đổi logic bên trong)

    public function searchTours($criteria)
    {
        try {
            $destination = $criteria['destination'] ?? '';
            $date = $criteria['date'] ?? null;
            $loaiTour = $criteria['loai_tour'] ?? null;

            $condition = " dm_tour.TrangThai = 1 AND dm_tour.TenTour LIKE :dest ";
            $params = [':dest' => "%$destination%"];

            if (!empty($date)) {
                $condition .= " AND dm_tour.NgayKhoiHanh >= :date ";
                $params[':date'] = $date;
            }

            if (!empty($loaiTour)) {
                $condition .= " AND dm_tour.ID_LoaiTour = :loai_tour ";
                $params[':loai_tour'] = $loaiTour;
            }

            $sql = "SELECT ID_Tour, TenTour, GiaNguoiLon, SoNgay, NoiDungTomTat 
                    FROM dm_tour 
                    WHERE {$condition}";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi tìm kiếm Tour: " . $e->getMessage());
            return [];
        }
    }

    public function getTourDetail($tourId)
    {
        try {
            $sql = "SELECT t.*, lt.TenLoaiTour 
                    FROM dm_tour t
                    JOIN dm_loai_tour lt ON t.ID_LoaiTour = lt.ID_LoaiTour
                    WHERE t.ID_Tour = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $tourId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi lấy chi tiết Tour: " . $e->getMessage());
            return false;
        }
    }
}
