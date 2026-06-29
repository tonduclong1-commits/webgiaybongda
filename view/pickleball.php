<!-- Pickleball View Page (view/pickleball.php) -->
<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=pickball");
    exit();
}

// Fetch Pickleball products from database
$ds_pickleball = pdo_query("SELECT * FROM sanpham WHERE id_danhmuc = 5 ORDER BY id ASC");

function get_pickleball_sizes($ten_sanpham) {
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

function get_pickleball_gift($ten_sanpham) {
    $name_lower = strtolower($ten_sanpham);
    if (strpos($name_lower, 'lite 4') !== false) {
        return null;
    }
    if (strpos($name_lower, 'giày') !== false || strpos($name_lower, 'asics') !== false || strpos($name_lower, 'nike') !== false || strpos($name_lower, 'babolat') !== false || strpos($name_lower, 'joma') !== false) {
        return "Tất thể thao T20 - màu tr...";
    }
    if (strpos($name_lower, 'vợt') !== false || strpos($name_lower, 'joola') !== false || strpos($name_lower, 'voltano') !== false || strpos($name_lower, 'zocker') !== false || strpos($name_lower, 'selkirk') !== false || strpos($name_lower, 'facolos') !== false || strpos($name_lower, 'kamito') !== false) {
        if (strpos($name_lower, 'bóng') === false && strpos($name_lower, 'balo') === false && strpos($name_lower, 'backpack') === false) {
            return "Cuốn cán vợt pickleball...";
        }
    }
    return null; // No gift for balls/bags
}
?>

<style>
/* Reset and theme styling for Pickleball page */
.pickleball-page-container {
    background-color: #ffffff;
    color: #1e293b;
    font-family: 'Inter', sans-serif;
    padding: 20px 0 60px;
}
.pickleball-breadcrumbs {
    font-size: 12px;
    color: #94a3b8;
    margin-bottom: 25px;
    display: flex;
    gap: 8px;
}
.pickleball-breadcrumbs a {
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
}
.pickleball-breadcrumbs a:hover {
    color: #1e293b;
}

.pickleball-title-row {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 15px;
    overflow-x: auto;
    white-space: nowrap;
}
.pickleball-title-h1 {
    font-size: 26px;
    font-weight: 900;
    color: #0f172a;
    letter-spacing: -0.5px;
    margin: 0;
    text-transform: uppercase;
}
.pickleball-pills-wrap {
    display: flex;
    gap: 8px;
}
.pickleball-pill-tag {
    background-color: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #475569;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    text-transform: uppercase;
    transition: all 0.2s ease;
}
.pickleball-pill-tag:hover, .pickleball-pill-tag.active {
    background-color: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}

/* Two columns main layout */
.pickleball-layout-grid {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 30px;
    margin-top: 10px;
}
@media (max-width: 992px) {
    .pickleball-layout-grid {
        grid-template-columns: 1fr;
    }
}

/* Sidebar styling */
.pickleball-sidebar {
    background: #ffffff;
}
.pickleball-sidebar-title {
    font-size: 20px;
    font-weight: 900;
    font-style: italic;
    color: #0f172a;
    margin: 0 0 20px 0;
    text-transform: uppercase;
    border-bottom: 2.5px solid #0f172a;
    padding-bottom: 8px;
}
.pickleball-filter-section {
    margin-bottom: 25px;
    border-bottom: 1.5px solid #f1f5f9;
    padding-bottom: 20px;
}
.pickleball-filter-heading {
    font-size: 13px;
    font-weight: 900;
    color: #0f172a;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0 0 14px 0;
}
.pickleball-checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.pickleball-checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
}
.pickleball-checkbox-label input {
    width: 17px;
    height: 17px;
    accent-color: #0f172a;
    cursor: pointer;
}

/* Brand grid buttons */
.pickleball-brand-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}
.pickleball-brand-btn {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    color: #1e293b;
    padding: 9px 4px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pickleball-brand-btn:hover, .pickleball-brand-btn.active {
    border-color: #0f172a;
    background: #0f172a;
    color: #ffffff;
}

/* Size grid buttons (TÌM THEO SIZE) */
.pickleball-size-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 6px;
}
.pickleball-size-btn {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    color: #1e293b;
    padding: 8px 1px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    text-align: center;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pickleball-size-btn:hover, .pickleball-size-btn.active {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}

/* Right Content Area */
.pickleball-catalog-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 15px;
}
.pickleball-sort-selector {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
}
.pickleball-sort-select {
    border: 1px solid #cbd5e1;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 800;
    color: #1e293b;
    outline: none;
    cursor: pointer;
    background-color: #ffffff;
    text-transform: uppercase;
}

