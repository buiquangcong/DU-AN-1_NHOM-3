<?php
// Giả sử $tourDetail, $listItinerary đã có
?>

<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=list-tours" class="btn btn-secondary">&larr; Quay lại danh sách tour</a>
    </div>

    <h2 class="mb-4">Quản lý Lịch trình cho Tour:</h2>
    <h3 class="text-primary"><?= htmlspecialchars($tourDetail['TenTour'] ?? 'Tên tour không tìm thấy') ?></h3>
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
</div>

<h4 class="mt-5">Các mục Lịch trình hiện có</h4>
<table class="table table-bordered table-hover align-middle">
    <thead class="table-dark">
        <tr class="text-center">
            <th>Ngày</th>
            <th>Thời gian</th>
            <th>Hoạt động</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($listItinerary)): ?>
            <?php foreach ($listItinerary as $item): ?>
                <tr>
                    <td class="text-center"><?= htmlspecialchars($item['ThuTu']) ?></td>
                    <td><?= htmlspecialchars($item['KhungGio']) ?></td>
                    <td><?= htmlspecialchars($item['TenHoatDong']) ?></td>
                    <td><?= nl2br(htmlspecialchars($item['MoTaHoatDong'])) ?></td>
                    <td class="text-center">

                        <a href="?act=edit-itinerary-item&id=<?= $item['ID_ChiTietTour'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="?act=delete-itinerary-item&id=<?= $item['ID_ChiTietTour'] ?>&tour_id=<?= $tourDetail['ID_Tour'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn có chắc muốn xóa mục này?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center text-muted">Chưa có mục lịch trình nào cho tour này.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</div>