<!-- Product List Page View (sanpham) -->
<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=sanpham");
    exit();
}
?>

<div class="container">
    <!-- Breadcrumbs -->
    <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px; padding-top: 15px;">
        <a href="index.php" style="color: #64748b;">Trang chủ</a> / 
        <?php if (isset($_GET['keyword']) && strtolower($_GET['keyword']) == 'nike'): ?>
            Giày Bóng Đá Nike Chính Hãng - Tốc Độ và Kĩ Thuật
        <?php else: ?>
            Sản phẩm
        <?php endif; ?>
    </div>

    <div class="shop-layout">
        
        <!-- Sidebar Category Filter -->
        <aside class="sidebar">
            <div class="sidebar-widget">
                <h3 class="widget-title" id="sidebar-toggle" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; user-select: none;">
                    Danh mục giày 
                    <i class="fa-solid fa-angle-up sidebar-arrow" style="font-size: 14px; transition: transform 0.3s ease;"></i>
                </h3>
                <ul class="filter-list sidebar-dropdown" id="sidebar-menu">
                    <li>
                        <a href="index.php?act=sanpham<?php echo isset($_GET['keyword']) ? '&keyword='.urlencode($_GET['keyword']) : ''; ?><?php echo isset($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="<?php echo (!isset($_GET['id_danhmuc']) || $_GET['id_danhmuc'] == 0) ? 'active' : ''; ?>">
                            Tất cả sản phẩm
                        </a>
                    </li>
                    <?php foreach ($ds_danhmuc as $dm): ?>
                        <li>
                            <a href="index.php?act=sanpham&id_danhmuc=<?php echo $dm['id']; ?><?php echo isset($_GET['keyword']) ? '&keyword='.urlencode($_GET['keyword']) : ''; ?><?php echo isset($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                               class="<?php echo (isset($_GET['id_danhmuc']) && $_GET['id_danhmuc'] == $dm['id']) ? 'active' : ''; ?>">
                                <?php echo htmlspecialchars($dm['ten_danhmuc']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Sidebar Brand Filter -->
            <div class="sidebar-widget" style="margin-top: 20px;">
                <h3 class="widget-title" id="brand-toggle" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; user-select: none;">
                    Thương hiệu
                    <i class="fa-solid fa-angle-up sidebar-arrow brand-arrow" style="font-size: 14px; transition: transform 0.3s ease;"></i>
                </h3>
                <ul class="filter-list sidebar-dropdown" id="brand-menu">
                    <li><a href="index.php?act=sanpham&keyword=Nike">Nike</a></li>
                    <li><a href="index.php?act=sanpham&keyword=Adidas">Adidas</a></li>
                    <li><a href="index.php?act=sanpham&keyword=Puma">Puma</a></li>
                    <li><a href="index.php?act=sanpham&keyword=Mizuno">Mizuno</a></li>
                    <li><a href="index.php?act=sanpham&keyword=Kamito">Kamito</a></li>
                    <li><a href="index.php?act=sanpham&keyword=Kelme">Kelme</a></li>
                </ul>
            </div>

            <!-- Promotion Widget -->
            <div class="sidebar-widget" style="background-color: var(--dark); color: var(--white); padding: 20px; border-radius: 8px; text-align: center;">
                <h4 style="color: var(--primary); margin-bottom: 10px; text-transform: uppercase;">FREESHIP toàn quốc</h4>
                <p style="font-size: 13px; color: #cbd5e1; line-height: 1.4;">Cho đơn hàng trị giá từ 799k trở lên. Cam kết giao hàng siêu tốc trong 2-3 ngày làm việc.</p>
            </div>
        </aside>

        <!-- Product Grid & Sorting -->
        <section class="shop-content">
            <!-- Brand Title Header -->
            <div class="shop-header" style="margin-bottom: 15px; border-bottom: none; padding-bottom: 0;">
                <div>
                    <h1 style="font-size: 28px; font-weight: 900; text-transform: uppercase; color: var(--text-dark); margin: 0;">
                        <?php 
                            if (isset($_GET['keyword']) && strtolower($_GET['keyword']) == 'nike') {
                                echo "Giày Bóng Đá Nike Chính Hãng - Tốc Độ và Kĩ Thuật";
                            } elseif (isset($_GET['id_danhmuc']) && $_GET['id_danhmuc'] > 0) {
                                echo htmlspecialchars(danhmuc_get_name($_GET['id_danhmuc']));
                            } else {
                                echo "Tất cả giày bóng đá";
                            }
                        ?>
                    </h1>
                </div>
            </div>

            <!-- Brand Description Banner removed as per user request -->

            <div class="shop-header">
                <div>
                    <?php if (isset($_GET['keyword']) && $_GET['keyword'] != '' && strtolower($_GET['keyword']) != 'nike'): ?>
                        <p style="color: var(--text-muted); font-size: 14px; margin-top: 5px;">
                            Tìm thấy <?php echo count($ds_sanpham); ?> kết quả cho từ khóa: "<strong><?php echo htmlspecialchars($_GET['keyword']); ?></strong>"
                        </p>
                    <?php elseif (isset($_GET['keyword']) && strtolower($_GET['keyword']) == 'nike'): ?>
                        <p style="color: var(--text-muted); font-size: 14px; margin-top: 5px;">
                            Tìm thấy <?php echo count($ds_sanpham); ?> sản phẩm
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Sorting Dropdown -->
                <div class="shop-sort">
                    <form action="index.php" method="GET" id="sort-form">
                        <input type="hidden" name="act" value="sanpham">
                        <?php if (isset($_GET['id_danhmuc'])): ?>
                            <input type="hidden" name="id_danhmuc" value="<?php echo $_GET['id_danhmuc']; ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET['keyword'])): ?>
                            <input type="hidden" name="keyword" value="<?php echo htmlspecialchars($_GET['keyword']); ?>">
                        <?php endif; ?>
                        
                        <label for="sort-select" style="font-size: 14px; font-weight: 600; margin-right: 8px;">Sắp xếp theo:</label>
                        <select name="sort" id="sort-select" onchange="this.form.submit()">
                            <option value="" <?php echo (!isset($_GET['sort']) || $_GET['sort'] == '') ? 'selected' : ''; ?>>Mới nhất</option>
                            <option value="gia_tang" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'gia_tang') ? 'selected' : ''; ?>>Giá tăng dần</option>
                            <option value="gia_giam" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'gia_giam') ? 'selected' : ''; ?>>Giá giảm dần</option>
                            <option value="ten_az" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'ten_az') ? 'selected' : ''; ?>>Tên A-Z</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Product Grid List -->
            <?php if (count($ds_sanpham) > 0): ?>
                <div class="product-grid">
                    <?php foreach ($ds_sanpham as $sp): ?>
                        <div class="product-card">
                            <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" class="product-img-wrapper">
                                <img src="<?php echo $sp['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($sp['ten_sanpham']); ?>">
                                <?php if ($sp['gia_giam'] > 0): ?>
                                    <?php 
                                        $percent = round((($sp['gia'] - $sp['gia_giam']) / $sp['gia']) * 100);
                                    ?>
                                    <span class="badge-tag sale">-<?php echo $percent; ?>%</span>
                                <?php endif; ?>
                            </a>
                            <div class="product-info">
                                <span class="product-cat">
                                    <?php 
                                        if ($sp['id_danhmuc'] == 1) echo 'Cỏ Nhân Tạo';
                                        elseif ($sp['id_danhmuc'] == 2) echo 'Cỏ Tự Nhiên';
                                        elseif ($sp['id_danhmuc'] == 3) echo 'Futsal';
                                        elseif ($sp['id_danhmuc'] == 4) echo 'Quả Bóng';
                                        elseif ($sp['id_danhmuc'] == 5) echo 'Pickleball';
                                        else echo 'Giày bóng đá';
                                    ?>
                                </span>
                                <h3 class="product-title">
                                    <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>"><?php echo htmlspecialchars($sp['ten_sanpham']); ?></a>
                                </h3>
                                <div class="product-price-row">
                                    <?php if ($sp['gia_giam'] > 0): ?>
                                        <span class="price"><?php echo number_format($sp['gia_giam'], 0, ',', '.'); ?>đ</span>
                                        <span class="price-old"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                    <?php else: ?>
                                        <span class="price"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; background-color: var(--white); border-radius: var(--radius); border: 1px solid var(--border-color);">
                    <i class="fa-regular fa-folder-open" style="font-size: 50px; color: var(--text-muted); margin-bottom: 15px;"></i>
                    <h3 style="font-weight: 700; margin-bottom: 10px;">Không tìm thấy sản phẩm nào!</h3>
                    <p style="color: var(--text-muted); font-size: 14px; max-width: 400px; margin: 0 auto;">Vui lòng thử tìm kiếm với từ khóa khác hoặc quay lại danh mục sản phẩm chính.</p>
                    <a href="index.php?act=sanpham" class="btn-primary" style="margin-top: 20px;">Tất cả sản phẩm</a>
                </div>
            <?php endif; ?>
        </section>
        
    </div>
</div>
