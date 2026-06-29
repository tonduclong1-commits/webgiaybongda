<!-- Admin: Danh sách Bài viết -->

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <div class="page-title" style="margin:0;">📰 Quản lý Bài Viết</div>
    <a href="index.php?act=baiviet-add" class="btn-sm btn-success" style="padding:10px 20px;">
        <i class="fa-solid fa-plus"></i> Thêm Bài Viết
    </a>
</div>

<!-- Search -->
<div class="card-admin" style="margin-bottom:20px;">
    <form method="GET" action="index.php" style="display:flex;gap:12px;align-items:flex-end;">
        <input type="hidden" name="act" value="baiviet-list">
        <div style="flex:1;">
            <label class="form-label">Tìm kiếm bài viết</label>
            <input type="text" name="keyword" class="form-control" placeholder="Tiêu đề bài viết..."
                   value="<?php echo htmlspecialchars(isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
        </div>
        <button type="submit" class="btn-sm btn-view" style="padding:10px 20px;">
            <i class="fa-solid fa-search"></i> Tìm
        </button>
    </form>
</div>

<!-- Table -->
<div class="card-admin">
    <?php if (empty($ds_baiviet)): ?>
        <p style="text-align:center;color:#94a3b8;padding:40px 0;">Chưa có bài viết nào.</p>
    <?php else: ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Tiêu đề</th>
                <th>Tác giả</th>
                <th>Ngày đăng</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($ds_baiviet as $bv): ?>
            <tr>
                <td><?php echo $bv['id']; ?></td>
                <td>
                    <?php if (!empty($bv['hinh_anh'])): ?>
                        <img src="../<?php echo $bv['hinh_anh']; ?>" style="width:70px;height:45px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;">
                    <?php else: ?>
                        <div style="width:70px;height:45px;background:#f1f5f9;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-newspaper" style="color:#94a3b8;"></i>
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <strong style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        <?php echo htmlspecialchars($bv['tieu_de']); ?>
                    </strong>
                </td>
                <td style="font-size:13px;"><?php echo htmlspecialchars($bv['tac_gia'] ?? '—'); ?></td>
                <td style="font-size:12px;color:#64748b;"><?php echo $bv['ngay_dang'] ?? '—'; ?></td>
                <td>
                    <a href="index.php?act=baiviet-edit&id=<?php echo $bv['id']; ?>" class="btn-sm btn-edit">
                        <i class="fa-solid fa-pen"></i> Sửa
                    </a>
                    <a href="index.php?act=baiviet-delete&id=<?php echo $bv['id']; ?>"
                       class="btn-sm btn-delete"
                       onclick="return confirm('Xóa bài viết này?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
