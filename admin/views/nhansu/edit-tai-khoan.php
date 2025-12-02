<div class="container-fluid mt-4">
    <h2 class="mb-3">Chỉnh sửa Tài khoản Nhân sự</h2>

    <?php
    // Lấy lỗi và dữ liệu cũ (nếu có từ redirect)
    $errors = $errors ?? [];
    // Biến $taiKhoan là object/array chứa dữ liệu từ DB (GET) hoặc dữ liệu cũ (POST lỗi)
    $tk = (array)$taiKhoan;

    if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($tk)): ?>
        <form action="?act=edit-tai-khoan&id=<?= htmlspecialchars($tk['ID_TaiKhoan']) ?>" method="POST">

            <input type="hidden" name="id" value="<?= htmlspecialchars($tk['ID_TaiKhoan']) ?>">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Họ tên *</label>
                    <input type="text" name="ho_ten" class="form-control"
                        value="<?= htmlspecialchars($tk['ho_ten'] ?? '') ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email (Tên đăng nhập) *</label>
                    <input type="email" name="email" class="form-control"
                        value="<?= htmlspecialchars($tk['TenDangNhap'] ?? '') ?>" required>
                </div>
            </div>

            <hr>
            <h4>Cập nhật Mật khẩu (Tùy chọn)</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mật khẩu mới</label>
                    <input type="password" name="mat_khau_moi" class="form-control"
                        placeholder="Để trống nếu không muốn đổi mật khẩu">
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phân Quyền *</label>
                    <select name="id_quyen" class="form-select" required>
                        <option value="">-- Chọn Quyền --</option>
                        <?php
                        // $roles phải được Controller truyền vào
                        $current_role_id = $tk['ID_Quyen'] ?? '';
                        foreach ($roles as $role): ?>
                            <option value="<?= htmlspecialchars($role['ID_Quyen']) ?>"
                                <?= ($current_role_id == $role['ID_Quyen']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($role['TenQuyen']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Trạng Thái *</label>
                    <select name="trang_thai" class="form-select" required>
                        <?php $current_status = $tk['TrangThai'] ?? 1; ?>
                        <option value="1" <?= ($current_status == 1) ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="0" <?= ($current_status == 0) ? 'selected' : '' ?>>Khóa</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" class="form-control"
                        value="<?= htmlspecialchars($tk['so_dien_thoai'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" name="dia_chi" class="form-control"
                        value="<?= htmlspecialchars($tk['dia_chi'] ?? '') ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-success">💾 Cập nhật</button>
            <a href="?act=quan-ly-tai-khoan" class="btn btn-secondary">⬅ Quay lại</a>
        </form>
    <?php else: ?>
        <p class="text-danger">Không tìm thấy dữ liệu tài khoản.</p>
    <?php endif; ?>
</div>