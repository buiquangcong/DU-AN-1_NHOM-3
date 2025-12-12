<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class NccBookingController
{
    public $modelBooking;

    public function __construct()
    {
        $this->modelBooking = new NccBookingModel();
    }

    public function danhSachBooking()
    {
        $listBookings = $this->modelBooking->getAllBookings();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/list-booking.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function chiTietBooking()
    {
        $id = $_GET['id'] ?? 0;

        // Lấy thông tin booking và khách
        $booking = $this->modelBooking->getBookingById($id);
        $guests  = $this->modelBooking->getGuestsByBookingId($id);

        // Truyền dữ liệu ra view
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/detail-booking.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

}
