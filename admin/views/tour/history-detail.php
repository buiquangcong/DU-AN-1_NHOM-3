<h2>Chi tiết Booking Tour</h2>
<a href="?act=history-tours" class="btn btn-secondary mb-3">← Quay lại</a>

<?php if (!empty($booking)): ?>
    <p><strong>Tên Tour:</strong> <?= htmlspecialchars($booking['TenTour']) ?></p>
    <p><strong>Ngày đặt:</strong> <?= htmlspecialchars($booking['NgayDatTour']) ?></p>
    <p><strong>Khách hàng:</strong> <?= htmlspecialchars($booking['TenKhachHang']) ?></p>
    <p><strong>Số lượng người lớn:</strong> <?= $booking['SoLuongNguoiLon'] ?></p>
    <p><strong>Số lượng trẻ em:</strong> <?= $booking['SoLuongTreEm'] ?></p>
    <p><strong>Tổng tiền:</strong> <?= number_format($booking['TongTien'],0,',','.') ?> VND</p>

    <h4>Danh sách khách đi kèm</h4>
    <ul>
        <?php foreach ($guests as $guest): ?>
            <li>
                <?= htmlspecialchars($guest['TenNguoiDi']) ?> - <?= htmlspecialchars($guest['GioiTinh']) ?> - <?= htmlspecialchars($guest['NgaySinh']) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <h4>Nhà cung cấp liên quan</h4>
    <ul>
        <?php foreach ($suppliers as $ncc): ?>
            <li><?= htmlspecialchars($ncc['ten_nha_cc']) ?> - <?= htmlspecialchars($ncc['email']) ?></li>
        <?php endforeach; ?>
    </ul>

<?php else: ?>
    <p>Không tìm thấy chi tiết booking này.</p>
<?php endif; ?>
