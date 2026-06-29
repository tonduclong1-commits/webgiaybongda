<!-- Product Detail Page View (chitiet) -->
<?php
if (!defined('DB_HOST')) {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 81;
    header("Location: ../index.php?act=chitiet&id=" . $id);
    exit();
}

// Determine custom attributes & breadcrumbs for Pickleball category
$is_pickleball = ($chi_tiet['id_danhmuc'] == 5);
$name_lower = strtolower($chi_tiet['ten_sanpham']);

$brand = 'Khác';
if (strpos($name_lower, 'nike') !== false) $brand = 'Nike';
elseif (strpos($name_lower, 'adidas') !== false) $brand = 'Adidas';
elseif (strpos($name_lower, 'mizuno') !== false) $brand = 'Mizuno';
elseif (strpos($name_lower, 'puma') !== false) $brand = 'Puma';
elseif (strpos($name_lower, 'kamito') !== false) $brand = 'Kamito';
elseif (strpos($name_lower, 'zocker') !== false) $brand = 'Zocker';
elseif (strpos($name_lower, 'wika') !== false) $brand = 'Wika';
elseif (strpos($name_lower, 'kelme') !== false) $brand = 'Kelme';
elseif (strpos($name_lower, 'asics') !== false) $brand = 'Asics';
elseif (strpos($name_lower, 'joola') !== false) $brand = 'Joola';
elseif (strpos($name_lower, 'babolat') !== false) $brand = 'Babolat';
elseif (strpos($name_lower, 'selkirk') !== false) $brand = 'Selkirk';
elseif (strpos($name_lower, 'facolos') !== false) $brand = 'Facolos';
elseif (strpos($name_lower, 'franklin') !== false) $brand = 'Franklin';
elseif (strpos($name_lower, 'voltano') !== false) $brand = 'Voltano';
elseif (strpos($name_lower, 'joma') !== false) $brand = 'Joma';

function get_pickleball_sizes_detail($ten_sanpham) {
    $name_lower = strtolower($ten_sanpham);
    if (strpos($name_lower, '1042a257-300') !== false || strpos($name_lower, 'dedicate 8 - 1042a257-300') !== false) {
        return ["35.5", "36", "37.5"];
    }
    if (strpos($name_lower, '1041a410-105') !== false || strpos($name_lower, 'dedicate 8 wide') !== false) {
        return ["39", "43.5", "44"];
    }
    if (strpos($name_lower, '1041a489 101') !== false) {
        return ["44"];
    }
    if (strpos($name_lower, 'fz2161-101') !== false) {
        return ["40.5", "41", "42", "42.5", "43", "44"];
    }
    if (strpos($name_lower, 'cz0220-133') !== false) {
        return ["42"];
    }
    if (strpos($name_lower, 'fd6574-106') !== false) {
        return ["40", "42", "42.5", "43", "44"];
    }
    if (strpos($name_lower, 'hv1376-100') !== false) {
        return ["35.5", "38", "38.5", "39"];
    }
    if (strpos($name_lower, 'fz2158-401') !== false) {
        return ["35.5", "36.5", "37.5"];
    }
    if (strpos($name_lower, 'pstros2502') !== false) {
        return ["40", "40.5", "41", "42", "42.5", "43"];
    }
    if (strpos($name_lower, 'court ff 3') !== false) {
        return ["39.5", "40", "41.5", "42.5", "43.5", "44"];
    }
    if (strpos($name_lower, 'game ff') !== false) {
        return ["41.5", "42", "42.5", "43.5", "44"];
    }
    if (strpos($name_lower, 'gel challenger 15') !== false) {
        return ["37", "37.5", "38", "39.5"];
    }
    if (strpos($name_lower, 'vapor pro 3') !== false) {
        return ["39.5", "40", "41.5", "42.5", "43.5", "44"];
    }
    if (strpos($name_lower, 'vapor 12') !== false) {
        return ["39", "39.5", "40.5", "41", "42", "43"];
    }
    if (strpos($name_lower, 'jet mach 4') !== false) {
        return ["41", "41.5", "42", "43", "44", "45"];
    }
    if (strpos($name_lower, '3s dual') !== false) {
        return ["3 QUẢ"];
    }
    if (strpos($name_lower, 'franklin') !== false) {
        return ["3 QUẢ", "HỘP 3 QUẢ"];
    }
    if (strpos($name_lower, '6 quả') !== false) {
        return ["6 QUẢ"];
    }
    if (strpos($name_lower, 'backpack') !== false || strpos($name_lower, 'balo') !== false) {
        return ["M", "L", "XL"];
    }
    if (strpos($name_lower, 'selkirk') !== false) {
        return ["16MM", "14MM", "13MM"];
    }
    if (strpos($name_lower, 'facolos') !== false) {
        return ["16MM", "15MM", "14MM"];
    }
    return ["16MM", "14MM"];
}

