
<?php
// File: views/danhmuc/adddanhmuc.php

// Nếu có lỗi từ controller, sẽ được truyền vào $error
$TenLoaiTourValue = $_POST['TenLoaiTour'] ?? '';

// Biến kiểm tra lỗi (để thêm class 'is-invalid' của Bootstrap)
$hasError = !empty($error['TenLoaiTour']);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Thêm Loại Tour Mới</h2>
    
    <a href="index.php?act=list-danhmuc" class="btn btn-secondary btn-sm">
        ⬅️ Quay lại danh sách
    </a>
</div>

<div class="card">
    <div class="card-body">
        
        <form action="index.php?act=add-danhmuc" method="post">
            
            <div class="mb-3">
                <label for="TenLoaiTour" class="form-label">Tên Loại Tour:</label>
                
                <input type="text" 
                       name="TenLoaiTour" 
                       id="TenLoaiTour" 
                       class="form-control <?= $hasError ? 'is-invalid' : '' ?>" 
                       value="<?= htmlspecialchars($TenLoaiTourValue) ?>">
                
                <?php if ($hasError): ?>
                    <div class="invalid-feedback">
                        <?= htmlspecialchars($error['TenLoaiTour']) ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary">➕ Thêm</button>

        </form>

    </div> </div> ```