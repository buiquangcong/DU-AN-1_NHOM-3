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
    <?php if (!empty($_SESSION['error']['itinerary'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']['itinerary'];
            unset($_SESSION['error']['itinerary']); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">Import bằng file Excel (.xlsx, .xls)</h5>
        </div>
        <div class="card-body">
            <form action="?act=import-excel-guests" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="ID_Booking" value="<?= $bookingDetail['ID_Booking'] ?>">
                <div class="mb-3">
                    <label for="excel_file" class="form-label">Chọn file Excel</label>
                    <input class="form-control" type="file" id="excel_file" name="excel_file" accept=".xlsx, .xls" required>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload me-2"></i> Tải lên
                        </button>
                    </div>
                    <div>
                        <small class="text-muted">
                            * File Excel phải đúng mẫu:<br>
                            - Cột A: Họ Tên (Bắt buộc)<br>
                            - Cột B: Giới tính (Nam/Nữ)<br>
                            - Cột C: Ngày Sinh (YYYY-MM-DD)<br>
                            - Cột D: Liên Hệ (SĐT)<br>
                            - Cột E: CCCD/Passport<br>
                            - Cột F: Ghi Chú
                        </small>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">Thêm khách mới vào đoàn (Thêm tay)</h5>
        </div>
        <div class="card-body">
            <form action="?act=add-guest" method="POST">
                <input type="hidden" name="ID_Booking" value="<?= $bookingDetail['ID_Booking'] ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="TenNguoiDi" class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control" id="TenNguoiDi" name="TenNguoiDi" placeholder="Nguyễn Văn A" required>
                    </div>
                    <div class="col-md-2">
                        <label for="GioiTinh" class="form-label">Giới tính</label>
                        <select id="GioiTinh" name="GioiTinh" class="form-select">
                            <option value="Nam" selected>Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="NgaySinh" class="form-label">Ngày Sinh</label>
                        <input type="date" class="form-control" id="NgaySinh" name="NgaySinh">
                    </div>
                    <div class="col-md-3">
                        <label for="LienHe" class="form-label">Liên hệ (SĐT)</label>
                        <input type="text" class="form-control" id="LienHe" name="LienHe" placeholder="09xxxxxxx">
                    </div>
                    <div class="col-md-6">
                        <label for="CCCD_Passport" class="form-label">CCCD / Passport</label>
                        <input type="text" class="form-control" id="CCCD_Passport" name="CCCD_Passport">
                    </div>
                    <div class="col-md-6">
                        <label for="GhiChu" class="form-label">Yêu cầu cá nhân</label>
                        <input type="text" class="form-control" id="GhiChu" name="GhiChu" placeholder="Ví dụ: Ăn chay, phòng tầng cao...">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">+ Thêm khách</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
                                <?php if ($bookingDetail['TrangThai'] == 1): ?>
                                    <span class="badge bg-success">Đã xác nhận</span>
                                <?php elseif ($bookingDetail['TrangThai'] == 2): ?>
                                    <span class="badge bg-danger">Đã hủy</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Chờ xác nhận</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <select class="form-select form-select-sm"
                                    name="guest_status[<?= $guest['ID_ChiTiet'] ?>]">
                                    <option value="0" <?= ($guest['TrangThaiCheckin'] == 0) ? 'selected' : '' ?>>
                                        Chưa đến
                                    </option>
                                    <option value="1" <?= ($guest['TrangThaiCheckin'] == 1) ? 'selected' : '' ?>>
                                        Đã đến
                                    </option>
                                    <option value="2" <?= ($guest['TrangThaiCheckin'] == 2) ? 'selected' : '' ?>>
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