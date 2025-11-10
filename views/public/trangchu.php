<?php
// Giả định controller đã include file header_public.php
// và đã chuẩn bị 1 biến mảng $dsTourNoiBat
?>

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Tìm Chuyến Đi Mơ Ước</h1>
        <p class="col-md-8 fs-4">Khám phá hàng ngàn tour du lịch với giá cả phải chăng.</p>
        <form class="d-flex gap-2">
            <input class="form-control form-control-lg" type="text" placeholder="Bạn muốn đi đâu?">
            <input class="form-control form-control-lg" type="date">
            <button class="btn btn-primary btn-lg flex-shrink-0" type="submit">Tìm Kiếm</button>
        </form>
    </div>
</div>

<h2 class="mb-3">Tour Nổi Bật</h2>
<div class="row row-cols-1 row-cols-md-3 g-4">

    <div class="col">
        <div class="card h-100 shadow-sm">
            <img src="https://example.com/image-danang.jpg" class="card-img-top" alt="Đà Nẵng">
            <div class="card-body">
                <h5 class="card-title">Khám Phá Đà Nẵng - Hội An</h5>
                <p class="card-text text-muted"><i class="bi bi-clock"></i> 3N2Đ</p>
                <h4 class="text-danger fw-bold">3,500,000 VND</h4>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="#" class="btn btn-primary w-100">Xem Chi Tiết</a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card h-100 shadow-sm">
            <img src="https://example.com/image-hanquoc.jpg" class="card-img-top" alt="Hàn Quốc">
            <div class="card-body">
                <h5 class="card-title">Du Lịch Mùa Thu Hàn Quốc</h5>
                <p class="card-text text-muted"><i class="bi bi-clock"></i> 5N4Đ</p>
                <h4 class="text-danger fw-bold">22,900,000 VND</h4>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="#" class="btn btn-primary w-100">Xem Chi Tiết</a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card h-100 shadow-sm">
            <img src="https://example.com/image-mientay.jpg" class="card-img-top" alt="Miền Tây">
            <div class="card-body">
                <h5 class="card-title">Miền Tây Sông Nước</h5>
                <p class="card-text text-muted"><i class="bi bi-clock"></i> 2N1Đ</p>
                <h4 class="text-danger fw-bold">1,800,000 VND</h4>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="#" class="btn btn-primary w-100">Xem Chi Tiết</a>
            </div>
        </div>
    </div>
</div>

<?php
// Giả định controller sẽ include file footer_public.php
?>