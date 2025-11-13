<?php
// File: /admin/controllers/AdminTourController.php

/**
 * (SỬA LỖI 1) Sửa đường dẫn Model
 * __DIR__ là '.../admin/controllers'
 * Chúng ta đi lùi 1 cấp (../) về '.../admin/',
 * rồi vào 'models/AdminTour.php'
 *
 * (File index.php đã require file này rồi, nhưng
 * để cẩn thận, chúng ta vẫn require_once ở đây)
 */
require_once __DIR__ . '/../models/AdminTour.php';

class AdminTourController
{
    /**
     * Action: Hiển thị form thêm tour ( ?act=add-tour )
     */
    public function showAddForm()
    {
        // Đường dẫn View (Đi lùi 1 cấp về /admin/, rồi vào /views/)
        $VIEW_PATH = dirname(__DIR__) . '/views';

        require_once $VIEW_PATH . '/layout/header.php';
        require_once $VIEW_PATH . '/tour/add.php';
        require_once $VIEW_PATH . '/layout/footer.php';
    }

    /**
     * Action: Xử lý lưu dữ liệu ( ?act=save-add-tour )
     */
    public function saveAdd()
    {
        // (SỬA LỖI 3) Đổi tên Class Model
        // $tourModel = new Tour(); // Tên class cũ (SAI)
        $tourModel = new AdminTour(); // Tên class mới (ĐÚNG)

        // (Code xử lý lưu dữ liệu của bạn sẽ ở đây)
        // ...

        header('Location: index.php?act=list-tours&status=add-success');
        exit;
    }

    // (Các hàm listTours, dashboard... tương tự)
    public function listTours()
    {
        $VIEW_PATH = dirname(__DIR__) . '/views';
        require_once $VIEW_PATH . '/layout/header.php';
        require_once $VIEW_PATH . '/danhmuc/listdanhmuc.php';
        require_once $VIEW_PATH . '/layout/footer.php';
    }

    public function dashboard()
    {
        $VIEW_PATH = dirname(__DIR__) . '/views';
        require_once $VIEW_PATH . '/layout/header.php';
        require_once $VIEW_PATH . '/layout/dashboard.php';
        require_once $VIEW_PATH . '/layout/footer.php';
    }
}
