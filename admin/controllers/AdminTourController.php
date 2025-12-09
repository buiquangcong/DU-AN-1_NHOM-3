<?php
require_once __DIR__ . '/../models/AdminTour.php';

class AdminTourController
{
   
    public function showAddForm()
    {
       
        $VIEW_PATH = dirname(__DIR__) . '/views';

        require_once $VIEW_PATH . '/layout/header.php';
        require_once $VIEW_PATH . '/tour/add.php';
        require_once $VIEW_PATH . '/layout/footer.php';
    }

   
    public function saveAdd()
    {
    
        $tourModel = new AdminTour(); 

        
        header('Location: index.php?act=list-tours&status=add-success');
        exit;
    }

    
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
