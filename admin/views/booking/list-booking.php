<div class="container mt-4">
    <h2 class="mb-4 text-center">Quản lý Booking</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="?act=add-booking" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Thêm Booking
        </a>

        <form action="" method="GET" class="d-flex">
            <input type="hidden" name="act" value="quan-ly-booking">

            <input type="text" name="keyword" class="form-control me-2"
                placeholder="Nhập Email hoặc Mã Booking..."
                value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>"
                style="width: 250px;">

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Tìm
            </button>
        </form>
    </div>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Tên Tour</th>
                    <th>Khách Hàng / Email</th>
                    <th>Ngày Đặt</th>
                    <th>Số Lượng (NL/TE)</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th style="width: 200px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listBookings)): ?>
                    <?php foreach ($listBookings as $item): ?>
                        <tr>
                            <td class="text-center fw-bold">#<?= htmlspecialchars($item['ID_Booking']) ?></td>
                            <td><?= htmlspecialchars($item['TenTour']) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($item['TenKhachHang']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($item['Email'] ?? 'N/A') ?></small>
                            </td>
                            <td class="text-center"><?= date('d/m/Y', strtotime($item['NgayDatTour'])) ?></td>
                            <td class="text-center"><?= $item['SoLuongNguoiLon'] ?> / <?= $item['SoLuongTreEm'] ?></td>
                            <td class="text-end fw-bold text-danger"><?= number_format($item['TongTien']) ?>₫</td>
                            <td class="text-center">
                                <?php if ($item['TrangThai'] == 1): ?>
                                    <span class="badge bg-success">Đã xác nhận</span>
                                <?php elseif ($item['TrangThai'] == 2): ?>
                                    <span class="badge bg-danger">Đã hủy</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <a href="?act=manage-guests&booking_id=<?= $item['ID_Booking'] ?>"
                                    class="btn btn-primary btn-sm mb-1" title="Quản lý khách">
                                    <i class="bi bi-people"></i>
                                </a>

                                <a href="?act=chi-tiet-booking&id=<?= $item['ID_Booking'] ?>"
                                    class="btn btn-info btn-sm mb-1 text-white" title="Xem chi tiết">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="?act=edit-booking&id=<?= $item['ID_Booking'] ?>"
                                    class="btn btn-warning btn-sm mb-1" title="Sửa Booking">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a href="?act=delete-booking&id=<?= $item['ID_Booking'] ?>"
                                    class="btn btn-danger btn-sm mb-1"
                                    onclick="return confirm('Cảnh báo: Xóa Booking sẽ xóa luôn danh sách khách trong đoàn. Bạn có chắc chắn muốn xóa?');"
                                    title="Xóa Booking">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1"></i><br>
                            Không tìm thấy kết quả nào.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>