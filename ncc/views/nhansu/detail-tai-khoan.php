<div class="container-fluid mt-4">
    <h2 class="mb-3">Chi tiết nhân sự</h2>

    <?php if (!empty($nhansu)): ?>
        <table class="table table-bordered">
            <tr>
                <th>ID nhân sự</th>
                <td><?= htmlspecialchars($nhansu['id_nhan_su']) ?></td>
            </tr>
            <tr>
                <th>Họ tên</th>
                <td><?= htmlspecialchars($nhansu['ho_ten']) ?></td>
            </tr>
            <tr>
                <th>Chức vụ</th>
                <td><?= htmlspecialchars($nhansu['chuc_vu']) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($nhansu['email']) ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?= htmlspecialchars($nhansu['so_dien_thoai']) ?></td>
            </tr>
            <tr>
                <th>Ngày tạo</th>
                <td><?= htmlspecialchars($nhansu['ngay_tao']) ?></td>
            </tr>
            <tr>
                <th>Ngày cập nhật</th>
                <td><?= htmlspecialchars($nhansu['ngay_cap_nhat']) ?></td>
            </tr>
        </table>

        <a href="?act=edit-nhansu&id_nhan_su=<?= $nhansu['id_nhan_su'] ?>" class="btn btn-warning">Sửa</a>
        <a href="?act=list-nhansu" class="btn btn-secondary">⬅Quay lại danh sách</a>
    <?php else: ?>
        <p class="text-danger">Không tìm thấy thông tin nhân sự.</p>
    <?php endif; ?>
</div>