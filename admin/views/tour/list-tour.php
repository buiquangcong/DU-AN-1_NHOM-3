<div class="container mt-4">
    <h2 class="mb-4 text-center">Danh sách Tour du lịch</h2>

    <!-- Thông báo thành công hoặc lỗi -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            foreach ($_SESSION['error'] as $err) {
                echo "<p>$err</p>";
            }
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <!-- Nút thêm tour -->
    <div class="mb-3 text-end">
        <a href="?act=add-tour" class="btn btn-primary">+ Thêm tour mới</a>
    </div>

    <!-- Bảng danh sách tour -->
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Tên tour</th>
                <th>Loại tour</th>
                <th>Giá người lớn</th>
                <th>Giá trẻ em</th>
                <th>Số ngày</th>
                <th>Số đêm</th>
                <th>Ngày khởi hành</th>
                <th>Điểm khởi hành</th>
                <th>Số chỗ</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listSanPham)): ?>
                <?php foreach ($listSanPham as $item): ?>
                    <tr>
                        <td class="text-center"><?= $item['ID_Tour'] ?? ''; ?></td>
                        <td><?= htmlspecialchars($item['TenTour']); ?></td>
                        <td><?= htmlspecialchars($item['TenLoaiTour']); ?></td>
                        <td><?= number_format($item['GiaNguoiLon']); ?>₫</td>
                        <td><?= number_format($item['GiaTreEm']); ?>₫</td>
                        <td><?= $item['SoNgay']; ?></td>
                        <td><?= $item['SoDem']; ?></td>
                        <td><?= htmlspecialchars($item['NgayKhoiHanh']); ?></td>
                        <td><?= htmlspecialchars($item['DiemKhoiHanh']); ?></td>
                        <td><?= $item['SoCho']; ?></td>
                        <td>
                            <?php if ($item['TrangThai'] == 1): ?>
                                <span class="badge bg-success">Hoạt động</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Tạm dừng</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="?act=edit-tour&id=<?= $item['ID_Tour']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="?act=delete-tour&id=<?= $item['ID_Tour']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa tour này không?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12" class="text-center text-muted">Chưa có tour nào được thêm.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>