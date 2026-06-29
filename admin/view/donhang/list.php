<!-- Admin: Danh sách đơn hàng -->
<?php
$trang_thai_labels = ['Chờ xử lý','Đang giao','Hoàn thành','Đã hủy'];
$trang_thai_badges = ['badge-wait','badge-ship','badge-done','badge-cancel'];
$pttt_labels       = ['COD (Tiền mặt)', 'Chuyển khoản'];
?>

<div class="page-title">📦 Quản lý Đơn Hàng</div>

<!-- Stats row -->
<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-bottom:24px;">
    <?php
    $stat_cards = [
        ['Tất cả',     $stats['all'],        '#6366f1', 'fa-box'],
        ['Chờ xử lý',  $stats['cho'],        '#f59e0b', 'fa-clock'],
        ['Đang giao',  $stats['dang_giao'],  '#3b82f6', 'fa-truck'],
        ['Hoàn thành', $stats['hoan_thanh'], '#22c55e', 'fa-check-circle'],
        ['Đã hủy',     $stats['da_huy'],     '#ef4444', 'fa-times-circle'],
    ];
    foreach ($stat_cards as $s): ?>
    <div style="background:white;border-radius:10px;padding:18px 20px;box-shadow:0 1px 4px rgba(0,0,0,0.06);display:flex;align-items:center;gap:14px;">
        <div style="width:40px;height:40px;border-radius:10px;background:<?php echo $s[2]; ?>1a;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid <?php echo $s[3]; ?>" style="color:<?php echo $s[2]; ?>;font-size:16px;"></i>
        </div>
        <div>
            <div style="font-size:20px;font-weight:800;color:#1e293b;"><?php echo number_format($s[1]); ?></div>
            <div style="font-size:11px;color:#64748b;font-weight:600;"><?php echo $s[0]; ?></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Filter bar -->
<div class="card-admin" style="margin-bottom:20px;">
    <form method="GET" action="index.php" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <input type="hidden" name="act" value="donhang-list">
        <div style="flex:1;min-width:200px;">
            <label class="form-label">Tìm kiếm</label>
            <input type="text" name="keyword" class="form-control" placeholder="Tên khách, SĐT, email..." value="<?php echo htmlspecialchars(isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
        </div>
        <div>
            <label class="form-label">Trạng thái</label>
            <select name="trang_thai" class="form-control">
                <option value="-1">Tất cả</option>
                <option value="0" <?php echo (isset($_GET['trang_thai']) && $_GET['trang_thai']=='0') ? 'selected' : ''; ?>>Chờ xử lý</option>
                <option value="1" <?php echo (isset($_GET['trang_thai']) && $_GET['trang_thai']=='1') ? 'selected' : ''; ?>>Đang giao</option>
                <option value="2" <?php echo (isset($_GET['trang_thai']) && $_GET['trang_thai']=='2') ? 'selected' : ''; ?>>Hoàn thành</option>
                <option value="3" <?php echo (isset($_GET['trang_thai']) && $_GET['trang_thai']=='3') ? 'selected' : ''; ?>>Đã hủy</option>
            </select>
        </div>
        <div>
            <button type="submit" class="btn-sm btn-view" style="padding:10px 20px;">
                <i class="fa-solid fa-search"></i> Lọc
            </button>
        </div>
    </form>
</div>

<!-- Table -->
<div class="card-admin">
    <?php if (empty($ds_donhang)): ?>
        <p style="text-align:center;color:#94a3b8;padding:40px 0;">Không có đơn hàng nào.</p>
    <?php else: ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Khách hàng</th>
                <th>SĐT</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Thanh toán</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($ds_donhang as $dh): ?>
            <tr>
                <td><strong>#<?php echo $dh['id']; ?></strong></td>
                <td>
                    <div style="font-weight:700;"><?php echo htmlspecialchars($dh['nguoi_nhan']); ?></div>
                    <div style="font-size:11px;color:#64748b;"><?php echo htmlspecialchars($dh['email']); ?></div>
                </td>
                <td><?php echo htmlspecialchars($dh['dien_thoai']); ?></td>
                <td style="font-size:12px;"><?php echo $dh['ngay_dat']; ?></td>
                <td style="font-weight:800;color:#ef4444;"><?php echo number_format($dh['tong_tien'],0,',','.'); ?>đ</td>
                <td><span style="font-size:12px;"><?php echo $pttt_labels[$dh['pttt']] ?? 'COD'; ?></span></td>
                <td>
                    <span class="badge <?php echo $trang_thai_badges[$dh['trang_thai']] ?? 'badge-wait'; ?>">
                        <?php echo $trang_thai_labels[$dh['trang_thai']] ?? 'Không rõ'; ?>
                    </span>
                </td>
                <td>
                    <a href="index.php?act=donhang-detail&id=<?php echo $dh['id']; ?>" class="btn-sm btn-view">
                        <i class="fa-solid fa-eye"></i> Xem
                    </a>
                    <a href="index.php?act=donhang-delete&id=<?php echo $dh['id']; ?>"
                       class="btn-sm btn-delete"
                       onclick="return confirm('Xóa đơn hàng #<?php echo $dh['id']; ?>?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
