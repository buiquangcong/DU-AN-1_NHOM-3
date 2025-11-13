<?php
// class AdmindanhmucController {
//     public $modelDanhmuc;
//     public function __construct() {
//         $this->modelDanhmuc = new Admindanhmuc;
//     }
//     public function danhsachDanhMuc() {
//       // ham nay de hien thi fom nhap
// $listdanhmuc = $this->modelDanhmuc->getAllDanhMuc();
// require_once __DIR__ . '/../views/danhmuc/listdanhmuc.php';

    
//     }

//     // public function postAddDanhMuc() {
//     //     if($_SERVER['REQUEST_METHOD'] === 'POST') {
//     //         $id_Loai_Tour = $_POST['ID_LoaiTour'];
//     //         $TenLoaiTour = $_POST['TenLoaiTour'];
//     //         $error=[];
//     //         if(empty($TenLoaiTour)){
//     //             $error['TenLoaiTour']="Tên loại tour không được để trống";
//     //         }
//     //         if(empty($error)){
//     //             $this->modelDanhmuc->insertDanhMuc( $TenLoaiTour);
//     //             header("Location: index.php?act=list-danhmuc");
//     //             exit();
//     //         } else {
//     //             require_once 'admin/views/danhmuc/adddanhmuc.php';
//     //         }
        
//     // }
//     // }
//       public function postAddDanhMuc() {
//         $error = [];
//         $TenLoaiTour = '';

//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $TenLoaiTour = $_POST['TenLoaiTour'] ?? '';
//             if (empty($TenLoaiTour)) {
//                 $error['TenLoaiTour'] = "Tên loại tour không được để trống";
//             }
//             if (empty($error)) {
//                 $this->modelDanhmuc->insertDanhMuc($TenLoaiTour);
//                 header("Location: index.php?act=list-danhmuc");
//                 exit();
//             }
//         }

       
//     }

//     public function formEditDanhMuc() {
//        // ham nay de hien thi fom nhap
//        // lay ra thong tin danh muc can sua
//        $id = $_GET['id'];
//          $danhmuc = $this->modelDanhmuc->getDetailDanhMuc($id);
//          if($danhmuc){
//             require_once __DIR__ . '/../views/danhmuc/editdanhmuc.php';
//          } else {
//             header("Location: index.php?act=list-danhmuc");
//             exit();
//          }
//     }
//     public function postEditDanhMuc() {
//         if($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $id = $_GET['id'];
//             $TenLoaiTour = $_POST['TenLoaiTour'];
//             $error=[];
//             if(empty($TenLoaiTour)){
//                 $error['TenLoaiTour']="Tên loại tour không được để trống";
//             }
//             if(empty($error)){
//                 $this->modelDanhmuc->updateDanhMuc($id, $TenLoaiTour);
//                 header("Location: index.php?act=list-danhmuc");
//                 exit();
//             } else {
//                 $danhmuc = $this->modelDanhmuc->getDetailDanhMuc($id);
//                 require_once 'admin/views/danhmuc/editdanhmuc.php';
//             }
        
//     }
//     }
//     public function deleteDanhMuc() {
//         $id = $_GET['id'];
//         $this->modelDanhmuc->deleteDanhMuc($id);
//         header("Location: index.php?act=list-danhmuc");
//         exit();
//     }
// }

class AdmindanhmucController {
    private $modelDanhmuc;

    public function __construct() {
        $this->modelDanhmuc = new AdminDanhMuc();
    }

    // Danh sách danh mục
    public function danhsachDanhMuc() {
        $listdanhmuc = $this->modelDanhmuc->getAllDanhMuc();
        
    require_once __DIR__ . '/../views/header.php';          // Load header/sidebar
    require_once __DIR__ . '/../views/danhmuc/listdanhmuc.php'; // Nội dung chính
    require_once __DIR__ . '/../views/footer.php';          // Load footer
        
    }

    // Thêm danh mục (GET + POST)
    public function postAddDanhMuc() {
        $error = [];
        $TenLoaiTour = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $TenLoaiTour = $_POST['TenLoaiTour'] ?? '';
            if (empty($TenLoaiTour)) {
                $error['TenLoaiTour'] = "Tên loại tour không được để trống";
            }

            if (empty($error)) {
                $this->modelDanhmuc->insertDanhMuc($TenLoaiTour);
                header("Location: index.php?act=list-danhmuc");
                exit();
            }
        }

        // Chỉ include view form thêm
        require_once __DIR__ . '/../views/header.php';    
        require_once __DIR__ . '/../views/danhmuc/adddanhmuc.php';
        require_once __DIR__ . '/../views/footer.php';   
        
    }

    // Hiển thị form sửa danh mục
    public function formEditDanhMuc() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=list-danhmuc");
            exit();
        }

        $danhmuc = $this->modelDanhmuc->getDetailDanhMuc($id);
        if (!$danhmuc) {
            header("Location: index.php?act=list-danhmuc");
            exit();
        }

        $error = [];
        require_once __DIR__ . '/../views/header.php';    
        require_once __DIR__ . '/../views/danhmuc/editdanhmuc.php';
        require_once __DIR__ . '/../views/footer.php';   
    }

    // Sửa danh mục
    public function postEditDanhMuc() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?act=list-danhmuc");
            exit();
        }

        $danhmuc = $this->modelDanhmuc->getDetailDanhMuc($id);
        $TenLoaiTour = $_POST['TenLoaiTour'] ?? '';
        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($TenLoaiTour)) {
                $error['TenLoaiTour'] = "Tên loại tour không được để trống";
            }

            if (empty($error)) {
                $this->modelDanhmuc->updateDanhMuc($id, $TenLoaiTour);
                header("Location: index.php?act=list-danhmuc");
                exit();
            }
        }

        require_once __DIR__ . '/../views/header.php';    
        require_once __DIR__ . '/../views/danhmuc/editdanhmuc.php';
        require_once __DIR__ . '/../views/footer.php';   
    }

    // Xóa danh mục
    public function deleteDanhMuc() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelDanhmuc->deleteDanhMuc($id);
        }
        header("Location: index.php?act=list-danhmuc");
        exit();
    }
}


?>

