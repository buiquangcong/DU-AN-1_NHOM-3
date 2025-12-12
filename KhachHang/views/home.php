<div class="search-section my-5">
    <div class="card shadow-lg border-0 bg-white">
        <div class="card-body p-4 p-lg-5">
            <h2 class="card-title mb-4 text-center" style="color: var(--bee-green-dark);">
                Tìm kiếm Tour Du lịch Xanh cùng Bee Green
            </h2>

            <form action="/search-tour" method="GET">
                <div class="row g-3 align-items-end">

                    <div class="col-12 col-lg-5">
                        <label for="destination" class="form-label fw-bold">
                            <i class="fas fa-map-marker-alt me-2 text-danger"></i> Điểm Đến
                        </label>
                        <input type="text" class="form-control form-control-lg" id="destination" name="destination" placeholder="Ví dụ: Hạ Long, Đà Lạt..." required>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="date" class="form-label fw-bold">
                            <i class="far fa-calendar-alt me-2" style="color: var(--bee-green-primary);"></i> Ngày Khởi Hành
                        </label>
                        <input type="date" class="form-control form-control-lg" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <label for="guests" class="form-label fw-bold">
                            <i class="fas fa-users me-2" style="color: var(--bee-green-primary);"></i> Khách
                        </label>
                        <input type="number" class="form-control form-control-lg" id="guests" name="guests" value="2" min="1">
                    </div>

                    <div class="col-12 col-lg-2">
                        <button type="submit" class="btn btn-lg w-100 fw-bold" style="background-color: var(--bee-green-primary); color: white;">
                            <i class="fas fa-search me-1"></i> Tìm Tour
                        </button>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>