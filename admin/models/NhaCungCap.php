<?php
class NhaCungCap
{
    private $db;
    private $table = "nha_cung_cap";

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lấy tất cả nhà cung cấp
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id_nha_cc DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy nhà cung cấp theo ID
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_nha_cc = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm nhà cung cấp
    public function insert($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (ten_nha_cc, dia_chi, email, so_dien_thoai)
            VALUES (:ten_nha_cc, :dia_chi, :email, :so_dien_thoai)
        ");
        $stmt->bindParam(':ten_nha_cc', $data['ten_nha_cc']);
        $stmt->bindParam(':dia_chi', $data['dia_chi']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':so_dien_thoai', $data['so_dien_thoai']);
        return $stmt->execute();
    }

    // Cập nhật nhà cung cấp
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET ten_nha_cc = :ten_nha_cc,
                dia_chi = :dia_chi,
                email = :email,
                so_dien_thoai = :so_dien_thoai,
                ngay_cap_nhat = CURRENT_TIMESTAMP
            WHERE id_nha_cc = :id
        ");
        $stmt->bindParam(':ten_nha_cc', $data['ten_nha_cc']);
        $stmt->bindParam(':dia_chi', $data['dia_chi']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':so_dien_thoai', $data['so_dien_thoai']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Xóa nhà cung cấp
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_nha_cc = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
