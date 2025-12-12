<?php

class NccdanhmucController
{
    private $modelDanhmuc;

    public function __construct()
    {
        $this->modelDanhmuc = new NccDanhMuc();
    }

    public function danhsachDanhMuc()
    {
        $listdanhmuc = $this->modelDanhmuc->getAllDanhMuc();

        require_once __DIR__ . '/../views/layout/header.php';       
        require_once __DIR__ . '/../views/danhmuc/listdanhmuc.php'; 
        require_once __DIR__ . '/../views/layout/footer.php';          

    }
}
