<!-- Admin: Quản lý Bình Luận -->
<?php
$current_keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$current_id_pro  = isset($_GET['id_pro'])  ? (int)$_GET['id_pro'] : 0;
?>

<div class="page-title">💬 Quản lý Bình Luận</div>

<!-- Stats row -->
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;">
    <div style="background:white;border-radius:12px;padding:20px 22px;box-shadow:0 1px 6px rgba(0,0,0,0.06);display:flex;align-items:center;gap:16px;">
        <div style="width:46px;height:46px;border-radius:12px;background:#6366f11a;display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-comments" style="color:#6366f1;font-size:20px;"></i>
        </div>
        <div>
            <div style="font-size:26px;font-weight:900;color:#1e293b;"><?php echo number_format($total_comments); ?></div>
            <div style="font-size:11px;color:#64748b;font-weight:600;">Tổng bình luận</div>
        </div>
    </div>

    <div style="background:white;border-radius:12px;padding:20px 22px;box-shadow:0 1px 6px rgba(0,0,0,0.06);display:flex;align-items:center;gap:16px;">
        <div style="width:46px;height:46px;border-radius:12px;background:#22c55e1a;display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-shoe-prints" style="color:#22c55e;font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:26px;font-weight:900;color:#1e293b;"><?php echo number_format($total_products_with_comments); ?></div>
            <div style="font-size:11px;color:#64748b;font-weight:600;">Sản phẩm có bình luận</div>
        </div>
    </div>

    <div style="background:white;border-radius:12px;padding:20px 22px;box-shadow:0 1px 6px rgba(0,0,0,0.06);display:flex;align-items:center;gap:16px;">
        <div style="width:46px;height:46px;border-radius:12px;background:#f59e0b1a;display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-trophy" style="color:#f59e0b;font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:14px;font-weight:800;color:#1e293b;line-height:1.3;">
                <?php echo $most_commented ? htmlspecialchars(mb_strimwidth($most_commented['ten_sanpham'],0,28,'…')) : '—'; ?>
            </div>
            <div style="font-size:11px;color:#64748b;font-weight:600;">
                Sản phẩm nhiều BL nhất <?php echo $most_commented ? '('.$most_commented['cnt'].' bình luận)' : ''; ?>
            </div>
        </div>
    </div>
</div>

