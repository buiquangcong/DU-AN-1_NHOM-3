<div class="container mt-4">
    <h2 class="mb-4 text-center">Quản lý Booking</h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>ID Booking</th>
                <th>Tên Tour</th>
                <th>Tên Khách Hàng</th>
                <th>Ngày Đặt</th>
                <th>Số Lượng (NL/TE)</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listBookings)): ?>
                <?php foreach ($listBookings as $item): ?>
                    <tr>
                        <td class="text-center"><?= htmlspecialchars($item['ID_Booking']) ?></td>
                        <td><?= htmlspecialchars($item['TenTour']) ?></td>
                        <td><?= htmlspecialchars($item['TenKhachHang']) ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($item['NgayDatTour'])) ?></td>
                        <td class="text-center"><?= $item['SoLuongNguoiLon'] ?> / <?= $item['SoLuongTreEm'] ?></td>
                        <td><?= number_format($item['TongTien']) ?>₫</td>
                        <td class="text-center">
                            <?php if ($item['TrangThai'] == 1): ?>
                                <span class="badge bg-success">Đã xác nhận</span>
                            <?php elseif ($item['TrangThai'] == 2): ?>
                                <span class="badge bg-danger">Đã hủy</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Chờ xác nhận</span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <a href="?act=manage-guests&booking_id=<?= $item['ID_Booking'] ?>"
                                class="btn btn-primary btn-sm"
                                title="Quản lý danh sách khách">
                                Quản lý Khách
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Chưa có đơn hàng (booking) nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>