<!-- Admin Category Add View -->

<div style="background-color: var(--white); border: 1px solid var(--border-color); box-shadow: var(--shadow); border-radius: var(--radius); padding: 35px; max-width: 600px; margin: 0 auto;">
    
    <h2 style="font-weight: 800; font-size: 20px; text-transform: uppercase; margin-bottom: 25px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
        Thêm danh mục mới
    </h2>

    <!-- PHP Error Alerts -->
    <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?act=danhmuc-add" method="POST">
        <!-- Category Name -->
        <div class="form-group">
            <label for="ten_danhmuc">Tên danh mục sản phẩm <span style="color: var(--danger)">*</span></label>
            <input type="text" name="ten_danhmuc" id="ten_danhmuc" class="form-control" 
                   placeholder="Ví dụ: Giày Cỏ Nhân Tạo (TF), Giày Trẻ Em..." required>
        </div>

        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <button type="submit" name="themmoi" class="btn-primary" style="padding: 10px 25px; border-radius: 6px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-check"></i> Lưu danh mục
            </button>
            <a href="index.php?act=danhmuc-list" class="btn-primary" 
               style="background-color: transparent; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px 25px; border-radius: 6px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-xmark"></i> Hủy / Quay lại
            </a>
        </div>
    </form>

</div>
