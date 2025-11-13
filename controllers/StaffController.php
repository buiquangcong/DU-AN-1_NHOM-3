<?php
require_once './models/Staff.php';

class StaffController
{
    private $staffModel;

    public function __construct()
    {
        $this->staffModel = new Staff();
    }

    public function danhSach()
    {
        $staffs = $this->staffModel->getAll();
        require './admin/views/header.php';
        require './admin/views/staff/danh-sach-staff.php';
        require './admin/views/footer.php';
    }

    public function them()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->staffModel->insert($_POST['name'], $_POST['position'], $_POST['salary']);
            header('Location: ?controller=staff&action=danhSach');
            exit;
        }
        require './admin/views/header.php';
        require './admin/views/staff/them-staff.php';
        require './admin/views/footer.php';
    }

    public function sua()
    {
        $id = $_GET['id'] ?? 0;
        $staff = $this->staffModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->staffModel->update($id, $_POST['name'], $_POST['position'], $_POST['salary']);
            header('Location: ?controller=staff&action=danhSach');
            exit;
        }

        require './admin/views/header.php';
        require './admin/views/staff/sua-staff.php';
        require './admin/views/footer.php';
    }

    public function xoa()
    {
        $id = $_GET['id'] ?? 0;
        $this->staffModel->delete($id);
        header('Location: ?controller=staff&action=danhSach');
    }
}
