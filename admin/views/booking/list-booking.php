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

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error'];
            unset($_SESSION['error']); ?>
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
                    <th>Đã Cọc</th>
                    <th>Còn Lại</th>

                    <th style="min-width: 150px;">Hướng Dẫn Viên</th>
                    <th>Trạng Thái</th>
                    <th style="width: 200px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listBookings)): ?>
                    <?php foreach ($listBookings as $item): ?>
                        <?php
                        // --- LOGIC TÍNH TIỀN ---
                        // 1. Lấy tiền cọc (Nếu DB chưa có thì mặc định là 0)
                        $tien_coc = isset($item['tien_coc']) ? $item['tien_coc'] : 0;

                        // 2. Tính còn lại
                        $con_lai = $item['TongTien'] - $tien_coc;
                        ?>
                        <tr>
                            <td class="text-center fw-bold">#<?= htmlspecialchars($item['ID_Booking']) ?></td>
                            <td><?= htmlspecialchars($item['TenTour']) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($item['TenKhachHang']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($item['Email'] ?? 'N/A') ?></small>
                            </td>
                            <td class="text-center"><?= date('d/m/Y', strtotime($item['NgayDatTour'])) ?></td>
                            <td class="text-center"><?= $item['SoLuongNguoiLon'] ?> / <?= $item['SoLuongTreEm'] ?></td>

                            <td class="text-end fw-bold text-primary">
                                <?= number_format($item['TongTien']) ?>₫
                            </td>

                            <td class="text-end fw-bold text-success">
                                <?= number_format($tien_coc) ?>₫
                            </td>

                            <td class="text-end fw-bold text-danger">
                                <?php if ($con_lai <= 0): ?>
                                    <span class="badge bg-success">Đã thanh toán đủ</span>
                                <?php else: ?>
                                    <?= number_format($con_lai) ?>₫
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php if (!empty($item['TenHDV'])): ?>
                                    <span class="badge bg-info text-dark border border-info">
                                        <i class="bi bi-person-badge"></i>
                                        <?= htmlspecialchars($item['TenHDV']) ?>
                                    </span>
                                <?php else: ?>
                                    <?php if ($item['TrangThai'] == 1): ?>
                                        <button type="button"
                                            class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalChonHDV"
                                            onclick="ganIdBooking(<?= $item['ID_Booking'] ?>)">
                                            <i class="bi bi-plus-circle"></i> Chọn HDV
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted small">--</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php if ($item['TrangThai'] == 1): ?>
                                    <span class="badge bg-success">Đã xác nhận</span>
                                <?php elseif ($item['TrangThai'] == 2): ?>
                                    <span class="badge bg-danger">Đã hủy</span>
                                <?php elseif ($item['TrangThai'] == 3): ?>
                                    <span class="badge bg-secondary text-white">Đã Hoàn Thành</span>
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
                        <td colspan="11" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1"></i><br>
                            Không tìm thấy kết quả nào.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalChonHDV" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="?act=cap-nhat-hdv" method="POST">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-person-plus-fill"></i> Phân công HDV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Vui lòng chọn hướng dẫn viên phụ trách cho Booking này:</p>

                    <input type="hidden" name="id_booking" id="id_booking_input">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Danh sách HDV khả dụng:</label>
                        <select name="id_hdv" class="form-select" required>
                            <option value="">-- Chọn Hướng Dẫn Viên --</option>

                            <?php if (isset($listHDV) && is_array($listHDV)): ?>
                                <?php foreach ($listHDV as $hdv): ?>
                                    <option value="<?= $hdv['ID_TaiKhoan'] ?>">
                                        <?= $hdv['ho_ten'] ?> (SĐT: <?= $hdv['so_dien_thoai'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function ganIdBooking(id) {
        document.getElementById('id_booking_input').value = id;
    }
</script>