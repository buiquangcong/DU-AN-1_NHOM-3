<?php
if (!class_exists('HdvTaiKhoan')) {
    class HdvTaiKhoan
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
                    } else if ($password == $user['MatKhau']) {
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


        public function getDetailHdv($id)
        {
            try {
                $sql = "SELECT tk.*, q.TenQuyen
                    FROM dm_tai_khoan tk 
                    JOIN dm_quyen q ON tk.ID_Quyen = q.ID_Quyen
                    WHERE tk.ID_TaiKhoan = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$id]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                error_log("Lỗi getDetailHdv: " . $e->getMessage());
                return null;
            }
        }

        public function getAllQuyen()
        {
            try {
                $sql = "SELECT * FROM dm_quyen ORDER BY ID_Quyen ASC";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                return [];
            }
        }
    }
}
