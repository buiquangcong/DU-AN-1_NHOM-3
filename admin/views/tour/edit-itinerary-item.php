<?php
// Biến $item được truyền từ Controller (hàm formEditItineraryItem)
?>
<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=manage-itinerary&id=<?= $item['ID_Tour'] ?? '' ?>" class="btn btn-secondary">&larr; Quay lại</a>
    </div>

    <h2 class="mb-4">Sửa mục Lịch trình</h2>
    <hr>

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">Chi tiết mục</h5>
        </div>
        <div class="card-body">
            <form action="?act=post-edit-itinerary-item" method="POST">

                <input type="hidden" name="tour_id" value="<?= $item['ID_Tour'] ?? '' ?>">
                <input type="hidden" name="itinerary_id" value="<?= $item['ID_ChiTietTour'] ?? '' ?>">

                <div class="row g-3">
                    <div class="col-md-2">
                        <label for="day_number" class="form-label">Ngày thứ</label>
                        <input type="number" class="form-control" id="day_number" name="day_number"
                            value="<?= htmlspecialchars($item['ThuTu'] ?? '1') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="time_slot" class="form-label">Thời gian</label>
                        <input type="text" class="form-control" id="time_slot" name="time_slot"
                            value="<?= htmlspecialchars($item['KhungGio'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="activity_title" class="form-label">Tên hoạt động / Điểm tham quan</label>
                        <input type="text" class="form-control" id="activity_title" name="activity_title"
                            value="<?= htmlspecialchars($item['TenHoatDong'] ?? '') ?>" required>
                    </div>
                    <div class="col-12">
                        <label for="activity_description" class="form-label">Mô tả chi tiết</label>
                        <textarea class="form-control" id="activity_description" name="activity_description" rows="3"><?= htmlspecialchars($item['MoTaHoatDong'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>