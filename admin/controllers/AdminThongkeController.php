<?php
require_once __DIR__ . '/../models/AdminThongKeModel.php';
class AdminThongkeController{
     public function dashboard()
    {
        $thongKeModel = new AdminThongKeModel();
        $soLuongTour = $thongKeModel->countTours();
        $soLuongDanhMuc = $thongKeModel->countDanhMuc();
        $soLuongUser = $thongKeModel->countTaiKhoan();
        $soLuongDonHang = $thongKeModel->countBooking();
        $listRecentTours = $thongKeModel->getRecentTours();
        require_once './views/layout/header.php';
        require_once './views/dashboard.php'; 
        require_once './views/layout/footer.php';
    }
}
?>