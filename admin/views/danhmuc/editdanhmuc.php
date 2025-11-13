<?php
// PHP GIỮ NGUYÊN
$TenLoaiTourValue = $_POST['TenLoaiTour'] ?? ($danhmuc['TenLoaiTour'] ?? '');
$hasError = !empty($error['TenLoaiTour']);
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cập nhật danh mục</h1>
        <a href="index.php?act=list-danhmuc" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <div class="row">
        <div class="col-12 col-lg-8">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin loại tour</h6>
                </div>

                <div class="card-body">
                    <form action="index.php?act=post-edit-danhmuc&id=<?= htmlspecialchars($danhmuc['ID_LoaiTour']) ?>" method="post">

                        <div class="mb-3">
                            <label for="TenLoaiTour" class="form-label fw-bold">Tên Loại Tour</label>
                            <input type="text"
                                name="TenLoaiTour"
                                id="TenLoaiTour"
                                class="form-control <?= $hasError ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($TenLoaiTourValue) ?>"
                                placeholder="Nhập tên danh mục...">

                            <?php if ($hasError): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($error['TenLoaiTour']) ?>
                                </div>
                            <?php else: ?>
                                <div class="form-text text-muted">Tên loại tour nên ngắn gọn và rõ nghĩa.</div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Lưu Thay Đổi
                            </button>
                            <button type="reset" class="btn btn-light border">
                                Nhập lại
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>