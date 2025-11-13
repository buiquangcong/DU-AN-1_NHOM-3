<!-- <?php
// class AdminSanPham {
//     public $conn;

//     public function __construct(){
//         $this->conn = connectDB();
//     }

//     // ✅ Lấy tất cả tour (sản phẩm)
//     public function getAllSanPham(){
//         try {
//             $sql = 'SELECT dm_tours.*, dm_loai_tour.TenLoaiTour
//                     FROM dm_tours
//                     INNER JOIN dm_loai_tour ON dm_tours.ID_LoaiTour = dm_loai_tour.ID_LoaiTour';
//             $stmt = $this->conn->prepare($sql);
//             $stmt->execute();
//             return $stmt->fetchAll(PDO::FETCH_ASSOC);
//         } catch (Exception $e) {
//             echo "Lỗi truy vấn: " . $e->getMessage();
//             return [];
//         }
//     }

//     // ✅ Thêm tour mới
//     public function insertSanPham(
//         $TenTour,
//         $ID_LoaiTour,
//         $GiaNguoiLon,
//         $GiaTreEm,
//         $SoNgay,
//         $SoDem,
//         $NoiDungTomTat,
//         $NoiDungChiTiet,
//         $NgayKhoiHanh,
//         $DiemKhoiHanh,
//         $SoCho,
//         $TrangThai
//     ){
//         try {
//             $sql = 'INSERT INTO `dm_tours` (
//                         `TenTour`,
//                         `ID_LoaiTour`,
//                         `GiaNguoiLon`,
//                         `GiaTreEm`,
//                         `SoNgay`,
//                         `SoDem`,
//                         `NoiDungTomTat`,
//                         `NoiDungChiTiet`,
//                         `NgayKhoiHanh`,
//                         `DiemKhoiHanh`,
//                         `SoCho`,
//                         `TrangThai`
//                     ) VALUES (
//                         :TenTour,
//                         :ID_LoaiTour,
//                         :GiaNguoiLon,
//                         :GiaTreEm,
//                         :SoNgay,
//                         :SoDem,
//                         :NoiDungTomTat,
//                         :NoiDungChiTiet,
//                         :NgayKhoiHanh,
//                         :DiemKhoiHanh,
//                         :SoCho,
//                         :TrangThai
//                     )';
            
//             $stmt = $this->conn->prepare($sql);
//             $stmt->execute([
//                 ':TenTour'        => $TenTour,
//                 ':ID_LoaiTour'    => $ID_LoaiTour,
//                 ':GiaNguoiLon'    => $GiaNguoiLon,
//                 ':GiaTreEm'       => $GiaTreEm,
//                 ':SoNgay'         => $SoNgay,
//                 ':SoDem'          => $SoDem,
//                 ':NoiDungTomTat'  => $NoiDungTomTat,
//                 ':NoiDungChiTiet' => $NoiDungChiTiet,
//                 ':NgayKhoiHanh'   => $NgayKhoiHanh,
//                 ':DiemKhoiHanh'   => $DiemKhoiHanh,
//                 ':SoCho'          => $SoCho,
//                 ':TrangThai'      => $TrangThai
//             ]);

//             // ✅ Trả về ID vừa thêm
//             return $this->conn->lastInsertId();

//         } catch (Exception $e) {
//             echo "Lỗi thêm sản phẩm: " . $e->getMessage();
//             return false;
//         }
//     }
// }
?> -->

<?php
class AdminSanPham {
    public $conn;

    public function __construct(){
        $this->conn = connectDB();
    }

    // ✅ Lấy tất cả tour (sản phẩm)
    public function getAllSanPham(){
        try {
            $sql = 'SELECT dm_tours.*, dm_loai_tour.TenLoaiTour
                    FROM dm_tours
                    INNER JOIN dm_loai_tour ON dm_tours.ID_LoaiTour = dm_loai_tour.ID_LoaiTour';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
            return [];
        }
    }

