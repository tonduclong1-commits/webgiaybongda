<!-- Blog Detail View (chitiet-baiviet) -->
<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=tintuc");
    exit();
}
?>

<div class="container" style="margin-top: 30px;">
    
    <!-- Split Layout: Main Content (left) and Recent Posts Sidebar (right) -->
    <div style="display: grid; grid-template-columns: 1fr 320px; gap: 40px;">
        
        <!-- Left Column: Article Body -->
        <article style="background-color: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius); padding: 40px; box-shadow: var(--shadow);">
            
            <!-- Breadcrumbs -->
            <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">
                <a href="index.php">Trang chủ</a> <span style="margin: 0 5px;">/</span> 
                <a href="index.php?act=tintuc">Tin tức</a> <span style="margin: 0 5px;">/</span> 
                <span style="color: var(--text-dark);"><?php echo htmlspecialchars($baiviet['tieu_de']); ?></span>
            </div>

            <!-- Date -->
            <div style="font-size: 13px; color: var(--text-muted); font-weight: 600; display: flex; align-items: center; gap: 5px; margin-bottom: 15px;">
                <i class="fa-regular fa-calendar"></i> Đăng ngày: <?php echo $baiviet['ngay_dang']; ?> | Tác giả: Antigravity Sports
            </div>

            <!-- Title -->
            <h1 style="font-size: 28px; font-weight: 800; color: var(--text-dark); line-height: 1.3; margin-bottom: 25px;">
                <?php echo htmlspecialchars($baiviet['tieu_de']); ?>
            </h1>

            <!-- Featured Image -->
            <div style="aspect-ratio: 2/1; overflow: hidden; border-radius: 8px; margin-bottom: 30px; background-color: #f1f5f9;">
                <img src="<?php echo $baiviet['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($baiviet['tieu_de']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <!-- Content -->
            <div style="font-size: 16px; color: #334155; line-height: 1.8; text-align: justify;">
                <?php echo nl2br(htmlspecialchars($baiviet['noi_dung'])); ?>
            </div>

            <!-- Social Share (Static UI) -->
            <div style="border-top: 1px solid var(--border-color); margin-top: 40px; padding-top: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                <span style="font-size: 14px; font-weight: 700; color: var(--text-dark);">Chia sẻ bài viết:</span>
                <div style="display: flex; gap: 10px; font-size: 16px;">
                    <a href="#" style="background-color: #3b5998; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" style="background-color: #1da1f2; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" style="background-color: #e60023; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fa-brands fa-pinterest-p"></i></a>
                </div>
            </div>

        </article>

        <!-- Right Column: Sidebar -->
        <aside style="display: flex; flex-direction: column; gap: 30px;">
            
            <!-- Widget: Recent Articles -->
            <div style="background-color: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius); padding: 25px; box-shadow: var(--shadow);">
                <h3 style="font-size: 16px; font-weight: 700; text-transform: uppercase; margin-bottom: 20px; border-bottom: 2px solid var(--border-color); padding-bottom: 8px;">Bài viết mới nhất</h3>
                
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <?php foreach ($ds_recent as $recent): ?>
                        <div style="display: flex; gap: 12px; align-items: flex-start;">
                            <a href="index.php?act=chitiet-baiviet&id=<?php echo $recent['id']; ?>" style="width: 80px; height: 50px; border-radius: 4px; overflow: hidden; display: block; flex-shrink: 0; background-color: #f1f5f9;">
                                <img src="<?php echo $recent['hinh_anh']; ?>" alt="thumb" style="width: 100%; height: 100%; object-fit: cover;">
                            </a>
                            <div>
                                <h4 style="font-size: 13px; font-weight: 700; line-height: 1.4; margin-bottom: 4px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                    <a href="index.php?act=chitiet-baiviet&id=<?php echo $recent['id']; ?>" style="color: var(--text-dark); hover: color: var(--primary-dark);"><?php echo htmlspecialchars($recent['tieu_de']); ?></a>
                                </h4>
                                <span style="font-size: 11px; color: var(--text-muted);"><i class="fa-regular fa-calendar"></i> <?php echo $recent['ngay_dang']; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Widget: Store Promo -->
            <div style="background-color: var(--dark); color: var(--white); border-radius: var(--radius); padding: 25px; box-shadow: var(--shadow); text-align: center;">
                <h4 style="color: var(--primary); font-size: 18px; font-weight: 700; text-transform: uppercase; margin-bottom: 10px;">VOUCHER ĐĂNG KÝ</h4>
                <p style="font-size: 13px; color: #cbd5e1; line-height: 1.5; margin-bottom: 20px;">Đăng ký tài khoản ngay hôm nay để nhận voucher chiết khấu 15% cho đôi giày bóng đá đầu tiên.</p>
                <a href="index.php?act=dangky" class="btn-primary" style="font-size: 13px; padding: 10px 20px; border-radius: 6px;">Đăng ký ngay</a>
            </div>

        </aside>

    </div>

</div>
