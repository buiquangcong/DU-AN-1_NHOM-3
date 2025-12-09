<?php

$PROJECT_ROOT_PATH = dirname(__DIR__, 2); 

/**
 * (SỬA LỖI 2) Khai báo Class
 * Tên class phải khớp với tên file và khớp với
 * tên gọi trong Controller (new AdminTour())
 */
class AdminTour
{
    /**
     * Hàm này sẽ được gọi bởi saveAdd()
     * (Chúng ta sẽ viết code SQL ở đây sau)
     */
    public function insertTour(
        $tenTour,
        $idLoaiTour,
        $giaNguoiLon,
        $giaTreEm,
        $soCho,
        $ngayKhoiHanh,
        $soNgay,
        $diemKhoiHanh,
        $noiDungTomTat,
        $noiDungChiTiet,
        $trangThai
    ) {
        // (Code SQL INSERT INTO dm_tours... sẽ ở đây)
        // $sql = "INSERT INTO dm_tours (TenTour, ID_LoaiTour, ...) VALUES (?, ?, ...)";
        // pdo_execute($sql, $tenTour, $idLoaiTour, ...);

        // (Tạm thời trả về 1 để mô phỏng ID tour mới)
        return 1;
    }

    /**
     * Hàm này sẽ được gọi để lưu ảnh
     * (Chúng ta sẽ viết code SQL ở đây sau)
     */
    public function insertAnhTour($idTourMoi, $image_url_chinh, $is_anh_bia)
    {
        // (Code SQL INSERT INTO dm_anh_tour... sẽ ở đây)        // $sql = "INSERT INTO dm_anh_tour (ID_Tour, DuongDan, LaAnhBia) VALUES (?, ?, ?)";
        // pdo_execute($sql, $idTourMoi, $image_url_chinh, $is_anh_bia);
    }

    // (Các hàm khác như getAllTours, getTourById... sẽ ở đây)
}
