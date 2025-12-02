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
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">Thêm mục Lịch trình mới</h5>
        </div>
        <div class="card-body">
            <form action="?act=add-itinerary-item" method="POST">
                <input type="hidden" name="tour_id" value="<?= $tourDetail['ID_Tour'] ?? '' ?>">

                <div class="row g-3">
                    <div class="col-md-2">
                        <label for="day_number" class="form-label">Ngày thứ</label>
                        <input type="number" class="form-control" id="day_number" name="day_number" placeholder="Ví dụ: 1" required>
                    </div>
                    <div class="col-md-4">
                        <label for="time_slot" class="form-label">Thời gian</label>
                        <input type="time" class="form-control" id="time_slot" name="time_slot" placeholder="Ví dụ: 08:00 - 10:00">
                    </div>
                    <div class="col-md-6">
                        <label for="activity_title" class="form-label">Tên hoạt động / Điểm tham quan</label>
                        <input type="text" class="form-control" id="activity_title" name="activity_title" placeholder="Ví dụ: Thăm Lăng Bác" required>
                    </div>
                    <div class="col-12">
                        <label for="activity_description" class="form-label">Mô tả chi tiết</label>
                        <textarea class="form-control" id="activity_description" name="activity_description" rows="3"></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">+ Thêm mục</button>
                    </div>
                </div>
            </form>
        </div>
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
                        <td><?= $item['KhungGio'] ?></td>
                        <td><?= $item['TenHoatDong'] ?></td>
                        <td><?= $item['MoTaHoatDong'] ?></td>
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