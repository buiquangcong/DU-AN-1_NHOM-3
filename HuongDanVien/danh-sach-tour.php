<?php
?>

<div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Danh Sách Tour</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Thêm Tour Mới
        </button>
    </div>
</div>

<div class="mb-3">
    <input type="text" class="form-control" placeholder="Tìm kiếm tour...">
</div>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Mã Tour</th>
                <th>Tên Tour</th>
                <th>Loại Tour</th>
                <th>Số Ngày</th>
                <th>Giá (VND)</th>
                <th>Trạng Thái</th>
                <th class="text-center">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>T-001</td>
                <td>Khám Phá Đà Nẵng - Hội An</td>
                <td>Trong Nước</td>
                <td>3N2Đ</td>
                <td>3,500,000</td>
                <td><span class="badge bg-success">Đang Mở Bán</span></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>T-003</td>
                <td>Du Lịch Mùa Thu Hàn Quốc</td>
                <td>Quốc Tế</td>
                <td>5N4Đ</td>
                <td>22,900,000</td>
                <td><span class="badge bg-warning text-dark">Hết Chỗ</span></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>T-004</td>
                <td>Khám Phá Miền Tây Sông Nước</td>
                <td>Trong Nước</td>
                <td>2N1Đ</td>
                <td>1,800,000</td>
                <td><span class="badge bg-danger">Đã Đóng</span></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php
?>