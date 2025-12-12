<?php
if (!$booking) {
    echo "<div class='alert alert-danger'>Không tìm thấy booking.</div>";
    return;
}
?>

<div class="container mt-4">
    <h2 class="mb-3">Chi tiết Booking</h2>
    <h4 class="text-primary mb-4">Booking ID: <?= htmlspecialchars($booking['ID_Booking']) ?></h4>

    <p><strong>Tên Tour:</strong> <?= htmlspecialchars($booking['TenTour'] ?? '-') ?></p>
    <p><strong>Tên Khách Hàng:</strong> <?= htmlspecialchars($booking['TenKhachHang'] ?? '-') ?></p>
    <p><strong>Ngày Đặt:</strong> <?= $booking['NgayDatTour'] ? date('d/m/Y', strtotime($booking['NgayDatTour'])) : '-' ?></p>
    <p><strong>Số lượng:</strong> <?= ($booking['SoLuongNguoiLon'] ?? 0) ?> NL / <?= ($booking['SoLuongTreEm'] ?? 0) ?> TE</p>
    <p><strong>Tổng tiền:</strong> <?= number_format($booking['TongTien'] ?? 0) ?>₫</p>
    <p><strong>Trạng thái:</strong>
        <?php
        $status = $booking['TrangThai'] ?? 0;
        if ($status == 1) echo "<span class='badge bg-success'>Đã xác nhận</span>";
        elseif ($status == 2) echo "<span class='badge bg-danger'>Đã hủy</span>";
        else echo "<span class='badge bg-warning'>Chờ xác nhận</span>";
        ?>
    </p>

    <h5 class="mt-4">Danh sách khách</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ Tên</th>
                <th>Ngày sinh</th>
                <th>Tuổi</th>
                <th>Giới tính</th>
                <th>CMND / CCCD</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($guests)): ?>
                <?php foreach ($guests as $index => $g): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($g['TenNguoiDi'] ?? '-') ?></td>
                        <td><?= $g['NgaySinh'] ? date('d/m/Y', strtotime($g['NgaySinh'])) : '-' ?></td>
                        <td><?= $g['NgaySinh'] ? (new DateTime($g['NgaySinh']))->diff(new DateTime('today'))->y : '-' ?></td>
                        <td><?= htmlspecialchars($g['GioiTinh'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($g['CMND_CCCD'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">Chưa có khách nào</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>