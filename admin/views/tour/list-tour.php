<div class="container mt-4">
    <h2 class="mb-4 text-center">Danh sách Tour du lịch</h2>

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

    <div class="mb-3 text-end">
        <a href="?act=add-tour" class="btn btn-primary">+ Thêm tour mới</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="" method="GET" class="d-flex">
                <input type="hidden" name="act" value="list-tours">

                <input type="text" class="form-control me-2" name="search_id"
                    placeholder="Nhập ID Tour (ví dụ: T-9011)"
                    value="<?= htmlspecialchars($_GET['search_id'] ?? '') ?>">

                <button type="submit" class="btn btn-primary" style="white-space: nowrap;">Tìm kiếm</button>

                <?php if (!empty($_GET['search_id'])): ?>
                    <a href="?act=list-tours" class="btn btn-outline-secondary ms-2">Hủy</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="table-responsive">
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
                    <th>Ảnh Bìa</th>
                    <th>Số chỗ</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($listTours)): ?>
                    <?php foreach ($listTours as $item): ?>
                        <tr>
                            <td class="text-center"><?= $item['ID_Tour'] ?? ''; ?></td>

                            <td><?= htmlspecialchars($item['TenTour'] ?? ''); ?></td>

                            <td><?= htmlspecialchars($item['TenLoaiTour'] ?? ''); ?></td>

                            <td><?= number_format($item['GiaNguoiLon'] ?? 0); ?>₫</td>
                            <td><?= number_format($item['GiaTreEm'] ?? 0); ?>₫</td>
                            <td><?= $item['SoNgay'] ?? ''; ?></td>
                            <td><?= $item['SoDem'] ?? ''; ?></td>

                            <td><?= htmlspecialchars($item['NgayKhoiHanh'] ?? ''); ?></td>

                            <td class="text-center">
                                <?php if (!empty($item['UrlAnh'])): ?>
                                    <img src="<?= htmlspecialchars($item['UrlAnh'] ?? ''); ?>" alt="Ảnh bìa Tour" style="width: 80px; height: 50px; object-fit: cover;">
                                <?php else: ?>
                                    <span class="text-muted">Không có ảnh</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $item['SoCho'] ?? ''; ?></td>
                            <td>
                                <?php if (($item['TrangThai'] ?? 0) == 1): ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Tạm dừng</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-grid gap-1 mx-auto" style="max-width: 120px;">

                                    <a href="?act=tour-detail&id=<?= $item['ID_Tour']; ?>" class="btn btn-primary btn-sm" title="Xem chi tiết Tour, Lịch trình và NCC">Chi tiết</a>

                                    <a href="?act=manage-itinerary&id=<?= $item['ID_Tour']; ?>" class="btn btn-info btn-sm" title="Quản lý Lịch trình">Lịch trình</a>
                                    <a href="?act=manage-suppliers&id=<?= $item['ID_Tour']; ?>" class="btn btn-secondary btn-sm" title="Quản lý Nhà cung cấp">NCC</a>
                                    <a href="?act=edit-tour&id=<?= $item['ID_Tour']; ?>" class="btn btn-warning btn-sm" title="Sửa thông tin cơ bản">Sửa</a>
                                    <a href="?act=delete-tour&id=<?= $item['ID_Tour']; ?>"
                                        class="btn btn-danger btn-sm" title="Xóa tour"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa tour này không?');">Xóa</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center text-muted">
                            <?php if (!empty($_GET['search_id'])): ?>
                                Không tìm thấy tour nào khớp với ID "<?= htmlspecialchars($_GET['search_id']) ?>".
                            <?php else: ?>
                                Chưa có tour nào được thêm.
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>