    // ✅ Thêm tour mới
   public function insertSanPham(
    $ID_Tour,           // ID_Tour do controller sinh
    $TenTour,
    $ID_LoaiTour,
    $GiaNguoiLon,
    $GiaTreEm,
    $SoNgay,
    $SoDem,
    $NoiDungTomTat,
    $NoiDungChiTiet,
    $NgayKhoiHanh,
    $DiemKhoiHanh,
    $SoCho,
    $TrangThai
){
    try {
        $sql = 'INSERT INTO `dm_tours` (
                    `ID_Tour`,
                    `TenTour`,
                    `ID_LoaiTour`,
                    `GiaNguoiLon`,
                    `GiaTreEm`,
                    `SoNgay`,
                    `SoDem`,
                    `NoiDungTomTat`,
                    `NoiDungChiTiet`,
                    `NgayKhoiHanh`,
                    `DiemKhoiHanh`,
                    `SoCho`,
                    `TrangThai`
                ) VALUES (
                    :ID_Tour,
                    :TenTour,
                    :ID_LoaiTour,
                    :GiaNguoiLon,
                    :GiaTreEm,
                    :SoNgay,
                    :SoDem,
                    :NoiDungTomTat,
                    :NoiDungChiTiet,
                    :NgayKhoiHanh,
                    :DiemKhoiHanh,
                    :SoCho,
                    :TrangThai
                )';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':ID_Tour'        => $ID_Tour,
            ':TenTour'        => $TenTour,
            ':ID_LoaiTour'    => $ID_LoaiTour,
            ':GiaNguoiLon'    => $GiaNguoiLon,
            ':GiaTreEm'       => $GiaTreEm,
            ':SoNgay'         => $SoNgay,
            ':SoDem'          => $SoDem,
            ':NoiDungTomTat'  => $NoiDungTomTat,
            ':NoiDungChiTiet' => $NoiDungChiTiet,
            ':NgayKhoiHanh'   => $NgayKhoiHanh,
            ':DiemKhoiHanh'   => $DiemKhoiHanh,
            ':SoCho'          => $SoCho,
            ':TrangThai'      => $TrangThai
        ]);

        return $ID_Tour; // Trả về ID_Tour vừa thêm

    } catch (Exception $e) {
        echo "Lỗi thêm sản phẩm: " . $e->getMessage();
        return false;
    }
}
    // ✅ Lấy tour theo ID (dùng cho form sửa)
    public function getSanPhamById($id){
        try {
            $sql = "SELECT * FROM dm_tours WHERE ID_Tour = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi lấy tour theo ID: " . $e->getMessage();
            return false;
        }
    }

    // ✅ Cập nhật tour
    public function updateSanPham(
        $ID_Tour,
        $TenTour,
        $ID_LoaiTour,
        $GiaNguoiLon,
        $GiaTreEm,
        $SoNgay,
        $SoDem,
        $NoiDungTomTat,
        $NoiDungChiTiet,
        $NgayKhoiHanh,
        $DiemKhoiHanh,
        $SoCho,
        $TrangThai
    ){
        try {
            $sql = "UPDATE dm_tours SET 
                        TenTour = :TenTour,
                        ID_LoaiTour = :ID_LoaiTour,
                        GiaNguoiLon = :GiaNguoiLon,
                        GiaTreEm = :GiaTreEm,
                        SoNgay = :SoNgay,
                        SoDem = :SoDem,
                        NoiDungTomTat = :NoiDungTomTat,
                        NoiDungChiTiet = :NoiDungChiTiet,
                        NgayKhoiHanh = :NgayKhoiHanh,
                        DiemKhoiHanh = :DiemKhoiHanh,
                        SoCho = :SoCho,
                        TrangThai = :TrangThai
                    WHERE ID_Tour = :ID_Tour";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ID_Tour'        => $ID_Tour,
                ':TenTour'        => $TenTour,
                ':ID_LoaiTour'    => $ID_LoaiTour,
                ':GiaNguoiLon'    => $GiaNguoiLon,
                ':GiaTreEm'       => $GiaTreEm,
                ':SoNgay'         => $SoNgay,
                ':SoDem'          => $SoDem,
                ':NoiDungTomTat'  => $NoiDungTomTat,
                ':NoiDungChiTiet' => $NoiDungChiTiet,
                ':NgayKhoiHanh'   => $NgayKhoiHanh,
                ':DiemKhoiHanh'   => $DiemKhoiHanh,
                ':SoCho'          => $SoCho,
                ':TrangThai'      => $TrangThai
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi cập nhật tour: " . $e->getMessage();
            return false;
        }
    }
    // ✅ Xóa tour
    // ✅ Xóa tour theo ID
public function deleteSanPham($ID_Tour){
    try {
        $sql = "DELETE FROM dm_tours WHERE ID_Tour = :ID_Tour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':ID_Tour' => $ID_Tour]);
        return true;
    } catch (Exception $e) {
        echo "Lỗi xóa tour: " . $e->getMessage();
        return false;
    }
}
}
?>

