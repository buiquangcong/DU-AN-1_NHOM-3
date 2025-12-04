<?php
// 1. Lấy thông tin Hoạt động từ phần tử đầu tiên (nếu có)
// Biến $listKhachAndStatus được truyền từ Controller
$currentActivity = $listKhachAndStatus[0]['TenHoatDong'] ?? 'Không xác định';
$totalGuests = count($listKhachAndStatus);

// 2. Lấy ID từ REQUEST (An toàn hơn)
$tour_id = $_REQUEST['tour_id'] ?? null;
$lich_trinh_id = $_REQUEST['lt_id'] ?? null;

// Gán giá trị mặc định để tránh lỗi hiển thị nếu thiếu
if (!$tour_id) $tour_id = 'N/A';
if (!$lich_trinh_id) $lich_trinh_id = 'N/A';
?>

<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=list-checkin-lich-trinh&tour_id=<?= htmlspecialchars($tour_id) ?>" class="btn btn-secondary">
            &larr; Quay lại danh sách hoạt động
        </a>
    </div>

    <h2 class="mb-2">✅ Điểm Danh Hành Khách</h2>
    <h4 class="text-primary mb-4">
        Hoạt động: <strong><?= htmlspecialchars($currentActivity) ?></strong>
        <span class="text-muted fs-6">(Tour ID: <?= htmlspecialchars($tour_id) ?>, LT ID: <?= htmlspecialchars($lich_trinh_id) ?>)</span>
    </h4>
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

    <form action="?act=process-checkin-lich-trinh" method="POST">
        <input type="hidden" name="tour_id" value="<?= htmlspecialchars($tour_id) ?>">
        <input type="hidden" name="lt_id" value="<?= htmlspecialchars($lich_trinh_id) ?>">

        <h5 class="mb-3">Danh sách khách hàng trong Tour (Tổng: <?= $totalGuests ?> người)</h5>

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr class="text-center">
                    <th style="width: 50px;">#</th>
                    <th>Họ Tên</th>
                    <th>Ngày Sinh</th>
                    <th>ID Booking</th>
                    <th>Trạng Thái Hiện Tại</th>
                    <th style="width: 200px;">Cập nhật</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listKhachAndStatus)): ?>
                    <?php
                    $stt = 1;
                    foreach ($listKhachAndStatus as $khach):
                        // Lấy trạng thái checkin (0, 1 hoặc NULL)
                        $status = $khach['trang_thai'];
                    ?>
                        <tr>
                            <td class="text-center"><?= $stt++ ?></td>
                            <td>
                                <strong><?= htmlspecialchars($khach['HoTen'] ?? 'Không tên') ?></strong>
                                <br>
                                <small class="text-muted"><?= htmlspecialchars($khach['GioiTinh'] ?? '') ?></small>
                            </td>
                            <td class="text-center"><?= htmlspecialchars($khach['NgaySinh'] ?? '') ?></td>
                            <td class="text-center"><?= htmlspecialchars($khach['ID_Booking'] ?? '') ?></td>

                            <td class="text-center">
                                <?php
                                if ($status === '1' || $status === 1) {
                                    echo '<span class="badge bg-success">✅ CÓ MẶT</span>';
                                } elseif ($status === '0' || $status === 0) {
                                    echo '<span class="badge bg-danger">❌ VẮNG MẶT</span>';
                                } else {
                                    echo '<span class="badge bg-warning text-dark">Chưa điểm danh</span>';
                                }
                                ?>
                            </td>

                            <td>
                                <select class="form-select form-select-sm" name="status[<?= $khach['ID_ChiTiet'] ?>]">
                                    <option value="9" <?= ($status === null) ? 'selected' : '' ?>>--- Chọn ---</option>
                                    <option value="1" <?= ($status == 1) ? 'selected' : '' ?>>Có Mặt</option>
                                    <option value="0" <?= ($status !== null && $status == 0) ? 'selected' : '' ?>>Vắng Mặt</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted p-3">
                            Tour này chưa có danh sách khách hàng.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="text-end mt-4 pb-5">
            <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="bi bi-save me-2"></i> Lưu Điểm Danh
            </button>
        </div>
    </form>
</div>