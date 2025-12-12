<?php
class HdvTaiKhoanController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        require_once './models/HdvTaiKhoan.php';
        $this->modelTaiKhoan = new HdvTaiKhoan();
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

                $user = $result;

                $role = $user['ID_Quyen'] ?? $user['id_quyen'] ?? 0;

                if ($role != 2) {
                    $_SESSION['error'] = "Tài khoản này không có quyền Hướng Dẫn Viên!";
                    header("Location: ?act=login-hdv");
                    exit();
                }

                $_SESSION['user'] = $user;

                header("Location: ?act=dashboard");
                exit();
            } else {
                $_SESSION['error'] = $result;
                $_SESSION['flash'] = true;

                header("Location: ?act=login-hdv");
                exit();
            }
        }
    }

    public function logout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        header('Location: ?act=login-hdv');
        exit();
    }
}