/* Product Cards Grid */
.pickleball-catalog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}
.pickleball-product-card {
    background: #ffffff;
    border: 1.5px solid #f1f5f9;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    position: relative;
}
.pickleball-product-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 10px 25px rgba(0,0,0,0.03);
}

.pickleball-card-discount {
    position: absolute;
    top: 15px;
    left: 15px;
    background: #ef4444;
    color: white;
    font-size: 10px;
    font-weight: 900;
    padding: 4px 8px;
    border-radius: 4px;
    z-index: 2;
}

.pickleball-card-image-wrap {
    padding: 30px 20px;
    background: #ffffff;
    height: 190px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1.5px solid #f8fafc;
}
.pickleball-card-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}
.pickleball-product-card:hover .pickleball-card-img {
    transform: scale(1.06);
}

.pickleball-card-info {
    padding: 18px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}
.pickleball-card-brand {
    font-size: 11px;
    font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase;
    margin-bottom: 6px;
}
.pickleball-card-name {
    font-size: 14px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.4;
    margin: 0 0 6px 0;
    height: 40px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.pickleball-card-name a {
    color: inherit;
    text-decoration: none;
}
.pickleball-card-size-attr {
    font-size: 11px;
    color: #94a3b8;
    margin-bottom: 15px;
    font-weight: 600;
}
.pickleball-card-price-row {
    display: flex;
    align-items: baseline;
    gap: 8px;
    margin-bottom: 12px;
}
.pickleball-card-price {
    font-size: 16px;
    font-weight: 900;
    color: #ef4444;
}
.pickleball-card-old-price {
    font-size: 11px;
    color: #94a3b8;
    text-decoration: line-through;
    font-weight: 600;
}

/* Light pink promo banner */
.pickleball-card-promo-tag {
    background-color: #fff1f2;
    border: 1px solid #ffe4e6;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 11px;
    font-weight: 700;
    color: #f43f5e;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: auto;
}
.pickleball-card-promo-tag span {
    font-size: 10px;
    background-color: #ef4444;
    color: white;
    padding: 1px 5px;
    border-radius: 3px;
    font-weight: 800;
    text-transform: uppercase;
}

.reset-filter-link {
    font-size: 12px;
    color: #3b82f6;
    text-decoration: none;
    font-weight: 700;
    cursor: pointer;
}
.reset-filter-link:hover {
    text-decoration: underline;
}

/* Pagination container */
.pickleball-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1.5px solid #f1f5f9;
}
.pickleball-page-btn {
    min-width: 38px;
    height: 38px;
    padding: 0 10px;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    color: #0f172a;
    font-size: 13px;
    font-weight: 800;
    border-radius: 4px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}
.pickleball-page-btn:hover, .pickleball-page-btn.active {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}
.pickleball-page-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
}
</style>

