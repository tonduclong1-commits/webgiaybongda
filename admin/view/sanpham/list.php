<!-- Admin Product List View -->

<div style="background-color: var(--white); border: 1px solid var(--border-color); box-shadow: var(--shadow); border-radius: var(--radius); padding: 30px;">
    
    <!-- Table Toolbar Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 20px; flex-wrap: wrap;">
        
        <!-- Search and Filter Form -->
        <form action="index.php" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; flex-grow: 1; max-width: 600px;">
            <input type="hidden" name="act" value="sanpham-list">
            
            <!-- Search Text -->
            <input type="text" name="keyword" placeholder="Tìm tên giày..." 
                   value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>"
                   class="form-control" style="padding: 8px 15px; border-radius: 6px; font-size: 14px; flex-grow: 1; min-width: 150px;">
            
            <!-- Category Filter -->
            <select name="id_danhmuc" class="form-control" style="padding: 8px 15px; border-radius: 6px; font-size: 14px; width: 180px;">
                <option value="0">Tất cả danh mục</option>
                <?php foreach ($ds_danhmuc as $dm): ?>
                    <option value="<?php echo $dm['id']; ?>" <?php echo (isset($_GET['id_danhmuc']) && $_GET['id_danhmuc'] == $dm['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($dm['ten_danhmuc']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <button type="submit" class="btn-primary" style="padding: 8px 20px; font-size: 14px; border-radius: 6px; display: flex; align-items: center; gap: 5px;">
                <i class="fa-solid fa-filter"></i> Lọc
            </button>
        </form>

        <!-- Add Button -->
        <a href="index.php?act=sanpham-add" class="btn-primary" style="padding: 10px 20px; font-size: 14px; border-radius: 6px; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-plus"></i> Thêm mới sản phẩm
        </a>
    </div>

    <!-- Data Table -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background-color: #f8fafc; border-bottom: 2px solid var(--border-color); font-weight: 700; color: var(--text-dark);">
                    <th style="padding: 15px 20px; width: 60px;">ID</th>
                    <th style="padding: 15px 20px; width: 100px;">Hình ảnh</th>
                    <th style="padding: 15px 20px;">Tên sản phẩm</th>
                    <th style="padding: 15px 20px; width: 130px;">Giá bán</th>
                    <th style="padding: 15px 20px; width: 130px;">Giá giảm</th>
                    <th style="padding: 15px 20px; width: 160px;">Danh mục</th>
                    <th style="padding: 15px 10px; width: 90px; text-align: center;">Lượt xem</th>
                    <th style="padding: 15px 10px; width: 100px; text-align: center;">Nổi bật</th>
                    <th style="padding: 15px 20px; width: 180px; text-align: center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($ds_sanpham) > 0): ?>
                    <?php foreach ($ds_sanpham as $sp): ?>
                        <tr style="border-bottom: 1px solid var(--border-color); transition: var(--transition);">
                            <td style="padding: 15px 20px; font-weight: 600; color: var(--text-muted);"><?php echo $sp['id']; ?></td>
                            <td style="padding: 10px 20px;">
                                <!-- Resolve path: uploads is in parent folder from admin, so we load as ../$img if custom uploads/ -->
                                <?php 
                                    $img_src = (strpos($sp['hinh_anh'], 'uploads/') === 0) ? '../' . $sp['hinh_anh'] : '../' . $sp['hinh_anh']; 
                                ?>
                                <img src="<?php echo $img_src; ?>" alt="shoe" 
                                     style="width: 50px; height: 50px; object-fit: contain; background: #f1f5f9; border-radius: 6px; border: 1px solid var(--border-color);">
                            </td>
                            <td style="padding: 15px 20px; font-weight: 700; color: var(--text-dark);"><?php echo htmlspecialchars($sp['ten_sanpham']); ?></td>
                            <td style="padding: 15px 20px; font-weight: 600;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</td>
                            <td style="padding: 15px 20px; color: var(--danger); font-weight: 600;">
                                <?php echo ($sp['gia_giam'] > 0) ? number_format($sp['gia_giam'], 0, ',', '.') . 'đ' : '<span style="color: var(--text-muted); font-weight: 400; font-style: italic;">Không</span>'; ?>
                            </td>
                            <td style="padding: 15px 20px; color: var(--text-muted); font-weight: 500;"><?php echo htmlspecialchars($sp['ten_danhmuc']); ?></td>
                            <td style="padding: 15px 10px; text-align: center; color: var(--text-muted);"><?php echo $sp['luot_xem']; ?></td>
                            <td style="padding: 15px 10px; text-align: center;">
                                <?php if ($sp['dac_biet'] == 1): ?>
                                    <span style="background-color: rgba(57, 255, 20, 0.15); color: var(--primary-dark); font-weight: 700; font-size: 11px; padding: 3px 8px; border-radius: 4px;">HOT</span>
                                <?php else: ?>
                                    <span style="color: var(--text-muted); font-size: 12px;">Thường</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 15px 20px; text-align: center;">
                                <a href="index.php?act=sanpham-edit&id=<?php echo $sp['id']; ?>" 
                                   style="color: #4facfe; padding: 6px 10px; font-weight: 600; border: 1px solid #4facfe; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px; margin-right: 5px; font-size: 13px;">
                                    <i class="fa-regular fa-pen-to-square"></i> Sửa
                                </a>
                                <a href="index.php?act=sanpham-delete&id=<?php echo $sp['id']; ?>" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"
                                   style="color: var(--danger); padding: 6px 10px; font-weight: 600; border: 1px solid var(--danger); border-radius: 4px; display: inline-flex; align-items: center; gap: 4px; font-size: 13px;">
                                    <i class="fa-regular fa-trash-can"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 50px; color: var(--text-muted);">
                            <i class="fa-regular fa-folder-open" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                            Không tìm thấy giày bóng đá nào thỏa mãn.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
