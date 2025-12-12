<?php
// Các biến $bookingDetail và $listGuests được truyền từ Controller
?>

<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=quan-ly-booking" class="btn btn-secondary">&larr; Quay lại danh sách Booking</a>
    </div>

    <h2 class="mb-2">Quản lý Đoàn khách</h2>
    <h4 class="text-primary mb-4">Tour: <?= htmlspecialchars($bookingDetail['TenTour'] ?? 'N/A') ?> (Booking ID: <?= $bookingDetail['ID_Booking'] ?>)</h4>
    <hr>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= is_array($_SESSION['error']) ? implode('<br>', $_SESSION['error']) : $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>


    <div class="card shadow-sm mb-4 border-info">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">📍 Quản lý Điểm danh Lịch trình Tour</h5>
        </div>
        <div class="card-body d-flex justify-content-between align-items-center">
            <p class="mb-0">Bấm vào đây để điểm danh hành khách theo từng hoạt động (ví dụ: điểm danh lên xe, điểm danh ăn trưa).</p>

            <a href="?act=list-checkin-lich-trinh&tour_id=<?= htmlspecialchars($bookingDetail['ID_Tour']) ?>"
                class="btn btn-primary btn-lg">
                <i class="bi bi-list-check me-2"></i> Xem Lịch trình & Điểm danh
            </a>
        </div>
    </div>
    <hr>

    <h4 class="mt-5">Danh sách khách trong đoàn (Hiện có: <?= count($listGuests) ?> người)</h4>

    <form action="?act=bulk-update-checkin" method="POST">
        <input type="hidden" name="booking_id" value="<?= $bookingDetail['ID_Booking'] ?>">

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Họ Tên</th>
                    <th>Giới Tính</th>
                    <th>Ngày Sinh</th>
                    <th>Liên Hệ</th>
                    <th>CCCD/Passport</th>
                    <th>Tình trạng TT</th>
                    <th style="width: 150px;">Check-in</th>
                    <th>Yêu cầu</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listGuests)): ?>
                    <?php foreach ($listGuests as $guest): ?>
                        <tr>
                            <td><?= htmlspecialchars($guest['TenNguoiDi'] ?? '') ?></td>
                            <td><?= htmlspecialchars($guest['GioiTinh'] ?? '') ?></td>
                            <td><?= htmlspecialchars($guest['NgaySinh'] ?? '') ?></td>
                            <td><?= htmlspecialchars($guest['LienHe'] ?? '') ?></td>
                            <td><?= htmlspecialchars($guest['CCCD_Passport'] ?? '') ?></td>

                            <td class="text-center">
                                <?php if (($bookingDetail['TrangThai'] ?? 0) == 1): ?>
                                    <span class="badge bg-success">Đã xác nhận</span>
                                <?php elseif (($bookingDetail['TrangThai'] ?? 0) == 2): ?>
                                    <span class="badge bg-danger">Đã hủy</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Chờ xác nhận</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <select class="form-select form-select-sm"
                                    name="guest_status[<?= $guest['ID_ChiTiet'] ?>]">
                                    <option value="0" <?= (($guest['TrangThaiCheckin'] ?? 0) == 0) ? 'selected' : '' ?>>
                                        Chưa đến
                                    </option>
                                    <option value="1" <?= (($guest['TrangThaiCheckin'] ?? 0) == 1) ? 'selected' : '' ?>>
                                        Đã đến
                                    </option>
                                    <option value="2" <?= (($guest['TrangThaiCheckin'] ?? 0) == 2) ? 'selected' : '' ?>>
                                        Vắng mặt
                                    </option>
                                </select>
                            </td>

                            <td><?= htmlspecialchars($guest['GhiChu'] ?? '') ?></td>
                            <td class="text-center">
                                <a href="?act=delete-guest&guest_id=<?= $guest['ID_ChiTiet'] ?>&booking_id=<?= $guest['ID_Booking'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xóa khách này khỏi đoàn?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted">Chưa có khách nào trong đoàn.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="bi bi-check-all me-2"></i> Lưu trạng thái Check-in
            </button>
        </div>

    </form>
</div>