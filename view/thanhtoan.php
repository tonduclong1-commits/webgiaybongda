<!-- Checkout View (thanhtoan) -->
<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=thanhtoan");
    exit();
}
?>

<div class="container" style="margin-top: 30px; margin-bottom: 50px;">
    <!-- Breadcrumbs -->
    <div style="margin-bottom: 20px; font-size: 14px; color: var(--text-muted);">
        <a href="index.php" style="hover: color: var(--text-dark);">Trang chủ</a> 
        <span style="margin: 0 8px;">/</span> 
        <a href="index.php?act=giohang" style="hover: color: var(--text-dark);">Giỏ hàng</a> 
        <span style="margin: 0 8px;">/</span> 
        <span style="color: var(--text-dark); font-weight: 600;">Thanh toán</span>
    </div>

    <h1 style="font-weight: 800; font-size: 28px; text-transform: uppercase; margin-bottom: 30px;">
        Thanh toán <span style="color: var(--primary-dark);">đơn hàng</span>
    </h1>

    <?php if (isset($_SESSION['error_checkout'])): ?>
        <div style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); color: var(--danger); padding: 15px; border-radius: var(--radius); margin-bottom: 20px; font-weight: 600;">
            <i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i>
            <?php 
                echo $_SESSION['error_checkout']; 
                unset($_SESSION['error_checkout']);
            ?>
        </div>
    <?php endif; ?>

    <form action="index.php?act=dathang" method="POST">
        <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 40px; align-items: start;">
            
            <!-- Left: Shipping & Billing Details Form -->
            <div style="background-color: var(--white); border: 1px solid var(--border-color); padding: 30px; border-radius: var(--radius); box-shadow: var(--shadow);">
                <h3 style="font-size: 18px; font-weight: 800; text-transform: uppercase; margin-bottom: 25px; border-bottom: 2px solid var(--border-color); padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-truck-fast" style="color: var(--primary-dark);"></i> Thông tin giao hàng
                </h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Recipient Name -->
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="nguoi_nhan" style="font-size: 14px; font-weight: 600; color: var(--text-dark);">Họ và tên người nhận <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="nguoi_nhan" id="nguoi_nhan" required placeholder="Nhập họ tên đầy đủ" 
                               value="<?php echo $user_info ? htmlspecialchars($user_info['user']) : ''; ?>"
                               style="padding: 12px 15px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 14px; font-family: var(--font); outline: none; transition: var(--transition);">
                    </div>
                    
                    <!-- Recipient Phone -->
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="dien_thoai" style="font-size: 14px; font-weight: 600; color: var(--text-dark);">Số điện thoại <span style="color: var(--danger);">*</span></label>
                        <input type="tel" name="dien_thoai" id="dien_thoai" required placeholder="Nhập số điện thoại nhận hàng" 
                               value="<?php echo $user_info ? htmlspecialchars($user_info['dien_thoai']) : ''; ?>"
                               style="padding: 12px 15px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 14px; font-family: var(--font); outline: none; transition: var(--transition);">
                    </div>
                </div>

                <!-- Recipient Email -->
                <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                    <label for="email" style="font-size: 14px; font-weight: 600; color: var(--text-dark);">Địa chỉ Email <span style="color: var(--danger);">*</span></label>
                    <input type="email" name="email" id="email" required placeholder="Nhập email để nhận thông tin đơn hàng" 
                           value="<?php echo $user_info ? htmlspecialchars($user_info['email']) : ''; ?>"
                           style="padding: 12px 15px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 14px; font-family: var(--font); outline: none; transition: var(--transition);">
                </div>

                <!-- Recipient Address -->
                <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 30px;">
                    <label for="dia_chi" style="font-size: 14px; font-weight: 600; color: var(--text-dark);">Địa chỉ giao hàng <span style="color: var(--danger);">*</span></label>
                    <textarea name="dia_chi" id="dia_chi" rows="3" required placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" 
                              style="padding: 12px 15px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 14px; font-family: var(--font); outline: none; resize: vertical; transition: var(--transition);"></textarea>
                </div>

                <!-- Payment Methods -->
                <h3 style="font-size: 18px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px; border-bottom: 2px solid var(--border-color); padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-wallet" style="color: var(--primary-dark);"></i> Phương thức thanh toán
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <!-- Option 1: COD -->
                    <label style="display: flex; align-items: center; gap: 12px; padding: 15px; border: 1px solid var(--border-color); border-radius: var(--radius); cursor: pointer; transition: var(--transition); background: #fafbfc;">
                        <input type="radio" name="pttt" value="0" checked style="accent-color: var(--dark);">
                        <i class="fa-solid fa-hand-holding-dollar" style="font-size: 20px; color: var(--text-muted);"></i>
                        <div>
                            <span style="font-weight: 700; font-size: 14px; display: block; color: var(--text-dark);">Thanh toán khi nhận hàng (COD)</span>
                            <span style="font-size: 12px; color: var(--text-muted);">Quý khách thanh toán bằng tiền mặt trực tiếp cho nhân viên giao hàng sau khi nhận hàng.</span>
                        </div>
                    </label>

                    <!-- Option 2: Bank Transfer -->
                    <label style="display: flex; align-items: center; gap: 12px; padding: 15px; border: 1px solid var(--border-color); border-radius: var(--radius); cursor: pointer; transition: var(--transition); background: #fafbfc;">
                        <input type="radio" name="pttt" value="1" style="accent-color: var(--dark);">
                        <i class="fa-solid fa-building-columns" style="font-size: 20px; color: var(--text-muted);"></i>
                        <div>
                            <span style="font-weight: 700; font-size: 14px; display: block; color: var(--text-dark);">Chuyển khoản ngân hàng</span>
                            <span style="font-size: 12px; color: var(--text-muted);">Chuyển khoản trực tiếp qua ngân hàng. Đơn hàng sẽ được chuyển đi ngay sau khi nhận được thanh toán.</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Right: Order Summary Sidebar -->
            <div style="background-color: var(--white); border: 1px solid var(--border-color); padding: 30px; border-radius: var(--radius); box-shadow: var(--shadow);">
                <h3 style="font-size: 18px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px; border-bottom: 2px solid var(--border-color); padding-bottom: 10px;">
                    Tóm tắt đơn hàng
                </h3>
                
                <!-- Items list -->
                <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 20px; max-height: 250px; overflow-y: auto; padding-right: 5px;">
                    <?php foreach ($cart as $item): ?>
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 50px; height: 50px; background-color: #f1f5f9; border-radius: 6px; display: flex; align-items: center; justify-content: center; padding: 3px; border: 1px solid var(--border-color); flex-shrink: 0;">
                                    <img src="<?php echo $item['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($item['ten_sanpham']); ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                </div>
                                <div>
                                    <h4 style="font-size: 13.5px; font-weight: 700; color: var(--text-dark); margin-bottom: 2px;"><?php echo htmlspecialchars($item['ten_sanpham']); ?></h4>
                                    <span style="font-size: 12px; color: var(--text-muted);">Size: <?php echo htmlspecialchars($item['size']); ?> &times; <?php echo $item['quantity']; ?></span>
                                </div>
                            </div>
                            <span style="font-size: 14px; font-weight: 700; color: var(--text-dark); flex-shrink: 0;">
                                <?php echo number_format($item['gia'] * $item['quantity'], 0, ',', '.'); ?>đ
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div style="border-top: 1px dashed var(--border-color); padding-top: 15px; margin-bottom: 15px; font-size: 14px; display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted);">Tạm tính</span>
                    <span style="font-weight: 600; color: var(--text-dark);"><?php echo number_format($tong_tien, 0, ',', '.'); ?>đ</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 14px;">
                    <span style="color: var(--text-muted);">Phí giao hàng</span>
                    <span style="font-weight: 600; color: var(--success);">Miễn phí</span>
                </div>
                
                <div style="border-top: 1px solid var(--border-color); padding-top: 15px; display: flex; justify-content: space-between; margin-bottom: 30px;">
                    <span style="font-size: 15px; font-weight: 700; color: var(--text-dark);">Tổng cộng</span>
                    <span style="font-size: 18px; font-weight: 800; color: var(--danger);"><?php echo number_format($tong_tien, 0, ',', '.'); ?>đ</span>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; text-align: center; border: none; font-family: var(--font); cursor: pointer; text-transform: uppercase; font-weight: 700; font-size: 15px; padding: 14px 20px; border-radius: var(--radius);">
                    Xác nhận đặt hàng <i class="fa-solid fa-circle-check" style="margin-left: 8px;"></i>
                </button>
            </div>

        </div>
    </form>
</div>
