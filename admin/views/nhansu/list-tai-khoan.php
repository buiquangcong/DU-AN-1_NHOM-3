<div class="container-fluid mt-4">
    <h2 class="mb-4">Danh sách Tài khoản Nhân sự</h2>

    <a href="?act=add-tai-khoan" class="btn btn-primary mb-3">➕ Thêm tài khoản</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Chức vụ</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listTaiKhoan)): ?>
                <?php foreach ($listTaiKhoan as $taikhoan): ?>
                    <tr>
                        <td><?= htmlspecialchars($taikhoan['ID_TaiKhoan']) ?></td>
                        <td><?= htmlspecialchars($taikhoan['ho_ten']) ?></td>
                        <td><?= htmlspecialchars($taikhoan['chuc_vu']) ?></td>
                        <td><?= htmlspecialchars($taikhoan['TenDangNhap']) ?></td>
                        <td><?= htmlspecialchars($taikhoan['so_dien_thoai'] ?? '') ?></td>
                        <td><?= htmlspecialchars($taikhoan['dia_chi'] ?? '') ?></td>
                        <td>
                            <a href="?act=detail-taikhoan&id=<?= $taikhoan['ID_TaiKhoan'] ?>" class="btn btn-info btn-sm">Chi tiết</a>
                            <a href="?act=edit-taikhoan&id=<?= $taikhoan['ID_TaiKhoan'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="?act=delete-taikhoan&id=<?= $taikhoan['ID_TaiKhoan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Không có dữ liệu tài khoản nào</td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>
</div>