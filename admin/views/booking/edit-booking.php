<?php
$dsDichVu = [
    1 => 'Khách sạn / Lưu trú',
    2 => 'Nhà hàng / Ăn uống',
    3 => 'Vận chuyển / Xe',
    4 => 'Vé tham quan',
    5 => 'Khác'
];
?>

<div class="container mt-4">
    <div class="mb-3">
        <a href="?act=quan-ly-booking" class="btn btn-secondary">&larr; Quay lại danh sách</a>
    </div>

    <h2 class="mb-4 text-center">Cập nhật Booking #<?= htmlspecialchars($booking['ID_Booking']) ?></h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php
    $lichSuThanhToan = isset($lichSuThanhToan) ? $lichSuThanhToan : [];
    $tongDaThu = 0;
    foreach ($lichSuThanhToan as $pay) {
        $tongDaThu += $pay['so_tien'];
    }
    ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning text-dark fw-bold">
                Thông tin Booking
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label for="tour_id" class="form-label">Tour Du Lịch <span class="text-danger">*</span></label>
                    <select class="form-select" id="tour_id" name="tour_id" required>
                        <?php foreach ($tours as $tour): ?>
                            <option value="<?= htmlspecialchars($tour['ID_Tour']) ?>"
                                <?= ($booking['ID_Tour'] == $tour['ID_Tour']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tour['TenTour']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tên Người Đặt (Liên hệ) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="TenKhachHang"
                            value="<?= htmlspecialchars($booking['TenKhachHang']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Liên hệ <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="Email"
                            value="<?= htmlspecialchars($booking['Email'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Ngày Khởi Hành</label>
                        <input type="date" class="form-control" name="ngay_dat"
                            value="<?= date('Y-m-d', strtotime($booking['NgayDatTour'])) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Người lớn</label>
                        <input type="number" min="1" class="form-control" name="so_luong_nl"
                            value="<?= $booking['SoLuongNguoiLon'] ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trẻ em</label>
                        <input type="number" min="0" class="form-control" name="so_luong_te"
                            value="<?= $booking['SoLuongTreEm'] ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Hướng Dẫn Viên Phụ Trách</label>
                    <select class="form-select" name="id_hdv">
                        <option value="">-- Chưa phân công --</option>
                        <?php if (isset($listHDV) && is_array($listHDV)): ?>
                            <?php foreach ($listHDV as $hdv): ?>
                                <option value="<?= $hdv['ID_TaiKhoan'] ?>"
                                    <?= (isset($booking['id_huong_dan_vien']) && $booking['id_huong_dan_vien'] == $hdv['ID_TaiKhoan']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($hdv['ho_ten']) ?> (SĐT: <?= $hdv['so_dien_thoai'] ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái Booking</label>
                    <select class="form-select w-auto" name="trang_thai">
                        <option value="0" <?= ($booking['TrangThai'] == 0) ? 'selected' : '' ?>>Chờ xác nhận</option>
                        <option value="1" <?= ($booking['TrangThai'] == 1) ? 'selected' : '' ?>>Đã xác nhận</option>
                        <option value="2" <?= ($booking['TrangThai'] == 2) ? 'selected' : '' ?>>Đã hủy</option>
                        <option value="3" <?= ($booking['TrangThai'] == 3) ? 'selected' : '' ?>>Đã Hoàn Thành</option>
                    </select>
                </div>

                <div class="card bg-light mb-4 border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary border-bottom pb-2">Thông tin thanh toán</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Tổng tiền Tour:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control fw-bold text-primary"
                                        value="<?= number_format($booking['TongTien']) ?>" readonly>
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                                <input type="hidden" id="tong_tien_goc" value="<?= $booking['TongTien'] ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-success">Đã thanh toán (Tổng):</label>
                                <div class="input-group">
                                    <input type="text" class="form-control fw-bold text-success"
                                        value="<?= number_format($tongDaThu) ?>" readonly>
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                                <input type="hidden" id="tien_coc" name="tien_coc" value="<?= $tongDaThu ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-danger">Số tiền còn lại:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control fw-bold text-danger"
                                        id="con_lai_hien_thi" readonly>
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                                <small class="text-muted" id="trang_thai_thanh_toan"></small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-white mb-4 border shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-secondary"><i class="bi bi-clock-history"></i> Lịch sử giao dịch</h5>
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalAddPayment">
                            <i class="bi bi-plus-circle"></i> Thêm giao dịch
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0 text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>STT</th>
                                        <th>Ngày thanh toán</th>
                                        <th>Số tiền</th>
                                        <th>Phương thức</th>
                                        <th>Chứng từ</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($lichSuThanhToan)): ?>
                                        <?php foreach ($lichSuThanhToan as $key => $pay): ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= date('d/m/Y H:i', strtotime($pay['ngay_thanh_toan'])) ?></td>
                                                <td class="fw-bold text-success"><?= number_format($pay['so_tien']) ?> đ</td>
                                                <td>
                                                    <span class="badge bg-<?= $pay['phuong_thuc'] == 'Chuyển khoản' ? 'info' : 'secondary' ?>">
                                                        <?= htmlspecialchars($pay['phuong_thuc']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if (!empty($pay['anh_chung_tu'])): ?>
                                                        <img src="uploads/chung_tu/<?= $pay['anh_chung_tu'] ?>"
                                                            alt="Bill"
                                                            class="img-thumbnail"
                                                            style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                                            onclick="xemAnhLon('uploads/chung_tu/<?= $pay['anh_chung_tu'] ?>')">
                                                    <?php else: ?>
                                                        <span class="text-muted small">---</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-start small"><?= htmlspecialchars($pay['ghi_chu']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-muted py-3">Chưa có lịch sử giao dịch nào.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card bg-white mb-4 border shadow-sm">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-building"></i> Nhà Cung Cấp Dịch Vụ (Theo Tour)</h5>

                        <button type="button" class="btn btn-sm btn-light text-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalLinkNCC">
                            <i class="bi bi-link-45deg"></i> Liên kết NCC mới
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0 text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên Nhà Cung Cấp</th>
                                        <th>Loại Dịch Vụ</th>
                                        <th>Liên hệ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($listNhaCungCap)): ?>
                                        <?php foreach ($listNhaCungCap as $key => $ncc): ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td class="text-start fw-bold"><?= htmlspecialchars($ncc['ten_nha_cc']) ?></td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        <?php
                                                        $idDV = isset($ncc['ID_DichVu']) ? $ncc['ID_DichVu'] : 0;
                                                        echo isset($dsDichVu[$idDV]) ? $dsDichVu[$idDV] : 'Chưa rõ (' . $idDV . ')';
                                                        ?>
                                                    </span>
                                                </td>
                                                <td class="text-start small">
                                                    <div><i class="bi bi-telephone"></i> <?= htmlspecialchars($ncc['so_dien_thoai']) ?></div>
                                                    <div><i class="bi bi-envelope"></i> <?= htmlspecialchars($ncc['email']) ?></div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-muted py-3">
                                                <i class="bi bi-info-circle"></i> Tour này chưa liên kết với Nhà cung cấp nào.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-warning btn-lg px-5">
                        <i class="bi bi-save"></i> Cập nhật thay đổi
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="modalAddPayment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="?act=them-thanh-toan" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Thêm giao dịch mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_booking" value="<?= $booking['ID_Booking'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Số tiền thu (VNĐ)</label>
                        <input type="number" class="form-control" name="so_tien" required min="1000" placeholder="Nhập số tiền...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày thanh toán</label>
                        <input type="datetime-local" class="form-control" name="ngay_thanh_toan"
                            value="<?= date('Y-m-d\TH:i') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phương thức</label>
                        <select class="form-select" name="phuong_thuc">
                            <option value="Tiền mặt">Tiền mặt</option>
                            <option value="Chuyển khoản">Chuyển khoản</option>
                            <option value="VNPAY">VNPAY</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ảnh chứng từ/Bill (nếu có)</label>
                        <input type="file" class="form-control" name="anh_chung_tu" accept="image/*">
                        <div class="form-text text-muted">Chấp nhận ảnh jpg, png, jpeg.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea class="form-control" name="ghi_chu" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Xác nhận thu tiền</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalLinkNCC" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="?act=them-ncc-tour" method="POST">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Liên kết Nhà Cung Cấp vào Tour</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_booking" value="<?= $booking['ID_Booking'] ?>">
                    <input type="hidden" name="id_tour" value="<?= $booking['ID_Tour'] ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Chọn Nhà Cung Cấp <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_ncc" required>
                            <option value="">-- Chọn danh sách --</option>
                            <?php if (isset($allNhaCungCap) && is_array($allNhaCungCap)): ?>
                                <?php foreach ($allNhaCungCap as $ncc): ?>
                                    <option value="<?= $ncc['id_nha_cc'] ?>">
                                        <?= htmlspecialchars($ncc['ten_nha_cc']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Loại dịch vụ cung cấp</label>
                        <select class="form-select" name="loai_dich_vu">
                            <option value="1">Khách sạn / Lưu trú</option>
                            <option value="2">Nhà hàng / Ăn uống</option>
                            <option value="3">Vận chuyển / Xe</option>
                            <option value="4">Vé tham quan</option>
                            <option value="5">Khác</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-info text-white">Xác nhận liên kết</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalXemAnh" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img src="" id="anh_phong_to" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Hàm định dạng tiền tệ
    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('vi-VN').format(amount);
    };

    // 2. Hàm tính tiền còn lại
    function tinhTienConLai() {
        const tongTien = parseFloat(document.getElementById('tong_tien_goc').value) || 0;
        const daThanhToan = parseFloat(document.getElementById('tien_coc').value) || 0;
        const conLai = tongTien - daThanhToan;

        document.getElementById('con_lai_hien_thi').value = formatCurrency(conLai);

        const labelStatus = document.getElementById('trang_thai_thanh_toan');
        const inputConLai = document.getElementById('con_lai_hien_thi');

        if (conLai <= 0) {
            labelStatus.innerHTML = '<span class="text-success fw-bold">✔ Đã thanh toán đủ</span>';
            inputConLai.classList.remove('text-danger');
            inputConLai.classList.add('text-success');
        } else {
            labelStatus.innerText = 'Khách cần thanh toán thêm.';
            inputConLai.classList.add('text-danger');
            inputConLai.classList.remove('text-success');
        }
    }

    // 3. Hàm xem ảnh lớn
    function xemAnhLon(duongDanAnh) {
        document.getElementById('anh_phong_to').src = duongDanAnh;
        var myModal = new bootstrap.Modal(document.getElementById('modalXemAnh'));
        myModal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        tinhTienConLai();
    });
</script>