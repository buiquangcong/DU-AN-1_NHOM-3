<div class="container mt-4">
    <h2 class="mb-3 text-center text-primary">➕ Thêm Tour Mới</h2>

    <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($_SESSION['error'] as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="index.php?act=save-add-tour" method="POST" enctype="multipart/form-data" class="border p-4 rounded bg-light">

        <div class="mb-3">
            <label class="form-label">Tên tour</label>
            <input type="text" name="TenTour" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Loại tour</label>
            <select name="ID_LoaiTour" class="form-select" required>
                <option value="" disabled selected>-- Chọn loại tour --</option>
                <?php foreach ($listDanhmuc as $dm): ?>
                    <option value="<?= $dm['ID_LoaiTour'] ?>"><?= htmlspecialchars($dm['TenLoaiTour']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Hình ảnh chính (Ảnh bìa)</label>
            <input type="file" name="AnhBia" class="form-control">
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Giá Người Lớn</label>
                <input type="number" name="GiaNguoiLon" class="form-control" min="0" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Giá Trẻ Em</label>
                <input type="number" name="GiaTreEm" class="form-control" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label">Số chỗ</label>
                <input type="number" name="SoCho" class="form-control" min="1" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Số ngày</label>
                <input type="number" name="SoNgay" class="form-control" min="1" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Số đêm</label>
                <input type="number" name="SoDem" class="form-control" min="0" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Ngày khởi hành</label>
                <input type="date" name="NgayKhoiHanh" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Nội dung tóm tắt</label>
            <textarea name="NoiDungTomTat" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Nội dung chi tiết</label>
            <textarea name="NoiDungChiTiet" class="form-control" rows="6" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="TrangThai" class="form-select">
                <option value="1" selected>Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success px-4">💾 Lưu Tour</button>
            <a href="index.php?act=list-tours" class="btn btn-secondary px-4">⬅ Quay lại</a>
        </div>
    </form>
</div>