<div class="pickleball-page-container">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <div class="pickleball-breadcrumbs">
            <a href="index.php">Trang chủ</a>
            <span>/</span>
            <span style="color: #0f172a; font-weight: 700;">Pickball</span>
        </div>

        <!-- Title and horizontal pills -->
        <div class="pickleball-title-row">
            <h1 class="pickleball-title-h1">Pickball</h1>
            <div class="pickleball-pills-wrap">
                <div class="pickleball-pill-tag" onclick="filterSeries('Voltano Apex')">Voltano Apex</div>
                <div class="pickleball-pill-tag" onclick="filterSeries('Zocker Aspire')">Zocker Aspire</div>
                <div class="pickleball-pill-tag" onclick="filterSeries('Nike Vapor Pro 3')">Nike Vapor Pro 3</div>
                <div class="pickleball-pill-tag" onclick="filterSeries('Nike Vapor 12')">Nike Vapor 12</div>
                <div class="pickleball-pill-tag" onclick="filterSeries('Babolat Jet Mach 4')">Babolat Jet Mach 4</div>
                <div class="pickleball-pill-tag" onclick="filterSeries('Asics Court FF')">Asics Court FF</div>
                <div class="pickleball-pill-tag" onclick="filterSeries('Joola Agassi')">Joola Agassi</div>
                <div class="pickleball-pill-tag" onclick="filterSeries('Joola Hyperion')">Joola Hyperion</div>
                <div class="pickleball-pill-tag" onclick="filterSeries('Joola Perseus')">Joola Perseus</div>
            </div>
        </div>

        <!-- Grid Layout -->
        <div class="pickleball-layout-grid">
            
            <!-- Sidebar Left -->
            <aside class="pickleball-sidebar">
                <h3 class="pickleball-sidebar-title">Bộ lọc</h3>
                
                <!-- Cửa hàng location filter -->
                <div class="pickleball-filter-section">
                    <h4 class="pickleball-filter-heading">Cửa hàng</h4>
                    <div class="pickleball-checkbox-group">
                        <label class="pickleball-checkbox-label">
                            <input type="checkbox" name="store" value="online" checked>
                            Kho Online
                        </label>
                        <label class="pickleball-checkbox-label">
                            <input type="checkbox" name="store" value="tx">
                            Sport9 Thanh Xuân
                        </label>
                        <label class="pickleball-checkbox-label">
                            <input type="checkbox" name="store" value="pnt">
                            Sport9 Phạm Ngọc Thạch
                        </label>
                        <label class="pickleball-checkbox-label">
                            <input type="checkbox" name="store" value="md">
                            Sport9 Mai Dịch
                        </label>
                    </div>
                </div>

                <!-- Thương hiệu button grid -->
                <div class="pickleball-filter-section">
                    <h4 class="pickleball-filter-heading">Thương hiệu</h4>
                    <div class="pickleball-brand-grid">
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('nike', this)">Nike</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('wilson', this)">Wilson</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('adidas', this)">Adidas</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('kamito', this)">Kamito</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('zocker', this)">Zocker</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('jogarbola', this)">Jogarbola</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('akapro', this)">Aka Pro</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('asics', this)">Asics</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('babolat', this)">Babolat</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('dongluc', this)">Động Lực</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('facolos', this)">Facolos</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('franklin', this)">Franklin</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('gearbox', this)">Gearbox</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('joma', this)">Joma</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('joola', this)">Joola</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('kaiwin', this)">Kaiwin</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('leopik', this)">Leopík</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('lotto', this)">Lotto</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('proton', this)">Proton</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('selkirk', this)">Selkirk</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('skechers', this)">Skechers</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('soxter', this)">Soxter</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('sypik', this)">Sypik</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('voltano', this)">Voltano</div>
                        <div class="pickleball-brand-btn" onclick="toggleBrandFilter('wika', this)">Wika</div>
                    </div>
                </div>

                <!-- Tìm theo size -->
                <div class="pickleball-filter-section">
                    <h4 class="pickleball-filter-heading">Tìm theo size</h4>
                    <div class="pickleball-size-grid">
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('13MM', this)">13MM</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('43', this)">43</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('6 QUẢ', this)">6 QUẢ</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('39', this)">39</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('45', this)">45</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('HỘP 3 QUẢ', this)">HỘP 3</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('39.5', this)">39.5</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('16MM', this)">16MM</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('S', this)">S</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('41', this)">41</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('40.5', this)">40.5</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('43.5', this)">43.5</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('35', this)">35</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('37.5', this)">37.5</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('3 QUẢ', this)">3 QUẢ</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('38.5', this)">38.5</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('L', this)">L</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('42.5', this)">42.5</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('44.5', this)">44.5</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('40', this)">40</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('38', this)">38</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('XL', this)">XL</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('44', this)">44</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('42', this)">42</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('36.5', this)">36.5</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('15MM', this)">15MM</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('37', this)">37</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('XXL', this)">XXL</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('M', this)">M</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('36', this)">36</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('14MM', this)">14MM</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('1 QUẢ', this)">1 QUẢ</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('41.5', this)">41.5</div>
                        <div class="pickleball-size-btn" onclick="toggleSizeFilter('35.5', this)">35.5</div>
                    </div>
                </div>

                <!-- Lọc theo giá -->
                <div class="pickleball-filter-section">
                    <h4 class="pickleball-filter-heading">Lọc theo giá</h4>
                    <div class="pickleball-checkbox-group">
                        <label class="pickleball-checkbox-label">
                            <input type="checkbox" name="priceRange" value="under-500" onchange="togglePriceRangeFilter()">
                            Dưới 500.000đ
                        </label>
                        <label class="pickleball-checkbox-label">
                            <input type="checkbox" name="priceRange" value="500-700" onchange="togglePriceRangeFilter()">
                            500.000đ - 700.000đ
                        </label>
                        <label class="pickleball-checkbox-label">
                            <input type="checkbox" name="priceRange" value="700-1000" onchange="togglePriceRangeFilter()">
                            700.000đ - 1.000.000đ
                        </label>
                        <label class="pickleball-checkbox-label">
                            <input type="checkbox" name="priceRange" value="1000-1500" onchange="togglePriceRangeFilter()">
                            1.000.000đ - 1.500.000đ
                        </label>
                        <label class="pickleball-checkbox-label">
                            <input type="checkbox" name="priceRange" value="1500-2000" onchange="togglePriceRangeFilter()">
                            1.500.000đ - 2.000.000đ
                        </label>
                        <label class="pickleball-checkbox-label">
                            <input type="checkbox" name="priceRange" value="2000-3000" onchange="togglePriceRangeFilter()">
                            2.000.000đ - 3.000.000đ
                        </label>
                        <label class="pickleball-checkbox-label">
                            <input type="checkbox" name="priceRange" value="above-3000" onchange="togglePriceRangeFilter()">
                            Trên 3.000.000đ
                        </label>
                    </div>
                </div>
            </aside>



            <!-- Product Grid Catalog Right -->
            <div>
                <!-- Catalog Header sort toolbar -->
                <div class="pickleball-catalog-header">
                    <div style="font-size: 13px; font-weight: 700; color: #475569;">
                        Hiển thị <span id="visibleCount" style="color: #0f172a; font-weight: 800;"><?php echo count($ds_pickleball); ?></span> sản phẩm Pickball
                        <span id="filterLabel" style="display:none; margin-left: 10px; background: #f1f5f9; padding: 4px 10px; border-radius: 12px; font-size: 11px;">
                            Đang lọc <a class="reset-filter-link" onclick="resetPickleballFilters()">Xóa lọc</a>
                        </span>
                    </div>
                    
                    <div class="pickleball-sort-selector">
                        <span>SẮP XẾP THEO</span>
                        <select class="pickleball-sort-select" onchange="sortPickleball(this.value)">
                            <option value="popularity">Phổ biến nhất</option>
                            <option value="price-asc">Giá tăng dần</option>
                            <option value="price-desc">Giá giảm dần</option>
                        </select>
                    </div>
                </div>

                <!-- Product Catalog Grid -->
                <div class="pickleball-catalog-grid" id="pickleballCatalog">
                    <?php if (empty($ds_pickleball)): ?>
                        <div style="grid-column: span 3; text-align:center; padding: 60px 0; color: #94a3b8;">
                            <i class="fa-solid fa-box-open" style="font-size: 40px; margin-bottom: 12px;"></i>
                            <p>Không tìm thấy sản phẩm Pickleball nào.</p>
                        </div>


                    <?php else: ?>
                        <?php foreach ($ds_pickleball as $sp): 
                            $name_lower = strtolower($sp['ten_sanpham']);
                            $brand = 'other';
                            if (strpos($name_lower, 'joola') !== false) $brand = 'joola';
                            elseif (strpos($name_lower, 'voltano') !== false) $brand = 'voltano';
                            elseif (strpos($name_lower, 'zocker') !== false) $brand = 'zocker';
                            elseif (strpos($name_lower, 'nike') !== false) $brand = 'nike';
                            elseif (strpos($name_lower, 'babolat') !== false) $brand = 'babolat';
                            elseif (strpos($name_lower, 'kamito') !== false) $brand = 'kamito';
                            elseif (strpos($name_lower, 'asics') !== false) $brand = 'asics';
                            elseif (strpos($name_lower, 'selkirk') !== false) $brand = 'selkirk';
                            elseif (strpos($name_lower, 'facolos') !== false) $brand = 'facolos';
                            elseif (strpos($name_lower, 'franklin') !== false) $brand = 'franklin';
                            elseif (strpos($name_lower, 'joma') !== false) $brand = 'joma';
                            
                            // Calculate discount percentage
                            $discount_pct = 0;
                            if ($sp['gia_giam'] > 0 && $sp['gia'] > 0) {
                                $discount_pct = round((($sp['gia'] - $sp['gia_giam']) / $sp['gia']) * 100);
                            }
                            
                            $sp_sizes = get_pickleball_sizes($sp['ten_sanpham']);
                            $sp_sizes_str = implode(',', $sp_sizes);
                        ?>
                            <div class="pickleball-product-card" 
                                 data-brand="<?php echo $brand; ?>" 
                                 data-name="<?php echo htmlspecialchars($sp['ten_sanpham']); ?>" 
                                 data-price="<?php echo ($sp['gia_giam'] > 0) ? $sp['gia_giam'] : $sp['gia']; ?>"
                                 data-sizes="<?php echo htmlspecialchars(strtoupper($sp_sizes_str)); ?>">
                                <?php if ($discount_pct > 0): ?>
                                    <div class="pickleball-card-discount">-<?php echo $discount_pct; ?>%</div>
                                <?php endif; ?>
                                
                                <div class="pickleball-card-image-wrap">
                                    <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" style="display: flex; align-items: center; justify-content: center; height: 100%; width: 100%;">
                                        <img src="<?php echo $sp['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($sp['ten_sanpham']); ?>" class="pickleball-card-img">
                                    </a>
                                </div>
                                
                                <div class="pickleball-card-info">
                                    <div class="pickleball-card-brand"><?php echo strtoupper($brand); ?></div>
                                    <h4 class="pickleball-card-name">
                                        <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>">
                                            <?php echo htmlspecialchars($sp['ten_sanpham']); ?>
                                        </a>
                                    </h4>
                                    
                                    <div class="pickleball-card-size-attr">Size: <?php echo htmlspecialchars(implode(', ', $sp_sizes)); ?></div>
                                    
                                    <div class="pickleball-card-price-row">
                                        <?php if ($sp['gia_giam'] > 0): ?>
                                            <span class="pickleball-card-price"><?php echo number_format($sp['gia_giam'], 0, ',', '.'); ?>đ</span>
                                            <span class="pickleball-card-old-price"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                        <?php else: ?>
                                            <span class="pickleball-card-price"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Light pink promo tag -->
                                    <?php 
                                    $gift = get_pickleball_gift($sp['ten_sanpham']);
                                    if ($gift):
                                    ?>
                                        <div class="pickleball-card-promo-tag">
                                            <span>TẶNG</span>
                                            <?php if (strpos(strtolower($sp['ten_sanpham']), 'giày') !== false || strpos(strtolower($sp['ten_sanpham']), 'asics') !== false || strpos(strtolower($sp['ten_sanpham']), 'nike') !== false || strpos(strtolower($sp['ten_sanpham']), 'babolat') !== false): ?>
                                                <i class="fa-solid fa-socks" style="margin-right: 4px;"></i>
                                            <?php else: ?>
                                                <i class="fa-solid fa-scroll" style="margin-right: 4px;"></i>
                                            <?php endif; ?>
                                            <?php echo htmlspecialchars($gift); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Pagination controls -->
                <div class="pickleball-pagination" id="pickleballPagination">
                    <!-- Javascript will render pagination elements here dynamically -->
                </div>
            </div>

        </div>

        <!-- Store Gallery Banner Showcase -->
        <div style="margin-top: 45px; margin-bottom: 20px; border-radius: 8px; overflow: hidden; border: 1.5px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); background: #ffffff;">
            <img src="assets/images/store_gallery.png" alt="Hệ thống cửa hàng Sport9" style="width: 100%; height: auto; display: block; object-fit: contain;">
        </div>

    </div>