<!-- Filter bar -->
<div class="card-admin" style="margin-bottom:20px;">
    <form method="GET" action="index.php" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <input type="hidden" name="act" value="binhluan-list">

        <div style="flex:1;min-width:200px;">
            <label class="form-label">Tìm kiếm nội dung / tên người dùng</label>
            <input type="text" name="keyword" class="form-control"
                   placeholder="Nhập từ khóa..."
                   value="<?php echo htmlspecialchars($current_keyword); ?>">
        </div>

        <div style="min-width:200px;">
            <label class="form-label">Lọc theo sản phẩm</label>
            <select name="id_pro" class="form-control">
                <option value="0">— Tất cả sản phẩm —</option>
                <?php foreach ($ds_sanpham_filter as $sp): ?>
                    <option value="<?php echo $sp['id']; ?>" <?php echo ($current_id_pro == $sp['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars(mb_strimwidth($sp['ten_sanpham'],0,40,'…')); ?> (<?php echo $sp['cnt']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="display:flex;gap:8px;">
            <button type="submit" class="btn-sm btn-view" style="padding:10px 18px;">
                <i class="fa-solid fa-filter"></i> Lọc
            </button>
            <a href="index.php?act=binhluan-list" class="btn-sm" style="background:#f1f5f9;color:#475569;padding:10px 14px;">
                <i class="fa-solid fa-rotate-left"></i> Đặt lại
            </a>
        </div>
    </form>
</div>

<!-- Comment Table -->
<div class="card-admin">
    <?php if (empty($ds_binhluan)): ?>
        <div style="text-align:center;padding:50px 0;color:#94a3b8;">
            <i class="fa-regular fa-comment-dots" style="font-size:40px;display:block;margin-bottom:14px;"></i>
            <p style="font-size:15px;font-weight:600;">Không có bình luận nào<?php echo ($current_keyword || $current_id_pro) ? ' phù hợp với bộ lọc' : ''; ?>.</p>
        </div>
    <?php else: ?>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
            <span style="font-size:13px;color:#64748b;font-weight:600;">
                Hiển thị <strong><?php echo count($ds_binhluan); ?></strong> bình luận
            </span>
            <?php if (!empty($ds_binhluan)): ?>
            <a href="#" onclick="if(confirm('Xóa TẤT CẢ bình luận đang hiển thị?')) { /* bulk delete not implemented */ alert('Chức năng xóa hàng loạt đang phát triển.'); }"
               style="font-size:12px;color:#ef4444;font-weight:700;text-decoration:none;">
                <i class="fa-solid fa-trash"></i> Xóa tất cả hiển thị
            </a>
            <?php endif; ?>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Người bình luận</th>
                    <th>Sản phẩm</th>
                    <th>Nội dung bình luận</th>
                    <th>Ngày giờ</th>
                    <th style="width:90px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($ds_binhluan as $bl): ?>
                <tr id="row-bl-<?php echo $bl['id']; ?>">
                    <td style="color:#94a3b8;font-size:12px;">#<?php echo $bl['id']; ?></td>

                    <!-- Người bình luận -->
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:#e0f2fe;display:flex;align-items:center;justify-content:center;font-weight:800;color:#0369a1;font-size:13px;flex-shrink:0;">
                                <?php echo strtoupper(substr($bl['user'], 0, 1)); ?>
                            </div>
                            <div>
                                <div style="font-weight:700;font-size:13px;"><?php echo htmlspecialchars($bl['user']); ?></div>
                                <div style="font-size:11px;color:#94a3b8;">ID khách #<?php echo $bl['id_user']; ?></div>
                            </div>
                        </div>
                    </td>

                    <!-- Sản phẩm -->
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <?php if (!empty($bl['anh_sp'])): ?>
                            <img src="../<?php echo $bl['anh_sp']; ?>"
                                 style="width:42px;height:42px;object-fit:contain;border-radius:6px;border:1px solid #f1f5f9;flex-shrink:0;">
                            <?php else: ?>
                            <div style="width:42px;height:42px;background:#f1f5f9;border-radius:6px;flex-shrink:0;"></div>
                            <?php endif; ?>
                            <div>
                                <div style="font-size:12px;font-weight:700;color:#1e293b;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                    <?php echo htmlspecialchars($bl['ten_sanpham']); ?>
                                </div>
                                <a href="index.php?act=binhluan-list&id_pro=<?php echo $bl['id_pro']; ?>"
                                   style="font-size:10px;color:#3b82f6;">
                                    Xem BL sản phẩm này →
                                </a>
                            </div>
                        </div>
                    </td>

                    <!-- Nội dung -->
                    <td>
                        <div style="max-width:280px;font-size:13px;color:#374151;line-height:1.5;">
                            <?php
                                $content = htmlspecialchars($bl['noi_dung']);
                                // Highlight từ khóa tìm kiếm
                                if ($current_keyword) {
                                    $content = preg_replace(
                                        '/(' . preg_quote($current_keyword, '/') . ')/i',
                                        '<mark style="background:#fef08a;padding:1px 3px;border-radius:3px;">$1</mark>',
                                        $content
                                    );
                                }
                                // Truncate nếu quá dài
                                $raw = $bl['noi_dung'];
                                if (mb_strlen($raw) > 120) {
                                    $short = htmlspecialchars(mb_substr($raw, 0, 120));
                                    echo '<span id="short-'.$bl['id'].'">' . $short . '... <a href="#" style="color:#3b82f6;font-size:11px;" onclick="document.getElementById(\'short-'.$bl['id'].'\').style.display=\'none\';document.getElementById(\'full-'.$bl['id'].'\').style.display=\'block\';return false;">Xem thêm</a></span>';
                                    echo '<span id="full-'.$bl['id'].'" style="display:none;">' . $content . ' <a href="#" style="color:#3b82f6;font-size:11px;" onclick="document.getElementById(\'full-'.$bl['id'].'\').style.display=\'none\';document.getElementById(\'short-'.$bl['id'].'\').style.display=\'block\';return false;">Thu gọn</a></span>';
                                } else {
                                    echo $content;
                                }
                            ?>
                        </div>
                    </td>

                    <!-- Ngày giờ -->
                    <td style="font-size:12px;color:#64748b;white-space:nowrap;">
                        <i class="fa-regular fa-clock" style="margin-right:4px;"></i>
                        <?php echo htmlspecialchars($bl['ngay_binh_luan']); ?>
                    </td>

                    <!-- Thao tác -->
                    <td>
                        <a href="index.php?act=binhluan-delete&id=<?php echo $bl['id']; ?>&back=binhluan-list"
                           class="btn-sm btn-delete"
                           onclick="return confirm('Xóa bình luận này?')"
                           title="Xóa bình luận">
                            <i class="fa-solid fa-trash"></i> Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
