<?php
// Tên file: manage_suppliers_for_tour.php (hoặc tên file View bạn đang dùng)

// Các biến cần có từ Controller: 
// $tourDetail: Thông tin chi tiết tour
// $allSuppliers: Danh sách tất cả nhà cung cấp
// $linkedSuppliers: Danh sách NCC đã liên kết (có cột ten_vai_tro)
// $serviceRoles: Danh sách Vai trò/Dịch vụ (có ID_DichVu và TenDichVu)
?>

<div class="container mt-4">
    <div class="mb-3">
        <a href="<?= BASE_URL_ADMIN ?>?act=list-tours" class="btn btn-secondary">&larr; Quay lại danh sách tour</a>
    </div>

    <h2 class="mb-4">Quản lý Nhà Cung Cấp cho Tour:</h2>
    <h3 class="text-primary"><?= htmlspecialchars($tourDetail['TenTour'] ?? 'Tour không xác định') ?></h3>
    <hr>

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">Liên kết Nhà Cung Cấp mới</h5>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL_ADMIN ?>?act=link-supplier-to-tour" method="POST">
                <input type="hidden" name="tour_id" value="<?= $tourDetail['ID_Tour'] ?? '' ?>">
                <input type="hidden" name="action" value="link-supplier"> 

                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="supplier_id" class="form-label">Chọn Nhà Cung Cấp</label>
                        <select class="form-select" id="supplier_id" name="supplier_id" required>
                            <option value="" selected disabled>-- Chọn một NCC --</option>
                            <?php if (!empty($allSuppliers)): ?>
                                <?php foreach ($allSuppliers as $supplier): ?>
                                    <option value="<?= $supplier['id_nha_cc'] ?>">
                                        <?= htmlspecialchars($supplier['ten_nha_cc']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label for="id_DichVu" class="form-label">Ghi chú (Vai trò)</label>
                        <select class="form-select" id="id_DichVu" name="id_DichVu" required> 
                            <option value="" selected disabled>-- Chọn Vai trò dịch vụ --</option>
                            <?php 
                            if (!empty($serviceRoles)): 
                                foreach ($serviceRoles as $role): 
                            ?>
                                <option value="<?= htmlspecialchars($role['ID_DichVu']) ?>"> 
                                    <?= htmlspecialchars($role['TenDichVu']) ?>
                                </option>
                            <?php 
                                endforeach; 
                            endif; 
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2 text-end">
                        <button type="submit" class="btn btn-primary">+ Liên kết</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h4 class="mt-5">Các Nhà Cung Cấp đã liên kết với tour này</h4>
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr class="text-center">
                <th>Tên Nhà Cung Cấp</th>
                <th>Địa chỉ</th>
                <th>Ghi chú (Vai trò)</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($linkedSuppliers)): ?>
                <?php foreach ($linkedSuppliers as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['ten_nha_cc']) ?></td>
                        <td><?= htmlspecialchars($item['dia_chi']) ?></td>
                        <td><?= htmlspecialchars($item['ten_vai_tro'] ?? 'N/A') ?></td> 
                        <td class="text-center">
                            <a href="<?= BASE_URL_ADMIN ?>?act=unlink-supplier&tour_id=<?= $item['tour_id'] ?>&supplier_id=<?= $item['nha_cc_id'] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc muốn hủy liên kết NCC này?');">Hủy liên kết</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">Chưa có Nhà Cung Cấp nào được liên kết với tour này.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>