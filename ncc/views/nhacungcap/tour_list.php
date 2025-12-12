<h1>Danh Sách Tour Đang Hoạt Động Của Nhà Cung Cấp</h1>

<p>
    Nhà cung cấp: <strong><?= $ncc['ten_ncc'] ?? 'Không rõ' ?></strong>
</p>

<?php if (empty($tours)): ?>
    <p style="color: red;">⚠️ Nhà Cung Cấp này hiện chưa có tour nào đang hoạt động.</p>
<?php else: ?>
    <table class="table table-bordered table-striped">
        <tr class="table-dark">
            <th>ID Tour</th>
            <th>Tên Tour</th>
            <th>Số Ngày/Đêm</th>
            <th>Giá Người Lớn</th>
            <th>Ngày Khởi Hành</th>
            <th>Số Chỗ</th>
            <th>Trạng Thái</th>
        </tr>
        <tbody>
            <?php foreach ($tours as $tour): ?>
                <tr>
                    <td><?= $tour['ID_Tour'] ?></td>
                    <td><?= $tour['TenTour'] ?></td>
                    <td><?= $tour['SoNgay'] ?> ngày / <?= $tour['SoDem'] ?> đêm</td>
                    <td><?= number_format($tour['GiaNguoiLon'], 0, ',', '.') ?> VNĐ</td>
                    <td><?= date('d/m/Y', strtotime($tour['NgayKhoiHanh'])) ?></td>
                    <td><?= $tour['SoCho'] ?></td>
                    <td><?= $tour['TrangThai'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>