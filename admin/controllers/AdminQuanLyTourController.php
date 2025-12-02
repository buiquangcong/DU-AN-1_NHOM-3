<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class AdminQuanLyTourController
{
    public $modelTour;      // Đổi tên biến
    public $modelDanhMuc;
    public $modelNhaCungCap; // Thêm model NCC
    public $modelDichVu;
    public $model; 

    public function __construct()
    {
        $this->modelTour = new AdminQuanLyTour(); // Khởi tạo model Tour
        $this->modelDanhMuc = new AdminDanhMuc();
        $this->modelNhaCungCap = new AdminNhaCungCap(); // Khởi tạo model NCC
        $this->modelDichVu = new AdminDichVu();
         $this->model = new AdminBookingModel();
    }


    public function danhSachTour()
    {
        // Lấy ID tìm kiếm từ URL
        $search_id = $_GET['search_id'] ?? '';
        $loai_tour_id = $_GET['loai_tour'] ?? '';
        $listTours = $this->modelTour->getAllTours($search_id, $loai_tour_id);

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tour/list-tour.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }


    public function formAddTour() // Đổi tên hàm
    {
        $listDanhmuc = $this->modelDanhMuc->getAllDanhMuc();
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tour/add-tour.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

  public function tourDetailOverview()
{
    // Lấy ID Tour từ URL
    $tour_id = $_GET['id'] ?? null;
    
    // 1. Kiểm tra ID
    if (!$tour_id) {
        header('Location: index.php?act=list-tours');
        exit;
    }

    // 2. LẤY DỮ LIỆU TỪ CÁC MODEL KHÁC NHAU
    
    // a. Lấy chi tiết Tour (Model: AdminQuanLyTour)
    $tourDetail = $this->modelTour->getTourById($tour_id);

    // b. Lấy Lịch trình (Model: AdminQuanLyTour - Giả định hàm nằm ở đây)
    $listItinerary = $this->modelTour->getItineraryByTourID($tour_id);

    // c. Lấy Nhà Cung Cấp đã liên kết (Model: AdminNhaCungCap)
    $linkedSuppliers = $this->modelNhaCungCap->getLinkedSuppliersByTour($tour_id);

    // 3. Kiểm tra kết quả Tour
    if (!$tourDetail) {
        $_SESSION['error']['tour_not_found'] = "Không tìm thấy chi tiết tour này.";
        header('Location: index.php?act=list-tours');
        exit;
    }

    // 4. LOAD VIEW
    require_once __DIR__ . '/../views/layout/header.php';
    // ✅ GỌI ĐÚNG TÊN FILE VIEW BẠN CUNG CẤP
    require_once __DIR__ . '/../views/tour/detail-tour.php'; 
    require_once __DIR__ . '/../views/layout/footer.php';
} 

public function historyTours()
{
    // ✅ Khởi tạo model Booking
    $bookingModel = new AdminBookingModel();
     $historyTours = $bookingModel->getAllHistory();

    // Lấy danh sách lịch sử tour
    
     $historyTours = $bookingModel->getAllHistory();
    require_once __DIR__ . '/../views/layout/header.php';
    require_once __DIR__ . '/../views/tour/history-tours.php';
    require_once __DIR__ . '/../views/layout/footer.php';
}
 public function historyDetail() {
        if (!isset($_GET['id'])) {
            echo "Thiếu ID booking!";
            return;
        }

        $id = $_GET['id'];

        // Gọi model
      $details = $this->model->historyDetailModel($id);

        // Render ra view
          require_once __DIR__ . '/../views/layout/header.php';
        include_once __DIR__ . '/../views/tour/history-detail.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }



    public function postAddTour() // Đổi tên hàm
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sinh ID_Tour tự động
            $ID_Tour = 'T-' . rand(1000, 9999);

            $TenTour        = trim($_POST['TenTour'] ?? '');
            $ID_LoaiTour    = $_POST['ID_LoaiTour'] ?? '';
            $GiaNguoiLon    = $_POST['GiaNguoiLon'] ?? 0;
            $GiaTreEm       = $_POST['GiaTreEm'] ?? 0;
            $SoNgay         = $_POST['SoNgay'] ?? 0;
            $SoDem          = $_POST['SoDem'] ?? 0;
            $NoiDungTomTat  = trim($_POST['NoiDungTomTat'] ?? '');
            $NoiDungChiTiet = trim($_POST['NoiDungChiTiet'] ?? '');

            // GIỮ LẠI NgayKhoiHanh
            $NgayKhoiHanh   = $_POST['NgayKhoiHanh'] ?? '';
            // Đã loại bỏ: $DiemKhoiHanh

            $SoCho          = $_POST['SoCho'] ?? 0;
            $TrangThai      = $_POST['TrangThai'] ?? 1;
            $policy_id      = $_POST['policy_id'] ?? null;

            // === KHỞI TẠO BIẾN ẢNH ===
            $fileAnhBia     = $_FILES['AnhBia'] ?? null;
            $anh_bia_url    = null;
            $target_file_fs = null; // Khởi tạo biến này để dùng cho unlink nếu lỗi

            $error = [];

            if (empty($TenTour)) $error['TenTour'] = "Tên tour không được để trống";
            // ... (các validation khác giữ nguyên) ...

            // === VALIDATE FILE UPLOAD BAN ĐẦU ===
            if (empty($fileAnhBia) || $fileAnhBia['error'] !== UPLOAD_ERR_OK) {
                $error['AnhBia'] = "Vui lòng chọn ảnh bìa hợp lệ.";
            }

            $_SESSION['error'] = $error;

            if (empty($error)) {

                // --- CẤU HÌNH ĐƯỜNG DẪN UPLOAD ---
                $upload_dir_fs = __DIR__ . '/../assets/uploads/';
                $upload_dir_web = BASE_URL_ADMIN . '/assets/uploads/';

                // --- BƯỚC 1: XỬ LÝ UPLOAD FILE ---
                $file_name = time() . '_' . basename($fileAnhBia['name']);
                $target_file_fs = $upload_dir_fs . $file_name;

                if (move_uploaded_file($fileAnhBia['tmp_name'], $target_file_fs)) {
                    $anh_bia_url = $upload_dir_web . $file_name; // Lưu đường dẫn web
                } else {
                    $error['Upload'] = "Lỗi khi di chuyển file.";
                    $_SESSION['error'] = $error;
                    header('Location: ' . BASE_URL_ADMIN . '?act=add-tour');
                    exit;
                }

                $insertId = $this->modelTour->insertTour(
                    $ID_Tour,
                    $TenTour,
                    $ID_LoaiTour,
                    $GiaNguoiLon,
                    $GiaTreEm,
                    $SoNgay,
                    $SoDem,
                    $NoiDungTomTat,
                    $NoiDungChiTiet,
                    $NgayKhoiHanh, // GIỮ LẠI NgayKhoiHanh
                    $SoCho,
                    $TrangThai,
                    $policy_id
                );

                if ($insertId) {
                    // --- BƯỚC 3: LƯU URL ẢNH VÀO BẢNG dm_anh_tour ---
                    if (!empty($anh_bia_url)) {
                        $this->modelTour->insertAnhTour($ID_Tour, $anh_bia_url, 0);
                    }

                    $_SESSION['success'] = "Thêm tour thành công!";
                    header('Location: ' . BASE_URL_ADMIN . '?act=list-tours');
                    exit;
                } else {
                    // Nếu insert tour thất bại, xóa file vừa upload
                    if (isset($target_file_fs) && file_exists($target_file_fs)) {
                        unlink($target_file_fs);
                    }
                    $_SESSION['error']['insert'] = "Thêm tour thất bại, vui lòng thử lại";
                    header('Location: ' . BASE_URL_ADMIN . '?act=add-tour');
                    exit;
                }
            } else {
                // Nếu có lỗi validate/upload ban đầu, chuyển hướng
                header('Location: ' . BASE_URL_ADMIN . '?act=add-tour');
                exit;
            }
        }
    }

    // ✅ Form sửa tour (?act=edit-tour&id=...)
    public function formEditTour($id) // Đổi tên hàm
    {
        // Gọi hàm model mới: getTourById()
        // Giữ tên biến $sanpham vì view 'edit-tour.php' đang dùng nó
        $sanpham = $this->modelTour->getTourById($id);
        $listDanhmuc = $this->modelDanhMuc->getAllDanhMuc();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tour/edit-tour.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // ✅ Xử lý sửa tour (?act=post-edit-tour)
    public function postEditTour()
    { {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ID_Tour        = $_POST['ID_Tour'] ?? '';
                $TenTour        = trim($_POST['TenTour'] ?? '');
                $ID_LoaiTour    = $_POST['ID_LoaiTour'] ?? '';
                $GiaNguoiLon    = $_POST['GiaNguoiLon'] ?? 0;
                $GiaTreEm       = $_POST['GiaTreEm'] ?? 0;
                $SoNgay         = $_POST['SoNgay'] ?? 0;
                $SoDem          = $_POST['SoDem'] ?? 0;
                $NoiDungTomTat  = trim($_POST['NoiDungTomTat'] ?? '');
                $NoiDungChiTiet = trim($_POST['NoiDungChiTiet'] ?? '');
                $NgayKhoiHanh   = $_POST['NgayKhoiHanh'] ?? '';
                $SoCho          = $_POST['SoCho'] ?? 0;
                $TrangThai      = $_POST['TrangThai'] ?? 1;

                // === KHẮC PHỤC LỖI POLICY_ID (Vấn đề chính) ===
                $policy_id = $_POST['policy_id'] ?? null;
                if ($policy_id === '') {
                    // Đặt thành NULL nếu cho phép NULL trong DB, hoặc 0 nếu không cho phép NULL.
                    // Giả định bạn đã thiết lập DB cho phép NULL cho policy_id.
                    $policy_id = null;
                }
                // ===============================================

                // === KHỞI TẠO BIẾN ẢNH ===
                $fileAnhBia     = $_FILES['AnhBia'] ?? null;
                $new_anh_bia_url = null;
                $target_file_fs = null;

                $error = [];
                if (empty($TenTour)) $error['TenTour'] = "Tên tour không được để trống";

                // --- LOGIC UPLOAD FILE ---
                if (!empty($fileAnhBia) && $fileAnhBia['error'] === UPLOAD_ERR_OK) {

                    $upload_dir_fs = __DIR__ . '/../assets/uploads/';
                    $upload_dir_web = BASE_URL_ADMIN . '/assets/uploads/';

                    $file_name = time() . '_' . basename($fileAnhBia['name']);
                    $target_file_fs = $upload_dir_fs . $file_name;

                    if (move_uploaded_file($fileAnhBia['tmp_name'], $target_file_fs)) {
                        $new_anh_bia_url = $upload_dir_web . $file_name;
                    } else {
                        $error['Upload'] = "Lỗi khi di chuyển file ảnh mới.";
                    }
                }

                $_SESSION['error'] = $error;

                if (empty($error)) {

                    // 1. GỌI HÀM MODEL GỘP (Sử dụng policy_id đã được làm sạch)
                    $success = $this->modelTour->updateTour(
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
                        $SoCho,
                        $TrangThai,
                        $policy_id, // <-- Đã được xử lý
                        $new_anh_bia_url
                    );

                    if ($success) {
                        $_SESSION['success'] = "Cập nhật tour thành công!";
                        header("Location: index.php?act=list-tours");
                        exit;
                    } else {
                        // Nếu Model update thất bại (do lỗi DB), xóa file vừa upload
                        if (isset($target_file_fs) && file_exists($target_file_fs)) {
                            unlink($target_file_fs);
                        }
                        $_SESSION['error']['db_fail'] = "Cập nhật tour thất bại do lỗi hệ thống.";
                        header("Location: index.php?act=edit-tour&id=" . $ID_Tour);
                        exit;
                    }
                } else {
                    // Nếu có lỗi validate/upload ban đầu, chuyển hướng và xóa file vừa upload
                    if (isset($target_file_fs) && file_exists($target_file_fs)) {
                        unlink($target_file_fs);
                    }
                    header("Location: index.php?act=edit-tour&id=" . $ID_Tour);
                    exit;
                }
            }
        }
    }
    // ✅ Xóa tour (?act=delete-tour&id=...)
    public function deleteTour($id) // Đổi tên hàm
    {
        // Gọi hàm model mới: deleteTour()
        $this->modelTour->deleteTour($id);
        header("Location: index.php?act=list-tours");
        exit;
    }

    // ===============================================
    // CÁC HÀM MỚI CHO LỊCH TRÌNH & NHÀ CUNG CẤP
    // ===============================================

    /**
     * Action: Hiển thị trang QL Lịch trình ( ?act=manage-itinerary )
     */
    public function manageItinerary()
    {
        $tour_id = $_GET['id'] ?? null;
        if (!$tour_id) {
            header('Location: index.php?act=list-tours');
            exit;
        }

        $tourDetail = $this->modelTour->getTourById($tour_id);
        $listItinerary = $this->modelTour->getItineraryByTourID($tour_id);

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tour/manage-itinerary.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Action: Xử lý thêm mục lịch trình ( ?act=add-itinerary-item )
     */
    public function addItineraryItem()
    {
        $tour_id = $_POST['tour_id'] ?? null;
        if (!$tour_id) {
            header('Location: index.php?act=list-tours');
            exit;
        }

        $day_number = $_POST['day_number'] ?? 1;
        $time_slot = $_POST['time_slot'] ?? '';
        $activity_title = $_POST['activity_title'] ?? '';
        $activity_description = $_POST['activity_description'] ?? '';

        if (!empty($activity_title)) {

            // Gọi Model và nhận kết quả (true/false)
            $result = $this->modelTour->addItineraryItem($tour_id, $day_number, $time_slot, $activity_title, $activity_description);

            // Kiểm tra kết quả
            if ($result) {
                $_SESSION['success'] = "Thêm mục lịch trình thành công!";
            } else {
                $_SESSION['error']['itinerary'] = "Có lỗi xảy ra khi thêm (ví dụ: sai kiểu dữ liệu). Vui lòng thử lại.";
            }
        } else {
            $_SESSION['error']['itinerary'] = "Tên hoạt động không được trống";
        }

        // Bây giờ lệnh chuyển hướng sẽ luôn chạy
        header('Location: index.php?act=manage-itinerary&id=' . $tour_id);
        exit;
    }

    /**
     * Action: Xử lý xóa mục lịch trình ( ?act=delete-itinerary-item )
     */
    public function deleteItineraryItem()
    {
        $itinerary_id = $_GET['id'] ?? null;
        $tour_id = $_GET['tour_id'] ?? null; // Lấy tour_id để redirect về

        if ($itinerary_id) {
            $this->modelTour->deleteItineraryItem($itinerary_id);
            $_SESSION['success'] = "Xóa mục lịch trình thành công!";
        }

        header('Location: index.php?act=manage-itinerary&id=' . $tour_id);
        exit;
    }

    /**
     * Action: Hiển thị trang QL Nhà Cung Cấp ( ?act=manage-suppliers )
     */
  public function manageSuppliers()
    {
        $tour_id = $_GET['id'] ?? null;
        if (!$tour_id) {
            header('Location: index.php?act=list-tours');
            exit;
        }

        $tourDetail = $this->modelTour->getTourById($tour_id);
        $linkedSuppliers = $this->modelNhaCungCap->getLinkedSuppliersByTour($tour_id);
        $allSuppliers = $this->modelNhaCungCap->getAll();
        $serviceRoles = $this->modelDichVu->getAllDichVu(); 

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tour/manage-suppliers.php'; 
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Action: Xử lý liên kết NCC ( ?act=link-supplier-to-tour )
     * KHẮC PHỤC LỖI VĂNG RA BẰNG try...catch
     */
    public function linkSupplierToTour()
    {
        $tour_id = $_POST['tour_id'] ?? null;
        $supplier_id = $_POST['supplier_id'] ?? null;
        $id_DichVu = $_POST['id_DichVu'] ?? null; 

        try {
            // 1. Kiểm tra Validation (Logic Error)
            if (!$tour_id || !$supplier_id || !$id_DichVu) {
                throw new Exception("Vui lòng chọn đầy đủ Nhà cung cấp và Vai trò.");
            }

            // 2. GỌI HÀM MODEL NCC ĐỂ THỰC HIỆN LIÊN KẾT
            $this->modelNhaCungCap->linkSupplierToTour($tour_id, $supplier_id, $id_DichVu);
            $_SESSION['success'] = "Liên kết nhà cung cấp thành công!";

        } catch (\PDOException $e) {
            // 3. Bắt lỗi Database (Khóa chính, Khóa ngoại)
            if ($e->getCode() == '23000' || $e->getCode() == 1062) {
                $_SESSION['error']['db'] = "Liên kết thất bại: Nhà cung cấp đã được liên kết với vai trò đã chọn cho Tour này.";
            } else {
                $_SESSION['error']['db'] = "Liên kết thất bại do lỗi hệ thống (Mã lỗi: " . $e->getCode() . "). Vui lòng kiểm tra tour_id có tồn tại không.";
            }
        } catch (Exception $e) {
            // 4. Bắt lỗi Logic
            $_SESSION['error']['logic'] = $e->getMessage();
        }

        header('Location: index.php?act=manage-suppliers&id=' . ($tour_id ?? '')); 
        exit;
    }

    /**
     * Action: Xử lý hủy liên kết NCC ( ?act=unlink-supplier )
     */
    public function unlinkSupplier()
    {
        $tour_id = $_GET['tour_id'] ?? null;
        $supplier_id = $_GET['supplier_id'] ?? null;

        if ($tour_id && $supplier_id) {
            $this->modelNhaCungCap->unlinkSupplierFromTour($tour_id, $supplier_id);
            $_SESSION['success'] = "Hủy liên kết thành công!";
        }

        header('Location: index.php?act=manage-suppliers&id=' . $tour_id);
        exit;
    }

    /**
     * Action: Hiển thị form Sửa mục lịch trình (?act=edit-itinerary-item)
     */
    public function formEditItineraryItem()
    {
        $itinerary_id = $_GET['id'] ?? null;
        if (!$itinerary_id) {
            header('Location: index.php?act=list-tours');
            exit;
        }

        // Gọi hàm Model mới (sẽ tạo ở Bước 3)
        $item = $this->modelTour->getItineraryItemById($itinerary_id);

        // Load view mới (sẽ tạo ở Bước 4)
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tour/edit-itinerary-item.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Action: Xử lý lưu form Sửa (?act=post-edit-itinerary-item)
     */
    public function postEditItineraryItem()
    {
        $itinerary_id = $_POST['itinerary_id'] ?? null;
        $tour_id = $_POST['tour_id'] ?? null;

        $day_number = $_POST['day_number'] ?? 1;
        $time_slot = $_POST['time_slot'] ?? '';
        $activity_title = $_POST['activity_title'] ?? '';
        $activity_description = $_POST['activity_description'] ?? '';

        if (!$itinerary_id || !$tour_id) {
            header('Location: index.php?act=list-tours');
            exit;
        }

        // Gọi hàm Model mới (sẽ tạo ở Bước 3)
        $this->modelTour->updateItineraryItem(
            $itinerary_id,
            $day_number,
            $time_slot,
            $activity_title,
            $activity_description
        );

        $_SESSION['success'] = "Cập nhật mục lịch trình thành công!";

        // Chuyển hướng về trang quản lý
        header('Location: index.php?act=manage-itinerary&id=' . $tour_id);
        exit;
    }
}
