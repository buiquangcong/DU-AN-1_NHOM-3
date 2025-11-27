<?php
if (!class_exists('AdminTaiKhoan')) {
    class AdminTaiKhoan
    {
        public $db;

        public function __construct()
        {
            // Giả định connectDB() trả về đối tượng PDO
            $this->db = connectDB();
        }

        // =================================================================
        // 1. Kiểm tra đăng nhập (Giữ nguyên - Code chuẩn hóa)
        // =================================================================
        public function checkLogin($email, $password)
        {
            try {
                $sql = "SELECT * FROM dm_tai_khoan WHERE TenDangNhap = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    // Ưu tiên kiểm tra mật khẩu đã mã hóa (Tốt nhất)
                    if (password_verify($password, $user['MatKhau'])) {
                        return $user;
                    }
                    // Hỗ trợ trường hợp mật khẩu chưa mã hóa (Code tạm thời/cũ)
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

        // =================================================================
        // 2. Lấy danh sách tài khoản (ĐÃ SỬA: Thêm cột Chức vụ)
        // =================================================================
        public function getAllTaiKhoan()
        {
            try {
                $sql = "SELECT 
                    tk.ID_TaiKhoan, 
                    tk.ho_ten, 
                    q.TenQuyen AS chuc_vu,  -- SỬA: Lấy Tên Quyền (q.TenQuyen) và đặt tên alias là chuc_vu
                    tk.TenDangNhap, 
                    tk.so_dien_thoai, 
                    tk.dia_chi,
                    tk.TrangThai
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

        // ===============================================================
        public function insertTaiKhoan($ho_ten, $email, $passwordHash, $id_quyen, $chuc_vu, $sdt, $dia_chi, $trang_thai)
        {
            try {
                // LƯU Ý: Controller đã hash mật khẩu, nên ta truyền $passwordHash

                $sql = "INSERT INTO dm_tai_khoan 
                (ho_ten, TenDangNhap, MatKhau, ID_Quyen, chuc_vu, so_dien_thoai, dia_chi, TrangThai) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $this->db->prepare($sql);

                // SỬA DỮ LIỆU: Bổ sung chuc_vu và TrangThai vào execute
                $stmt->execute([
                    $ho_ten,
                    $email,
                    $passwordHash, // Mật khẩu đã Hash
                    $id_quyen,
                    $chuc_vu,      // Tham số mới
                    $sdt,
                    $dia_chi,
                    $trang_thai    // Tham số mới
                ]);

                return true;
            } catch (PDOException $e) {
                error_log("Lỗi SQL insertTaiKhoan: " . $e->getMessage());
                return false;
            }
        }


        // =================================================================
        // 4. Lấy chi tiết tài khoản (ĐÃ SỬA: Lấy cột chuc_vu)
        // =================================================================
        public function getDetailAdmin($id)
        {
            try {
                // Lấy cột chuc_vu từ dm_tai_khoan và TenQuyen từ dm_quyen
                $sql = "SELECT tk.*, q.TenQuyen
                    FROM dm_tai_khoan tk 
                    JOIN dm_quyen q ON tk.ID_Quyen = q.ID_Quyen
                    WHERE tk.ID_TaiKhoan = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$id]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                error_log("Lỗi getDetailAdmin: " . $e->getMessage());
                return null;
            }
        }

        // =================================================================
        // 5. Cập nhật tài khoản (ĐÃ SỬA: Thêm cột chuc_vu)
        // =================================================================
        public function updateTaiKhoan($id, $ho_ten, $email, $id_quyen, $sdt, $dia_chi, $trang_thai)
        {
            $sql = "UPDATE dm_tai_khoan 
                SET ho_ten=?, TenDangNhap=?, ID_Quyen=?, so_dien_thoai=?, dia_chi=?, TrangThai=? 
                WHERE ID_TaiKhoan=?";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                $ho_ten,
                $email,
                $id_quyen,
                $sdt,
                $dia_chi,
                $trang_thai, // SỬA: Thêm TrangThai
                $id
            ]);
        }

        // 6. Đặt lại Mật khẩu (SỬA: Đã bỏ password_hash và để Controller xử lý)
        public function resetPassword($id, $newPassHash)
        {
            $sql = "UPDATE dm_tai_khoan SET MatKhau = ? WHERE ID_TaiKhoan = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$newPassHash, $id]);
        }

        // 7. Xóa tài khoản (Giữ nguyên)
        public function deleteTaiKhoan($id)
        {
            $sql = "DELETE FROM dm_tai_khoan WHERE ID_TaiKhoan = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        }

        // 8. Lấy danh sách Quyền (Cần cho Controller)
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
