<?php
if (!$booking) {
    echo "<div class='alert alert-danger'>Không tìm thấy booking.</div>";
    return;
}

// --- 1. LOGIC TÍNH TOÁN ---
// Lấy tiền cọc (Nếu database chưa có cột này thì mặc định là 0)
$tien_coc = isset($booking['tien_coc']) ? $booking['tien_coc'] : 0;
$tong_tien = isset($booking['TongTien']) ? $booking['TongTien'] : 0;

// Tính tiền còn lại
$con_lai = $tong_tien - $tien_coc;
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Chi tiết Booking</h2>
        <a href="?act=quan-ly-booking" class="btn btn-secondary btn-sm">&larr; Quay lại danh sách</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="text-primary mb-4 border-bottom pb-2">Booking ID: #<?= htmlspecialchars($booking['ID_Booking']) ?></h4>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Tên Tour:</strong> <?= htmlspecialchars($booking['TenTour'] ?? '-') ?></p>
                    <p><strong>Tên Khách Hàng:</strong> <?= htmlspecialchars($booking['TenKhachHang'] ?? '-') ?></p>
                    <p><strong>Email / Liên hệ:</strong> <?= htmlspecialchars($booking['Email'] ?? '-') ?></p>
                    <p><strong>Ngày Đặt:</strong> <?= $booking['NgayDatTour'] ? date('d/m/Y', strtotime($booking['NgayDatTour'])) : '-' ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Số lượng:</strong> <?= ($booking['SoLuongNguoiLon'] ?? 0) ?> NL / <?= ($booking['SoLuongTreEm'] ?? 0) ?> TE</p>

                    <p><strong>Tổng tiền:</strong> <span class="fs-5 text-primary fw-bold"><?= number_format($tong_tien) ?>₫</span></p>

                    <p><strong>Đã cọc:</strong> <span class="fs-5 text-success fw-bold"><?= number_format($tien_coc) ?>₫</span></p>

                    <p><strong>Còn lại:</strong>
                        <?php if ($con_lai <= 0): ?>
                            <span class="badge bg-success fs-6">Đã thanh toán đủ</span>
                        <?php else: ?>
                            <span class="fs-5 text-danger fw-bold"><?= number_format($con_lai) ?>₫</span>
                        <?php endif; ?>
                    </p>

                    <p><strong>Trạng thái:</strong>
                        <?php
                        $status = $booking['TrangThai'] ?? 0;
                        if ($status == 1) echo "<span class='badge bg-success'>Đã xác nhận</span>";
                        elseif ($status == 2) echo "<span class='badge bg-danger'>Đã hủy</span>";
                        elseif ($status == 3) echo "<span class='badge bg-secondary'>Đã hoàn thành</span>";
                        else echo "<span class='badge bg-warning text-dark'>Chờ xác nhận</span>";
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mt-4 text-secondary"><i class="bi bi-people-fill"></i> Danh sách khách trong đoàn</h5>
    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Họ Tên</th>
                    <th>Ngày sinh</th>
                    <th>Tuổi</th>
                    <th>Giới tính</th>
                    <th>CCCD / Passport</th>
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
                            <td><?= htmlspecialchars($g['CCCD_Passport'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Chưa có thông tin khách hàng đi kèm</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>