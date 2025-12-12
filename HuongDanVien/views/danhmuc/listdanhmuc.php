<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Quản lý danh mục</h1>
    <p class="mb-4">Danh sách các loại tour hiện có trong hệ thống.</p>

    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 10%;">ID</th>
                            <th>Tên Loại Tour</th>
                            <th style="width: 10%;">Hành Động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($listdanhmuc as $dm): ?>
                            <tr>
                                <td class="align-middle"><?= $dm['ID_LoaiTour'] ?></td>
                                <td class="align-middle fw-bold"><?= $dm['TenLoaiTour'] ?></td>
                                <td class="align-middle">
                                    <a href="index.php?act=edit-danhmuc&id=<?= $dm['ID_LoaiTour'] ?>"
                                        class="btn btn-warning btn-sm me-1">
                                        <i class=""></i> Xem
                                    </a>


                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>