<div class="container mt-4">
    <h2 class="mb-4 text-center">Danh sách Tour du lịch</h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            foreach ($_SESSION['error'] as $err) {
                echo "<p class='mb-0'>$err</p>";
            }
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <div class="mb-3 text-end">
        <a href="?act=add-tour" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Thêm tour mới
        </a>
        <a href="?act=history-tours" class="btn btn-warning ms-2">
            <i class="bi bi-clock-history"></i> Lịch sử Tour
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="" method="GET" class="d-flex">
                <input type="hidden" name="act" value="list-tours">
                <input type="text" class="form-control me-2" name="search_id"
                    placeholder="Nhập ID Tour (ví dụ: T-9011)"
                    value="<?= htmlspecialchars($_GET['search_id'] ?? '') ?>">
                <button type="submit" class="btn btn-primary" style="white-space: nowrap;">Tìm kiếm</button>
                <?php if (!empty($_GET['search_id'])): ?>
                    <a href="?act=list-tours" class="btn btn-outline-secondary ms-2">Hủy</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th style="width: 200px;">Tên tour</th>
                    <th>Loại tour</th>
                    <th>Giá (NL / TE)</th>

                    <th>Thời gian</th>

                    <th>Ảnh Bìa</th>
                    <th>Số chỗ</th>
                    <th>Trạng thái</th>
                    <th style="width: 140px;">Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($listTours)): ?>
                    <?php foreach ($listTours as $item): ?>
                        <tr>
                            <td class="text-center fw-bold"><?= $item['ID_Tour'] ?? ''; ?></td>

                            <td><?= htmlspecialchars($item['TenTour'] ?? ''); ?></td>

                            <td class="text-center"><?= htmlspecialchars($item['TenLoaiTour'] ?? ''); ?></td>

                            <td class="text-end">
                                <div class="text-danger fw-bold"><?= number_format($item['GiaNguoiLon'] ?? 0); ?>₫</div>
                                <div class="text-muted small"><?= number_format($item['GiaTreEm'] ?? 0); ?>₫</div>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-info text-dark">
                                    <?= $item['SoNgay'] ?? 0 ?>N <?= $item['SoDem'] ?? 0 ?>Đ
                                </span>
                            </td>

                            <td class="text-center">
                                <?php
                                // 1. Lấy đường dẫn ảnh từ Model (Code model bạn vừa gửi trả về 'UrlAnh')
                                $rawUrl = $item['UrlAnh'] ?? '';
                                ?>

                                <?php if (!empty($rawUrl)): ?>
                                    <?php
                                    // 2. QUAN TRỌNG: Cắt bỏ đường dẫn rác trong DB, chỉ lấy tên file (vd: hinh1.jpg)
                                    $tenFileSach = basename($rawUrl);

                                    // 3. Tự ghép đường dẫn chuẩn
                                    // Dấu ../ để lùi từ admin ra ngoài, vào assets/uploads
                                    $srcChuan = "assets/uploads/" . $tenFileSach;
                                    ?>

                                    <img src="<?= htmlspecialchars($srcChuan) ?>"
                                        alt="Ảnh Tour"
                                        style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc;"
                                        onerror="this.src='https://placehold.co/80x50?text=Lỗi+File'">

                                <?php else: ?>
                                    <span class="text-muted small">Chưa có ảnh</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center"><?= $item['SoCho'] ?? 0; ?></td>

                            <td class="text-center">
                                <?php if (($item['TrangThai'] ?? 0) == 1): ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Tạm dừng</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <div class="d-grid gap-1 mx-auto">
                                    <a href="?act=tour-detail&id=<?= $item['ID_Tour']; ?>" class="btn btn-primary btn-sm">Chi tiết</a>
                                    <a href="?act=manage-itinerary&id=<?= $item['ID_Tour']; ?>" class="btn btn-info btn-sm text-white">Lịch trình</a>
                                    <a href="?act=manage-suppliers&id=<?= $item['ID_Tour']; ?>" class="btn btn-secondary btn-sm">NCC</a>
                                    <a href="?act=edit-tour&id=<?= $item['ID_Tour']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="?act=delete-tour&id=<?= $item['ID_Tour']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa tour này không?');">Xóa</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <?php if (!empty($_GET['search_id'])): ?>
                                Không tìm thấy tour nào khớp với ID "<strong><?= htmlspecialchars($_GET['search_id']) ?></strong>".
                            <?php else: ?>
                                Chưa có tour nào trong hệ thống.
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>