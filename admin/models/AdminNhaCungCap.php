<?php
class AdminNhaCungCap
{
    public $db;
    public $table = "nha_cung_cap";

    public function __construct()
    {
        $this->db = connectDB();
        // BẬT HIỂN THỊ LỖI PDO ĐỂ DỄ DEBUG KHÓA NGOẠI HOẶC KHÓA CHÍNH
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //--- (Các hàm CRUD NCC đã có) ---

    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT ncc.*, dv.TenDichVu 
            FROM {$this->table} ncc
            LEFT JOIN dm_dich_vu dv ON ncc.id_DichVu = dv.ID_DichVu
            ORDER BY ncc.id_nha_cc DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. READ: Lấy nhà cung cấp theo ID
    // =========================================================================
    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT 
                ncc.*, 
                dv.TenDichVu 
            FROM 
                {$this->table} ncc
            LEFT JOIN 
                dm_dich_vu dv ON ncc.id_DichVu = dv.ID_DichVu
            WHERE 
                ncc.id_nha_cc = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        // Dùng fetch() vì chỉ cần lấy 1 dòng
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =========================================================================
    // 3. CREATE: Thêm nhà cung cấp mới
    // =========================================================================
    public function insert($data)
    {
        $sql = "
            INSERT INTO {$this->table} (
                ten_nha_cc, id_dichvu, dia_chi, email, so_dien_thoai
            ) VALUES (
                :ten_nha_cc, :id_dichvu, :dia_chi, :email, :so_dien_thoai
            )
        ";
        $stmt = $this->db->prepare($sql);

        // Sử dụng bindParam để ngăn chặn SQL Injection
        $stmt->bindParam(':ten_nha_cc', $data['ten_nha_cc'], PDO::PARAM_STR);
        $stmt->bindParam(':id_dichvu', $data['id_dichvu'], PDO::PARAM_INT);
        $stmt->bindParam(':dia_chi', $data['dia_chi'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':so_dien_thoai', $data['so_dien_thoai'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // =========================================================================
    // 4. UPDATE: Cập nhật thông tin nhà cung cấp
    // =========================================================================
    public function update($id, $data)
    {
        $sql = "
            UPDATE {$this->table} SET 
                ten_nha_cc = :ten_nha_cc,
                id_dich_vu = :id_dich_vu,
                dia_chi = :dia_chi,
                email = :email,
                so_dien_thoai = :so_dien_thoai
            WHERE 
                id_nha_cc = :id
        ";
        $stmt = $this->db->prepare($sql);

        // Bind ID (khóa chính)
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Bind các trường dữ liệu
        $stmt->bindParam(':ten_nha_cc', $data['ten_nha_cc'], PDO::PARAM_STR);
        $stmt->bindParam(':id_dichvu', $data['id_dichvu'], PDO::PARAM_INT);
        $stmt->bindParam(':dia_chi', $data['dia_chi'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':so_dien_thoai', $data['so_dien_thoai'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // =========================================================================
    // 5. DELETE: Xóa nhà cung cấp
    // =========================================================================
    public function delete($id)
    {
        // *Chú ý: Nếu có Ràng buộc Khóa ngoại (Foreign Key) trên bảng khác (ví dụ: tour_nha_cung_cap), 
        // bạn cần đảm bảo rằng tất cả các bản ghi liên quan đã được xóa trước 
        // (hoặc thiết lập ON DELETE CASCADE trên database).
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_nha_cc = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function linkSupplierToTour($tourId, $supplierId, $idDichVu)
    {
        $stmt = $this->db->prepare("
            INSERT INTO tour_nha_cung_cap (tour_id, nha_cc_id, id_DichVu) 
            VALUES (:tour_id, :supplier_id, :id_dich_vu)
        ");

        // GIẢ ĐỊNH tour_id LÀ CHUỖI VÌ BẠN DÙNG ĐỊNH DẠNG 'T-XXXX'
        $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_STR);
        $stmt->bindParam(':supplier_id', $supplierId, PDO::PARAM_INT);
        $stmt->bindParam(':id_dich_vu', $idDichVu, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getLinkedSuppliersByTour($tourId)
    {
        $stmt = $this->db->prepare("
            SELECT
                tncc.tour_id,
                tncc.nha_cc_id,
                ncc.ten_nha_cc,
                ncc.dia_chi,
                dv.TenDichVu AS ten_vai_tro  -- ALIAS NÀY ĐƯỢC DÙNG TRONG VIEW
            FROM
                tour_nha_cung_cap AS tncc
            JOIN
                {$this->table} AS ncc ON tncc.nha_cc_id = ncc.id_nha_cc
            JOIN
                dm_dich_vu AS dv ON tncc.id_DichVu = dv.ID_DichVu 
            WHERE
                tncc.tour_id = :tour_id;
        ");

        // GIẢ ĐỊNH tour_id LÀ CHUỖI
        $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function unlinkSupplierFromTour($tourId, $supplierId)
    {
        // Bạn có thể cần thêm idDichVu vào DELETE nếu bảng dùng 3 cột làm Khóa chính
        $stmt = $this->db->prepare("
            DELETE FROM tour_nha_cung_cap
            WHERE tour_id = :tour_id AND nha_cc_id = :supplier_id
        ");

        $stmt->bindParam(':tour_id', $tourId, PDO::PARAM_STR);
        $stmt->bindParam(':supplier_id', $supplierId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
