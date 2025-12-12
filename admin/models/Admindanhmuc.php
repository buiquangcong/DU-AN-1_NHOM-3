

<?php
class AdminDanhMuc {
    public $conn;

    public function __construct() {
        $this->conn = connectDB(); 
    }

    // Lấy tất cả danh mục
    public function getAllDanhMuc() {
        $sql = "SELECT * FROM dm_loai_tour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm danh mục 
    public function insertDanhMuc($TenLoaiTour) {
        $sql = "INSERT INTO dm_loai_tour (TenLoaiTour) VALUES (:TenLoaiTour)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':TenLoaiTour', $TenLoaiTour);
        return $stmt->execute();
    }

    // Lấy chi tiết 1 danh mục
    public function getDetailDanhMuc($id) {
        $sql = "SELECT * FROM dm_loai_tour WHERE ID_LoaiTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật danh mục
    public function updateDanhMuc($id, $TenLoaiTour) {
        $sql = "UPDATE dm_loai_tour SET TenLoaiTour = :TenLoaiTour WHERE ID_LoaiTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':TenLoaiTour', $TenLoaiTour);
        return $stmt->execute();
    }

    // Xóa danh mục
   public function deleteDanhMuc($id) {
    try {
        $sql = "DELETE FROM dm_loai_tour WHERE ID_LoaiTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return true;

    } catch (PDOException $e) {
    
        if ($e->getCode() == 23000) {
            return "Không thể xóa vì danh mục đang được sử dụng bởi Tour!";
        }
        return "Lỗi hệ thống: " . $e->getMessage();
    }
}
}
?>
