<!-- Admin Dashboard View -->

<!-- Stats Grid: 5 cards -->
<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-bottom:28px;">
    <?php
    $stat_data = [
        ['Danh mục',    $total_categories, '#4facfe', 'fa-list-ul',    'danhmuc-list'],
        ['Sản phẩm',    $total_products,   '#39ff14', 'fa-shoe-prints', 'sanpham-list'],
        ['Thành viên',  $total_users,      '#f59e0b', 'fa-users',       'taikhoan-list'],
        ['Đơn hàng',    $total_orders,     '#a855f7', 'fa-box-open',    'donhang-list'],
        ['Doanh thu',   number_format($total_revenue,0,',','.').'đ', '#ef4444', 'fa-chart-line', 'donhang-list'],
    ];
    foreach ($stat_data as $s): ?>
    <a href="index.php?act=<?php echo $s[4]; ?>" style="text-decoration:none;">
        <div style="background:white;padding:22px 18px;border-radius:12px;box-shadow:0 1px 6px rgba(0,0,0,0.06);display:flex;align-items:center;justify-content:space-between;transition:transform 0.2s,box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='0 1px 6px rgba(0,0,0,0.06)'">
            <div>
                <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;"><?php echo $s[0]; ?></div>
                <div style="font-size:<?php echo is_numeric($s[1]) ? '28px' : '18px'; ?>;font-weight:900;color:#1e293b;line-height:1;"><?php echo $s[1]; ?></div>
            </div>
            <div style="width:48px;height:48px;border-radius:12px;background:<?php echo $s[2]; ?>1a;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fa-solid <?php echo $s[3]; ?>" style="color:<?php echo $s[2]; ?>;font-size:20px;"></i>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
</div>

<!-- Two columns: Quick actions + Recent orders -->
<div style="display:grid;grid-template-columns:280px 1fr;gap:24px;">

    <!-- Quick Actions -->
    <div style="background:white;padding:24px;border-radius:12px;box-shadow:0 1px 6px rgba(0,0,0,0.06);height:fit-content;">
        <h3 style="font-size:14px;font-weight:800;text-transform:uppercase;letter-spacing:0.5px;color:#475569;margin:0 0 16px;">⚡ Thao tác nhanh</h3>
        <div style="display:flex;flex-direction:column;gap:10px;">
            <a href="index.php?act=sanpham-add" class="btn-sm btn-success" style="justify-content:flex-start;padding:10px 14px;">
                <i class="fa-solid fa-plus" style="width:14px;"></i> Thêm sản phẩm mới
            </a>
            <a href="index.php?act=baiviet-add" class="btn-sm" style="background:#6366f1;color:white;justify-content:flex-start;padding:10px 14px;">
                <i class="fa-solid fa-pen" style="width:14px;"></i> Viết bài mới
            </a>
            <a href="index.php?act=banner-add" class="btn-sm" style="background:#0ea5e9;color:white;justify-content:flex-start;padding:10px 14px;">
                <i class="fa-solid fa-image" style="width:14px;"></i> Thêm banner mới
            </a>
            <a href="index.php?act=donhang-list&trang_thai=0" class="btn-sm" style="background:#f59e0b;color:white;justify-content:flex-start;padding:10px 14px;">
                <i class="fa-solid fa-clock" style="width:14px;"></i> Đơn hàng chờ xử lý
            </a>
            <a href="../index.php" class="btn-sm btn-view" style="justify-content:flex-start;padding:10px 14px;">
                <i class="fa-solid fa-eye" style="width:14px;"></i> Xem website
            </a>
        </div>
    </div>

    <!-- Recent Orders table -->
    <div style="background:white;padding:24px;border-radius:12px;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <h3 style="font-size:14px;font-weight:800;text-transform:uppercase;letter-spacing:0.5px;color:#475569;margin:0;">📦 Đơn hàng gần đây</h3>
            <a href="index.php?act=donhang-list" style="font-size:12px;font-weight:700;color:#3b82f6;text-decoration:none;">Xem tất cả →</a>
        </div>
        <?php
        $tt_labels = ['Chờ xử lý','Đang giao','Hoàn thành','Đã hủy'];
        $tt_badges = ['badge-wait','badge-ship','badge-done','badge-cancel'];
        ?>
        <?php if (empty($recent_orders)): ?>
            <p style="text-align:center;color:#94a3b8;padding:30px 0;">Chưa có đơn hàng nào.</p>
        <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($recent_orders as $dh): ?>
                <tr>
                    <td><strong>#<?php echo $dh['id']; ?></strong></td>
                    <td>
                        <div style="font-weight:700;font-size:13px;"><?php echo htmlspecialchars($dh['nguoi_nhan']); ?></div>
                        <div style="font-size:11px;color:#64748b;"><?php echo $dh['ngay_dat']; ?></div>
                    </td>
                    <td style="font-weight:800;color:#ef4444;font-size:13px;"><?php echo number_format($dh['tong_tien'],0,',','.'); ?>đ</td>
                    <td><span class="badge <?php echo $tt_badges[$dh['trang_thai']]; ?>"><?php echo $tt_labels[$dh['trang_thai']]; ?></span></td>
                    <td>
                        <a href="index.php?act=donhang-detail&id=<?php echo $dh['id']; ?>" class="btn-sm btn-view">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
