<!-- Blog/News Listing View (tintuc) -->
<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=tintuc");
    exit();
}
?>

<div class="container">
    <div class="info-layout">
        
        <div class="info-header">
            <h1>Tin tức & Cẩm nang bóng đá</h1>
            <p>Cập nhật những xu hướng giày bóng đá mới nhất, cẩm nang chọn phom chân và kinh nghiệm sân cỏ</p>
        </div>

        <div class="info-content">
            <?php if (count($ds_baiviet) > 0): ?>
                <!-- Blog Grid Layout -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; margin-top: 30px;">
                    <?php foreach ($ds_baiviet as $bv): ?>
                        <article style="background-color: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); display: flex; flex-direction: column; transition: var(--transition);"
                                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='var(--shadow-lg)';"
                                 onmouseout="this.style.transform='none'; this.style.boxShadow='var(--shadow)';">
                            
                            <!-- Article Image -->
                            <a href="index.php?act=chitiet-baiviet&id=<?php echo $bv['id']; ?>" style="display: block; aspect-ratio: 16/9; overflow: hidden; background-color: #f1f5f9;">
                                <img src="<?php echo $bv['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($bv['tieu_de']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            </a>

                            <!-- Article Content -->
                            <div style="padding: 25px; display: flex; flex-direction: column; flex-grow: 1;">
                                <span style="font-size: 12px; color: var(--text-muted); font-weight: 600; display: flex; align-items: center; gap: 5px; margin-bottom: 10px;">
                                    <i class="fa-regular fa-calendar"></i> <?php echo $bv['ngay_dang']; ?>
                                </span>
                                
                                <h3 style="font-size: 18px; font-weight: 800; line-height: 1.4; margin-bottom: 12px; height: 50px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: var(--text-dark);">
                                    <a href="index.php?act=chitiet-baiviet&id=<?php echo $bv['id']; ?>" style="color: inherit;">
                                        <?php echo htmlspecialchars($bv['tieu_de']); ?>
                                    </a>
                                </h3>

                                <p style="font-size: 14px; color: var(--text-muted); line-height: 1.6; margin-bottom: 20px; height: 68px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                    <?php echo htmlspecialchars($bv['mo_ta_ngan']); ?>
                                </p>

                                <a href="index.php?act=chitiet-baiviet&id=<?php echo $bv['id']; ?>" class="btn-link" style="margin-top: auto; font-weight: 700; font-size: 14px; color: var(--text-dark); display: inline-flex; align-items: center; gap: 5px; transition: var(--transition);">
                                    Đọc bài viết <i class="fa-solid fa-angle-right"></i>
                                </a>
                            </div>

                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                    Không tìm thấy bài viết nào!
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
