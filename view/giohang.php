<!-- Shopping Cart View (giohang) -->
<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=giohang");
    exit();
}
?>

<div class="container" style="margin-top: 30px; margin-bottom: 50px;">
    <!-- Breadcrumbs -->
    <div style="margin-bottom: 20px; font-size: 14px; color: var(--text-muted);">
        <a href="index.php" style="hover: color: var(--text-dark);">Trang chủ</a> 
        <span style="margin: 0 8px;">/</span> 
        <span style="color: var(--text-dark); font-weight: 600;">Giỏ hàng</span>
    </div>

    <h1 style="font-weight: 800; font-size: 28px; text-transform: uppercase; margin-bottom: 30px;">
        Giỏ hàng <span style="color: var(--primary-dark);">của bạn</span>
    </h1>

    <?php if (empty($cart)): ?>
        <div style="background-color: var(--white); border: 1px solid var(--border-color); padding: 50px 30px; border-radius: var(--radius); text-align: center; box-shadow: var(--shadow);">
            <i class="fa-solid fa-bag-shopping" style="font-size: 64px; color: var(--text-muted); margin-bottom: 20px; display: block;"></i>
            <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 10px;">Giỏ hàng của bạn đang trống</h2>
            <p style="color: var(--text-muted); margin-bottom: 25px;">Hãy khám phá hàng trăm mẫu giày bóng đá chính hãng từ các thương hiệu hàng đầu thế giới ngay.</p>
            <a href="index.php?act=sanpham" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                Tiếp tục mua sắm <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; align-items: start;">
            
            <!-- Left: Cart Items List -->
            <div>
                <form action="index.php?act=update-cart" method="POST" id="cart-form">
                    <div style="background-color: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow);">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead>
                                <tr style="background-color: var(--dark); color: var(--white); border-bottom: 2px solid var(--primary);">
                                    <th style="padding: 15px 20px; font-weight: 700; font-size: 14px; text-transform: uppercase;">Sản phẩm</th>
                                    <th style="padding: 15px; font-weight: 700; font-size: 14px; text-transform: uppercase; text-align: center;">Size</th>
                                    <th style="padding: 15px; font-weight: 700; font-size: 14px; text-transform: uppercase; text-align: right;">Đơn giá</th>
                                    <th style="padding: 15px; font-weight: 700; font-size: 14px; text-transform: uppercase; text-align: center;">Số lượng</th>
                                    <th style="padding: 15px; font-weight: 700; font-size: 14px; text-transform: uppercase; text-align: right;">Thành tiền</th>
                                    <th style="padding: 15px 20px; text-align: center;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $key => $item): ?>
                                    <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.2s;">
                                        <!-- Product Detail Info -->
                                        <td style="padding: 20px;">
                                            <div style="display: flex; align-items: center; gap: 15px;">
                                                <div style="width: 70px; height: 70px; background-color: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; padding: 5px; border: 1px solid var(--border-color);">
                                                    <img src="<?php echo $item['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($item['ten_sanpham']); ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                                </div>
                                                <div>
                                                    <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 4px; color: var(--text-dark);">
                                                        <a href="index.php?act=chitiet&id=<?php echo $item['id']; ?>" style="hover: color: var(--primary-dark);"><?php echo htmlspecialchars($item['ten_sanpham']); ?></a>
                                                    </h4>
                                                    <span style="font-size: 12px; color: var(--text-muted); background: #f1f5f9; padding: 2px 8px; border-radius: 4px;">Hàng Chính Hãng</span>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Size -->
                                        <td style="padding: 15px; text-align: center; font-weight: 700; font-size: 15px; color: var(--text-dark);">
                                            <?php echo htmlspecialchars($item['size']); ?>
                                        </td>
                                        
                                        <!-- Price -->
                                        <td style="padding: 15px; text-align: right; font-weight: 600; font-size: 15px; color: var(--text-dark);">
                                            <?php echo number_format($item['gia'], 0, ',', '.'); ?>đ
                                        </td>
                                        
                                        <!-- Quantity Picker -->
                                        <td style="padding: 15px; text-align: center;">
                                            <div style="display: inline-flex; align-items: center; border: 1px solid var(--border-color); border-radius: 6px; overflow: hidden; background: #fff;">
                                                <button type="button" onclick="adjustQty('<?php echo $key; ?>', -1)" style="padding: 6px 10px; border: none; background: none; font-size: 14px; font-weight: 700; cursor: pointer;">&minus;</button>
                                                <input type="number" name="quantity[<?php echo $key; ?>]" id="qty_<?php echo $key; ?>" value="<?php echo $item['quantity']; ?>" min="1" max="10" readonly style="width: 32px; border: none; text-align: center; font-size: 14px; font-weight: 700; outline: none; background: none;">
                                                <button type="button" onclick="adjustQty('<?php echo $key; ?>', 1)" style="padding: 6px 10px; border: none; background: none; font-size: 14px; font-weight: 700; cursor: pointer;">&plus;</button>
                                            </div>
                                        </td>
                                        
                                        <!-- Subtotal -->
                                        <td style="padding: 15px; text-align: right; font-weight: 700; font-size: 15px; color: var(--text-dark);">
                                            <?php echo number_format($item['gia'] * $item['quantity'], 0, ',', '.'); ?>đ
                                        </td>
                                        
                                        <!-- Remove Link -->
                                        <td style="padding: 15px 20px; text-align: center;">
                                            <a href="index.php?act=delete-from-cart&key=<?php echo $key; ?>" style="color: var(--danger); font-size: 16px; transition: var(--transition);" title="Xóa khỏi giỏ hàng">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <!-- Cart Actions Bar -->
                        <div style="padding: 20px; display: flex; justify-content: space-between; align-items: center; background-color: #fafbfc; border-top: 1px solid var(--border-color);">
                            <a href="index.php?act=sanpham" style="font-weight: 600; font-size: 14px; color: var(--text-dark); display: inline-flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-arrow-left"></i> Tiếp tục mua sắm
                            </a>
                            
                            <button type="submit" style="background-color: var(--dark-accent); color: var(--white); border: none; font-weight: 600; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; transition: var(--transition);">
                                <i class="fa-solid fa-rotate"></i> Cập nhật giỏ hàng
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Right: Order Summary Panel -->
            <div style="background-color: var(--white); border: 1px solid var(--border-color); padding: 30px; border-radius: var(--radius); box-shadow: var(--shadow); position: sticky; top: 120px;">
                <h3 style="font-size: 18px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px; border-bottom: 2px solid var(--border-color); padding-bottom: 10px;">
                    Thông tin đơn hàng
                </h3>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px;">
                    <span style="color: var(--text-muted);">Tạm tính (<?php echo count($cart); ?> sản phẩm)</span>
                    <span style="font-weight: 600; color: var(--text-dark);"><?php echo number_format($tong_tien, 0, ',', '.'); ?>đ</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 14px; border-bottom: 1px dashed var(--border-color); padding-bottom: 15px;">
                    <span style="color: var(--text-muted);">Phí vận chuyển</span>
                    <span style="font-weight: 600; color: var(--success);">Miễn phí</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
                    <span style="font-size: 16px; font-weight: 700; color: var(--text-dark);">Tổng thanh toán</span>
                    <span style="font-size: 20px; font-weight: 800; color: var(--danger);"><?php echo number_format($tong_tien, 0, ',', '.'); ?>đ</span>
                </div>
                
                <a href="index.php?act=thanhtoan" class="btn-primary" style="width: 100%; text-align: center; display: block; text-transform: uppercase; font-weight: 700; font-size: 15px; padding: 14px 20px; border-radius: var(--radius);">
                    Tiến hành thanh toán <i class="fa-solid fa-credit-card" style="margin-left: 8px;"></i>
                </a>
                
                <div style="margin-top: 20px; text-align: center; font-size: 12px; color: var(--text-muted);">
                    <i class="fa-solid fa-lock" style="color: var(--success); margin-right: 5px;"></i> Thanh toán bảo mật tuyệt đối 100%
                </div>
            </div>

        </div>
    <?php endif; ?>
</div>

<script>
function adjustQty(key, amt) {
    const input = document.getElementById('qty_' + key);
    let val = parseInt(input.value) + amt;
    if (val < 1) val = 1;
    if (val > 10) val = 10;
    input.value = val;
    
    // Auto submit form to save state
    document.getElementById('cart-form').submit();
}
</script>