</div>

<script>
// Keep state of filters
let activeBrands = [];
let activeSizes = [];
let activePriceRanges = [];
let activeSeries = '';
let currentSort = 'popularity';
let currentPage = 1;
const itemsPerPage = 9;

// Toggle brand filters (multi-select)
function toggleBrandFilter(brandName, btn) {
    brandName = brandName.toLowerCase();
    
    // Reset series active tag since brand takes priority
    document.querySelectorAll('.pickleball-pill-tag').forEach(p => p.classList.remove('active'));
    activeSeries = '';

    if (activeBrands.includes(brandName)) {
        activeBrands = activeBrands.filter(b => b !== brandName);
        if (btn) btn.classList.remove('active');
    } else {
        activeBrands.push(brandName);
        if (btn) btn.classList.add('active');
    }
    
    currentPage = 1;
    applyFilters();
}

// Filter from series tags (pills on top)
function filterSeries(seriesName) {
    // Reset brand and other filters
    document.querySelectorAll('.pickleball-brand-btn').forEach(b => b.classList.remove('active'));
    activeBrands = [];

    document.querySelectorAll('.pickleball-pill-tag').forEach(p => {
        if (p.textContent.toLowerCase() === seriesName.toLowerCase()) {
            p.classList.add('active');
            activeSeries = seriesName.toLowerCase();
        } else {
            p.classList.remove('active');
        }
    });

    currentPage = 1;
    applyFilters();
}

