<?php
// File này giả định nhận biến $tours (danh sách các tour) và $pageTitle từ Controller

// Thiết lập hàm format_price() đơn giản nếu chưa có
if (!function_exists('format_price')) {
    function format_price($price)
    {
        return number_format($price, 0, ',', '.') . ' VNĐ';
    }
}

// Nếu biến $tours không tồn tại, gán mảng rỗng để tránh lỗi lặp
$tours = $tours ?? [];
$pageTitle = $pageTitle ?? 'Danh Sách Tour Du Lịch';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h2 class="text-start mb-4" style="color: var(--bee-green-dark);">
                <i class="fas fa-route me-2"></i> <?php echo htmlspecialchars($pageTitle); ?>
            </h2>
            <hr class="mb-5">
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

        <?php if (empty($tours)): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> Rất tiếc, không tìm thấy Tour nào.
                </div>
            </div>
        <?php else: ?>

            <?php foreach ($tours as $tour): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 tour-card-custom">

                        <img src="<?php echo $tour['image_url'] ?? '/public/images/placeholder.jpg'; ?>"
                            class="card-img-top tour-image-custom"
                            alt="<?php echo htmlspecialchars($tour['TenTour'] ?? 'Tour Du lịch'); ?>">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2 text-truncate" style="color: var(--bee-green-dark); font-weight: 600;">
                                <?php echo htmlspecialchars($tour['TenTour'] ?? 'Tour Mới'); ?>
                            </h5>

                            <p class="card-text text-muted mb-3 small">
                                <i class="far fa-clock me-1"></i>
                                <?php echo htmlspecialchars($tour['SoNgay'] ?? '?'); ?> Ngày /
                                <?php echo htmlspecialchars($tour['SoDem'] ?? '?'); ?> Đêm
                            </p>

                            <p class="card-text mb-3 tour-summary">
                                <?php echo htmlspecialchars($tour['NoiDungTomTat'] ?? 'Chưa có mô tả tóm tắt.'); ?>
                            </p>

                            <div class="mt-auto pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price-display fw-bold" style="color: #FF5722; font-size: 1.25rem;">
                                        <?php
                                        $giaNL = $tour['GiaNguoiLon'] ?? 0;
                                        echo format_price($giaNL);
                                        ?>
                                    </span>
                                    <a href="/tour-detail?id=<?php echo htmlspecialchars($tour['ID_Tour'] ?? ''); ?>"
                                        class="btn btn-sm btn-bee-green">
                                        Chi tiết <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                                <p class="text-end text-muted small mt-1 mb-0">Giá từ người lớn</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</div>
<style>
    /* CSS Tùy chỉnh (Được nhúng hoặc đặt trong file CSS chính) */
    :root {
        /* Định nghĩa biến màu nếu chưa có */
        --bee-green-primary: #4CAF50;
        --bee-green-dark: #2E7D32;
    }

    .tour-card-custom {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 8px;
        overflow: hidden;
    }

    .tour-card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .tour-image-custom {
        height: 220px;
        object-fit: cover;
    }

    .tour-summary {
        /* Giới hạn số dòng cho mô tả tóm tắt */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* Chỉ hiển thị 2 dòng */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 3rem;
        /* Đảm bảo chiều cao đồng nhất */
    }

    .btn-bee-green {
        background-color: var(--bee-green-primary) !important;
        color: white !important;
        border: none;
    }

    .btn-bee-green:hover {
        background-color: var(--bee-green-dark) !important;
    }
</style>