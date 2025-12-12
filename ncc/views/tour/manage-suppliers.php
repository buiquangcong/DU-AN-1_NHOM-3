<?php
// Giả sử $tourDetail chứa thông tin tour (từ Controller)
// Giả sử $linkedSuppliers là danh sách NCC đã liên kết với tour này (từ Controller)
// Giả sử $allSuppliers là *tất cả* NCC có trong hệ thống (để cho vào dropdown)
?>

<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=list-tours" class="btn btn-secondary">&larr; Quay lại danh sách tour</a>
    </div>

    <h2 class="mb-4">Quản lý Nhà Cung Cấp cho Tour:</h2>
    <h3 class="text-primary"><?= htmlspecialchars($tourDetail['TenTour'] ?? 'Tên tour không tìm thấy') ?></h3>
    <hr>

    <!-- <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">Liên kết Nhà Cung Cấp mới</h5>
        </div>
        <div class="card-body">
            <form action="?act=link-supplier-to-tour" method="POST">
                <input type="hidden" name="tour_id" value="<?= $tourDetail['ID_Tour'] ?? '' ?>">

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
                        <label for="ghi_chu" class="form-label">Ghi chú (Vai trò)</label>
                        <input type="text" class="form-control" id="ghi_chu" name="ghi_chu" placeholder="Ví dụ: Cung cấp xe 45 chỗ, Khách sạn tại Đà Nẵng">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="submit" class="btn btn-primary">+ Liên kết</button>
                    </div>
                </div>
            </form>
        </div>
    </div> -->

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
                        <td><?= htmlspecialchars($item['ghi_chu']) // Đây là Ghi chú từ bảng liên kết 
                            ?></td>
                        <td class="text-center">
                            <a href="?act=unlink-supplier&tour_id=<?= $item['tour_id'] ?>&supplier_id=<?= $item['nha_cc_id'] ?>"
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