<!-- Order Success View (donhang_success) -->
<div class="container" style="margin-top: 40px; margin-bottom: 60px; max-width: 800px;">
    
    <!-- Success Banner -->
    <div style="background-color: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius); padding: 40px 30px; text-align: center; box-shadow: var(--shadow); margin-bottom: 30px;">
        <i class="fa-solid fa-circle-check" style="font-size: 72px; color: var(--success); margin-bottom: 20px; display: block;"></i>
        <h1 style="font-size: 26px; font-weight: 800; text-transform: uppercase; margin-bottom: 10px; color: var(--text-dark);">Đặt hàng thành công!</h1>
        <p style="color: var(--text-muted); font-size: 15px; margin-bottom: 20px;">Cảm ơn bạn đã tin tưởng chọn mua sản phẩm tại Soccer Sports Store.</p>
        
        <div style="display: inline-block; background-color: var(--light); border: 1px dashed var(--border-color); padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 15px; color: var(--text-dark);">
            Mã đơn hàng của bạn: <span style="color: var(--danger);">#DH-<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></span>
        </div>
    </div>

    <!-- Order Details -->
    <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 30px; margin-bottom: 35px; align-items: start;">
        
        <!-- Shipping Details Card -->
        <div style="background-color: var(--white); border: 1px solid var(--border-color); padding: 25px; border-radius: var(--radius); box-shadow: var(--shadow); height: 100%;">
            <h3 style="font-size: 16px; font-weight: 800; text-transform: uppercase; margin-bottom: 15px; border-bottom: 2px solid var(--border-color); padding-bottom: 8px;">
                Thông tin nhận hàng
            </h3>
            <ul style="display: flex; flex-direction: column; gap: 10px; font-size: 14px;">
                <li><strong style="color: var(--text-dark);">Người nhận:</strong> <?php echo htmlspecialchars($order['nguoi_nhan']); ?></li>
                <li><strong style="color: var(--text-dark);">Điện thoại:</strong> <?php echo htmlspecialchars($order['dien_thoai']); ?></li>
                <li><strong style="color: var(--text-dark);">Email:</strong> <?php echo htmlspecialchars($order['email']); ?></li>
                <li><strong style="color: var(--text-dark);">Địa chỉ:</strong> <?php echo htmlspecialchars($order['dia_chi']); ?></li>
                <li><strong style="color: var(--text-dark);">Thời gian đặt:</strong> <?php echo $order['ngay_dat']; ?></li>
            </ul>
        </div>
        
        <!-- Payment & Status Card -->
        <div style="background-color: var(--white); border: 1px solid var(--border-color); padding: 25px; border-radius: var(--radius); box-shadow: var(--shadow); height: 100%;">
            <h3 style="font-size: 16px; font-weight: 800; text-transform: uppercase; margin-bottom: 15px; border-bottom: 2px solid var(--border-color); padding-bottom: 8px;">
                Thanh toán & Trạng thái
            </h3>
            <ul style="display: flex; flex-direction: column; gap: 10px; font-size: 14px; margin-bottom: 15px;">
                <li>
                    <strong style="color: var(--text-dark);">Hình thức:</strong> 
                    <?php echo ($order['pttt'] == 1) ? 'Chuyển khoản ngân hàng' : 'Thanh toán tiền mặt khi nhận hàng (COD)'; ?>
                </li>
                <li>
                    <strong style="color: var(--text-dark);">Trạng thái:</strong> 
                    <span style="background-color: #fef3c7; color: #d97706; padding: 2px 8px; border-radius: 4px; font-weight: 600; font-size: 12px;">
                        Chờ xác nhận
                    </span>
                </li>
                <li>
                    <strong style="color: var(--text-dark);">Giao hàng:</strong> 
                    <span style="color: var(--success); font-weight: 600;">Miễn phí giao hàng</span>
                </li>
            </ul>

            <!-- Bank Transfer Details (if PTTT is 1) -->
            <?php if ($order['pttt'] == 1): ?>
                <div style="background-color: #f8fafc; border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px; font-size: 12.5px; line-height: 1.5;">
                    <strong style="color: var(--text-dark); display: block; margin-bottom: 5px; font-size: 13px;"><i class="fa-solid fa-circle-info" style="color: var(--primary-dark);"></i> Hướng dẫn chuyển khoản:</strong>
                    Ngân hàng: <strong>MB Bank (Quân Đội)</strong><br>
                    Số tài khoản: <strong>0987654321</strong><br>
                    Chủ TK: <strong>SOCCER SPORTS STORE</strong><br>
                    Nội dung CK: <strong style="color: var(--danger);">DH <?php echo $order['id']; ?></strong>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Items Grid Receipt -->
    <div style="background-color: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); margin-bottom: 40px;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background-color: var(--dark); color: var(--white); border-bottom: 2px solid var(--primary);">
                    <th style="padding: 12px 20px; font-weight: 700; text-transform: uppercase;">Sản phẩm</th>
                    <th style="padding: 12px; font-weight: 700; text-transform: uppercase; text-align: center;">Size</th>
                    <th style="padding: 12px; font-weight: 700; text-transform: uppercase; text-align: right;">Đơn giá</th>
                    <th style="padding: 12px; font-weight: 700; text-transform: uppercase; text-align: center;">SL</th>
                    <th style="padding: 12px 20px; font-weight: 700; text-transform: uppercase; text-align: right;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_details as $item): ?>
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 15px 20px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 45px; height: 45px; background-color: #f1f5f9; border-radius: 6px; display: flex; align-items: center; justify-content: center; padding: 3px; border: 1px solid var(--border-color); flex-shrink: 0;">
                                    <img src="<?php echo $item['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($item['ten_sanpham']); ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                </div>
                                <span style="font-weight: 700; color: var(--text-dark);"><?php echo htmlspecialchars($item['ten_sanpham']); ?></span>
                            </div>
                        </td>
                        <td style="padding: 15px; text-align: center; font-weight: 600; color: var(--text-dark);">
                            <?php echo htmlspecialchars($item['size']); ?>
                        </td>
                        <td style="padding: 15px; text-align: right; color: var(--text-dark);">
                            <?php echo number_format($item['gia'], 0, ',', '.'); ?>đ
                        </td>
                        <td style="padding: 15px; text-align: center; font-weight: 600; color: var(--text-dark);">
                            <?php echo $item['so_luong']; ?>
                        </td>
                        <td style="padding: 15px 20px; text-align: right; font-weight: 700; color: var(--text-dark);">
                            <?php echo number_format($item['gia'] * $item['so_luong'], 0, ',', '.'); ?>đ
                        </td>
                    </tr>
                <?php endforeach; ?>
                <!-- Total Row -->
                <tr style="background-color: #fafbfc; border-top: 1.5px solid var(--border-color);">
                    <td colspan="4" style="padding: 15px 20px; text-align: right; font-weight: 700; font-size: 15px; color: var(--text-dark);">Tổng thanh toán:</td>
                    <td style="padding: 15px 20px; text-align: right; font-weight: 800; font-size: 17px; color: var(--danger);">
                        <?php echo number_format($order['tong_tien'], 0, ',', '.'); ?>đ
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Actions Panel -->
    <div style="display: flex; gap: 20px; justify-content: center;">
        <a href="index.php?act=sanpham" class="btn-primary" style="padding: 12px 30px; text-transform: uppercase; font-size: 14px; font-weight: 700;">
            Tiếp tục mua sắm <i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i>
        </a>
        <a href="index.php" style="background-color: var(--dark); color: var(--white); border: none; font-weight: 700; padding: 12px 30px; border-radius: var(--radius); text-transform: uppercase; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; hover: transform: translateY(-2px); transition: var(--transition);">
            Về trang chủ <i class="fa-solid fa-house"></i>
        </a>
    </div>

</div>
