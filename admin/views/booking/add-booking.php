<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=quan-ly-booking" class="btn btn-secondary">&larr; Quay lại</a>
    </div>

    <h2 class="mb-4 text-center">Thêm Booking Mới</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL_ADMIN . "?act=add-booking" ?>" enctype="multipart/form-data">

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">I. Thông tin Người đại diện & Tour</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="tour_id" class="form-label">Chọn Tour <span class="text-danger">*</span></label>
                    <select class="form-select" id="tour_id" name="tour_id" required>
                        <option value="">-- Chọn Tour --</option>
                        <?php foreach ($tours as $tour): ?>
                            <option value="<?= htmlspecialchars($tour['ID_Tour']) ?>"
                                <?= (isset($_POST['tour_id']) && $_POST['tour_id'] == $tour['ID_Tour']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tour['TenTour']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="TenKhachHang" class="form-label">Tên Người đặt <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="TenKhachHang" name="TenKhachHang"
                            value="<?= isset($_POST['TenKhachHang']) ? htmlspecialchars($_POST['TenKhachHang']) : '' ?>"
                            placeholder="Nhập tên người đại diện" required>
                    </div>
                    <div class="col-md-6">
                        <label for="Email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="Email" name="Email"
                            value="<?= isset($_POST['Email']) ? htmlspecialchars($_POST['Email']) : '' ?>"
                            placeholder="Nhập email" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="ngay_dat" class="form-label">Ngày Đặt</label>
                        <input type="date" class="form-control" id="ngay_dat" name="ngay_dat"
                            value="<?= $_POST['ngay_dat'] ?? date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="so_luong_nl" class="form-label">Người lớn</label>
                        <input type="number" min="0" class="form-control" id="so_luong_nl" name="so_luong_nl"
                            value="<?= (isset($_POST['so_luong_nl'])) ? (int)$_POST['so_luong_nl'] : 1 ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="so_luong_te" class="form-label">Trẻ em</label>
                        <input type="number" min="0" class="form-control" id="so_luong_te" name="so_luong_te"
                            value="<?= (isset($_POST['so_luong_te'])) ? (int)$_POST['so_luong_te'] : 0 ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="trang_thai" class="form-label">Trạng thái</label>
                    <select class="form-select w-auto" id="trang_thai" name="trang_thai">

                        <option value="0" selected class="fw-bold text-primary">Chờ xác nhận</option>

                        <option value="1" disabled style="color: #ccc;">Đã xác nhận</option>
                        <option value="2" disabled style="color: #ccc;">Đã hủy</option>
                        <option value="3" disabled style="color: #ccc;">Đã Hoàn Thành</option>

                    </select>

                    <div class="form-text text-muted">
                        <i class="bi bi-info-circle"></i> Booking mới tạo mặc định là "Chờ xác nhận".
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 border-info shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">II. Danh sách thành viên đoàn</h5>
            </div>
            <div class="card-body">

                <ul class="nav nav-tabs" id="guestTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab">
                            <i class="bi bi-pencil-square"></i> Nhập tay
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="excel-tab" data-bs-toggle="tab" data-bs-target="#excel" type="button" role="tab">
                            <i class="bi bi-file-earmark-excel"></i> Nhập bằng Excel
                        </button>
                    </li>
                </ul>

                <div class="tab-content pt-3" id="guestTabContent">

                    <div class="tab-pane fade show active" id="manual" role="tabpanel">
                        <div class="text-end mb-2">
                            <button type="button" class="btn btn-warning btn-sm" id="btnAddGuest">
                                <i class="bi bi-plus-circle"></i> Thêm dòng
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th style="width: 25%">Họ tên</th>
                                        <th style="width: 15%">Giới tính</th>
                                        <th style="width: 15%">Ngày sinh</th>
                                        <th style="width: 20%">SĐT</th>
                                        <th style="width: 20%">CCCD/Passport</th>
                                        <th style="width: 5%">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody id="guestContainer">
                                    <tr class="guest-item">
                                        <td><input type="text" name="guests[0][TenNguoiDi]" class="form-control form-control-sm" placeholder="Họ tên"></td>
                                        <td>
                                            <select name="guests[0][GioiTinh]" class="form-select form-select-sm">
                                                <option value="Nam">Nam</option>
                                                <option value="Nữ">Nữ</option>
                                                <option value="Khác">Khác</option>
                                            </select>
                                        </td>
                                        <td><input type="date" name="guests[0][NgaySinh]" class="form-control form-control-sm"></td>
                                        <td><input type="text" name="guests[0][LienHe]" class="form-control form-control-sm"></td>
                                        <td><input type="text" name="guests[0][CCCD_Passport]" class="form-control form-control-sm"></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger btn-sm btnRemoveGuest"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="excel" role="tabpanel">
                        <div class="alert alert-warning">
                            <i class="bi bi-info-circle"></i> Vui lòng tải file mẫu, điền thông tin và upload lại.
                            <a href="path/to/sample_file.xlsx" class="fw-bold" download>Tải file mẫu tại đây</a>
                        </div>
                        <div class="mb-3">
                            <label for="guest_file" class="form-label fw-bold">Chọn file Excel (.xlsx, .xls)</label>
                            <input class="form-control" type="file" id="guest_file" name="guest_file" accept=".xlsx, .xls">
                        </div>
                        <div class="form-text text-muted">
                            Hệ thống sẽ ưu tiên lấy dữ liệu từ file Excel nếu bạn vừa nhập tay vừa upload file.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="text-center pb-5">
            <button type="submit" class="btn btn-success btn-lg px-5">Lưu Booking</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let guestIndex = 1;
        document.getElementById('btnAddGuest').addEventListener('click', function() {
            const container = document.getElementById('guestContainer');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td><input type="text" name="guests[${guestIndex}][TenNguoiDi]" class="form-control form-control-sm"></td>
            <td>
                <select name="guests[${guestIndex}][GioiTinh]" class="form-select form-select-sm">
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </td>
            <td><input type="date" name="guests[${guestIndex}][NgaySinh]" class="form-control form-control-sm"></td>
            <td><input type="text" name="guests[${guestIndex}][LienHe]" class="form-control form-control-sm"></td>
            <td><input type="text" name="guests[${guestIndex}][CCCD_Passport]" class="form-control form-control-sm"></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm btnRemoveGuest"><i class="bi bi-trash"></i></button></td>
        `;
            container.appendChild(newRow);
            guestIndex++;
        });

        document.getElementById('guestContainer').addEventListener('click', function(e) {
            if (e.target.closest('.btnRemoveGuest')) {
                e.target.closest('tr').remove();
            }
        });
    });
</script>