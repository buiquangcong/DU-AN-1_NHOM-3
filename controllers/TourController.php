<?php
// File: /d:/laragon/www/DU-AN-1_NHOM-3/controllers/TourController.php
class TourController
{
    protected string $viewsPath;
    protected string $modelsPath;

    public function __construct()
    {
        // thư mục project root
        $root = dirname(__DIR__);
        $this->viewsPath = $root . '/views';
        $this->modelsPath = $root . '/models';
    }

    /**
     * Render view: sẽ include header/footer nếu tồn tại
     * $view là đường dẫn relative tới thư mục views, ví dụ: 'client/trangchu.php'
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $header = $this->viewsPath . '/client/header.php';
        $footer = $this->viewsPath . '/client/footer.php';
        $viewFile = $this->viewsPath . '/' . ltrim($view, '/');

        if (file_exists($header)) include $header;
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            // fallback nếu view không tồn tại
            http_response_code(500);
            echo '<h2>View not found: ' . htmlspecialchars($view) . '</h2>';
            if (!empty($data)) {
                echo '<pre>' . htmlspecialchars(print_r($data, true)) . '</pre>';
            }
        }
        if (file_exists($footer)) include $footer;
    }

    protected function loadModel(string $modelName): void
    {
        $path = $this->modelsPath . '/' . $modelName . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }

    // Trang chủ: hiển thị danh sách tour (nếu có model Tour)
    public function trangChu(): void
    {
        $this->loadModel('Tour');
        $tours = [];

        if (class_exists('Tour')) {
            // hỗ trợ vài tên hàm phổ biến trong model
            if (method_exists('Tour', 'getAll')) {
                $tours = Tour::getAll();
            } elseif (method_exists('Tour', 'all')) {
                $tours = Tour::all();
            } elseif (method_exists('Tour', 'index')) {
                $tours = Tour::index();
            }
        }

        $this->render('client/trangchu.php', ['tours' => $tours]);
    }

    // Chi tiết tour: expects ?id=... or ?ma_tour=...
    public function chiTietTour(): void
    {
        $id = $_GET['id'] ?? $_GET['ma_tour'] ?? null;
        if (!$id) {
            $this->e404();
            return;
        }

        $this->loadModel('Tour');
        $tour = null;

        if (class_exists('Tour')) {
            if (method_exists('Tour', 'find')) {
                $tour = Tour::find($id);
            } elseif (method_exists('Tour', 'getById')) {
                $tour = Tour::getById($id);
            } elseif (method_exists('Tour', 'detail')) {
                $tour = Tour::detail($id);
            }
        }

        if (!$tour) {
            $this->e404();
            return;
        }

        $this->render('client/tour_chi_tiet.php', ['tour' => $tour]);
    }

    // Trang giới thiệu tĩnh
    public function trangGioiThieu(): void
    {
        $this->render('client/gioi_thieu.php');
    }

    // 404
    public function e404(): void
    {
        http_response_code(404);
        if (file_exists($this->viewsPath . '/client/404.php')) {
            $this->render('client/404.php');
            return;
        }
        echo '<h1>404 - Không tìm thấy trang</h1>';
        echo '<p>Trang bạn yêu cầu không tồn tại.</p>';
    }
}
