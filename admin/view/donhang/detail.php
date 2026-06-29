<!-- Admin: Chi tiết đơn hàng -->
<?php
$trang_thai_labels = ['Chờ xử lý','Đang giao','Hoàn thành','Đã hủy'];
$trang_thai_badges = ['badge-wait','badge-ship','badge-done','badge-cancel'];
$trang_thai_colors = ['#f59e0b','#3b82f6','#22c55e','#ef4444'];
?>

<div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
    <a href="index.php?act=donhang-list" class="btn-sm btn-view">
        <i class="fa-solid fa-arrow-left"></i> Quay lại
    </a>
    <h2 class="page-title" style="margin:0;">Chi tiết Đơn hàng #<?php echo $donhang['id']; ?></h2>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:24px;">

    <!-- Left: Customer info + Items -->
    <div>
        <!-- Items -->
        <div class="card-admin" style="margin-bottom:20px;">
            <h3 style="font-size:15px;font-weight:800;margin:0 0 16px;">🛒 Sản phẩm đã đặt</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:60px;">Ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Size</th>
                        <th>Đơn giá</th>
                        <th>SL</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($chi_tiet as $item): ?>
                    <tr>
                        <td>
                            <img src="../<?php echo $item['hinh_anh']; ?>" style="width:50px;height:50px;object-fit:contain;border-radius:6px;border:1px solid #e2e8f0;">
                        </td>
                        <td><strong><?php echo htmlspecialchars($item['ten_sanpham']); ?></strong></td>
                        <td><?php echo $item['size'] ? $item['size'] : '—'; ?></td>
                        <td><?php echo number_format($item['gia'],0,',','.'); ?>đ</td>
                        <td><?php echo $item['so_luong']; ?></td>
                        <td style="font-weight:800;color:#ef4444;"><?php echo number_format($item['gia'] * $item['so_luong'],0,',','.'); ?>đ</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align:right;font-weight:800;padding:16px;">TỔNG CỘNG:</td>
                        <td style="font-size:18px;font-weight:900;color:#ef4444;"><?php echo number_format($donhang['tong_tien'],0,',','.'); ?>đ</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Customer info -->
        <div class="card-admin">
            <h3 style="font-size:15px;font-weight:800;margin:0 0 16px;">👤 Thông tin khách hàng</h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <div class="form-label">Người nhận</div>
                    <div style="font-weight:700;"><?php echo htmlspecialchars($donhang['nguoi_nhan']); ?></div>
                </div>
                <div>
                    <div class="form-label">Số điện thoại</div>
                    <div style="font-weight:700;"><?php echo htmlspecialchars($donhang['dien_thoai']); ?></div>
                </div>
                <div>
                    <div class="form-label">Email</div>
                    <div style="font-weight:700;"><?php echo htmlspecialchars($donhang['email']); ?></div>
                </div>
                <div>
                    <div class="form-label">Ngày đặt</div>
                    <div style="font-weight:700;"><?php echo $donhang['ngay_dat']; ?></div>
                </div>
                <div style="grid-column:1/-1;">
                    <div class="form-label">Địa chỉ giao hàng</div>
                    <div style="font-weight:700;"><?php echo htmlspecialchars($donhang['dia_chi']); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Status panel -->
    <div>
        <div class="card-admin" style="position:sticky;top:100px;">
            <h3 style="font-size:15px;font-weight:800;margin:0 0 16px;">📋 Trạng thái đơn hàng</h3>

            <!-- Current status -->
            <div style="text-align:center;padding:20px 0;border-bottom:1px solid #f1f5f9;margin-bottom:20px;">
                <span class="badge <?php echo $trang_thai_badges[$donhang['trang_thai']]; ?>" style="font-size:14px;padding:8px 20px;">
                    <?php echo $trang_thai_labels[$donhang['trang_thai']]; ?>
                </span>
            </div>

            <!-- Update status buttons -->
            <div style="margin-bottom:20px;">
                <div class="form-label">Cập nhật trạng thái</div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <?php foreach ($trang_thai_labels as $idx => $label): ?>
                        <?php if ($idx != $donhang['trang_thai']): ?>
                        <a href="index.php?act=donhang-status&id=<?php echo $donhang['id']; ?>&trang_thai=<?php echo $idx; ?>"
                           class="btn-sm"
                           style="background:<?php echo $trang_thai_colors[$idx]; ?>;color:white;justify-content:center;"
                           onclick="return confirm('Chuyển sang: <?php echo $label; ?>?')">
                            <?php echo $label; ?>
                        </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Payment method -->
            <div style="padding-top:16px;border-top:1px solid #f1f5f9;">
                <div class="form-label">Phương thức thanh toán</div>
                <strong><?php echo $donhang['pttt'] == 1 ? '🏦 Chuyển khoản' : '💵 COD (Tiền mặt)'; ?></strong>
            </div>

            <!-- Total -->
            <div style="padding-top:16px;border-top:1px solid #f1f5f9;margin-top:16px;">
                <div class="form-label">Tổng tiền</div>
                <div style="font-size:22px;font-weight:900;color:#ef4444;"><?php echo number_format($donhang['tong_tien'],0,',','.'); ?>đ</div>
            </div>

            <!-- Delete -->
            <div style="padding-top:16px;border-top:1px solid #f1f5f9;margin-top:16px;">
                <a href="index.php?act=donhang-delete&id=<?php echo $donhang['id']; ?>"
                   class="btn-sm btn-delete" style="width:100%;justify-content:center;padding:10px;"
                   onclick="return confirm('Xóa vĩnh viễn đơn hàng này?')">
                    <i class="fa-solid fa-trash"></i> Xóa đơn hàng
                </a>
            </div>
        </div>
    </div>
</div>
