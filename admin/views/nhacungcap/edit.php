<div class="container-fluid mt-4">
    <h2 class="mb-3">Chỉnh sửa Nhà Cung Cấp</h2>

    <?php if (!empty($ncc)): ?>
        <form action="?act=post-edit-nhacungcap&id_nha_cc=<?= $ncc['id_nha_cc'] ?>" method="POST">
            <div class="mb-3">
                <label class="form-label">Tên nhà cung cấp</label>
                <input type="text" name="ten_nha_cc" class="form-control" value="<?= htmlspecialchars($ncc['ten_nha_cc']) ?>" required>
                <span class="text-danger"><?= $error['ten_nha_cc'] ?? '' ?></span>
            </div>

            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="dia_chi" class="form-control" value="<?= htmlspecialchars($ncc['dia_chi']) ?>" required>
                <span class="text-danger"><?= $error['dia_chi'] ?? '' ?></span>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($ncc['email']) ?>">
                <span class="text-danger"><?= $error['email'] ?? '' ?></span>
            </div>

            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="so_dien_thoai" class="form-control" value="<?= htmlspecialchars($ncc['so_dien_thoai']) ?>" required>
                <span class="text-danger"><?= $error['so_dien_thoai'] ?? '' ?></span>
            </div>

            <button type="submit" class="btn btn-success">💾 Cập nhật</button>
            <a href="?act=list-nhacungcap" class="btn btn-secondary">⬅ Quay lại</a>
        </form>
    <?php else: ?>
        <p class="text-danger">Không tìm thấy dữ liệu nhà cung cấp.</p>
    <?php endif; ?>
</div>