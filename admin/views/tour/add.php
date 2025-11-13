<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Quản lý Tour</h1>
    <p class="mb-4">Thêm mới tour du lịch.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Thêm Tour</h6>
        </div>
        <div class="card-body">
            
            <form action="index.php?act=save-add-tour" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="TenTour">Tên tour:</label>
                    <input type="text" class="form-control" id="TenTour" name="TenTour" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ID_LoaiTour">Loại tour:</label>
                            <select class="form-control" id="ID_LoaiTour" name="ID_LoaiTour" required>
                                <option value="" disabled selected>-- Chọn loại tour --</option>
                                <?php
                                    // Giả sử bạn có biến $listdanhmuc từ Controller
                                    // foreach ($listdanhmuc as $danhmuc) {
                                    //     echo '<option value="' . $danhmuc['ID_LoaiTour'] . '">' . $danhmuc['TenLoaiTour'] . '</option>';
                                    // }
                                ?>
                                <option value="1">Tour Nước Ngoài (Test)</option>
                                <option value="2">Tour Trong Nước (Test)</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="HinhAnhChinh">Hình ảnh chính (Ảnh bìa):</label>
                            <input type="file" class="form-control-file" id="HinhAnhChinh" name="HinhAnhChinh">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="GiaNguoiLon">Giá Người Lớn:</label>
                            <input type="number" class="form-control" id="GiaNguoiLon" name="GiaNguoiLon" min="0" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="GiaTreEm">Giá Trẻ Em:</label>
                            <input type="number" class="form-control" id="GiaTreEm" name="GiaTreEm" min="0">
                        </div>
                    </div>
                        
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="SoCho">Tổng số chỗ:</label>
                            <input type="number" class="form-control" id="SoCho" name="SoCho" min="1" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="NgayKhoiHanh">Ngày khởi hành:</label>
                            <input type="date" class="form-control" id="NgayKhoiHanh" name="NgayKhoiHanh">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="SoNgay">Số ngày:</label>
                            <input type="number" class="form-control" id="SoNgay" name="SoNgay" min="1">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="DiemKhoiHanh">Điểm khởi hành:</label>
                            <input type="text" class="form-control" id="DiemKhoiHanh" name="DiemKhoiHanh">
                        </div>
                    </div>
                </div>
                          
                <div class="col-md-3">
        

                <div class="form-group">
                    <label for="NoiDungTomTat">Mô tả tóm tắt:</label>
                    <textarea class="form-control" id="NoiDungTomTat" name="NoiDungTomTat" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="NoiDungChiTiet">Mô tả chi tiết:</label>
                    <textarea class="form-control" id="NoiDungChiTiet" name="NoiDungChiTiet" rows="8"></textarea>
                </div>

                <div class="form-group">
                    <label for="TrangThai">Trạng thái:</label>
                    <select class="form-control" id="TrangThai" name="TrangThai">
                        <option value="1">Hoạt động (Cho phép đặt)</option>
                        <option value="0">Tạm ẩn</option>
                    </select>
                </div>

                <button type="submit" name="btn-add-tour" class="btn btn-primary">Lưu Tour Mới</button>
                <a href="index.php?act=list-tours" class="btn btn-secondary">Quay lại danh sách</a>

            </form>
            
        </div>
    </div>

</div>