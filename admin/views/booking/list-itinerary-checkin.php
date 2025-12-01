<?php
// File: /views/booking/list-itinerary-checkin.php

// Gán Tour ID
$tourId = $listLichTrinh[0]['ID_Tour'] ?? $_GET['tour_id'] ?? null;
?>

<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=manage-guests&booking_id=<?= htmlspecialchars($_GET['booking_id'] ?? '') ?>" class="btn btn-secondary">&larr; Quay lại quản lý khách</a>
    </div>

    <h2 class="mb-4">📋 Danh sách Hoạt động Cần Điểm danh</h2>
    <h4 class="text-primary mb-4">Tour ID: <?= htmlspecialchars($tourId) ?></h4>

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

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr class="text-center">
                <th style="width: 5%;">Ngày</th>
                <th style="width: 10%;">Thời Gian</th>
                <th style="width: 30%;">Tên Hoạt Động / Địa Điểm</th>
                <th>Mô Tả Chi Tiết</th>
                <th style="width: 15%;">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listLichTrinh)): ?>
                <?php foreach ($listLichTrinh as $lichTrinh):

                    // Tìm ID Lịch Trình (Khóa chính)
                    // Dựa trên ảnh DB, tên cột chính xác là ID_ChiTietTour
                    $ltId = htmlspecialchars($lichTrinh['ID_ChiTietTour'] ?? '0');

                    // Lấy ID Tour
                    $tId = htmlspecialchars($lichTrinh['ID_Tour'] ?? '0');

                    // Bỏ qua nếu ID bị rỗng
                    if ($ltId === '0' || $tId === '0') continue;
                ?>
                    <tr>
                        <td class="text-center"><?= htmlspecialchars($lichTrinh['ThuTu'] ?? '') ?></td>
                        <td class="text-center"><?= $lichTrinh['KhungGio'] ?? '' ?></td>
                        <td>
                            <strong><?= htmlspecialchars($lichTrinh['TenHoatDong'] ?? 'Chưa đặt tên') ?></strong>
                        </td>
                        <td><?= nl2br(htmlspecialchars($lichTrinh['MoTaHoatDong'] ?? '')) ?></td>
                        <td class="text-center">
                            <a href="?act=process-checkin-lich-trinh&tour_id=<?= $tId ?>&amp;lt_id=<?= $ltId ?>"
                                class="btn btn-primary btn-sm">
                                <i class="bi bi-person-check me-1"></i> Điểm danh
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Tour này chưa có mục lịch trình nào được thiết lập.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>