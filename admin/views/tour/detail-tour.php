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
            <p><strong>Tên Tour:</strong> <?= htmlspecialchars($tourDetail['TenTour'] ?? 'Chưa xác định') ?></p>
            <p><strong>Loại Tour:</strong> <?= htmlspecialchars($tourDetail['ID_LoaiTour'] ?? 'Chưa xác định') ?></p>
            <p><strong>Ngày khởi hành:</strong> <?= htmlspecialchars($tourDetail['NgayKhoiHanh'] ?? 'Chưa xác định') ?></p>
            <p><strong>Thời gian:</strong> <?= ($tourDetail['SoNgay'] ?? 'X') . ' Ngày / ' . ($tourDetail['SoDem'] ?? 'X') . ' Đêm' ?></p>
            <p><strong>Số chỗ tối đa:</strong> <?= $tourDetail['SoCho'] ?? 'N/A' ?></p>
            <p><strong>Giá người lớn:</strong> <?= htmlspecialchars($tourDetail['GiaNguoiLon'] ?? 'Đang cập nhật...') ?></p>
            <p><strong>Giá trẻ em:</strong> <?= htmlspecialchars($tourDetail['GiaTreEm'] ?? 'Đang cập nhật...') ?></p>
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
                                    <a href="?act=add-itinerary-item&id=<?= $item['ID_ChiTietTour'] ?>" class="btn btn-primary btn-sm">Thêm</a>
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