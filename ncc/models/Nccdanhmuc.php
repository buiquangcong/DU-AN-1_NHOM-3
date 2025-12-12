

<?php
class NccDanhMuc {
    public $conn;

    public function __construct() {
        $this->conn = connectDB(); 
    }

    public function getAllDanhMuc() {
        $sql = "SELECT * FROM dm_loai_tour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertDanhMuc($TenLoaiTour) {
        $sql = "INSERT INTO dm_loai_tour (TenLoaiTour) VALUES (:TenLoaiTour)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':TenLoaiTour', $TenLoaiTour);
        return $stmt->execute();
    }

    public function getDetailDanhMuc($id) {
        $sql = "SELECT * FROM dm_loai_tour WHERE ID_LoaiTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateDanhMuc($id, $TenLoaiTour) {
        $sql = "UPDATE dm_loai_tour SET TenLoaiTour = :TenLoaiTour WHERE ID_LoaiTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':TenLoaiTour', $TenLoaiTour);
        return $stmt->execute();
    }
}
?>
