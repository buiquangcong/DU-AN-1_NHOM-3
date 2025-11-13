<?php
class AdminTaiKhoan
{
    public $db;

    public function __construct()
    {
        $this->db = connectDB();
    }

    // 1. Kiểm tra đăng nhập (Sửa tên bảng thành dm_tai_khoan)
    public function checkLogin($email, $password)
    {
        // SỬA: Chọn từ bảng dm_tai_khoan
        $sql = "SELECT * FROM dm_tai_khoan WHERE TenDangNhap = '$email'";
        $user = $this->db->query($sql)->fetch();

        if ($user) {
            // Trường hợp 1: Mật khẩu trong DB đã mã hóa (Code chuẩn)
            if (password_verify($password, $user['MatKhau'])) {
                return $user;
            }
            // Trường hợp 2: Mật khẩu chưa mã hóa (Để bạn đăng nhập được nick admin@gmail.com / 123321 hiện tại)
            else if ($password == $user['MatKhau']) {
                return $user;
            } else {
                return "Mật khẩu không đúng";
            }
        } else {
            return "Email không tồn tại";
        }
    }

    // 2. Lấy danh sách tài khoản (Join dm_tai_khoan và dm_quyen)
    public function getAllTaiKhoan()
    {
        // SỬA: Join bảng dm_tai_khoan với dm_quyen
        $sql = "SELECT tk.*, q.TenQuyen 
                FROM dm_tai_khoan tk 
                JOIN dm_quyen q ON tk.ID_Quyen = q.ID_Quyen
                ORDER BY tk.ID_TaiKhoan DESC";
        return $this->db->query($sql)->fetchAll();
    }

    // 3. Thêm tài khoản mới
    public function insertTaiKhoan($ho_ten, $email, $mat_khau, $id_quyen)
    {
        try {
            // 1. Câu lệnh SQL (Dùng dấu ? để bảo mật hơn)
            $sql = "INSERT INTO dm_tai_khoan (TenDangNhap, MatKhau, ID_Quyen, ho_ten, TrangThai) 
                VALUES (?, ?, ?, ?, 1)";

            // 2. Chuẩn bị câu lệnh (Prepare)
            $stmt = $this->db->prepare($sql);

            // 3. Thực thi (Execute) với mảng dữ liệu đúng thứ tự các dấu ?
            $stmt->execute([$email, $mat_khau, $id_quyen, $ho_ten]);

            // (Tùy chọn) Nếu muốn trả về ID vừa thêm
            // return $this->db->lastInsertId();

        } catch (PDOException $e) {
            echo "Lỗi SQL: " . $e->getMessage();
        }
    }

    // 4. Lấy chi tiết tài khoản
    public function getDetailAdmin($id)
    {
        $sql = "SELECT * FROM dm_tai_khoan WHERE ID_TaiKhoan = $id";
        return $this->db->query($sql)->fetch();
    }

    // 5. Cập nhật tài khoản
    // (Lưu ý: Bạn cần kiểm tra lại các cột SoDienThoai, HoTen... có trong bảng dm_tai_khoan không nhé, 
    // vì trong ảnh mình chỉ thấy: ID_TaiKhoan, TenDangNhap, MatKhau, ID_Quyen, TrangThai)

    public function resetPassword($id, $newPass)
    {
        $sql = "UPDATE dm_tai_khoan SET MatKhau = '$newPass' WHERE ID_TaiKhoan = $id";
        return $this->db->exec($sql);
    }
}
