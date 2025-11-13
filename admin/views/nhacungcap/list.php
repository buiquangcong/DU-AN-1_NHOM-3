<div class="container-fluid mt-4">
    <h2 class="mb-3">Danh sách Nhà Cung Cấp</h2>
    <a href="?act=add-nhacungcap" class="btn btn-primary mb-3">➕ Thêm Nhà Cung Cấp</a>

    <?php if (!empty($listNCC)): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên nhà cung cấp</th>
                    <th>Địa chỉ</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listNCC as $ncc): ?>
                    <tr>
                        <td><?= $ncc['id_nha_cc'] ?></td>
                        <td><?= htmlspecialchars($ncc['ten_nha_cc']) ?></td>
                        <td><?= htmlspecialchars($ncc['dia_chi']) ?></td>
                        <td><?= htmlspecialchars($ncc['email']) ?></td>
                        <td><?= htmlspecialchars($ncc['so_dien_thoai']) ?></td>
                        <td>
                            <a href="?act=detail-nhacungcap&id_nha_cc=<?= $ncc['id_nha_cc'] ?>" class="btn btn-info btn-sm">Chi tiết</a>
                            <a href="?act=edit-nhacungcap&id_nha_cc=<?= $ncc['id_nha_cc'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="?act=delete-nhacungcap&id_nha_cc=<?= $ncc['id_nha_cc'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-danger">Chưa có nhà cung cấp nào.</p>
    <?php endif; ?>
</div>