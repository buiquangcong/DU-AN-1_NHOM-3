<div class="container mt-4">
    <h2 class="mb-3 text-center text-primary">✏️ Sửa thông tin Tour</h2>

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

    <form action="?act=save-edit-tour" method="POST" class="border p-4 rounded bg-light">
        <input type="hidden" name="ID_Tour" value="<?= $sanpham['ID_Tour'] ?>">

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Tên tour</label>
                <input type="text" name="TenTour" class="form-control" value="<?= htmlspecialchars($sanpham['TenTour']) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Loại tour</label>
                <select name="ID_LoaiTour" class="form-select" required>
                    <?php foreach ($listDanhmuc as $dm): ?>
                        <option value="<?= $dm['ID_LoaiTour'] ?>"
                            <?= ($dm['ID_LoaiTour'] == $sanpham['ID_LoaiTour']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dm['TenLoaiTour']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Giá người lớn</label>
                <input type="number" name="GiaNguoiLon" class="form-control" value="<?= $sanpham['GiaNguoiLon'] ?>" min="0" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Giá trẻ em</label>
                <input type="number" name="GiaTreEm" class="form-control" value="<?= $sanpham['GiaTreEm'] ?>" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label">Số chỗ</label>
                <input type="number" name="SoCho" class="form-control" value="<?= $sanpham['SoCho'] ?>" min="1" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Số ngày</label>
                <input type="number" name="SoNgay" class="form-control" value="<?= $sanpham['SoNgay'] ?>" min="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Số đêm</label>
                <input type="number" name="SoDem" class="form-control" value="<?= $sanpham['SoDem'] ?>" min="0" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ngày khởi hành</label>
                <input type="date" name="NgayKhoiHanh" class="form-control" value="<?= $sanpham['NgayKhoiHanh'] ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Điểm khởi hành</label>
                <input type="text" name="DiemKhoiHanh" class="form-control" value="<?= htmlspecialchars($sanpham['DiemKhoiHanh']) ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nội dung tóm tắt</label>
            <textarea name="NoiDungTomTat" rows="3" class="form-control" required><?= htmlspecialchars($sanpham['NoiDungTomTat']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Nội dung chi tiết</label>
            <textarea name="NoiDungChiTiet" rows="5" class="form-control" required><?= htmlspecialchars($sanpham['NoiDungChiTiet']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="TrangThai" class="form-select" required>
                <option value="1" <?= ($sanpham['TrangThai'] == 1) ? 'selected' : '' ?>>Hoạt Động</option>
                <option value="0" <?= ($sanpham['TrangThai'] == 0) ? 'selected' : '' ?>>Tạm Dừng</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success px-4">💾 Cập nhật</button>
            <a href="?act=list-tours" class="btn btn-secondary px-4">⬅ Quay lại</a>
        </div>
    </form>
</div>
