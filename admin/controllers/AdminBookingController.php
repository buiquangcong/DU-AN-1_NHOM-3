<?php
// File: /admin/controllers/AdminBookingController.php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AdminBookingController
{
    public $modelBooking;

    public function __construct()
    {
        // Khởi tạo Model
        $this->modelBooking = new AdminBookingModel();
    }

    /**
     * Action: Hiển thị danh sách Booking (?act=quan-ly-booking)
     */
    public function danhSachBooking()
    {
        // Gọi Model để lấy dữ liệu
        $listBookings = $this->modelBooking->getAllBookings();

        // Load view và truyền dữ liệu
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

        // Gọi Model (sẽ tạo ở bước 3)
        $bookingDetail = $this->modelBooking->getBookingById($booking_id);
        $listGuests = $this->modelBooking->getGuestsByBookingID($booking_id);

        // Load view (sẽ tạo ở bước 4)
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/manage-guests.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Action: Xử lý thêm khách mới vào đoàn (?act=add-guest)
     */
    public function addGuest()
    {
        $booking_id = $_POST['ID_Booking'] ?? null;
        if (!$booking_id) {
            header('Location: ?act=quan-ly-booking');
            exit;
        }

        // Lấy dữ liệu từ form
        $data = [
            'ID_Booking' => $booking_id,
            'TenNguoiDi' => $_POST['TenNguoiDi'],
            'GioiTinh' => $_POST['GioiTinh'],
            'NgaySinh' => $_POST['NgaySinh'],
            'LienHe' => $_POST['LienHe'],
            'CCCD_Passport' => $_POST['CCCD_Passport'],
            'GhiChu' => $_POST['GhiChu']
        ];

        // Gọi Model (sẽ tạo ở bước 3)
        $this->modelBooking->addGuest($data);

        $_SESSION['success'] = "Thêm khách vào đoàn thành công!";
        header('Location: ?act=manage-guests&booking_id=' . $booking_id);
        exit;
    }

    /**
     * Action: Xử lý xóa khách khỏi đoàn (?act=delete-guest)
     */
    public function deleteGuest()
    {
        $guest_id = $_GET['guest_id'] ?? null;
        $booking_id = $_GET['booking_id'] ?? null;

        if ($guest_id) {
            // Gọi Model (sẽ tạo ở bước 3)
            $this->modelBooking->deleteGuest($guest_id);
            $_SESSION['success'] = "Xóa khách khỏi đoàn thành công!";
        }

        header('Location: ?act=manage-guests&booking_id=' . $booking_id);
        exit;
    }
    public function updateCheckinStatus()
    {
        $guest_id = $_GET['guest_id'] ?? null;
        $booking_id = $_GET['booking_id'] ?? null;
        $status = $_GET['status'] ?? 0; // Lấy trạng thái mới từ URL

        if ($guest_id && $booking_id) {
            // Gọi Model (sẽ tạo ở Bước 3)
            $this->modelBooking->updateCheckinStatus($guest_id, $status);
            $_SESSION['success'] = "Cập nhật check-in thành công!";
        }

        // Quay lại trang quản lý khách
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

        // 1. Lấy mảng dữ liệu từ form
        // Mảng này sẽ có dạng [ guest_id => status, guest_id => status, ... ]
        $guest_statuses = $_POST['guest_status'] ?? [];

        // 2. Lặp qua từng khách trong mảng để cập nhật
        foreach ($guest_statuses as $guest_id => $status) {
            // 3. Gọi lại hàm Model CŨ (updateCheckinStatus)
            // Chúng ta tận dụng lại hàm cập nhật 1 khách
            $this->modelBooking->updateCheckinStatus($guest_id, $status);
        }

        $_SESSION['success'] = "Cập nhật check-in cho cả đoàn thành công!";

        // Quay lại trang quản lý khách
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

        // 1. Kiểm tra file upload
        if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0) {

            $filePath = $_FILES['excel_file']['tmp_name'];

            try {
                // 2. Dùng thư viện để load file
                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getActiveSheet();

                $count = 0;

                // 3. Lặp qua từng dòng (bắt đầu từ dòng 2, bỏ qua tiêu đề)
                foreach ($sheet->getRowIterator() as $row) {
                    if ($row->getRowIndex() == 1) {
                        continue; // Bỏ qua dòng tiêu đề
                    }

                    // 4. Đọc dữ liệu từ các ô
                    // (Giả định A=Họ Tên, B=Giới tính, C=Ngày Sinh, D=Liên Hệ, E=CCCD, F=Ghi Chú)
                    $ten_nguoi_di = $sheet->getCell('A' . $row->getRowIndex())->getValue();

                    // Nếu cột Tên trống, dừng lại (coi như hết file)
                    if (empty($ten_nguoi_di)) {
                        break;
                    }

                    $gioi_tinh = $sheet->getCell('B' . $row->getRowIndex())->getValue();

                    // Xử lý ngày sinh (Excel lưu ngày tháng rất phức tạp)
                    $ngay_sinh_excel = $sheet->getCell('C' . $row->getRowIndex())->getValue();
                    $ngay_sinh = null;
                    if (!empty($ngay_sinh_excel)) {
                        if (is_numeric($ngay_sinh_excel)) {
                            // Nếu là số, chuyển từ Excel timestamp
                            $ngay_sinh = Date::excelToDateTimeObject($ngay_sinh_excel)->format('Y-m-d');
                        } else {
                            // Nếu là chữ, cố gắng dùng
                            $ngay_sinh = date('Y-m-d', strtotime($ngay_sinh_excel));
                        }
                    }

                    $lien_he = $sheet->getCell('D' . $row->getRowIndex())->getValue();
                    $cccd = $sheet->getCell('E' . $row->getRowIndex())->getValue();
                    $ghi_chu = $sheet->getCell('F' . $row->getRowIndex())->getValue();

                    // 5. Chuẩn bị data và gọi Model (dùng lại hàm addGuest)
                    $data = [
                        'ID_Booking' => $booking_id,
                        'TenNguoiDi' => $ten_nguoi_di,
                        'GioiTinh' => $gioi_tinh,
                        'NgaySinh' => $ngay_sinh,
                        'LienHe' => $lien_he,
                        'CCCD_Passport' => $cccd,
                        'GhiChu' => $ghi_chu
                    ];

                    // Dùng $this->modelBooking (theo style OOP của bạn)
                    $this->modelBooking->addGuest($data);
                    $count++;
                }

                $_SESSION['success'] = "Đã import thành công $count khách từ file Excel.";
            } catch (Exception $e) {
                // Nếu file bị lỗi (ví dụ: không phải file Excel)
                $_SESSION['error']['itinerary'] = "Lỗi đọc file: " . $e->getMessage();
            }
        } else {
            $_SESSION['error']['itinerary'] = "Không có file nào được tải lên hoặc file bị lỗi.";
        }

        header('Location: ?act=manage-guests&booking_id=' . $booking_id);
        exit;
    }
}