// Sizes lists matching specific product categories
$sizes_list = ["39.5", "40", "41.5", "42.5", "43.5", "44"];
if ($is_pickleball) {
    $sizes_list = get_pickleball_sizes_detail($chi_tiet['ten_sanpham']);
} elseif (strpos($name_lower, 'backpack') !== false || strpos($name_lower, 'balo') !== false) {
    $sizes_list = ["S", "M", "L", "XL"];
}
?>

<style>
/* CSS Styles for detailed layouts matching the screenshots */
.detail-breadcrumbs {
    font-size: 11px;
    color: #94a3b8;
    margin: 15px 0 25px 0;
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.detail-breadcrumbs a {
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
}
.detail-breadcrumbs a:hover {
    color: #0f172a;
}

.detail-main-grid {
    display: grid;
    grid-template-columns: 1fr 1.1fr;
    gap: 40px;
    margin-bottom: 40px;
}
@media (max-width: 768px) {
    .detail-main-grid {
        grid-template-columns: 1fr;
    }
}

/* Image grid matching screenshots */
.gallery-layout-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.gallery-full-width {
    grid-column: span 2;
}
.gallery-box {
    border: 1.5px solid #f1f5f9;
    border-radius: 8px;
    overflow: hidden;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
}
.gallery-box img {
    max-width: 100%;
    height: auto;
    object-fit: contain;
}

/* Details block */
.detail-info-pane {
    display: flex;
    flex-direction: column;
}
.detail-brand-badge {
    color: #3b82f6;
    font-weight: 800;
    text-transform: uppercase;
    font-size: 13px;
    margin-bottom: 8px;
    text-decoration: none;
}
.detail-title-h1 {
    font-size: 24px;
    font-weight: 900;
    color: #0f172a;
    line-height: 1.3;
    margin: 0 0 15px 0;
    text-transform: uppercase;
}

.badge-green-row {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 20px;
}
.badge-green-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #16a34a;
}
.badge-green-item i {
    font-size: 16px;
}

.bullets-list {
    margin: 0 0 25px 0;
    padding-left: 20px;
    font-size: 13px;
    color: #3b82f6;
    line-height: 1.8;
}
.bullets-list li span {
    color: #475569;
    font-weight: 600;
}

.color-pills-label {
    font-size: 12px;
    font-weight: 800;
    color: #64748b;
    text-transform: uppercase;
    margin-bottom: 8px;
    border-bottom: 1.5px solid #f1f5f9;
    padding-bottom: 6px;
}
.color-pills-grid {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 25px;
}
.color-pill-thumbnail {
    width: 54px;
    height: 54px;
    border: 1.5px solid #e2e8f0;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
    background: #ffffff;
    padding: 3px;
}
.color-pill-thumbnail.active {
    border-color: #0f172a;
}
.color-pill-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

