<div class="container-fluid mt-4">
    <h2 class="mb-3">Thêm Nhà Cung Cấp</h2>

    <form action="?act=add-nhacungcap" method="POST">
        <div class="mb-3">
            <label class="form-label">Tên nhà cung cấp</label>
            <input type="text" name="ten_nha_cc" class="form-control" value="<?= $_POST['ten_nha_cc'] ?? '' ?>" required>
            <span class="text-danger"><?= $error['ten_nha_cc'] ?? '' ?></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="dia_chi" class="form-control" value="<?= $_POST['dia_chi'] ?? '' ?>" required>
            <span class="text-danger"><?= $error['dia_chi'] ?? '' ?></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= $_POST['email'] ?? '' ?>">
            <span class="text-danger"><?= $error['email'] ?? '' ?></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="so_dien_thoai" class="form-control" value="<?= $_POST['so_dien_thoai'] ?? '' ?>" required>
            <span class="text-danger"><?= $error['so_dien_thoai'] ?? '' ?></span>
        </div>

        <button type="submit" class="btn btn-success">💾 Thêm</button>
        <a href="?act=list-nhacungcap" class="btn btn-secondary">⬅ Quay lại</a>
    </form>
</div>