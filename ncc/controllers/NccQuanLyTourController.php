<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class NccQuanLyTourController
{
    public $modelTour;     
    public $modelDanhMuc;
    public $modelNhaCungCap;

    public function __construct()
    {
        $this->modelTour = new NccQuanLyTour();
        $this->modelDanhMuc = new NccDanhMuc();
        $this->modelNhaCungCap = new NccNhaCungCap(); 
    }

    public function danhSachTour()
    {
        $search_id = $_GET['search_id'] ?? '';

        $loai_tour_id = $_GET['loai_tour'] ?? '';


        $listTours = $this->modelTour->getAllTours($search_id, $loai_tour_id);

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tour/list-tour.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

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


    public function deleteItineraryItem()
    {
        $itinerary_id = $_GET['id'] ?? null;
        $tour_id = $_GET['tour_id'] ?? null; 

        if ($itinerary_id) {
            $this->modelTour->deleteItineraryItem($itinerary_id);
            $_SESSION['success'] = "Xóa mục lịch trình thành công!";
        }

        header('Location: index.php?act=manage-itinerary&id=' . $tour_id);
        exit;
    }

    public function manageSuppliers()
    {
        $tour_id = $_GET['id'] ?? null;
        if (!$tour_id) {
            header('Location: index.php?act=list-tours');
            exit;
        }

        $tourDetail = $this->modelTour->getTourById($tour_id);

        $linkedSuppliers = $this->modelTour->getLinkedSuppliersByTourID($tour_id);
 
        $allSuppliers = $this->modelNhaCungCap->getAll();

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/tour/manage-suppliers.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
