<?php
class AdminQuanLyNhanSu
{
    private $db;
    private $table = 'dm_nhan_su';

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lấy tất cả nhân sự
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id_nhan_su DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy theo ID
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_nhan_su = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm
    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (ho_ten, chuc_vu, email, so_dien_thoai) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['ho_ten'],
            $data['chuc_vu'],
            $data['email'],
            $data['so_dien_thoai']
        ]);
    }

    // Sửa
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} 
                SET ho_ten=?, chuc_vu=?, email=?, so_dien_thoai=? 
                WHERE id_nhan_su=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['ho_ten'],
            $data['chuc_vu'],
            $data['email'],
            $data['so_dien_thoai'],
            $id
        ]);
    }

    // Xóa
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_nhan_su = ?");
        return $stmt->execute([$id]);
    }
}
