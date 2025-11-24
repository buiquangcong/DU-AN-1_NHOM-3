<?php
// File: tour-detail-overview.php

// Các biến cần có từ Controller: 
// $tourDetail: Thông tin cơ bản tour
// $listItinerary: Danh sách lịch trình chi tiết
// $linkedSuppliers: Danh sách NCC đã liên kết (có cột ten_vai_tro)
?>

<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=list-tours" class="btn btn-secondary">&larr; Quay lại danh sách tour</a>
    </div>

    <h2 class="mb-4">Chi tiết Tổng quan Tour:</h2>
    <h3 class="text-primary"><?= htmlspecialchars($tourDetail['TenTour'] ?? 'Tour không tìm thấy') ?> (ID: <?= $tourDetail['ID_Tour'] ?? 'N/A' ?>)</h3>
    <hr>

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">Thông tin Cơ bản</h5>
        </div>
        <div class="card-body">
            <p><strong>Ngày khởi hành:</strong> <?= htmlspecialchars($tourDetail['NgayKhoiHanh'] ?? 'Chưa xác định') ?></p>
            <p><strong>Thời gian:</strong> <?= ($tourDetail['SoNgay'] ?? 'X') . ' Ngày / ' . ($tourDetail['SoDem'] ?? 'X') . ' Đêm' ?></p>
            <p><strong>Số chỗ tối đa:</strong> <?= $tourDetail['SoCho'] ?? 'N/A' ?></p>
            <p><strong>Tóm tắt:</strong> <?= htmlspecialchars($tourDetail['NoiDungTomTat'] ?? 'Đang cập nhật...') ?></p>
        </div>
    </div>
    
    <ul class="nav nav-tabs" id="tourDetailTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="itinerary-tab" data-bs-toggle="tab" data-bs-target="#itinerary-content" type="button" role="tab" aria-controls="itinerary-content" aria-selected="true">
                <i class="fas fa-list-ul"></i> Lịch trình Tour (<?= count($listItinerary) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="suppliers-tab" data-bs-toggle="tab" data-bs-target="#suppliers-content" type="button" role="tab" aria-controls="suppliers-content" aria-selected="false">
                <i class="fas fa-truck"></i> Nhà Cung Cấp (<?= count($linkedSuppliers) ?>)
            </button>
        </li>
        </ul>

    <div class="tab-content border border-top-0 p-3" id="tourDetailTabsContent">
        
        <div class="tab-pane fade show active" id="itinerary-content" role="tabpanel" aria-labelledby="itinerary-tab">
            <h4>Lịch trình chi tiết:</h4>
            <?php if (!empty($listItinerary)): ?>
                <?php 
                // Sắp xếp lịch trình theo ngày (Giả định cột 'day_number' tồn tại trong dữ liệu)
                $groupedItinerary = [];
                foreach ($listItinerary as $item) {
                    $groupedItinerary[$item['day_number']][] = $item;
                }
                ksort($groupedItinerary); // Sắp xếp theo thứ tự ngày (key)
                ?>
                
                <?php foreach ($groupedItinerary as $day => $activities): ?>
                    <div class="mb-4">
                        <h5 class="text-info">NGÀY <?= $day ?></h5>
                        <ul class="list-group">
                            <?php foreach ($activities as $activity): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>[<?= htmlspecialchars($activity['time_slot'] ?? 'Cả ngày') ?>]</strong> 
                                        <?= htmlspecialchars($activity['activity_title'] ?? 'Hoạt động') ?>
                                        <p class="mb-0 text-muted small"><?= htmlspecialchars($activity['activity_description'] ?? '') ?></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>

                <a href="?act=manage-itinerary&id=<?= $tourDetail['ID_Tour']; ?>" class="btn btn-sm btn-outline-info mt-3">Chỉnh sửa Lịch trình</a>
                
            <?php else: ?>
                <p class="text-muted">Tour này chưa có thông tin lịch trình chi tiết.</p>
                <a href="?act=manage-itinerary&id=<?= $tourDetail['ID_Tour']; ?>" class="btn btn-sm btn-outline-info">Thêm Lịch trình</a>
            <?php endif; ?>
        </div>

        <div class="tab-pane fade" id="suppliers-content" role="tabpanel" aria-labelledby="suppliers-tab">
            <h4>Nhà Cung Cấp đã liên kết:</h4>
            <?php if (!empty($linkedSuppliers)): ?>
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nhà Cung Cấp</th>
                            <th>Địa chỉ</th>
                            <th>Vai trò Dịch vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($linkedSuppliers as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['ten_nha_cc'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($item['dia_chi'] ?? 'N/A') ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($item['ten_vai_tro'] ?? 'Chưa xác định') ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="?act=manage-suppliers&id=<?= $tourDetail['ID_Tour']; ?>" class="btn btn-sm btn-outline-secondary mt-3">Chỉnh sửa Nhà Cung Cấp</a>
            <?php else: ?>
                <p class="text-muted">Tour này chưa liên kết với Nhà Cung Cấp nào.</p>
                <a href="?act=manage-suppliers&id=<?= $tourDetail['ID_Tour']; ?>" class="btn btn-sm btn-outline-secondary">Liên kết Nhà Cung Cấp</a>
            <?php endif; ?>
        </div>

    </div>
</div>