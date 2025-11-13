<div class="container-fluid mt-4">
    <h2 class="mb-3">Chỉnh sửa thông tin nhân sự</h2>

    <?php if (!empty($nhansu)): ?>
        <form action="?act=post-edit-nhansu&id_nhan_su=<?= $nhansu['id_nhan_su'] ?>" method="POST">
            <div class="mb-3">
                <label class="form-label">Họ tên</label>
                <input type="text" name="ho_ten" class="form-control"
                    value="<?= htmlspecialchars($nhansu['ho_ten']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Chức vụ</label>
                <input type="text" name="chuc_vu" class="form-control"
                    value="<?= htmlspecialchars($nhansu['chuc_vu']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    value="<?= htmlspecialchars($nhansu['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="so_dien_thoai" class="form-control"
                    value="<?= htmlspecialchars($nhansu['so_dien_thoai']) ?>" required>
            </div>

            <button type="submit" class="btn btn-success">💾 Cập nhật</button>
            <a href="?act=list-nhansu" class="btn btn-secondary">⬅ Quay lại</a>
        </form>
    <?php else: ?>
        <p class="text-danger">Không tìm thấy dữ liệu nhân sự.</p>
    <?php endif; ?>
</div>