<?php
// PHP GIỮ NGUYÊN
// Nếu có lỗi từ controller, sẽ được truyền vào $error
$TenLoaiTourValue = $_POST['TenLoaiTour'] ?? '';

// Biến kiểm tra lỗi (để thêm class 'is-invalid' của Bootstrap)
$hasError = !empty($error['TenLoaiTour']);
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm Loại Tour Mới</h1>
        <a href="index.php?act=list-danhmuc" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nhập thông tin danh mục</h6>
                </div>

                <div class="card-body">
                    <form action="index.php?act=add-danhmuc" method="post">

                        <div class="mb-3">
                            <label for="TenLoaiTour" class="form-label fw-bold">Tên Loại Tour <span class="text-danger">*</span></label>

                            <input type="text"
                                name="TenLoaiTour"
                                id="TenLoaiTour"
                                class="form-control <?= $hasError ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($TenLoaiTourValue) ?>"
                                placeholder="Ví dụ: Du lịch biển, Du lịch núi...">

                            <?php if ($hasError): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($error['TenLoaiTour']) ?>
                                </div>
                            <?php else: ?>
                                <div class="form-text">Tên danh mục không được để trống.</div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Thêm Mới
                            </button>
                            <button type="reset" class="btn btn-light border ms-2">
                                Nhập lại
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div> ```