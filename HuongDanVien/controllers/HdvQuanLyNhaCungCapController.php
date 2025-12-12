<?php
require_once __DIR__ . '/../models/HdvNhaCungCap.php';

require_once __DIR__ . '/../models/HdvDichVu.php';

class HdvQuanLyNhaCungCapController
{
    public $model;
    public $modelDichVu;

    public function __construct()
    {
        $this->model = new HdvNhaCungCap();
        $this->modelDichVu = new HdvDichVu();
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
            header('Location: ' . BASE_URL_HDV . '?act=list-nhacungcap');
            exit();
        }

        $ncc = $this->model->getById($id);
        if (!$ncc) {
            header('Location: ' . BASE_URL_HDV . '?act=list-nhacungcap');
            exit();
        }

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/nhacungcap/detail.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
