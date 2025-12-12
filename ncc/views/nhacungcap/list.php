<div class="container-fluid mt-4">
    <h2 class="mb-3">Danh sách Nhà Cung Cấp</h2>

    <?php if (!empty($listNCC)): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên nhà cung cấp</th>
                    <th>Dịch vụ cung cấp</th>
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

                        <td>
                            <?= htmlspecialchars($ncc['TenDichVu'] ?? '(Chưa chọn)') ?>
                        </td>

                        <td><?= htmlspecialchars($ncc['dia_chi']) ?></td>
                        <td><?= htmlspecialchars($ncc['email']) ?></td>
                        <td><?= htmlspecialchars($ncc['so_dien_thoai']) ?></td>
                        <td>
                            <a href="?act=detail-nhacungcap&id_nha_cc=<?= $ncc['id_nha_cc'] ?>" class="btn btn-info btn-sm">Chi tiết</a>
                            <a href="<?= BASE_URL_NCC ?>?act=ncc-tour-list&id_nha_cc=<?= $ncc['id_nha_cc'] ?>" class="btn btn-success btn-sm">
                                Danh sách
                            </a>
                            <a href="<?= BASE_URL_NCC ?>?act=ncc-tour-history&id_nha_cc=<?= $ncc['id_nha_cc'] ?>" class="btn btn-warning btn-sm">
                                Lịch sử
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-danger">Chưa có nhà cung cấp nào.</p>
    <?php endif; ?>
</div>