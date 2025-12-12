<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Quản lý danh mục</h1>
    <p class="mb-4">Danh sách các loại tour hiện có trong hệ thống.</p>

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh Sách Danh Mục Tour</h6>

        </div>

        <div class="card-body">

          <!-- HIỂN THỊ THÔNG BÁO DELETE / SUCCESS -->
<?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= is_array($_SESSION['error']) ? implode('<br>', $_SESSION['error']) : $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= is_array($_SESSION['success']) ? implode('<br>', $_SESSION['success']) : $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<!-- HẾT PHẦN THÊM -->

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 10%;">ID</th>
                            <th>Tên Loại Tour</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($listdanhmuc as $dm): ?>
                            <tr>
                                <td class="align-middle"><?= $dm['ID_LoaiTour'] ?></td>
                                <td class="align-middle fw-bold"><?= $dm['TenLoaiTour'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
