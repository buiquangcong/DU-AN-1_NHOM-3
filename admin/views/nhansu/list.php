<div class="container-fluid mt-4">
    <h2 class="mb-4">Danh sách nhân sự</h2>

    <a href="?act=add-nhansu" class="btn btn-primary mb-3">➕ Thêm nhân sự</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Chức vụ</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listNhanSu)): ?>
                <?php foreach ($listNhanSu as $nhansu): ?>
                    <tr>
                        <td><?= htmlspecialchars($nhansu['id_nhan_su']) ?></td>
                        <td><?= htmlspecialchars($nhansu['ho_ten']) ?></td>
                        <td><?= htmlspecialchars($nhansu['chuc_vu']) ?></td>
                        <td><?= htmlspecialchars($nhansu['email']) ?></td>
                        <td><?= htmlspecialchars($nhansu['so_dien_thoai']) ?></td>
                        <td><?= htmlspecialchars($nhansu['ngay_tao']) ?></td>
                        <td>
                            <a href="?act=detail-nhansu&id_nhan_su=<?= $nhansu['id_nhan_su'] ?>" class="btn btn-info btn-sm">Chi tiết</a>
                            <a href="?act=edit-nhansu&id_nhan_su=<?= $nhansu['id_nhan_su'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="?act=delete-nhansu&id_nhan_su=<?= $nhansu['id_nhan_su'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa nhân sự này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Không có dữ liệu nhân sự</td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>
</div>