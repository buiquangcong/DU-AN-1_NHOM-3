<?php
class NccTaiKhoanController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        require_once 'models/NccTaiKhoan.php';
        $this->modelTaiKhoan = new NccTaiKhoan();
    }

    public function formLogin()
    {
        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $result = $this->modelTaiKhoan->checkLogin($email, $password);

            if (is_array($result)) {
                $_SESSION['user_admin'] = $result;
                if ($result['ID_Quyen'] == 3) { 
                    header("Location: " . BASE_URL_NCC . '?act=dashboard');
                } else {
                    header("Location: " . BASE_URL);
                }
                exit();
            } else {
                $_SESSION['error'] = $result;
                $_SESSION['flash'] = true;
                header('Location: ' . BASE_URL_NCC . '?act=login-admin');
                exit();
            }
        }
    }

    public function logout()
    {
        if (isset($_SESSION['user_admin'])) {
            unset($_SESSION['user_admin']);
        }
        header('Location: ' . BASE_URL_NCC . '?act=login-admin');
        exit();
    }

}
