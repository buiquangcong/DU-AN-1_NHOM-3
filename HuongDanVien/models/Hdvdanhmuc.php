

<?php
class HdvDanhMuc
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllDanhMuc()
    {
        $sql = "SELECT * FROM dm_loai_tour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetailDanhMuc($id)
    {
        $sql = "SELECT * FROM dm_loai_tour WHERE ID_LoaiTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
