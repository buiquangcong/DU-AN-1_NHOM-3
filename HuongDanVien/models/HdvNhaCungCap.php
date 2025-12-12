<?php
class HdvNhaCungCap
{
    public $db;
    public $table = "nha_cung_cap";

    public function __construct()
    {
        $this->db = connectDB();
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT ncc.*, dv.TenDichVu 
            FROM {$this->table} ncc
            -- SỬA JOIN: dùng cột id_DichVu trong bảng ncc và ID_DichVu trong dm_dich_vu
            LEFT JOIN dm_dich_vu dv ON ncc.id_DichVu = dv.ID_DichVu
            ORDER BY ncc.id_nha_cc DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getById($id)
    {
        $stmt = $this->db->prepare("
        SELECT ncc.*, dv.TenDichVu
        FROM {$this->table} ncc
        LEFT JOIN dm_dich_vu dv ON ncc.id_DichVu = dv.ID_DichVu
        WHERE ncc.id_nha_cc = :id 
        LIMIT 1
    ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
