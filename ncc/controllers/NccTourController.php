<?php
require_once __DIR__ . '/../models/NccTour.php';

class NccTourController
{
    public function listTours()
    {
        $VIEW_PATH = dirname(__DIR__) . '/views';
        require_once $VIEW_PATH . '/layout/header.php';
        require_once $VIEW_PATH . '/danhmuc/listdanhmuc.php';
        require_once $VIEW_PATH . '/layout/footer.php';
    }

    public function dashboard()
    {
        require_once './views/layout/header.php';
        require_once './views/dashboard.php';
        require_once './views/layout/footer.php';
    }
}
