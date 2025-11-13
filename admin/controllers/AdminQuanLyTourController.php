<!-- <?php
        // class AdminquanlytourController{
        //     public $modelSanPham;
        //     public $modelDanhMuc;
        //     public function __construct(){
        //         $this->modelSanPham= new AdminSanPham();
        //         $this->modelDanhMuc= new AdminDanhMuc();
        //     }
        //     public function danhSachSanPham(){
        //         $listSanPham=$this->modelSanPham->getAllSanPham();
        //         require_once __DIR__ . '/../views/header.php';          // Load header/sidebar
        //         require_once __DIR__ . '/../views/tour/listTour.php';
        //         require_once __DIR__ . '/../views/footer.php';          // Load footer
        //     }
        //     public function formAddSanPham(){
        //         $listDanhmuc=$this->modelDanhMuc->getAllDanhMuc();
        //         require_once __DIR__ . '/../views/header.php';          // Load header/sidebar
        //         require_once __DIR__ . '/../views/tour/add.php';
        //         require_once __DIR__ . '/../views/footer.php';          // Load footer
        //     }
        //     public function postAddSanPham(){
        //         if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //             $TenTour=$_POST['TenTour'];
        //             $ID_LoaiTour=$_POST['ID_LoaiTour'];
        //             $GiaNguoiLon=$_POST['GiaNguoiLon'];
        //             $GiaTreEm=$_POST['GiaTreEm'];
        //             $SoNgay=$_POST['SoNgay'];
        //             $SoDem=$_POST['SoDem'];
        //             $NoiDungTomTat=$_POST['NoiDungTomTat'];
        //             $NoiDungChiTiet=$_POST['NoiDungChiTiet'];
        //             $NgayKhoiHanh=$_POST['NgayKhoiHanh'];
        //             $DiemKhoiHanh=$_POST['DiemKhoiHanh'];
        //             $socho=$_POST['SoCho'];
        //             $TrangThai=$_POST['TrangThai'];
        //             $error=[];
        //             if(empty($TenTour)){
        //                 $error['TenTour']="Tên tour không được để trống";
        //             }
        //             if(empty($GiaNguoiLon)){
        //                 $error['GiaNguoiLon']="Giá người lớn không được để trống";
        //             }
        //             if(empty($SoCho)){
        //                 $error['SoCho']="Số chỗ không được để trống";
        //             }
        //             if(empty($GiaTreEm)){
        //                 $error['GiaTreEm']="Giá trẻ em không được để trống";
        //             }
        //             if(empty($SoNgay)){
        //                 $error['SoNgay']="Số ngày không được để trống";
        //             }
        //             if(empty($SoDem)){
        //                 $error['SoDem']="Số đêm không được để trống";
        //             }
        //             if(empty($NoiDungTomTat)){
        //                 $error['NoiDungTomTat']="Nội dung tóm tắt không được để trống";
        //             }
        //             if(empty($NoiDungChiTiet)){
        //                 $error['NoiDungChiTiet']="Nội dung chi tiết không được để trống";
        //             }
        //             if(empty($NgayKhoiHanh)){
        //                 $error['NgayKhoiHanh']="Ngày khởi hành không được để trống";
        //             }
        //             if(empty($DiemKhoiHanh)){
        //                 $error['DiemKhoiHanh']="Điểm khởi hành không được để trống";
        //             }
        //             if(empty($socho)){
        //                 $error['SoCho']="Số chỗ không được để trống";
        //             }
        //             if(empty($TrangThai)){
        //                 $error['TrangThai']="Trạng thái không được để trống";
        //             }
        //             $_SESSION['error']=$error;
        //             if(empty($error)){

        //     }
        // }
        // }
        // }
        ?> -->


