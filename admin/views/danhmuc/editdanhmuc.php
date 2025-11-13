<?php
// File: views/danhmuc/editdanhmuc.php

// PHP CỦA BẠN GIỮ NGUYÊN
$TenLoaiTourValue = $_POST['TenLoaiTour'] ?? ($danhmuc['TenLoaiTour'] ?? '');

// Thêm 1 biến phụ cho dễ dùng
$hasError = !empty($error['TenLoaiTour']); 
?>

<h2 class="mb-3">Sửa Loại Tour</h2>

<a href="index.php?act=list-danhmuc" class="btn btn-secondary btn-sm mb-3">
    ⬅️ Quay lại danh sách
</a>

<form action="index.php?act=post-edit-danhmuc&id=<?= htmlspecialchars($danhmuc['ID_LoaiTour']) ?>" method="post">
    
    <div class="card">
        <div class="card-body">

            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td style="width: 20%; vertical-align: middle;">
                            <label for="TenLoaiTour" class="form-label mb-0">Tên Loại Tour:</label>
                        </td>
                        <td>
                            <input type="text" 
                                   name="TenLoaiTour" 
                                   id="TenLoaiTour" 
                                   class="form-control <?= $hasError ? 'is-invalid' : '' ?>" 
                                   value="<?= htmlspecialchars($TenLoaiTourValue) ?>">
                            
                            <?php if ($hasError): ?>
                                <div class="invalid-feedback d-block">
                                    <?= htmlspecialchars($error['TenLoaiTour']) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td> <td colspan="2">
                            <button type="submit" class="btn btn-primary">💾 Lưu Thay Đổi</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        
        </div> </div> </form>
