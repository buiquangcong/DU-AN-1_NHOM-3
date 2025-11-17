<div class="container-fluid mt-4">
    <h2>Thêm nhân sự</h2>

    <form action="?act=post-add-nhansu" method="POST">
        <div class="form-group mb-3">
            <label>Họ tên</label>
            <input type="text" name="ho_ten" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Chức vụ</label>
            <input type="text" name="chuc_vu" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="so_dien_thoai" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="?act=list-nhansu" class="btn btn-secondary">Hủy</a>
    </form>
</div>