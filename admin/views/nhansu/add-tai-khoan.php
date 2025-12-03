<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=quan-ly-tai-khoan" class="btn btn-secondary">&larr; Quay lại</a>
    </div>

    <h2 class="mb-4 text-center">Thêm Tài Khoản Mới</h2>

    <?php
    // Giả định biến $errors chứa các lỗi từ Controller
    $errors = $errors ?? [];
    // Giả định biến $data chứa dữ liệu đã nhập (nếu submit lỗi)
    $data = $_POST ?? [];

    if (!empty($errors)):
    ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="?act=post-add-tai-khoan">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label for="ho_ten" class="form-label">Họ Tên *</label>
                <input type="text" class="form-control" id="ho_ten" name="ho_ten"
                    value="<?= htmlspecialchars($data['ho_ten'] ?? '') ?>"
                    placeholder="Nhập họ và tên" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email (Tên đăng nhập) *</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?= htmlspecialchars($data['email'] ?? '') ?>"
                    placeholder="Nhập email" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="mat_khau" class="form-label">Mật khẩu *</label>
                <input type="password" class="form-control" id="mat_khau" name="mat_khau"
                    placeholder="Nhập mật khẩu" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="so_dien_thoai" class="form-label">Số Điện Thoại</label>
                <input type="tel" class="form-control" id="so_dien_thoai" name="so_dien_thoai"
                    value="<?= htmlspecialchars($data['so_dien_thoai'] ?? '') ?>"
                    placeholder="Nhập số điện thoại">
            </div>

            <div class="col-md-6 mb-3">
                <label for="dia_chi" class="form-label">Địa Chỉ</label>
                <input type="text" class="form-control" id="dia_chi" name="dia_chi"
                    value="<?= htmlspecialchars($data['dia_chi'] ?? '') ?>"
                    placeholder="Nhập địa chỉ">
            </div>
        </div>

        <div class="mb-3">
            <label for="id_quyen" class="form-label">Phân Quyền *</label>
            <select class="form-select" id="id_quyen" name="id_quyen" required>
                <option value="">-- Chọn Quyền --</option>
                <?php
                // Biến $roles phải được Controller truyền vào, chứa các ID_Quyen và TenQuyen
                $roles = $roles ?? [];
                foreach ($roles as $role):
                ?>
                    <option value="<?= htmlspecialchars($role['ID_Quyen']) ?>"
                        <?= (isset($data['id_quyen']) && $data['id_quyen'] == $role['ID_Quyen']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($role['TenQuyen']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="trang_thai" class="form-label">Trạng Thái *</label>
            <select class="form-select" id="trang_thai" name="trang_thai" required>
                <?php $current_status = $data['trang_thai'] ?? 1; ?>
                <option value="1" <?= ($current_status == 1) ? 'selected' : '' ?>>Hoạt động</option>
                <option value="0" <?= ($current_status == 0) ? 'selected' : '' ?>>Khóa</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Thêm Tài Khoản</button>
    </form>
</div>