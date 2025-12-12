<div class="container-fluid mt-4">
    <h2 class="mb-3">Chi tiết Nhà Cung Cấp</h2>

    <?php if (!empty($ncc)): ?>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td><?= $ncc['id_nha_cc'] ?></td>
            </tr>
            <tr>
                <th>Tên nhà cung cấp</th>
                <td><?= htmlspecialchars($ncc['ten_nha_cc']) ?></td>
            </tr>
            
            <tr>
                <th>Dịch vụ cung cấp</th>
                <td><?= htmlspecialchars($ncc['TenDichVu'] ?? '(Chưa có thông tin)') ?></td>
            </tr>
            
            <tr>
                <th>Địa chỉ</th>
                <td><?= htmlspecialchars($ncc['dia_chi']) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($ncc['email']) ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?= htmlspecialchars($ncc['so_dien_thoai']) ?></td>
            </tr>
            <tr>
                <th>Ngày tạo</th>
                <td><?= $ncc['ngay_tao'] ?></td>
            </tr>
            <tr>
                <th>Ngày cập nhật</th>
                <td><?= $ncc['ngay_cap_nhat'] ?></td>
            </tr>
        </table>
        <a href="?act=list-nhacungcap" class="btn btn-secondary">⬅ Quay lại</a>
    <?php else: ?>
        <p class="text-danger">Không tìm thấy dữ liệu nhà cung cấp.</p>
    <?php endif; ?>
</div>