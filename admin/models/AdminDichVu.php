<?php
class AdminDichVu
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
}
?>