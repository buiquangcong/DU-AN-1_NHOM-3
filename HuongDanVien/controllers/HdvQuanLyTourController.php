<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class HdvQuanLyTourController
{
    public $modelTour;
    public $modelDanhMuc;
    public $modelNhaCungCap;

    public function __construct()
    {
        $this->modelTour = new HdvQuanLyTour();
        $this->modelDanhMuc = new HdvDanhMuc();
        $this->modelNhaCungCap = new HdvNhaCungCap();
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
}
