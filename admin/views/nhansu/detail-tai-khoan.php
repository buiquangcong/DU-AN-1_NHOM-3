<div class="container-fluid mt-4">
    <h2 class="mb-3">Chi tiết tài khoản</h2>

    <?php if (isset($taikhoan) && is_array($taikhoan)): ?>
        <table class="table table-bordered">
            <tr>
                <th>ID Tài khoản</th>
                <td><?= $taikhoan['ID_TaiKhoan'] ?></td>
            </tr>
            <tr>
                <th>Họ tên</th>
                <td><?= $taikhoan['ho_ten'] ?></td>
            </tr>
            <tr>
                <th>Tên đăng nhập (Email)</th>
                <td><?= $taikhoan['TenDangNhap'] ?></td>
            </tr>
            <tr>
                <th>Mật khẩu</th>
                <td><?= $taikhoan['MatKhau'] ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?= $taikhoan['so_dien_thoai'] ?></td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td><?= $taikhoan['dia_chi'] ?></td>
            </tr>
            <tr>
                <th>Chức vụ</th>
                <td><span class="badge bg-primary"><?= $taikhoan['ten_chuc_vu'] ?></span></td>
            </tr>
        </table>

        <a href="?act=list-tai-khoan" class="btn btn-secondary">Quay lại danh sách</a>
    <?php else: ?>
        <p class="alert alert-danger">Không có dữ liệu hiển thị.</p>
    <?php endif; ?>
</div>