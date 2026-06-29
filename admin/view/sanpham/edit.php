<!-- Admin Product Edit View -->

<div style="background-color: var(--white); border: 1px solid var(--border-color); box-shadow: var(--shadow); border-radius: var(--radius); padding: 35px; max-width: 800px; margin: 0 auto;">
    
    <h2 style="font-weight: 800; font-size: 20px; text-transform: uppercase; margin-bottom: 25px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
        Cập nhật sản phẩm giày
    </h2>

    <!-- PHP Error Alerts -->
    <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?act=sanpham-edit&id=<?php echo $sanpham['id']; ?>" method="POST" enctype="multipart/form-data">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <!-- Product ID -->
            <div class="form-group" style="grid-column: span 2;">
                <label>Mã sản phẩm (ID)</label>
                <input type="text" class="form-control" style="background-color: #f1f5f9; cursor: not-allowed;" 
                       value="<?php echo $sanpham['id']; ?>" readonly>
            </div>

            <!-- Product Name -->
            <div class="form-group" style="grid-column: span 2;">
                <label for="ten_sanpham">Tên sản phẩm giày bóng đá <span style="color: var(--danger)">*</span></label>
                <input type="text" name="ten_sanpham" id="ten_sanpham" class="form-control" 
                       value="<?php echo htmlspecialchars($sanpham['ten_sanpham']); ?>" required>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="id_danhmuc">Danh mục sản phẩm <span style="color: var(--danger)">*</span></label>
                <select name="id_danhmuc" id="id_danhmuc" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($ds_danhmuc as $dm): ?>
                        <option value="<?php echo $dm['id']; ?>" <?php echo ($sanpham['id_danhmuc'] == $dm['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($dm['ten_danhmuc']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Image File Upload -->
            <div class="form-group">
                <label for="hinh_anh">Hình ảnh sản phẩm</label>
                <input type="file" name="hinh_anh" id="hinh_anh" class="form-control" accept="image/*">
                <span style="font-size: 11px; color: var(--text-muted);">Định dạng hợp lệ: JPG, PNG, GIF, SVG, WEBP. Chọn file mới để thay thế ảnh cũ.</span>
                
                <!-- Current image thumbnail preview -->
                <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 13px; font-weight: 600;">Ảnh hiện tại:</span>
                    <?php 
                        $img_src = (strpos($sanpham['hinh_anh'], 'uploads/') === 0) ? '../' . $sanpham['hinh_anh'] : '../' . $sanpham['hinh_anh']; 
                    ?>
                    <img src="<?php echo $img_src; ?>" alt="current shoe image" 
                         style="width: 60px; height: 60px; object-fit: contain; background: #f1f5f9; border-radius: 6px; border: 1px solid var(--border-color);">
                </div>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label for="gia">Giá niêm yết (đ) <span style="color: var(--danger)">*</span></label>
                <input type="number" name="gia" id="gia" min="0" class="form-control" 
                       value="<?php echo $sanpham['gia']; ?>" required>
            </div>

            <!-- Discount Price -->
            <div class="form-group">
                <label for="gia_giam">Giá khuyến mãi (đ) (nếu có)</label>
                <input type="number" name="gia_giam" id="gia_giam" min="0" class="form-control" 
                       value="<?php echo $sanpham['gia_giam']; ?>">
            </div>

            <!-- Featured Checkbox -->
            <div class="form-group" style="grid-column: span 2; display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" name="dac_biet" id="dac_biet" style="width: 18px; height: 18px; accent-color: var(--dark);"
                       <?php echo ($sanpham['dac_biet'] == 1) ? 'checked' : ''; ?>>
                <label for="dac_biet" style="margin-bottom: 0; cursor: pointer; font-weight: 700;">Đánh dấu là sản phẩm nổi bật / HOT (hiển thị ngoài trang chủ)</label>
            </div>

            <!-- Description -->
            <div class="form-group" style="grid-column: span 2;">
                <label for="mo_ta">Mô tả thông tin chi tiết</label>
                <textarea name="mo_ta" id="mo_ta" rows="6" class="form-control" style="resize: vertical; min-height: 120px;"><?php echo htmlspecialchars($sanpham['mo_ta']); ?></textarea>
            </div>
        </div>

        <div style="display: flex; gap: 15px; margin-top: 30px; border-top: 1px solid var(--border-color); padding-top: 25px;">
            <button type="submit" name="capnhat" class="btn-primary" style="padding: 10px 25px; border-radius: 6px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-check"></i> Cập nhật sản phẩm
            </button>
            <a href="index.php?act=sanpham-list" class="btn-primary" 
               style="background-color: transparent; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px 25px; border-radius: 6px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-xmark"></i> Hủy / Quay lại
            </a>
        </div>
    </form>

</div>
