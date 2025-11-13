<h2 class="mb-3">Danh Sách Danh Mục Tour</h2>

<a href="index.php?act=add-danhmuc" class="btn btn-primary btn-sm mb-3">
    ➕ Thêm Danh Mục
</a>

<table class="table table-bordered table-striped table-hover">

    <thead class="table-dark">
        <tr>
            <th style="width: 10%;">ID</th>
            <th>Tên Loại Tour</th>
            <th style="width: 20%;">Hành Động</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($listdanhmuc as $dm): ?>
            <tr>
                <td><?= $dm['ID_LoaiTour'] ?></td>
                <td><?= $dm['TenLoaiTour'] ?></td>
                <td>
                    <a href="index.php?act=edit-danhmuc&id=<?= $dm['ID_LoaiTour'] ?>"
                        class="btn btn-warning btn-sm">
                        ✏️ Sửa
                    </a>

                    <a onclick="return confirm('Bạn có chắc muốn xóa không?')"
                        href="index.php?act=delete-danhmuc&id=<?= $dm['ID_LoaiTour'] ?>"
                        class="btn btn-danger btn-sm">
                        🗑️ Xoá
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>