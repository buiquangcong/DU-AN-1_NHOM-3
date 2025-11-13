<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function danhSach()
    {
        $categories = $this->categoryModel->getAll();
        require './admin/views/header.php';
        require './admin/views/category/danh-sach-category.php';
        require './admin/views/footer.php';
    }

    public function them()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->insert($_POST['name']);
            header('Location: ?controller=category&action=danhSach');
            exit;
        }
        require './admin/views/header.php';
        require './admin/views/category/them-category.php';
        require './admin/views/footer.php';
    }

    public function sua()
    {
        $id = $_GET['id'] ?? 0;
        $category = $this->categoryModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->update($id, $_POST['name']);
            header('Location: ?controller=category&action=danhSach');
            exit;
        }

        require './admin/views/header.php';
        require './admin/views/category/sua-category.php';
        require './admin/views/footer.php';
    }

    public function xoa()
    {
        $id = $_GET['id'] ?? 0;
        $this->categoryModel->delete($id);
        header('Location: ?controller=category&action=danhSach');
    }
}
