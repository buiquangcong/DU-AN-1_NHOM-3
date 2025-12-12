<?php
if (!class_exists('AdminTaiKhoan')) {
    class NccTaiKhoan
    {
        public $db;

        public function __construct()
        {
            $this->db = connectDB();
        }

        public function checkLogin($email, $password)
        {
            try {
                $sql = "SELECT * FROM dm_tai_khoan WHERE TenDangNhap = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    if (password_verify($password, $user['MatKhau'])) {
                        return $user;
                    }
                    else if ($password == $user['MatKhau']) {
                        return $user;
                    } else {
                        return "Mật khẩu không đúng";
                    }
                } else {
                    return "Email không tồn tại";
                }
            } catch (Exception $e) {
                return "Lỗi hệ thống khi kiểm tra đăng nhập.";
            }
        }

        public function getAllTaiKhoan()
        {
            try {

                $sql = "SELECT 
                        tk.ID_TaiKhoan, 
                        tk.ho_ten, 
                        tk.chuc_vu,                    
                        tk.TenDangNhap, 
                        tk.so_dien_thoai, 
                        tk.dia_chi,
                        tk.TrangThai,
                        q.TenQuyen
                    FROM 
                        dm_tai_khoan tk 
                    JOIN 
                        dm_quyen q ON tk.ID_Quyen = q.ID_Quyen
                    ORDER BY 
                        tk.ID_TaiKhoan DESC";

                return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                error_log("Lỗi SQL getAllTaiKhoan: " . $e->getMessage());
                return [];
            }
        }
        /**
         * @param string $chuc_vu 
         * @param int $trang_thai 
         */
        public function insertTaiKhoan($ho_ten, $email, $passwordHash, $id_quyen, $chuc_vu, $sdt, $dia_chi, $trang_thai)
        {
            try {

                $sql = "INSERT INTO dm_tai_khoan 
                (ho_ten, TenDangNhap, MatKhau, ID_Quyen, chuc_vu, so_dien_thoai, dia_chi, TrangThai) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $this->db->prepare($sql);

                $stmt->execute([
                    $ho_ten,
                    $email,
                    $passwordHash, 
                    $id_quyen,
                    $chuc_vu,      
                    $sdt,
                    $dia_chi,
                    $trang_thai    
                ]);

                return true;
            } catch (PDOException $e) {
                error_log("Lỗi SQL insertTaiKhoan: " . $e->getMessage());
                return false;
            }
        }
}
}
