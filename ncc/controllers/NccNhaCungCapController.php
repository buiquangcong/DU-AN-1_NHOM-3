<?php
require_once __DIR__ . '/../models/NccNhaCungCap.php';

require_once __DIR__ . '/../models/NccDichVu.php'; 

class NccNhaCungCapController
{
    public $model;
    public $modelDichVu; 

    public function __construct()
    {
        $this->model = new NccNhaCungCap();
        $this->modelDichVu = new NccDichVu(); 
    }
    public function index()
    {
        $listNCC = $this->model->getAll();
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhacungcap/list.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
    public function detail()
    {
        $id = $_GET['id_nha_cc'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL_NCC . '?act=list-nhacungcap');
            exit();
        }

        $ncc = $this->model->getById($id);
        if (!$ncc) {
            header('Location: ' . BASE_URL_NCC . '?act=list-nhacungcap');
            exit();
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhacungcap/detail.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function tourHistory()
    {
        $id = $_GET['id_nha_cc'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL_NCC . '?act=list-nhacungcap');
            exit();
        }

        $ncc = $this->model->getById($id);
        if (!$ncc) { 
            header('Location: ' . BASE_URL_NCC . '?act=list-nhacungcap');
            exit();
        }
        $tours = $this->modelDichVu->getTourHistoryByNCC($id);

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhacungcap/tour_history.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }


    public function DanhSach()
    {
        $id = $_GET['id_nha_cc'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL_NCC . '?act=list-nhacungcap');
            exit();
        }
        $ncc = $this->model->getById($id);
        if (!$ncc) {
            header('Location: ' . BASE_URL_NCC . '?act=list-nhacungcap');
            exit();
        }
        $tours = $this->modelDichVu->getLiveToursByNCC($id);
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhacungcap/tour_list.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}