/* Choose Size Widget styling */
.size-picker-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-bottom: none;
    padding: 10px 15px;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
}
.size-tab-btn {
    font-size: 11px;
    font-weight: 900;
    color: #475569;
    background: none;
    border: none;
    text-transform: uppercase;
    cursor: pointer;
    padding: 4px 8px;
}
.size-tab-btn.active {
    background: #ffffff;
    color: #0f172a;
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.size-picker-body {
    border: 1px solid #cbd5e1;
    background: #ffffff;
    padding: 15px;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 8px;
    margin-bottom: 25px;
}
.size-grid-box {
    border: 1.5px solid #e2e8f0;
    color: #0f172a;
    font-weight: 800;
    text-align: center;
    padding: 10px 2px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.2s ease;
}
.size-grid-box:hover, .size-grid-box.active {
    border-color: #0f172a;
    background: #0f172a;
    color: #ffffff;
}

/* Gift panel styling */
.gift-panel-box {
    border: 1.5px solid #22c55e;
    background-color: #f0fdf4;
    border-radius: 8px;
    padding: 18px;
    margin-bottom: 25px;
}
.gift-panel-heading {
    font-size: 13px;
    font-weight: 800;
    color: #16a34a;
    margin-bottom: 4px;
}
.gift-item-row {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #ffffff;
    border: 1px solid #dcfce7;
    padding: 8px 12px;
    border-radius: 6px;
    margin-top: 10px;
}
.gift-item-row input[type="radio"] {
    width: 18px;
    height: 18px;
    accent-color: #22c55e;
    cursor: pointer;
}
.gift-item-img {
    width: 40px;
    height: 40px;
    object-fit: contain;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
}

.submit-order-btn {
    width: 100%;
    background-color: #e11d48;
    color: #ffffff;
    font-size: 15px;
    font-weight: 900;
    text-transform: uppercase;
    border: none;
    padding: 16px 20px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s ease;
    letter-spacing: 0.5px;
}
.submit-order-btn:hover {
    background-color: #be123c;
}

/* Store locations panel */
.store-list-box {
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 25px;
}
.store-list-header {
    background-color: #fff1f2;
    border-bottom: 1.5px solid #ffe4e6;
    padding: 12px 16px;
    font-size: 12px;
    font-weight: 900;
    color: #e11d48;
    display: flex;
    align-items: center;
    gap: 8px;
}
.store-location-item {
    padding: 12px 16px;
    border-bottom: 1px solid #f1f5f9;
}
.store-location-item:last-child {
    border-bottom: none;
}
.store-location-name {
    font-size: 12px;
    font-weight: 900;
    color: #0f172a;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.store-status-badge {
    background-color: #dcfce7;
    color: #16a34a;
    font-size: 10px;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 12px;
    text-transform: uppercase;
}
.store-location-address {
    font-size: 11px;
    color: #64748b;
    margin-top: 4px;
}

/* PayLater Promo Table */
.paylater-box {
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 25px;
}
.paylater-bar {
    background: #facc15;
    padding: 10px;
    text-align: center;
    font-size: 11px;
    font-weight: 900;
    color: #000000;
}
.paylater-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
}
.paylater-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #f1f5f9;
    color: #475569;
}
.paylater-table tr:last-child td {
    border-bottom: none;
}
.paylater-badge {
    background-color: #ef4444;
    color: white;
    font-weight: 900;
    padding: 3px 6px;
    border-radius: 4px;
    text-transform: uppercase;
    font-size: 9px;
}

.bottom-bullets {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    margin-bottom: 25px;
}
.bottom-bullet-item {
    font-size: 12px;
    font-weight: 700;
    color: #16a34a;
    display: flex;
    align-items: center;
    gap: 6px;
}

