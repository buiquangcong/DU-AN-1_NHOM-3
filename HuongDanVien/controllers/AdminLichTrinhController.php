<?php

require_once __DIR__ . '/../models/AdminLichTrinhModel.php';

class AdminLichTrinhController
{
    public $modelLichTrinh;

    public function __construct()
    {
        $this->modelLichTrinh = new AdminLichTrinhModel();
    }

    public function listCheckinLichTrinh()
    {
        $tour_id = $_GET['tour_id'] ?? null;
        if (!$tour_id) {
            $_SESSION['error'] = "Không tìm thấy Tour ID để xem lịch trình.";
            header('Location: ?act=quan-ly-booking');
            exit;
        }

        $listLichTrinh = $this->modelLichTrinh->getItineraryByTourId($tour_id);

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/list-itinerary-checkin.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function processCheckinLichTrinh()
    {
        $tour_id = $_REQUEST['tour_id'] ?? null;
        $lich_trinh_id = $_REQUEST['lt_id'] ?? null;

        if (!$tour_id || !$lich_trinh_id) {
            $_SESSION['error'] = "Thiếu thông tin Tour hoặc Lịch trình.";

            $redirect_url = $tour_id
                ? ('?act=list-checkin-lich-trinh&tour_id=' . $tour_id)
                : '?act=quan-ly-booking';

            header('Location: ' . $redirect_url);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $guest_statuses = $_POST['status'] ?? [];
            $success_count = 0;

            foreach ($guest_statuses as $guest_id => $status) {
                $statusInt = (int)$status;

                if ($statusInt === 1 || $statusInt === 0) {
                    if ($this->modelLichTrinh->updateCheckinStatusLichTrinh($lich_trinh_id, $guest_id, $statusInt)) {
                        $success_count++;
                    }
                }
            }

            $_SESSION['success'] = "Đã cập nhật điểm danh thành công cho {$success_count} khách!";

            header('Location: ?act=process-checkin-lich-trinh&tour_id=' . $tour_id . '&lt_id=' . $lich_trinh_id);
            exit;
        }

        $listKhachAndStatus = $this->modelLichTrinh->getGuestsAndCheckinStatus($tour_id, $lich_trinh_id);

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/booking/checkin-form-lich-trinh.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
