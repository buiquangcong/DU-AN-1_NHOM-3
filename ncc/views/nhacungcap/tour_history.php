<h2>Lịch sử tour do nhà cung cấp: <?= htmlspecialchars($data['ten_ncc'] ?? '') ?>
    cung cấp</h2>

<table class="table table-bordered table-striped">
    <tr class="table-dark">
        <th>ID Tour</th>
        <th>Tên Tour</th>
        <th>Giá Người Lớn</th>
        <th>Giá Trẻ Em</th>
        <th>Số Ngày</th>
        <th>Số Đêm</th>
        <th>Ngày Khởi Hành</th>
        <th>Số Chỗ</th>
        <th>Trạng Thái</th>
    </tr>

    <?php if (!empty($tours)): ?>
        <?php foreach ($tours as $tour): ?>
            <tr>
                <td><?= $tour['ID_Tour'] ?></td>
                <td><?= $tour['TenTour'] ?></td>
                <td><?= number_format($tour['GiaNguoiLon']) ?> VNĐ</td>
                <td><?= number_format($tour['GiaTreEm']) ?> VNĐ</td>
                <td><?= $tour['SoNgay'] ?></td>
                <td><?= $tour['SoDem'] ?></td>
                <td><?= $tour['NgayKhoiHanh'] ?></td>
                <td><?= $tour['SoCho'] ?></td>
                <td>
                    <?= $tour['TrangThai'] == 1 ? 'Đang hoạt động' : 'Đã kết thúc/Ẩn' ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="9">Nhà cung cấp này chưa cung cấp tour nào</td>
        </tr>
    <?php endif; ?>
</table>