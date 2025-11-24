<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=quan-ly-booking" class="btn btn-secondary">&larr; Quay lại</a>
    </div>

    <h2 class="mb-4 text-center">Thêm Booking Mới</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL_ADMIN . "?act=add-booking" ?>">
        <div class="mb-3">
            <label for="tour_id" class="form-label">Chọn Tour</label>
            <select class="form-select" id="tour_id" name="tour_id" required>
                <option value="">-- Chọn Tour --</option>
                <?php foreach ($tours as $tour): ?>
                    <option value="<?= htmlspecialchars($tour['ID_Tour']) ?>"
                        <?= (isset($_POST['tour_id']) && $_POST['tour_id'] == $tour['ID_Tour']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tour['TenTour']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="TenKhachHang" class="form-label">Tên Khách hàng</label>
            <input type="text" class="form-control" id="TenKhachHang" name="TenKhachHang"
                value="<?= isset($_POST['TenKhachHang']) ? htmlspecialchars($_POST['TenKhachHang']) : '' ?>"
                placeholder="Nhập tên khách hàng" required>
        </div>

        <div class="mb-3">
            <label for="Email" class="form-label">Email Khách hàng</label>
            <input type="email" class="form-control" id="Email" name="Email"
                value="<?= isset($_POST['Email']) ? htmlspecialchars($_POST['Email']) : '' ?>"
                placeholder="Nhập địa chỉ Email" required>
        </div>

        <div class="mb-3">
            <label for="ngay_dat" class="form-label">Ngày Đặt</label>
            <input type="date" class="form-control" id="ngay_dat" name="ngay_dat"
                value="<?= $_POST['ngay_dat'] ?? date('Y-m-d') ?>" required>
        </div>

        <div class="mb-3 row">
            <div class="col">
                <label for="so_luong_nl" class="form-label">Số lượng Người lớn</label>
                <input type="number" min="0" class="form-control" id="so_luong_nl" name="so_luong_nl"
                    value="<?= (isset($_POST['so_luong_nl']) && is_numeric($_POST['so_luong_nl'])) ? (int)$_POST['so_luong_nl'] : 0 ?>" required>
            </div>
            <div class="col">
                <label for="so_luong_te" class="form-label">Số lượng Trẻ em</label>
                <input type="number" min="0" class="form-control" id="so_luong_te" name="so_luong_te"
                    value="<?= (isset($_POST['so_luong_te']) && is_numeric($_POST['so_luong_te'])) ? (int)$_POST['so_luong_te'] : 0 ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="trang_thai" class="form-label">Trạng thái</label>
            <select class="form-select" id="trang_thai" name="trang_thai" required>
                <?php $current_status = isset($_POST['trang_thai']) ? (int)$_POST['trang_thai'] : 0; ?>

                <option value="0" <?= ($current_status === 0) ? 'selected' : '' ?>>Chờ xác nhận</option>
                <option value="1" <?= ($current_status === 1) ? 'selected' : '' ?>>Đã xác nhận</option>
                <option value="2" <?= ($current_status === 2) ? 'selected' : '' ?>>Đã hủy</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Thêm Booking</button>
    </form>
</div>