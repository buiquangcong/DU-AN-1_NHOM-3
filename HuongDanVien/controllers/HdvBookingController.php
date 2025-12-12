<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class HdvBookingController
{
    public $modelBooking;

    public function __construct()
    {
        $this->modelBooking = new HdvBookingModel();
    }

    public function danhSachBooking()
    {
        $listBookings = $this->modelBooking->getAllBookings();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/list-booking.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function manageGuests()
    {
        $booking_id = $_GET['booking_id'] ?? null;
        if (!$booking_id) {
            header('Location: ?act=quan-ly-booking');
            exit;
        }

        $bookingDetail = $this->modelBooking->getBookingById($booking_id);
        $listGuests = $this->modelBooking->getGuestsByBookingID($booking_id);

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/manage-guests.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function addGuest()
    {
        $booking_id = $_POST['ID_Booking'] ?? null;
        if (!$booking_id) {
            header('Location: ?act=quan-ly-booking');
            exit;
        }

        $data = [
            'ID_Booking' => $booking_id,
            'TenNguoiDi' => $_POST['TenNguoiDi'],
            'GioiTinh' => $_POST['GioiTinh'],
            'NgaySinh' => $_POST['NgaySinh'],
            'LienHe' => $_POST['LienHe'],
            'CCCD_Passport' => $_POST['CCCD_Passport'],
            'GhiChu' => $_POST['GhiChu']
        ];

        $this->modelBooking->addGuest($data);

        $_SESSION['success'] = "Thêm khách vào đoàn thành công!";
        header('Location: ?act=manage-guests&booking_id=' . $booking_id);
        exit;
    }

    public function updateCheckinStatus()
    {
        $guest_id = $_GET['guest_id'] ?? null;
        $booking_id = $_GET['booking_id'] ?? null;
        $status = $_GET['status'] ?? 0;

        if ($guest_id && $booking_id) {
            $this->modelBooking->updateCheckinStatus($guest_id, $status);
            $_SESSION['success'] = "Cập nhật check-in thành công!";
        }

        header('Location: ?act=manage-guests&booking_id=' . $booking_id);
        exit;
    }
    public function bulkUpdateCheckinStatus()
    {
        $booking_id = $_POST['booking_id'] ?? null;
        if (!$booking_id) {
            header('Location: ?act=quan-ly-booking');
            exit;
        }

        $guest_statuses = $_POST['guest_status'] ?? [];

        foreach ($guest_statuses as $guest_id => $status) {
            $this->modelBooking->updateCheckinStatus($guest_id, $status);
        }

        $_SESSION['success'] = "Cập nhật check-in cho cả đoàn thành công!";

        header('Location: ?act=manage-guests&booking_id=' . $booking_id);
        exit;
    }
    public function importExcelGuests()
    {
        $booking_id = $_POST['ID_Booking'] ?? null;
        if (!$booking_id) {
            header('Location: ?act=quan-ly-booking');
            exit;
        }

        if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0) {

            $filePath = $_FILES['excel_file']['tmp_name'];

            try {
                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getActiveSheet();

                $count = 0;

                foreach ($sheet->getRowIterator() as $row) {
                    if ($row->getRowIndex() == 1) {
                        continue;
                    }

                    $ten_nguoi_di = $sheet->getCell('A' . $row->getRowIndex())->getValue();

                    if (empty($ten_nguoi_di)) {
                        break;
                    }

                    $gioi_tinh = $sheet->getCell('B' . $row->getRowIndex())->getValue();

                    $ngay_sinh_excel = $sheet->getCell('C' . $row->getRowIndex())->getValue();
                    $ngay_sinh = null;
                    if (!empty($ngay_sinh_excel)) {
                        if (is_numeric($ngay_sinh_excel)) {
                            $ngay_sinh = Date::excelToDateTimeObject($ngay_sinh_excel)->format('Y-m-d');
                        } else {
                            $ngay_sinh = date('Y-m-d', strtotime($ngay_sinh_excel));
                        }
                    }

                    $lien_he = $sheet->getCell('D' . $row->getRowIndex())->getValue();
                    $cccd = $sheet->getCell('E' . $row->getRowIndex())->getValue();
                    $ghi_chu = $sheet->getCell('F' . $row->getRowIndex())->getValue();

                    $data = [
                        'ID_Booking' => $booking_id,
                        'TenNguoiDi' => $ten_nguoi_di,
                        'GioiTinh' => $gioi_tinh,
                        'NgaySinh' => $ngay_sinh,
                        'LienHe' => $lien_he,
                        'CCCD_Passport' => $cccd,
                        'GhiChu' => $ghi_chu
                    ];

                    $this->modelBooking->addGuest($data);
                    $count++;
                }

                $_SESSION['success'] = "Đã import thành công $count khách từ file Excel.";
            } catch (Exception $e) {
                $_SESSION['error']['itinerary'] = "Lỗi đọc file: " . $e->getMessage();
            }
        } else {
            $_SESSION['error']['itinerary'] = "Không có file nào được tải lên hoặc file bị lỗi.";
        }

        header('Location: ?act=manage-guests&booking_id=' . $booking_id);
        exit;
    }

    public function chiTietBooking()
    {
        $id = $_GET['id'] ?? 0;

        $booking = $this->modelBooking->getBookingById($id);
        $guests  = $this->modelBooking->getGuestsByBookingId($id);

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/detail-booking.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
