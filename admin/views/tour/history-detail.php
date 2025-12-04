<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="?act=history-tours" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
        <h2 class="text-primary">Chi Tiết Lịch Sử Booking</h2>
    </div>

    <?php if (!empty($booking)): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white fw-bold">
                <i class="bi bi-info-circle"></i> Thông tin đơn hàng #<?= htmlspecialchars($booking['ID_Booking']) ?>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 border-end">
                        <h5 class="text-dark border-bottom pb-2">Thông tin Tour</h5>
                        <p><strong>Tên Tour:</strong> <span class="text-primary fw-bold"><?= htmlspecialchars($booking['TenTour']) ?></span></p>
                        <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($booking['NgayDatTour'])) ?></p>
                        <p><strong>Trạng thái:</strong>
                            <?php if ($booking['TrangThai'] == 1): ?>
                                <span class="badge bg-success">Đã xác nhận</span>
                            <?php elseif ($booking['TrangThai'] == 2): ?>
                                <span class="badge bg-danger">Đã hủy</span>
                            <?php elseif ($booking['TrangThai'] == 3): ?>
                                <span class="badge bg-primary">Hoàn thành</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Chờ xử lý</span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <div class="col-md-6 ps-4">
                        <h5 class="text-dark border-bottom pb-2">Người đặt & Thanh toán</h5>
                        <p><strong>Họ tên:</strong> <?= htmlspecialchars($booking['TenKhachHang']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($booking['Email'] ?? 'N/A') ?></p>
                        <div class="alert alert-light border">
                            <strong>Số lượng:</strong> <?= $booking['SoLuongNguoiLon'] ?> Người lớn - <?= $booking['SoLuongTreEm'] ?> Trẻ em<br>
                            <strong>Tổng tiền:</strong> <span class="text-danger fw-bold fs-5"><?= number_format($booking['TongTien']) ?> VNĐ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white fw-bold">
                <i class="bi bi-people"></i> Danh sách khách hàng trong đoàn
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">STT</th>
                                <th>Họ và Tên</th>
                                <th class="text-center">Giới tính</th>
                                <th class="text-center">Ngày sinh</th>
                                <th>Liên hệ / SĐT</th>
                                <th>CCCD / Passport</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($guests)): ?>
                                <?php foreach ($guests as $index => $guest): ?>
                                    <tr>
                                        <td class="text-center"><?= $index + 1 ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($guest['TenNguoiDi']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($guest['GioiTinh']) ?></td>
                                        <td class="text-center">
                                            <?= !empty($guest['NgaySinh']) ? date('d/m/Y', strtotime($guest['NgaySinh'])) : '--' ?>
                                        </td>
                                        <td><?= htmlspecialchars($guest['LienHe']) ?></td>
                                        <td><?= htmlspecialchars($guest['CCCD_Passport']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">Chưa có danh sách khách hàng.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-building"></i> Nhà cung cấp dịch vụ cho Tour này
            </div>
            <div class="card-body">
                <?php if (!empty($suppliers)): ?>
                    <div class="row">
                        <?php foreach ($suppliers as $ncc): ?>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center border rounded p-3 bg-light">
                                    <div class="me-3">
                                        <i class="bi bi-shop fs-1 text-secondary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold"><?= htmlspecialchars($ncc['ten_nha_cc']) ?></h6>
                                        <small class="text-muted d-block"><i class="bi bi-envelope"></i> <?= htmlspecialchars($ncc['email']) ?></small>
                                        <small class="text-muted d-block"><i class="bi bi-telephone"></i> <?= htmlspecialchars($ncc['so_dien_thoai']) ?></small>
                                        <small class="text-muted d-block"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($ncc['dia_chi']) ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">Chưa có nhà cung cấp nào được liên kết với Tour này.</p>
                <?php endif; ?>
            </div>
        </div>

    <?php else: ?>
        <div class="alert alert-danger text-center">
            <h4><i class="bi bi-exclamation-triangle"></i> Lỗi dữ liệu</h4>
            <p>Không tìm thấy thông tin Booking hoặc Booking không tồn tại.</p>
            <a href="?act=history-tours" class="btn btn-outline-danger">Quay lại danh sách</a>
        </div>
    <?php endif; ?>
</div>