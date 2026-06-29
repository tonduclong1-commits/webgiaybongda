<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=thuonghieu");
    exit();
}
?>
<!-- Brands Page View (thuonghieu) - E-commerce Layout -->
<style>
    .brand-page-container {
        display: flex;
        gap: 30px;
        padding: 20px 0;
        margin-top: 20px;
    }
    
    /* Sidebar Styles */
    .brand-sidebar {
        width: 250px;
        flex-shrink: 0;
    }
    .filter-group {
        margin-bottom: 30px;
        border-bottom: 1px dashed #e2e8f0;
        padding-bottom: 20px;
    }
    .filter-group:last-child {
        border-bottom: none;
    }
    .filter-title {
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        color: #1e293b;
        margin-bottom: 15px;
    }
    .filter-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .filter-item {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }
    .filter-checkbox {
        width: 16px;
        height: 16px;
        border: 1px solid #cbd5e1;
        border-radius: 3px;
        cursor: pointer;
        appearance: none;
        outline: none;
        position: relative;
    }
    .filter-checkbox:checked {
        background-color: #ef4444;
        border-color: #ef4444;
    }
    .filter-checkbox:checked::after {
        content: '\2714';
        position: absolute;
        color: white;
        font-size: 10px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .filter-label {
        font-size: 13px;
        color: #475569;
        font-weight: 500;
        user-select: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .color-dot {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }
    .view-more-link {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
    }
    
    /* Main Content Styles */
    .brand-main {
        flex: 1;
    }
    .brand-header {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 20px;
    }
    .brand-desc-box {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .brand-desc-text {
        font-size: 14px;
        color: #475569;
        margin-bottom: 10px;
    }
    .brand-desc-link {
        font-size: 13px;
        color: #3b82f6;
        text-decoration: underline;
        font-weight: 600;
    }
    
    /* Product Grid */
    .brand-product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    @media (max-width: 1024px) {
        .brand-product-grid { grid-template-columns: repeat(3, 1fr); }
        .brand-sidebar { width: 200px; }
    }
    @media (max-width: 768px) {
        .brand-page-container { flex-direction: column; }
        .brand-sidebar { width: 100%; display: flex; flex-wrap: wrap; gap: 20px; }
        .filter-group { border: none; margin-bottom: 0; padding-bottom: 0; flex: 1; min-width: 150px; }
        .brand-product-grid { grid-template-columns: repeat(2, 1fr); }
    }
    
    /* Simplified Product Card for Grid */
    .b-card {
        border: none;
        background: white;
    }
    .b-img-wrap {
        background-color: #f8fafc;
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 15px;
    }
    .b-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        mix-blend-mode: multiply;
    }
    .b-brand-name {
        font-size: 10px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
        display: block;
    }
    .b-title {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        height: 38px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    .b-price-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .b-price-new {
        color: #ef4444;
        font-weight: 700;
        font-size: 14px;
    }
    .b-price-old {
        color: #94a3b8;
        font-size: 12px;
        text-decoration: line-through;
    }
    .b-discount {
        background-color: #ef4444;
        color: white;
        font-size: 10px;
        font-weight: 800;
        padding: 2px 6px;
        border-radius: 12px;
    }
</style>

<div class="container">
    <!-- Breadcrumbs -->
    <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 10px; padding-top: 15px;">
        <a href="index.php" style="color: #64748b;">Trang chủ</a> / <span style="font-weight: 600; color: #1e293b;">Thương Hiệu</span>
    </div>

    <div class="brand-page-container">
        <!-- Sidebar Filters -->
        <aside class="brand-sidebar">
            
            <!-- Brands Filter -->
            <div class="filter-group">
                <div class="filter-title">Thương Hiệu</div>
                <ul class="filter-list">
                    <?php 
                    $brands = ['Mira', 'NMS', 'Kelme', 'Động Lực', 'Mitre', 'New Balacc', 'Pan', 'Kaiwin', 'Zocker', 'Kamito', 'Wika', 'Mizuno', 'Adidas', 'Puma', 'Nike'];
                    foreach(array_slice($brands, 0, 15) as $br): ?>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><?php echo $br; ?></span>
                    </label>
                    <?php endforeach; ?>
                </ul>
                <div class="view-more-link">Xem thêm <i class="fa-solid fa-angle-down"></i></div>
            </div>

            <!-- Color Filter -->
            <div class="filter-group">
                <div class="filter-title">Màu Sắc</div>
                <ul class="filter-list">
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><span class="color-dot" style="background: #000;"></span> Đen</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><span class="color-dot" style="background: #1e3a8a;"></span> Xanh đen</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><span class="color-dot" style="background: #451a03;"></span> Nâu đậm</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><span class="color-dot" style="background: #d97706;"></span> Nâu nhạt</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><span class="color-dot" style="background: #f472b6;"></span> Hồng</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><span class="color-dot" style="background: #fef3c7;"></span> Kem</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><span class="color-dot" style="background: #dc2626;"></span> Đỏ</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><span class="color-dot" style="background: #ea580c;"></span> Cam</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><span class="color-dot" style="background: #c084fc;"></span> Tím</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><span class="color-dot" style="background: #65a30d;"></span> Xanh lá</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label"><span class="color-dot" style="background: #fff;"></span> Trắng</span>
                    </label>
                </ul>
                <div class="view-more-link">Xem thêm <i class="fa-solid fa-angle-down"></i></div>
            </div>

            <!-- Price Filter -->
            <div class="filter-group" style="border: none;">
                <div class="filter-title">Mức Giá</div>
                <ul class="filter-list">
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label">Giá dưới 1.000.000đ</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label">1.000.000đ - 2.000.000đ</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label">2.000.000đ - 3.000.000đ</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label">3.000.000đ - 5.000.000đ</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label">5.000.000đ - 7.000.000đ</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label">7.000.000đ - 10.000.000đ</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="filter-label">Giá trên 10.000.000đ</span>
                    </label>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="brand-main">
            <h1 class="brand-header">Thương Hiệu</h1>
            
            <div class="brand-desc-box">
                <div class="brand-desc-text">Các thương Hiệu sản phẩm có mặt tại Unifootball</div>
                <a href="#" class="brand-desc-link">Xem thêm</a>
            </div>

            <!-- Products Grid -->
            <div class="brand-product-grid">
                <?php 
                // Display first 16 products as an example for the grid
                $display_products = array_slice($ds_sanpham, 0, 16);
                foreach($display_products as $sp):
                    
                    // Simple heuristic to extract brand name from product name
                    $brand = 'KHÁC';
                    $ten_lower = strtolower($sp['ten_sanpham']);
                    if(strpos($ten_lower, 'nike') !== false) $brand = 'NIKE';
                    elseif(strpos($ten_lower, 'adidas') !== false) $brand = 'ADIDAS';
                    elseif(strpos($ten_lower, 'mizuno') !== false) $brand = 'MIZUNO';
                    elseif(strpos($ten_lower, 'puma') !== false) $brand = 'PUMA';
                    elseif(strpos($ten_lower, 'kamito') !== false) $brand = 'KAMITO';
                    elseif(strpos($ten_lower, 'zocker') !== false) $brand = 'ZOCKER';
                    elseif(strpos($ten_lower, 'wika') !== false) $brand = 'WIKA';
                    elseif(strpos($ten_lower, 'kelme') !== false) $brand = 'KELME';
                ?>
                <div class="b-card">
                    <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" class="b-img-wrap">
                        <img src="<?php echo $sp['hinh_anh']; ?>" alt="<?php echo $sp['ten_sanpham']; ?>">
                    </a>
                    <div style="padding: 0 5px;">
                        <span class="b-brand-name"><?php echo $brand; ?></span>
                        <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" style="text-decoration: none;">
                            <h3 class="b-title"><?php echo $sp['ten_sanpham']; ?></h3>
                        </a>
                        <div class="b-price-row">
                            <span class="b-price-new"><?php echo number_format($sp['gia_giam'] ?? $sp['gia'], 0, ',', '.'); ?>đ</span>
                            <?php if ($sp['gia_giam']): ?>
                                <span class="b-price-old"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                <span class="b-discount">-<?php echo round((($sp['gia'] - $sp['gia_giam']) / $sp['gia']) * 100); ?>%</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination Mockup -->
            <div style="margin-top: 40px; display: flex; justify-content: center; gap: 8px;">
                <span style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: #ef4444; color: white; font-weight: 700; border-radius: 4px; font-size: 14px; cursor: pointer;">1</span>
                <span style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e2e8f0; color: #475569; font-weight: 600; border-radius: 4px; font-size: 14px; cursor: pointer;">2</span>
                <span style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e2e8f0; color: #475569; font-weight: 600; border-radius: 4px; font-size: 14px; cursor: pointer;">3</span>
                <span style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e2e8f0; color: #475569; font-weight: 600; border-radius: 4px; font-size: 14px; cursor: pointer;"><i class="fa-solid fa-angle-right"></i></span>
            </div>
            
        </main>
    </div>
</div>
