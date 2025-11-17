<?php
class AdminTaiKhoan
{
    public $db;

    public function __construct()
    {
        // Giả định connectDB() trả về đối tượng PDO
        $this->db = connectDB();
    }

    // 1. Kiểm tra đăng nhập (Không cần sửa đổi)
    public function checkLogin($email, $password)
    {
        // Sử dụng prepare/execute để bảo mật hơn, thay vì truyền biến trực tiếp vào query
        $sql = "SELECT * FROM dm_tai_khoan WHERE TenDangNhap = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Trường hợp 1: Mật khẩu trong DB đã mã hóa (Code chuẩn)
            if (password_verify($password, $user['MatKhau'])) {
                return $user;
            }
            // Trường hợp 2: Mật khẩu chưa mã hóa (Code cũ/tạm thời)
            else if ($password == $user['MatKhau']) {
                return $user;
            } else {
                return "Mật khẩu không đúng";
            }
        } else {
            return "Email không tồn tại";
        }
    }

    // 2. Lấy danh sách tài khoản (Join dm_tai_khoan và dm_quyen + Thêm SĐT, Địa chỉ)
    public function getAllTaiKhoan()
    {
        // Lấy cột MoTa (chức vụ) từ dm_quyen và các cột mới từ dm_tai_khoan
        $sql = "SELECT 
                    tk.ID_TaiKhoan, 
                    tk.ho_ten, 
                    q.MoTa AS chuc_vu, 
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
    }

    // 3. Thêm tài khoản mới (Thêm SĐT và Địa chỉ)
    public function insertTaiKhoan($ho_ten, $email, $mat_khau, $id_quyen, $sdt, $dia_chi)
    {
        try {
            // LƯU Ý: Nên MÃ HÓA MẬT KHẨU ở đây: $mat_khau_hash = password_hash($mat_khau, PASSWORD_DEFAULT);
            $sql = "INSERT INTO dm_tai_khoan 
                (TenDangNhap, MatKhau, ID_Quyen, ho_ten, so_dien_thoai, dia_chi, TrangThai) 
                VALUES (?, ?, ?, ?, ?, ?, 1)"; // TrangThai = 1 (Hoạt động)

            $stmt = $this->db->prepare($sql);

            // Dữ liệu: Email, Mật khẩu (Chưa hash), ID Quyền, Họ tên, SĐT mới, Địa chỉ mới
            $stmt->execute([$email, $mat_khau, $id_quyen, $ho_ten, $sdt, $dia_chi]);

            return true;
        } catch (PDOException $e) {
            echo "Lỗi SQL: " . $e->getMessage();
            return false;
        }
    }

    // 4. Lấy chi tiết tài khoản (Thêm thông tin quyền để hiển thị)
    public function getDetailAdmin($id)
    {
        // JOIN để lấy cả MoTa (Chức vụ) và ID_Quyen
        $sql = "SELECT tk.*, q.MoTa AS chuc_vu
                FROM dm_tai_khoan tk 
                JOIN dm_quyen q ON tk.ID_Quyen = q.ID_Quyen
                WHERE tk.ID_TaiKhoan = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 5. Cập nhật tài khoản (Thêm SĐT và Địa chỉ, và cập nhật ID_Quyen)
    public function updateTaiKhoan($id, $ho_ten, $email, $id_quyen, $sdt, $dia_chi)
    {
        $sql = "UPDATE dm_tai_khoan 
                SET ho_ten=?, TenDangNhap=?, ID_Quyen=?, so_dien_thoai=?, dia_chi=? 
                WHERE ID_TaiKhoan=?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $ho_ten,
            $email,
            $id_quyen,
            $sdt,
            $dia_chi,
            $id
        ]);
    }

    // 6. Đặt lại Mật khẩu (Sử dụng prepare/execute để bảo mật hơn)
    public function resetPassword($id, $newPass)
    {
        // LƯU Ý: Nên MÃ HÓA MẬT KHẨU ở đây
        $sql = "UPDATE dm_tai_khoan SET MatKhau = ? WHERE ID_TaiKhoan = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$newPass, $id]);
    }

    // 7. Xóa tài khoản (Thêm nếu bạn cần)
    public function deleteTaiKhoan($id)
    {
        $sql = "DELETE FROM dm_tai_khoan WHERE ID_TaiKhoan = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