<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class AdminQuanLyTourController
{
    public $modelSanPham;
    public $modelDanhMuc;

    public function __construct()
    {
        $this->modelSanPham = new AdminSanPham();
        $this->modelDanhMuc = new AdminDanhMuc();
    }

    // Danh sách tour
    public function danhSachSanPham()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tour/list-tour.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // Form thêm tour
    public function formAddSanPham()
    {
        $listDanhmuc = $this->modelDanhMuc->getAllDanhMuc();
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tour/add-tour.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // Xử lý thêm tour
    public function postAddSanPham()
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
            $NgayKhoiHanh   = $_POST['NgayKhoiHanh'] ?? '';
            $DiemKhoiHanh   = trim($_POST['DiemKhoiHanh'] ?? '');
            $SoCho          = $_POST['SoCho'] ?? 0;
            $TrangThai      = $_POST['TrangThai'] ?? 1;

            $error = [];

            // Validate
            if (empty($TenTour)) $error['TenTour'] = "Tên tour không được để trống";
            if (empty($ID_LoaiTour)) $error['ID_LoaiTour'] = "Loại tour chưa chọn";
            if (empty($GiaNguoiLon)) $error['GiaNguoiLon'] = "Giá người lớn không được để trống";
            if (empty($GiaTreEm)) $error['GiaTreEm'] = "Giá trẻ em không được để trống";
            if (empty($SoNgay)) $error['SoNgay'] = "Số ngày không được để trống";
            if (empty($SoDem)) $error['SoDem'] = "Số đêm không được để trống";
            if (empty($NoiDungTomTat)) $error['NoiDungTomTat'] = "Nội dung tóm tắt không được để trống";
            if (empty($NoiDungChiTiet)) $error['NoiDungChiTiet'] = "Nội dung chi tiết không được để trống";
            if (empty($NgayKhoiHanh)) $error['NgayKhoiHanh'] = "Ngày khởi hành không được để trống";
            if (empty($DiemKhoiHanh)) $error['DiemKhoiHanh'] = "Điểm khởi hành không được để trống";
            if (empty($SoCho)) $error['SoCho'] = "Số chỗ không được để trống";

            $_SESSION['error'] = $error;

            if (empty($error)) {
                $insertId = $this->modelSanPham->insertSanPham(
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
                );

                if ($insertId) {
                    header('Location: ' . BASE_URL_ADMIN . '?act=list-tours');
                    exit;
                } else {
                    $_SESSION['error']['insert'] = "Thêm tour thất bại, vui lòng thử lại";
                    header('Location: ' . BASE_URL_ADMIN . '?act=add-tour');
                    exit;
                }
            } else {
                header('Location: ' . BASE_URL_ADMIN . '?act=add-tour');
                exit;
            }
        }
    }

    // Form sửa tour
    public function formEditSanPham($id)
    {
        $sanpham = $this->modelSanPham->getSanPhamById($id);
        $listDanhmuc = $this->modelDanhMuc->getAllDanhMuc();
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tour/edit-tour.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    // Xử lý sửa tour
    public function postEditSanPham()
    {
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
            $DiemKhoiHanh   = trim($_POST['DiemKhoiHanh'] ?? '');
            $SoCho          = $_POST['SoCho'] ?? 0;
            $TrangThai      = $_POST['TrangThai'] ?? 1;

            $error = [];

            // Validate
            if (empty($TenTour)) $error['TenTour'] = "Tên tour không được để trống";
            if (empty($GiaNguoiLon)) $error['GiaNguoiLon'] = "Giá người lớn không được để trống";
            if (empty($SoCho)) $error['SoCho'] = "Số chỗ không được để trống";
            if (empty($GiaTreEm)) $error['GiaTreEm'] = "Giá trẻ em không được để trống";
            if (empty($SoNgay)) $error['SoNgay'] = "Số ngày không được để trống";
            if (empty($SoDem)) $error['SoDem'] = "Số đêm không được để trống";
            if (empty($NoiDungTomTat)) $error['NoiDungTomTat'] = "Nội dung tóm tắt không được để trống";
            if (empty($NoiDungChiTiet)) $error['NoiDungChiTiet'] = "Nội dung chi tiết không được để trống";
            if (empty($NgayKhoiHanh)) $error['NgayKhoiHanh'] = "Ngày khởi hành không được để trống";
            if (empty($DiemKhoiHanh)) $error['DiemKhoiHanh'] = "Điểm khởi hành không được để trống";

            $_SESSION['error'] = $error;

            if (empty($error)) {
                $this->modelSanPham->updateSanPham(
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
                );
                header("Location: index.php?act=list-tours");
                exit;
            } else {
                header("Location: index.php?act=edit-tour&id=" . $ID_Tour);
                exit;
            }
        }
    }

    // Xóa tour
    public function deleteSanPham($id)
    {
        $this->modelSanPham->deleteSanPham($id);
        header("Location: index.php?act=list-tours");
        exit;
    }
}
?>