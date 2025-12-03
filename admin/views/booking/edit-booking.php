<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=quan-ly-booking" class="btn btn-secondary">&larr; Quay lại danh sách</a>
    </div>

    <h2 class="mb-4 text-center">Cập nhật Booking #<?= htmlspecialchars($booking['ID_Booking']) ?></h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark fw-bold">
                Thông tin Booking
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label for="tour_id" class="form-label">Tour Du Lịch <span class="text-danger">*</span></label>
                    <select class="form-select" id="tour_id" name="tour_id" required>
                        <?php foreach ($tours as $tour): ?>
                            <option value="<?= htmlspecialchars($tour['ID_Tour']) ?>"
                                <?= ($booking['ID_Tour'] == $tour['ID_Tour']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tour['TenTour']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tên Người Đặt (Liên hệ) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="TenKhachHang"
                            value="<?= htmlspecialchars($booking['TenKhachHang']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Liên hệ <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="Email"
                            value="<?= htmlspecialchars($booking['Email'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Ngày Khởi Hành</label>
                        <input type="date" class="form-control" name="ngay_dat"
                            value="<?= date('Y-m-d', strtotime($booking['NgayDatTour'])) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Người lớn</label>
                        <input type="number" min="1" class="form-control" name="so_luong_nl"
                            value="<?= $booking['SoLuongNguoiLon'] ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trẻ em</label>
                        <input type="number" min="0" class="form-control" name="so_luong_te"
                            value="<?= $booking['SoLuongTreEm'] ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Hướng Dẫn Viên Phụ Trách</label>
                    <select class="form-select" name="id_hdv">
                        <option value="">-- Chưa phân công --</option>
                        <?php if (isset($listHDV) && is_array($listHDV)): ?>
                            <?php foreach ($listHDV as $hdv): ?>
                                <option value="<?= $hdv['ID_TaiKhoan'] ?>"
                                    <?= (isset($booking['id_huong_dan_vien']) && $booking['id_huong_dan_vien'] == $hdv['ID_TaiKhoan']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($hdv['ho_ten']) ?> (SĐT: <?= $hdv['so_dien_thoai'] ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái Booking</label>
                    <select class="form-select w-auto" name="trang_thai">
                        <option value="0" <?= ($booking['TrangThai'] == 0) ? 'selected' : '' ?>>Chờ xác nhận</option>
                        <option value="1" <?= ($booking['TrangThai'] == 1) ? 'selected' : '' ?>>Đã xác nhận</option>
                        <option value="2" <?= ($booking['TrangThai'] == 2) ? 'selected' : '' ?>>Đã hủy</option>
                        <option value="3" <?= ($booking['TrangThai'] == 3) ? 'selected' : '' ?>>Đã Hoàn Thành</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Tổng tiền hiện tại:</label>
                    <input type="text" class="form-control bg-light" value="<?= number_format($booking['TongTien']) ?> VNĐ" readonly>
                    <small class="text-muted">Hệ thống sẽ tự động tính lại tổng tiền sau khi bấm Cập nhật dựa trên số lượng và giá tour.</small>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-warning btn-lg px-5">
                        <i class="bi bi-save"></i> Cập nhật thay đổi
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>