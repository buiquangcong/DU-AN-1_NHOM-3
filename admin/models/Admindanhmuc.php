<!-- <?php
// class AdminDanhMuc{
//     public $conn;
//     public function __construct(){
//         $this->conn = pdo_get_connection();

//     }
//     public function getAllDanhMuc(){
//         $sql="SELECT * FROM dm_loai_tour";
//         $stmt=$this->conn->prepare($sql);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }
//     public function insertDanhMuc($id_Loai_Tour, $TenLoaiTour) {
//         $sql = "INSERT INTO dm_loai_tour (ID_LoaiTour, TenLoaiTour) VALUES (:id_Loai_Tour, :TenLoaiTour)";
//         $stmt = $this->conn->prepare($sql);
//         $stmt->bindParam(':id_Loai_Tour', $id_Loai_Tour);
//         $stmt->bindParam(':TenLoaiTour', $TenLoaiTour);
//         return $stmt->execute();
//     }

// }
?> -->

<?php
class AdminDanhMuc {
    public $conn;

    public function __construct() {
        $this->conn = connectDB(); // đúng với function của bạn
    }

    // Lấy tất cả danh mục
    public function getAllDanhMuc() {
        $sql = "SELECT * FROM dm_loai_tour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm danh mục (ID tự tăng, chỉ cần tên)
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
        $sql = "DELETE FROM dm_loai_tour WHERE ID_LoaiTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