// Toggle size filters (multi-select)
function toggleSizeFilter(sizeVal, btn) {
    sizeVal = sizeVal.toUpperCase();
    if (activeSizes.includes(sizeVal)) {
        activeSizes = activeSizes.filter(s => s !== sizeVal);
        if (btn) btn.classList.remove('active');
    } else {
        activeSizes.push(sizeVal);
        if (btn) btn.classList.add('active');
    }
    
    currentPage = 1;
    applyFilters();
}

// Toggle price range checkboxes (multi-select)
function togglePriceRangeFilter() {
    activePriceRanges = [];
    const checkboxes = document.querySelectorAll('input[name="priceRange"]:checked');
    checkboxes.forEach(cb => {
        activePriceRanges.push(cb.value);
    });
    
    currentPage = 1;
    applyFilters();
}

// Main filter execution logic
function applyFilters() {
    const cards = Array.from(document.querySelectorAll('.pickleball-product-card'));
    let matchedCards = [];

    cards.forEach(card => {
        const brand = card.getAttribute('data-brand').toLowerCase();
        const name = card.getAttribute('data-name').toLowerCase();
        const price = parseFloat(card.getAttribute('data-price'));
        const sizes = card.getAttribute('data-sizes').split(',');

        // 1. Check Brand
        let brandMatch = activeBrands.length === 0 || activeBrands.includes(brand);

        // 2. Check Series
        let seriesMatch = activeSeries === '' || name.includes(activeSeries);

        // 3. Check Sizes
        let sizeMatch = activeSizes.length === 0;
        if (activeSizes.length > 0) {
            for (let s of activeSizes) {
                if (sizes.includes(s)) {
                    sizeMatch = true;
                    break;
                }
            }
        }

        // 4. Check Price
        let priceMatch = activePriceRanges.length === 0;
        if (activePriceRanges.length > 0) {
            for (let range of activePriceRanges) {
                if (range === 'under-500' && price < 500000) priceMatch = true;
                else if (range === '500-700' && price >= 500000 && price <= 700000) priceMatch = true;
                else if (range === '700-1000' && price >= 700000 && price <= 1000000) priceMatch = true;
                else if (range === '1000-1500' && price >= 1000000 && price <= 1500000) priceMatch = true;
                else if (range === '1500-2000' && price >= 1500000 && price <= 2000000) priceMatch = true;
                else if (range === '2000-3000' && price >= 2000000 && price <= 3000000) priceMatch = true;
                else if (range === 'above-3000' && price > 3000000) priceMatch = true;
            }
        }

        if (brandMatch && seriesMatch && sizeMatch && priceMatch) {
            matchedCards.push(card);
        }
        card.style.display = 'none'; // Hide by default
    });

    // Handle sort
    sortCardsArray(matchedCards);

    // Apply pagination
    const totalCount = matchedCards.length;
    document.getElementById('visibleCount').textContent = totalCount;
    
    // Show/hide reset button
    const isFiltered = activeBrands.length > 0 || activeSizes.length > 0 || activePriceRanges.length > 0 || activeSeries !== '';
    document.getElementById('filterLabel').style.display = isFiltered ? 'inline-block' : 'none';

    if (totalCount === 0) {
        document.getElementById('pickleballPagination').innerHTML = '';
        return;
    }

    const totalPages = Math.ceil(totalCount / itemsPerPage);
    if (currentPage > totalPages) currentPage = totalPages;

    const startIdx = (currentPage - 1) * itemsPerPage;
    const endIdx = Math.min(startIdx + itemsPerPage, totalCount);

    // Display only the current page items
    for (let i = startIdx; i < endIdx; i++) {
        matchedCards[i].style.display = 'flex';
    }

    renderPagination(totalPages);
}

