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
        $keyword = $_GET['keyword'] ?? null;
        $listBookings = $this->modelBooking->getAllBookings($keyword);
        $listHDV = $this->modelBooking->load_all_hdv();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/list-booking.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Action: Xử lý phân công HDV (?act=cap-nhat-hdv)
     */
    public function assignGuide()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_booking = $_POST['id_booking'] ?? null;
            $id_hdv = $_POST['id_hdv'] ?? null;

            if ($id_booking && $id_hdv) {
                $result = $this->modelBooking->updateGuide($id_booking, $id_hdv);
                if ($result) {
                    $_SESSION['success'] = "Đã phân công Hướng dẫn viên thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật.";
                }
            }
        }
        header('Location: ?act=quan-ly-booking');
        exit;
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

    // =========================================================================
    // [CẬP NHẬT] Hàm Edit Booking: Thêm lấy lịch sử thanh toán
    // =========================================================================
    public function editBooking()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?act=quan-ly-booking');
            exit;
        }

        // 1. Lấy dữ liệu cũ để hiển thị
        $booking = $this->modelBooking->getBookingById($id);
        $tours = $this->modelBooking->getAllTours();
        $listHDV = $this->modelBooking->load_all_hdv();

        // [MỚI] Lấy danh sách lịch sử thanh toán để hiển thị ra bảng
        // Hàm này đã được thêm vào Model ở bước trước
        $lichSuThanhToan = $this->modelBooking->getPaymentHistory($id);

        if (!$booking) {
            $_SESSION['error'] = "Không tìm thấy Booking này.";
            header('Location: ?act=quan-ly-booking');
            exit;
        }

        // 2. Xử lý khi bấm nút "Cập nhật" (Form chính)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // [LOGIC CŨ GIỮ NGUYÊN]

            // Lấy tiền cọc (lúc này ô input là readonly nhưng vẫn gửi value đi)
            $tien_coc = isset($_POST['tien_coc']) ? $_POST['tien_coc'] : 0;
            // Xóa dấu phẩy nếu có (vì format number view hiển thị 1,000,000)
            $tien_coc = str_replace([',', '.'], '', $tien_coc);

            $tourID = $_POST['tour_id'];
            $slNL = (int)$_POST['so_luong_nl'];
            $slTE = (int)$_POST['so_luong_te'];

            // Tính lại tổng tiền
            $giaNL = 0;
            $giaTE = 0;
            foreach ($tours as $t) {
                if ($t['ID_Tour'] == $tourID) {
                    $giaNL = $t['GiaNguoiLon'];
                    $giaTE = $t['GiaTreEm'];
                    break;
                }
            }
            $tong_tien_moi = ($giaNL * $slNL) + ($giaTE * $slTE);

            $data = [
                'ID_Tour'           => $tourID,
                'TenKhachHang'      => trim($_POST['TenKhachHang']),
                'Email'             => trim($_POST['Email']),
                'NgayDatTour'       => $_POST['ngay_dat'],
                'SoLuongNguoiLon'   => $slNL,
                'SoLuongTreEm'      => $slTE,
                'TongTien'          => $tong_tien_moi,
                'tien_coc'          => $tien_coc,
                'TrangThai'         => (int)$_POST['trang_thai'],
                'id_huong_dan_vien' => !empty($_POST['id_hdv']) ? $_POST['id_hdv'] : null
            ];

            if ($this->modelBooking->updateBooking($id, $data)) {
                $_SESSION['success'] = "Cập nhật Booking #$id thành công!";
                header("Location: ?act=quan-ly-booking"); // Quay về danh sách hoặc ở lại trang edit tùy bạn
                exit;
            } else {
                $errors[] = "Lỗi khi cập nhật.";
            }
        }

        // Load view
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/edit-booking.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // =========================================================================
    // [MỚI HOÀN TOÀN] Xử lý thêm thanh toán từ Modal (?act=them-thanh-toan)
    // =========================================================================
    public function processAddPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_booking = $_POST['id_booking'];

            $anh_chung_tu = null;
            if (isset($_FILES['anh_chung_tu']) && $_FILES['anh_chung_tu']['error'] == 0) {

                $target_dir = "uploads/chung_tu/";


                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $file_extension = pathinfo($_FILES["anh_chung_tu"]["name"], PATHINFO_EXTENSION);
                $file_name = time() . '_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $file_name;

                // Di chuyển file
                if (move_uploaded_file($_FILES["anh_chung_tu"]["tmp_name"], $target_file)) {
                    $anh_chung_tu = $file_name;
                }
            }
            $data = [
                'id_booking'      => $id_booking,
                'so_tien'         => $_POST['so_tien'],
                'ngay_thanh_toan' => $_POST['ngay_thanh_toan'],
                'phuong_thuc'     => $_POST['phuong_thuc'],
                'ghi_chu'         => $_POST['ghi_chu'],
                'anh_chung_tu'    => $anh_chung_tu
            ];

            if ($this->modelBooking->addPayment($data)) {

                $this->modelBooking->updateBookingDeposit($id_booking);

                $_SESSION['success'] = "Đã thêm giao dịch thanh toán thành công!";
            } else {
                $_SESSION['error'] = "Lỗi khi thêm giao dịch.";
            }

            header("Location: ?act=edit-booking&id=" . $id_booking);
            exit;
        }
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

    public function deleteGuest()
    {
        $guest_id = $_GET['guest_id'] ?? null;
        $booking_id = $_GET['booking_id'] ?? null;

        if ($guest_id) {
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
        $tours = $this->modelBooking->getAllTours();
        $customers = $this->modelBooking->getAllCustomers();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tour_id = $_POST['tour_id'] ?? '';
            $ten_kh = trim($_POST['TenKhachHang'] ?? '');
            $email_kh = trim($_POST['Email'] ?? '');
            $ngay_dat = $_POST['ngay_dat'] ?? '';
            $so_nl = $_POST['so_luong_nl'] ?? 0;
            $so_te = $_POST['so_luong_te'] ?? 0;
            $tien_coc = $_POST['tien_coc'] ?? 0;
            $trang_thai = $_POST['trang_thai'] ?? 0;

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
                    'tien_coc'          => $tien_coc,
                    'TrangThai'         => (int)$trang_thai
                ];

                $newBookingId = $this->modelBooking->addBookingSimple($data);

                if ($newBookingId) {
                    // Thêm khách đại diện
                    $this->modelBooking->addGuest([
                        'ID_Booking'    => $newBookingId,
                        'TenNguoiDi'    => $ten_kh,
                        'GioiTinh'      => 'Khác',
                        'NgaySinh'      => null,
                        'LienHe'        => $email_kh,
                        'CCCD_Passport' => '',
                        'GhiChu'        => 'Người đặt tour (Tự động thêm)'
                    ]);

                    // Xử lý Excel nếu có
                    if (isset($_FILES['guest_file']) && $_FILES['guest_file']['error'] == 0) {
                        // (Giữ nguyên logic import excel của bạn)
                        // ... Code import excel ...
                    }

                    // Xử lý nhập tay mảng guests
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
