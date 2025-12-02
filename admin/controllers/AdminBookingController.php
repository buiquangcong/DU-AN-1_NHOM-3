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
        // 1. Lấy từ khóa tìm kiếm từ URL
        $keyword = $_GET['keyword'] ?? null;

        // 2. Truyền keyword vào Model
        $listBookings = $this->modelBooking->getAllBookings($keyword);

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/list-booking.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function deleteBooking()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelBooking->deleteBooking($id);
            $_SESSION['success'] = "Đã xóa Booking thành công!";
        }
        header('Location: ?act=quan-ly-booking');
        exit;
    }

    // Hàm editBooking (bạn cần tạo thêm view edit-booking.php tương tự add-booking.php nhưng có dữ liệu đổ vào)
    public function editBooking()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?act=quan-ly-booking');
            exit;
        }

        // Lấy dữ liệu cũ để hiển thị
        $booking = $this->modelBooking->getBookingById($id);
        $tours = $this->modelBooking->getAllTours();

        if (!$booking) {
            $_SESSION['error'] = "Không tìm thấy Booking này.";
            header('Location: ?act=quan-ly-booking');
            exit;
        }

        // Xử lý khi bấm nút "Cập nhật"
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TourID'            => $_POST['tour_id'],
                'TenKhachHang'      => trim($_POST['TenKhachHang']),
                'Email'             => trim($_POST['Email']),
                'NgayDatTour'       => $_POST['ngay_dat'],
                'SoLuongNguoiLon'   => (int)$_POST['so_luong_nl'],
                'SoLuongTreEm'      => (int)$_POST['so_luong_te'],
                'TrangThai'         => (int)$_POST['trang_thai']
            ];

            if ($this->modelBooking->updateBooking($id, $data)) {
                $_SESSION['success'] = "Cập nhật Booking #$id thành công!";
                header('Location: ?act=quan-ly-booking');
                exit;
            } else {
                $errors[] = "Lỗi khi cập nhật (Vui lòng kiểm tra lại dữ liệu).";
            }
        }

        // Load view
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/edit-booking.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
    public function manageGuests()
    {
        $booking_id = $_GET['booking_id'] ?? null;
        if (!$booking_id) {
            header('Location: ?act=quan-ly-booking');
            exit;
        }

        // Gọi Model
        $bookingDetail = $this->modelBooking->getBookingById($booking_id);
        $listGuests = $this->modelBooking->getGuestsByBookingID($booking_id);

        // Load view
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

        // Gọi Model
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
            // Gọi Model
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

        // 1. Kiểm tra file upload
        if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0) {

            $filePath = $_FILES['excel_file']['tmp_name'];

            try {
                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getActiveSheet();
                $count = 0;

                foreach ($sheet->getRowIterator() as $row) {
                    if ($row->getRowIndex() == 1) continue;

                    $ten_nguoi_di = $sheet->getCell('A' . $row->getRowIndex())->getValue();
                    if (empty($ten_nguoi_di)) break;

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


    public function addBooking()
    {
        // Lấy danh sách để hiển thị form
        $tours = $this->modelBooking->getAllTours();
        $customers = $this->modelBooking->getAllCustomers();

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- 1. Xác thực và Chuẩn hóa dữ liệu đầu vào ---
            $tour_id = $_POST['tour_id'] ?? '';
            $ten_kh = trim($_POST['TenKhachHang'] ?? '');
            $email_kh = trim($_POST['Email'] ?? '');
            $ngay_dat = $_POST['ngay_dat'] ?? '';
            $so_nl = $_POST['so_luong_nl'] ?? 0;
            $so_te = $_POST['so_luong_te'] ?? 0;
            $trang_thai = $_POST['trang_thai'] ?? 0;

            // Kiểm tra cơ bản
            if (empty($tour_id) || $tour_id === '-- Chọn Tour --') {
                $errors[] = "Vui lòng chọn Tour.";
            }
            if (empty($ten_kh)) {
                $errors[] = "Tên khách hàng không được để trống.";
            }
            if (empty($email_kh)) {
                $errors[] = "Email khách hàng không được để trống.";
            }
            if (empty($ngay_dat)) {
                $errors[] = "Vui lòng chọn Ngày đặt.";
            }
            if ((int)$so_nl + (int)$so_te <= 0) {
                $errors[] = "Tổng số lượng người lớn và trẻ em phải lớn hơn 0.";
            }

            if (empty($errors)) {
                $data = [
                    'TourID'            => $tour_id,
                    'TenKhachHang'      => $ten_kh,
                    'Email'             => $email_kh,
                    'NgayDatTour'       => $ngay_dat,
                    'SoLuongNguoiLon'   => (int)$so_nl,
                    'SoLuongTreEm'      => (int)$so_te,
                    'TrangThai'         => (int)$trang_thai
                ];

                // === BẮT ĐẦU: Xử lý thêm Booking và lấy ID ===
                $newBookingId = $this->modelBooking->addBookingSimple($data);

                if ($newBookingId) {

                    // 


                    // =================================================================
                    // [ĐÂY LÀ PHẦN TÔI ĐÃ THÊM VÀO GIÚP BẠN]
                    // Tự động thêm người đặt tour vào danh sách khách
                    // =================================================================
                    $this->modelBooking->addGuest([
                        'ID_Booking'    => $newBookingId,
                        'TenNguoiDi'    => $ten_kh,      // Lấy tên từ người đại diện
                        'GioiTinh'      => 'Khác',
                        'NgaySinh'      => null,
                        'LienHe'        => $email_kh,    // Lấy email từ người đại diện
                        'CCCD_Passport' => '',
                        'GhiChu'        => 'Người đặt tour (Tự động thêm)'
                    ]);
                    // =================================================================

                    // === A. XỬ LÝ KHÁCH HÀNG TỪ FILE EXCEL (Nếu có upload) ===
                    if (isset($_FILES['guest_file']) && $_FILES['guest_file']['error'] == 0) {
                        try {
                            $filePath = $_FILES['guest_file']['tmp_name'];
                            $spreadsheet = IOFactory::load($filePath);
                            $sheet = $spreadsheet->getActiveSheet();

                            foreach ($sheet->getRowIterator() as $row) {
                                if ($row->getRowIndex() == 1) continue;

                                $ten = $sheet->getCell('A' . $row->getRowIndex())->getValue();
                                if (empty($ten)) break;

                                $gioiTinh = $sheet->getCell('B' . $row->getRowIndex())->getValue();
                                $ngaySinhRaw = $sheet->getCell('C' . $row->getRowIndex())->getValue();
                                $ngaySinh = null;
                                if (!empty($ngaySinhRaw)) {
                                    if (is_numeric($ngaySinhRaw)) {
                                        $ngaySinh = Date::excelToDateTimeObject($ngaySinhRaw)->format('Y-m-d');
                                    } else {
                                        $ngaySinh = date('Y-m-d', strtotime($ngaySinhRaw));
                                    }
                                }

                                $lienHe = $sheet->getCell('D' . $row->getRowIndex())->getValue();
                                $cccd = $sheet->getCell('E' . $row->getRowIndex())->getValue();
                                $ghiChu = $sheet->getCell('F' . $row->getRowIndex())->getValue();

                                $this->modelBooking->addGuest([
                                    'ID_Booking' => $newBookingId,
                                    'TenNguoiDi' => $ten,
                                    'GioiTinh' => $gioiTinh,
                                    'NgaySinh' => $ngaySinh,
                                    'LienHe' => $lienHe,
                                    'CCCD_Passport' => $cccd,
                                    'GhiChu' => $ghiChu
                                ]);
                            }
                        } catch (Exception $e) {
                            // Log lỗi
                        }
                    }

                    // === B. XỬ LÝ KHÁCH HÀNG NHẬP TAY (Mảng guests) ===
                    if (isset($_POST['guests']) && is_array($_POST['guests'])) {
                        foreach ($_POST['guests'] as $guest) {
                            if (!empty(trim($guest['TenNguoiDi']))) {
                                $this->modelBooking->addGuest([
                                    'ID_Booking' => $newBookingId,
                                    'TenNguoiDi' => $guest['TenNguoiDi'],
                                    'GioiTinh' => $guest['GioiTinh'] ?? 'Khác',
                                    'NgaySinh' => $guest['NgaySinh'] ?? null,
                                    'LienHe' => $guest['LienHe'] ?? '',
                                    'CCCD_Passport' => $guest['CCCD_Passport'] ?? '',
                                    'GhiChu' => ''
                                ]);
                            }
                        }
                    }

                    $_SESSION['success'] = "Thêm booking và danh sách đoàn thành công!";
                    header('Location: ?act=quan-ly-booking');
                    exit;
                } else {
                    $errors[] = "Lỗi khi thêm booking (Lỗi database/logic).";
                }
            }
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/add-booking.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