.toggle-content-btn {
    display: block;
    margin: 25px auto 0;
    background: none;
    border: 2px solid #0f172a;
    color: #0f172a;
    padding: 10px 24px;
    font-size: 12px;
    font-weight: 900;
    border-radius: 20px;
    text-transform: uppercase;
    cursor: pointer;
}
.toggle-content-btn:hover {
    background: #0f172a;
    color: #ffffff;
}
</style>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 15px;">
    
    <!-- Breadcrumbs -->
    <div class="detail-breadcrumbs">
        <a href="index.php">Trang chủ</a>
        <span>/</span>
        <?php if ($is_pickleball): ?>
            <a href="index.php?act=pickball">Pickball</a>
            <span>/</span>
            <span style="color: #64748b; font-weight: 500;">Giày Pickball</span>
            <span>/</span>
            <span style="color: #64748b; font-weight: 500;">Giày Pickball Asics</span>
        <?php else: ?>
            <a href="index.php?act=sanpham">Giày Bóng Đá</a>
        <?php endif; ?>
        <span>/</span>
        <span style="color: #0f172a; font-weight: 700;"><?php echo htmlspecialchars($chi_tiet['ten_sanpham']); ?></span>
    </div>

    <!-- Main Two Columns -->
    <div class="detail-main-grid">
        
        <!-- LEFT COLUMN: Image Gallery Grid -->
        <div>
            <div class="gallery-layout-grid">
                <!-- Main showcasing image (full width) -->
                <div class="gallery-box gallery-full-width" style="height: 380px;">
                    <img src="<?php echo $chi_tiet['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($chi_tiet['ten_sanpham']); ?>" id="main-product-img">
                </div>
                
                <?php if ($is_pickleball && strpos($name_lower, 'asics') !== false): ?>
                    <!-- Extra alternate view screenshots matching layout -->
                    <div class="gallery-box" style="height: 180px;">
                        <img src="uploads/asics_court_ff_3.svg" style="transform: scaleX(-1);">
                    </div>
                    <div class="gallery-box" style="height: 180px;">
                        <img src="uploads/asics_game_ff.svg">
                    </div>
                    <div class="gallery-box" style="height: 180px;">
                        <img src="uploads/asics_gel_challenger_15.svg">
                    </div>
                    <div class="gallery-box" style="height: 180px;">
                        <img src="uploads/asics_upcourt_6_pink.svg">
                    </div>
                <?php else: ?>
                    <div class="gallery-box" style="height: 180px;">
                        <img src="<?php echo $chi_tiet['hinh_anh']; ?>" style="opacity: 0.8;">
                    </div>
                    <div class="gallery-box" style="height: 180px;">
                        <img src="<?php echo $chi_tiet['hinh_anh']; ?>" style="transform: scaleX(-1); opacity: 0.7;">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- RIGHT COLUMN: Order actions, vouchers, paylater, store inventories -->
        <div class="detail-info-pane">
            <a href="#" class="detail-brand-badge"><?php echo $brand; ?></a>
            <h1 class="detail-title-h1"><?php echo htmlspecialchars($chi_tiet['ten_sanpham']); ?></h1>

            <!-- Price display -->
            <div style="margin-bottom: 20px;">
                <div style="display: flex; align-items: baseline; gap: 12px;">
                    <span style="color: #ef4444; font-size: 24px; font-weight: 900;"><?php echo number_format($chi_tiet['gia_giam'] ?? $chi_tiet['gia'], 0, ',', '.'); ?>đ</span>
                    <?php if ($chi_tiet['gia_giam'] > 0): ?>
                        <span style="color: #94a3b8; font-size: 15px; text-decoration: line-through; font-weight: 600;"><?php echo number_format($chi_tiet['gia'], 0, ',', '.'); ?>đ</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Green shipping check badges -->
            <div class="badge-green-row">
                <div class="badge-green-item"><i class="fa-solid fa-circle-check"></i> Miễn phí vận chuyển toàn quốc</div>
                <div class="badge-green-item"><i class="fa-solid fa-circle-check"></i> Tặng kèm tất dệt kim cao cấp cho mỗi đôi giày</div>
            </div>

            <!-- Detailed specifications -->
            <ul class="bullets-list">
                <li><span>Upper lưới mesh kết hợp da tổng hợp, ôm chân và thoáng khí</span></li>
                <li><span>Đệm FLYTEFOAM kết hợp GEL Cushioning êm ái, giảm chấn hiệu quả</span></li>
                <li><span>Công nghệ TWISTRUSS + thiết kế MONO-SOCK tăng độ ổn định</span></li>
                <li><span>Đế cao su AHAR PLUS bền bỉ, bám sân tốt</span></li>
                <li><span>Phù hợp thi đấu tennis & pickleball trên sân cứng, cường độ cao</span></li>
            </ul>

            <!-- MÀU SẮC KHÁC -->
            <div class="color-pills-label">Màu sắc khác</div>
            <div class="color-pills-grid">
                <?php if ($is_pickleball): ?>
                    <a href="index.php?act=chitiet&id=81" class="color-pill-thumbnail <?php echo ($chi_tiet['id'] == 81) ? 'active' : ''; ?>">
                        <img src="uploads/asics_court_ff_3.svg">
                    </a>
                    <a href="index.php?act=chitiet&id=82" class="color-pill-thumbnail <?php echo ($chi_tiet['id'] == 82) ? 'active' : ''; ?>">
                        <img src="uploads/asics_game_ff.svg">
                    </a>
                    <a href="index.php?act=chitiet&id=83" class="color-pill-thumbnail <?php echo ($chi_tiet['id'] == 83) ? 'active' : ''; ?>">
                        <img src="uploads/asics_gel_challenger_15.svg">
                    </a>
                    <a href="index.php?act=chitiet&id=95" class="color-pill-thumbnail <?php echo ($chi_tiet['id'] == 95) ? 'active' : ''; ?>">
                        <img src="uploads/asics_upcourt_6_pink.svg">
                    </a>
                <?php else: ?>
                    <div class="color-pill-thumbnail active">
                        <img src="<?php echo $chi_tiet['hinh_anh']; ?>">
                    </div>
                <?php endif; ?>
            </div>

            <!-- Submit form -->
            <form action="index.php?act=add-to-cart" method="POST">
                <input type="hidden" name="id" value="<?php echo $chi_tiet['id']; ?>">
                
                <!-- CHỌN SIZE section -->
                <div class="size-picker-header">
                    <span style="font-size: 11px; font-weight: 900; color: #0f172a;">CHỌN SIZE <span style="color:#ef4444;">*</span></span>
                    <div>
                        <button type="button" class="size-tab-btn active">EU</button>
                        <button type="button" class="size-tab-btn">US</button>
                        <button type="button" class="size-tab-btn">UK</button>
                        <button type="button" class="size-tab-btn">JP</button>
                        <span style="color:#cbd5e1; margin:0 6px;">|</span>
                        <a href="#" style="font-size:10px; font-weight:800; color:#3b82f6; text-decoration:none;">Size Guide</a>
                    </div>
                </div>
                <div class="size-picker-body">
                    <?php foreach ($sizes_list as $sz): ?>
                        <div class="size-grid-box" onclick="selectSize('<?php echo $sz; ?>', this)"><?php echo $sz; ?></div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="size" id="selected-size-input" required>

                <!-- Quà tặng kèm -->
                <div class="gift-panel-box">
                    <div class="gift-panel-heading">Quà tặng kèm</div>
                    <div style="font-size: 11px; color:#64748b;">Đã chọn tự động — bạn có thể thay đổi</div>
                    
                    <div class="gift-item-row">
                        <input type="radio" name="gift" value="socks" checked>
                        <img src="uploads/gift_socks.svg" class="gift-item-img">
                        <div style="flex-grow:1;">
                            <div style="font-size:12px; font-weight:800; color:#0f172a;">Tất thể thao T20 - màu trắng</div>
                            <div style="font-size:11px; color:#94a3b8;"><span style="text-decoration:line-through; margin-right:6px;">20.000đ</span> <span style="color:#16a34a; font-weight:800;">Miễn phí</span></div>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart / Quantity selection row -->
                <div style="display: flex; gap: 15px; margin-bottom: 25px;">
                    <div style="display: flex; align-items: center; border: 1.5px solid #cbd5e1; border-radius: 6px; overflow: hidden; background: #fff; width: 100px;">
                        <button type="button" onclick="changeDetailQty(-1)" style="padding: 12px 14px; border: none; background: none; font-size: 16px; font-weight: 800; cursor: pointer; color: #64748b;">&minus;</button>
                        <input type="number" name="quantity" id="detail-qty-input" value="1" min="1" max="10" readonly style="flex: 1; border: none; text-align: center; font-size: 14px; font-weight: 800; color: #0f172a; outline: none; background: none;">
                        <button type="button" onclick="changeDetailQty(1)" style="padding: 12px 14px; border: none; background: none; font-size: 16px; font-weight: 800; cursor: pointer; color: #64748b;">&plus;</button>
                    </div>
                    
                    <button type="submit" class="submit-order-btn">CHỌN MUA</button>
                </div>
            </form>

            <!-- HỆ THỐNG CỬA HÀNG -->
            <div class="store-list-box">
                <div class="store-list-header">
                    <i class="fa-solid fa-store"></i> HỆ THỐNG CỬA HÀNG <span style="font-size:9px; background:#fff; color:#e11d48; padding:1px 6px; border-radius:10px; margin-left:auto;">4 cửa hàng</span>
                </div>
                <div style="background:#ffffff;">
                    <div class="store-location-item">
                        <div class="store-location-name">KHO ONLINE <span class="store-status-badge">Còn hàng</span></div>
                        <div class="store-location-address">8:30 - 21:00</div>
                    </div>
                    <div class="store-location-item">
                        <div class="store-location-name">SPORT9 THANH XUÂN <span class="store-status-badge">Còn hàng</span></div>
                        <div class="store-location-address">27 Nguyễn Viết Xuân, Khương Mai, Thanh Xuân, Hà Nội</div>
                    </div>
                    <div class="store-location-item">
                        <div class="store-location-name">SPORT9 PHẠM NGỌC THẠCH <span class="store-status-badge">Còn hàng</span></div>
                        <div class="store-location-address">Kiốt 11-B7 Phạm Ngọc Thạch, Đống Đa, Hà Nội</div>
                    </div>
                    <div class="store-location-item">
                        <div class="store-location-name">SPORT9 MAI DỊCH <span class="store-status-badge">Còn hàng</span></div>
                        <div class="store-location-address">155 Mai Dịch, Cầu Giấy, Hà Nội</div>
                    </div>
                </div>
            </div>

            <!-- Store Gallery Banner Showcase -->
            <div style="margin-top: 15px; margin-bottom: 20px; border-radius: 8px; overflow: hidden; border: 1.5px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); background: #ffffff;">
                <img src="assets/images/store_gallery.png" alt="Hệ thống cửa hàng Sport9" style="width: 100%; height: auto; display: block; object-fit: contain;">
            </div>

            <!-- Paylater Banner Widget -->
            <div class="paylater-box">
                <div class="paylater-bar">MUA NGAY - TRẢ SAU <span style="color:#ef4444;">HOME PayLater</span></div>
                <table class="paylater-table">
                    <tr>
                        <td>Giảm 10% – tối đa 500.000đ khi chọn kỳ hạn 6 &amp; 12 tháng cho khách hàng mới</td>
                        <td><span class="paylater-badge">Ưu đãi hot</span></td>
                    </tr>
                    <tr>
                        <td>Giảm 3% – tối đa 100.000đ với kỳ hạn 3 tháng cho khách hàng mới</td>
                        <td><span class="paylater-badge">Ưu đãi hot</span></td>
                    </tr>
                    <tr>
                        <td>Giảm 3% – tối đa 100.000đ với kỳ hạn 3 tháng cho khách hàng đã phát sinh đơn hàng HPL</td>
                        <td><span class="paylater-badge" style="background:#f97316;">Siêu hot</span></td>
                    </tr>
                </table>
            </div>

            <div class="bottom-bullets">
                <div class="bottom-bullet-item"><i class="fa-solid fa-circle-check"></i> Chính hãng, fullbox</div>
                <div class="bottom-bullet-item"><i class="fa-solid fa-circle-check"></i> Giao hàng COD</div>
                <div class="bottom-bullet-item"><i class="fa-solid fa-circle-check"></i> Đổi size miễn phí</div>
                <div class="bottom-bullet-item"><i class="fa-solid fa-circle-check"></i> Bảo hành 6 tháng</div>
            </div>

        </div>

    </div>

    <!-- Product description -->
    <section class="section" style="border-top: 1px solid #cbd5e1; padding-top: 30px; margin-top: 30px;">
        <h2 style="font-size:20px; font-weight:900; text-transform:uppercase; text-align:center; margin-bottom: 25px; letter-spacing:0.5px;">MÔ TẢ CHI TIẾT SẢN PHẨM</h2>
        <div style="font-size: 14px; color:#475569; line-height:1.7; text-align:justify;">
            <p><?php echo nl2br(htmlspecialchars($chi_tiet['mo_ta'])); ?></p>
            <div style="display:flex; justify-content:center; margin: 25px 0;">
                <img src="<?php echo $chi_tiet['hinh_anh']; ?>" style="max-width:450px; width:100%; height:auto; border-radius:8px; border:1px solid #e2e8f0;">
            </div>
            <button type="button" class="toggle-content-btn">XEM THÊM NỘI DUNG</button>
        </div>
    </section>

    <!-- Comments Section -->
    <section class="section" style="margin-top: 30px; background-color: var(--white); border: 1px solid var(--border-color); padding: 40px; border-radius: var(--radius);">
        <div class="section-title" style="margin-bottom: 25px;">
            <h2>Bình luận <span>sản phẩm (<?php echo count($ds_binhluan); ?>)</span></h2>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px; max-height: 400px; overflow-y: auto; padding-right: 10px; margin-bottom: 30px;">
            <?php if (count($ds_binhluan) > 0): ?>
                <?php foreach ($ds_binhluan as $bl): ?>
                    <div style="border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <span style="font-weight: 700; font-size: 14px; color: var(--text-dark); display: flex; align-items: center; gap: 6px;">
                                <i class="fa-regular fa-circle-user" style="font-size: 16px; color: var(--text-muted);"></i>
                                <?php echo htmlspecialchars($bl['user']); ?>
                            </span>
                            <span style="font-size: 12px; color: var(--text-muted);"><i class="fa-regular fa-calendar" style="margin-right: 3px;"></i> <?php echo $bl['ngay_binh_luan']; ?></span>
                        </div>
                        <p style="font-size: 14px; color: #475569; line-height: 1.5; padding-left: 22px;">
                            <?php echo nl2br(htmlspecialchars($bl['noi_dung'])); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 30px; color: var(--text-muted);">
                    <i class="fa-regular fa-comments" style="font-size: 32px; display: block; margin-bottom: 8px;"></i>
                    Chưa có bình luận nào cho sản phẩm này. Hãy là người đầu tiên chia sẻ cảm nhận!
                </div>
            <?php endif; ?>
        </div>

        <div style="border-top: 1px dashed var(--border-color); padding-top: 25px;">
            <?php if (isset($_SESSION['user'])): ?>
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 15px;">Viết bình luận của bạn</h3>
                <form action="index.php?act=chitiet&id=<?php echo $chi_tiet['id']; ?>" method="POST">
                    <div class="form-group">
                        <textarea name="noi_dung" rows="3" class="form-control" placeholder="Nhập cảm nhận của bạn về phom giày, chất lượng da, độ bám sân..." required style="resize: vertical; min-height: 80px;"></textarea>
                    </div>
                    <button type="submit" name="guibinhluan" class="btn-primary" style="padding: 10px 20px; font-size: 14px; border-radius: 6px; margin-top: 10px; display: inline-flex; align-items: center; gap: 8px;">
                        Gửi bình luận <i class="fa-regular fa-paper-plane"></i>
                    </button>
                </form>
            <?php else: ?>
                <div style="background-color: #f8fafc; border: 1px solid var(--border-color); padding: 15px; border-radius: 6px; text-align: center; font-size: 14px;">
                    Bạn cần <a href="index.php?act=dangnhap" style="color: var(--primary-dark); font-weight: 700; text-decoration: underline;">Đăng nhập</a> hoặc <a href="index.php?act=dangky" style="color: var(--primary-dark); font-weight: 700; text-decoration: underline;">Đăng ký</a> để gửi bình luận cho sản phẩm này.
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Related Products Section (Asics shoes / paddles matching) -->
    <section class="section" style="margin-top: 40px; border-top: 1px solid #cbd5e1; padding-top: 30px;">
        <div class="section-title">
            <h2>Sản phẩm <span>liên quan</span></h2>
            <a href="index.php?act=pickleball" class="view-all">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="product-grid">
            <?php foreach ($ds_cungloai as $sp): ?>
                <div class="product-card">
                    <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" class="product-img-wrapper" style="height:170px; display:flex; align-items:center; justify-content:center;">
                        <img src="<?php echo $sp['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($sp['ten_sanpham']); ?>" style="max-height:100%; max-width:100%; object-fit:contain;">
                        <?php if ($sp['gia_giam'] > 0): ?>
                            <?php 
                                $percent = round((($sp['gia'] - $sp['gia_giam']) / $sp['gia']) * 100);
                            ?>
                            <span class="badge-tag sale" style="background:#ef4444; color:white; font-size:10px; font-weight:900; padding:2px 6px; border-radius:4px; position:absolute; top:10px; left:10px;">-<?php echo $percent; ?>%</span>
                        <?php endif; ?>
                    </a>
                    <div class="product-info" style="padding:15px; display:flex; flex-direction:column; gap:5px;">
                        <span class="product-cat" style="font-size:10px; font-weight:800; color:#94a3b8; text-transform:uppercase;">
                            <?php 
                            $rel_name_lower = strtolower($sp['ten_sanpham']);
                            $rel_brand = 'Khác';
                            if (strpos($rel_name_lower, 'nike') !== false) $rel_brand = 'Nike';
                            elseif (strpos($rel_name_lower, 'adidas') !== false) $rel_brand = 'Adidas';
                            elseif (strpos($rel_name_lower, 'mizuno') !== false) $rel_brand = 'Mizuno';
                            elseif (strpos($rel_name_lower, 'puma') !== false) $rel_brand = 'Puma';
                            elseif (strpos($rel_name_lower, 'kamito') !== false) $rel_brand = 'Kamito';
                            elseif (strpos($rel_name_lower, 'zocker') !== false) $rel_brand = 'Zocker';
                            elseif (strpos($rel_name_lower, 'wika') !== false) $rel_brand = 'Wika';
                            elseif (strpos($rel_name_lower, 'kelme') !== false) $rel_brand = 'Kelme';
                            elseif (strpos($rel_name_lower, 'asics') !== false) $rel_brand = 'Asics';
                            elseif (strpos($rel_name_lower, 'joola') !== false) $rel_brand = 'Joola';
                            elseif (strpos($rel_name_lower, 'babolat') !== false) $rel_brand = 'Babolat';
                            elseif (strpos($rel_name_lower, 'selkirk') !== false) $rel_brand = 'Selkirk';
                            elseif (strpos($rel_name_lower, 'facolos') !== false) $rel_brand = 'Facolos';
                            elseif (strpos($rel_name_lower, 'franklin') !== false) $rel_brand = 'Franklin';
                            elseif (strpos($rel_name_lower, 'voltano') !== false) $rel_brand = 'Voltano';
                            elseif (strpos($rel_name_lower, 'joma') !== false) $rel_brand = 'Joma';
                            echo $rel_brand;
                            ?>
                        </span>
                        <h3 class="product-title" style="font-size:13px; font-weight:800; line-height:1.4; height:36px; overflow:hidden; text-overflow:ellipsis; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; margin:0;">
                            <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" style="color:#0f172a; text-decoration:none;"><?php echo htmlspecialchars($sp['ten_sanpham']); ?></a>
                        </h3>
                        <div style="font-size:10px; color:#cbd5e1; font-weight:600; margin-bottom:5px;">
                            Size: <?php 
                            if ($sp['id_danhmuc'] == 5) {
                                echo htmlspecialchars(implode(', ', get_pickleball_sizes_detail($sp['ten_sanpham'])));
                            } else {
                                echo "39, 40, 41, 42, 43";
                            }
                            ?>
                        </div>
                        <div class="product-price-row" style="display:flex; align-items:baseline; gap:8px;">
                            <?php if ($sp['gia_giam'] > 0): ?>
                                <span class="price" style="color:#ef4444; font-weight:900; font-size:14px;"><?php echo number_format($sp['gia_giam'], 0, ',', '.'); ?>đ</span>
                                <span class="price-old" style="color:#94a3b8; font-size:10px; text-decoration:line-through; font-weight:600;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                            <?php else: ?>
                                <span class="price" style="color:#0f172a; font-weight:900; font-size:14px;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</div>

<script>
function selectSize(sizeVal, element) {
    // Reset active box styles
    document.querySelectorAll('.size-grid-box').forEach(box => {
        box.classList.remove('active');
    });
    
    // Set active
    element.classList.add('active');
    document.getElementById('selected-size-input').value = sizeVal;
}

function changeDetailQty(amt) {
    const inp = document.getElementById('detail-qty-input');
    let val = parseInt(inp.value) + amt;
    if (val < 1) val = 1;
    if (val > 10) val = 10;
    inp.value = val;
}
</script>
