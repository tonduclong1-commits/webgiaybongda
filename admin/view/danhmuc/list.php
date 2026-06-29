<!-- Admin Category List View -->

<div style="background-color: var(--white); border: 1px solid var(--border-color); box-shadow: var(--shadow); border-radius: var(--radius); padding: 30px;">
    
    <!-- Table Toolbar Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 20px; flex-wrap: wrap;">
        
        <!-- Search bar -->
        <form action="index.php" method="GET" style="display: flex; gap: 10px; width: 100%; max-width: 400px;">
            <input type="hidden" name="act" value="danhmuc-list">
            <input type="text" name="keyword" placeholder="Tìm tên danh mục..." 
                   value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>"
                   class="form-control" style="padding: 8px 15px; border-radius: 6px; font-size: 14px;">
            <button type="submit" class="btn-primary" style="padding: 8px 20px; font-size: 14px; border-radius: 6px; display: flex; align-items: center; gap: 5px;">
                <i class="fa-solid fa-magnifying-glass"></i> Tìm
            </button>
        </form>

        <!-- Add Button -->
        <a href="index.php?act=danhmuc-add" class="btn-primary" style="padding: 10px 20px; font-size: 14px; border-radius: 6px; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-plus"></i> Thêm mới danh mục
        </a>
    </div>

    <!-- Data Table -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background-color: #f8fafc; border-bottom: 2px solid var(--border-color); font-weight: 700; color: var(--text-dark);">
                    <th style="padding: 15px 20px; width: 80px;">ID</th>
                    <th style="padding: 15px 20px;">Tên danh mục</th>
                    <th style="padding: 15px 20px; width: 200px; text-align: center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($ds_danhmuc) > 0): ?>
                    <?php foreach ($ds_danhmuc as $dm): ?>
                        <tr style="border-bottom: 1px solid var(--border-color); transition: var(--transition);">
                            <td style="padding: 15px 20px; font-weight: 600; color: var(--text-muted);"><?php echo $dm['id']; ?></td>
                            <td style="padding: 15px 20px; font-weight: 700; color: var(--text-dark);"><?php echo htmlspecialchars($dm['ten_danhmuc']); ?></td>
                            <td style="padding: 15px 20px; text-align: center;">
                                <!-- Edit Button -->
                                <a href="index.php?act=danhmuc-edit&id=<?php echo $dm['id']; ?>" 
                                   style="color: #4facfe; padding: 6px 12px; font-weight: 600; border: 1px solid #4facfe; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px; margin-right: 5px; font-size: 13px;">
                                    <i class="fa-regular fa-pen-to-square"></i> Sửa
                                </a>
                                
                                <!-- Delete Button -->
                                <a href="index.php?act=danhmuc-delete&id=<?php echo $dm['id']; ?>" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Điều này sẽ xóa tất cả giày bóng đá thuộc danh mục này!');"
                                   style="color: var(--danger); padding: 6px 12px; font-weight: 600; border: 1px solid var(--danger); border-radius: 4px; display: inline-flex; align-items: center; gap: 4px; font-size: 13px;">
                                    <i class="fa-regular fa-trash-can"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <i class="fa-regular fa-folder-open" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                            Không có danh mục nào phù hợp với điều kiện tìm kiếm.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
