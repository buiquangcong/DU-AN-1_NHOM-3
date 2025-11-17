<div class="container mt-4">
    <h2 class="mb-3 text-center text-primary">Thêm Nhà Cung Cấp</h2>

    <form action="?act=add-nhacungcap" method="POST" class="border p-4 rounded bg-light">
        <div class="mb-3">
            <label class="form-label">Tên nhà cung cấp</label>
            <input type="text" name="ten_nha_cc" class="form-control" required>
            <?php if (isset($error['ten_nha_cc'])): ?>
                <div class="text-danger"><?= $error['ten_nha_cc'] ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Dịch vụ cung cấp</label>
            <select name="id_dich_vu" class="form-select" required>
                <option value="" disabled selected>-- Chọn dịch vụ --</option>
                <?php 
                // Lặp qua dữ liệu $listDichVu đã được truyền từ Controller
                if (isset($listDichVu) && is_array($listDichVu)):
                    foreach ($listDichVu as $dv): 
                        // Giả định tên cột là ID_DichVu và TenDichVu
                ?>
                    <option value="<?= $dv['ID_DichVu'] ?>">
                        <?= htmlspecialchars($dv['TenDichVu']) ?>
                    </option>
                <?php 
                    endforeach;
                endif; 
                ?>
            </select>
            <?php if (isset($error['id_dich_vu'])): ?>
                <div class="text-danger"><?= $error['id_dich_vu'] ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="dia_chi" class="form-control" required>
            <?php if (isset($error['dia_chi'])): ?>
                <div class="text-danger"><?= $error['dia_chi'] ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
            <?php if (isset($error['email'])): ?>
                <div class="text-danger"><?= $error['email'] ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="so_dien_thoai" class="form-control" required>
            <?php if (isset($error['so_dien_thoai'])): ?>
                <div class="text-danger"><?= $error['so_dien_thoai'] ?></div>
            <?php endif; ?>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success px-4">➕ Thêm</button>
            <a href="?act=list-nhacungcap" class="btn btn-secondary px-4">⬅ Quay lại</a>
        </div>
    </form>
</div>