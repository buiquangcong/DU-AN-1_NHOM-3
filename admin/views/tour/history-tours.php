<h2>Lịch sử Tour</h2>
<a href="?act=list-tours" class="btn btn-secondary mb-3">← Quay lại</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID Booking</th>
            <th>Tên Tour</th>
            <th>Khách Hàng</th>
            <th>Ngày đặt</th>
            <th>Tổng Tiền</th>
            <th>Ảnh Tour</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($historyTours)): ?>
            <?php foreach ($historyTours as $b): ?>
                <tr>
                    <td><?= $b['ID_Booking'] ?></td>
                    <td><?= htmlspecialchars($b['TenTour']) ?></td>
                    <td><?= htmlspecialchars($b['TenKhachHang'] ?? '') ?></td>
                    <td><?= htmlspecialchars($b['NgayDatTour']) ?></td>
                    <td>
                        <?= number_format($b['TongTien'] ?? 0) ?>₫
                    </td>
                    <td>
                        <?php if (!empty($b['UrlAnh'])): ?>
                            <img src="<?= $b['UrlAnh'] ?>" style="width:70px;height:50px;object-fit:cover;">
                        <?php else: ?>
                            Chưa có ảnh
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?act=history-detail&id=<?= $b['ID_Booking'] ?>" class="btn btn-info btn-sm">Chi tiết</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Chưa có lịch sử đặt tour.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
