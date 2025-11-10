<?php
// (Giả sử bạn đã có file Database.php để kết nối CSDL)
// require_once 'Database.php';

class Tour
{

    // Hàm lấy tất cả tour
    public function getAllTours()
    {
        // Viết code SQL SELECT * FROM DM_TOURS ở đây
        echo "Đang lấy tất cả tour...";
        return []; // Trả về mảng dữ liệu
    }

    // Hàm lấy tour theo ID
    public function getTourById($id)
    {
        // Viết code SQL SELECT * FROM DM_TOURS WHERE ID_Tour = ?
        echo "Đang lấy tour có ID = $id";
        return null; // Trả về 1 tour
    }

    // Hàm lấy tour nổi bật
    public function getTourNoiBat()
    {
        // Viết code SQL SELECT ... LIMIT 6
        return [];
    }

    // Hàm tạo tour mới
    public function createTour($tenTour, $gia)
    {
        // Viết code SQL INSERT INTO...
        echo "Đang lưu tour mới: $tenTour";
    }

    // Hàm cập nhật tour
    public function updateTour($id, $tenTour, $gia)
    {
        // Viết code SQL UPDATE... WHERE ID_Tour = ?
        echo "Đang cập nhật tour ID = $id";
    }

    // Hàm xóa tour
    public function deleteTour($id)
    {
        // Viết code SQL DELETE FROM... WHERE ID_Tour = ?
        echo "Đang xóa tour ID = $id";
    }
}