// Sort cards
function sortCardsArray(cardsArray) {
    cardsArray.sort((a, b) => {
        const priceA = parseFloat(a.getAttribute('data-price'));
        const priceB = parseFloat(b.getAttribute('data-price'));
        const nameA = a.getAttribute('data-name');
        const nameB = b.getAttribute('data-name');

        if (currentSort === 'price-asc') {
            return priceA - priceB;
        } else if (currentSort === 'price-desc') {
            return priceB - priceA;
        } else {
            // Default sort: alphabetical
            return nameA.localeCompare(nameB);
        }
    });

    // Re-order in DOM
    const catalog = document.getElementById('pickleballCatalog');
    cardsArray.forEach(card => {
        catalog.appendChild(card);
    });
}

function sortPickleball(val) {
    currentSort = val;
    applyFilters();
}

// Render dynamic pagination buttons matching screenshot: [1] [2] [3] [4] [5] [Kế tiếp] [Cuối cùng]
function renderPagination(totalPages) {
    const container = document.getElementById('pickleballPagination');
    container.innerHTML = '';

    if (totalPages <= 1) {
        return; // No need for pagination
    }

    // Previous Page Button
    const prevBtn = document.createElement('button');
    prevBtn.className = 'pickleball-page-btn' + (currentPage === 1 ? ' disabled' : '');
    prevBtn.innerHTML = '<i class="fa-solid fa-angle-left"></i>';
    prevBtn.onclick = () => {
        if (currentPage > 1) {
            currentPage--;
            applyFilters();
            window.scrollTo({ top: 300, behavior: 'smooth' });
        }
    };
    container.appendChild(prevBtn);

    // Page Number Buttons
    for (let i = 1; i <= totalPages; i++) {
        const pageBtn = document.createElement('button');
        pageBtn.className = 'pickleball-page-btn' + (currentPage === i ? ' active' : '');
        pageBtn.textContent = i;
        pageBtn.onclick = () => {
            currentPage = i;
            applyFilters();
            window.scrollTo({ top: 300, behavior: 'smooth' });
        };
        container.appendChild(pageBtn);
    }

    // Next Page Button (Kế tiếp)
    const nextBtn = document.createElement('button');
    nextBtn.className = 'pickleball-page-btn' + (currentPage === totalPages ? ' disabled' : '');
    nextBtn.textContent = 'Kế tiếp';
    nextBtn.onclick = () => {
        if (currentPage < totalPages) {
            currentPage++;
            applyFilters();
            window.scrollTo({ top: 300, behavior: 'smooth' });
        }
    };
    container.appendChild(nextBtn);

    // Last Page Button (Cuối cùng)
    const lastBtn = document.createElement('button');
    lastBtn.className = 'pickleball-page-btn' + (currentPage === totalPages ? ' disabled' : '');
    lastBtn.textContent = 'Cuối cùng';
    lastBtn.onclick = () => {
        if (currentPage !== totalPages) {
            currentPage = totalPages;
            applyFilters();
            window.scrollTo({ top: 300, behavior: 'smooth' });
        }
    };
    container.appendChild(lastBtn);
}

// Reset all filters
function resetPickleballFilters() {
    activeBrands = [];
    activeSizes = [];
    activePriceRanges = [];
    activeSeries = '';
    
    // Reset buttons styles
    document.querySelectorAll('.pickleball-brand-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.pickleball-size-btn').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.pickleball-pill-tag').forEach(p => p.classList.remove('active'));
    
    // Reset checkboxes
    document.querySelectorAll('input[name="priceRange"]').forEach(cb => {
        cb.checked = false;
    });

    currentPage = 1;
    applyFilters();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    applyFilters();
});
</script>
