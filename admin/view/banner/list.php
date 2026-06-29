<!-- Admin: Danh sách Banner -->

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <div class="page-title" style="margin:0;">🖼️ Quản lý Banner</div>
    <a href="index.php?act=banner-add" class="btn-sm btn-success" style="padding:10px 20px;">
        <i class="fa-solid fa-plus"></i> Thêm Banner
    </a>
</div>

<div class="card-admin">
    <?php if (empty($ds_banner)): ?>
        <p style="text-align:center;color:#94a3b8;padding:40px 0;">Chưa có banner nào.</p>
    <?php else: ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Tên Banner</th>
                <th>Loại</th>
                <th>Liên kết</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($ds_banner as $bn): ?>
            <tr>
                <td><?php echo $bn['id']; ?></td>
                <td>
                    <?php if ($bn['hinh_anh']): ?>
                        <img src="../<?php echo $bn['hinh_anh']; ?>" style="width:80px;height:45px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;">
                    <?php else: ?>
                        <div style="width:80px;height:45px;background:#f1f5f9;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-image" style="color:#94a3b8;"></i>
                        </div>
                    <?php endif; ?>
                </td>
                <td><strong><?php echo htmlspecialchars($bn['ten_banner']); ?></strong></td>
                <td>
                    <span class="badge <?php echo $bn['vi_tri'] == 'slider' ? 'badge-done' : 'badge-user'; ?>">
                        <?php echo $bn['vi_tri'] == 'slider' ? 'Slider' : 'Sub Banner'; ?>
                    </span>
                </td>
                <td>
                    <?php if ($bn['lien_ket']): ?>
                        <a href="<?php echo htmlspecialchars($bn['lien_ket']); ?>" target="_blank" style="color:#3b82f6;font-size:12px;max-width:160px;display:inline-block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            <?php echo htmlspecialchars($bn['lien_ket']); ?>
                        </a>
                    <?php else: ?>
                        <span style="color:#94a3b8;">—</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="index.php?act=banner-edit&id=<?php echo $bn['id']; ?>" class="btn-sm btn-edit">
                        <i class="fa-solid fa-pen"></i> Sửa
                    </a>
                    <a href="index.php?act=banner-delete&id=<?php echo $bn['id']; ?>"
                       class="btn-sm btn-delete"
                       onclick="return confirm('Xóa banner này?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
