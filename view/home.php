<!-- Home Page View (trangchu) -->
<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=trangchu");
    exit();
}
?>

<section style="position: relative; height: 500px; background-color: #000; color: var(--white); overflow: hidden; display: flex; align-items: center;">
    
    <!-- Slides Wrapper -->
    <div id="hero-slider" style="width: 100%; height: 100%; position: relative;">
        
        <?php foreach ($banners_slider as $index => $banner): ?>
            <!-- Slide Item -->
            <div class="hero-slide <?php echo ($index === 0) ? 'active' : ''; ?>" 
                 data-index="<?php echo $index; ?>"
                 style="position: absolute; width: 100%; height: 100%; opacity: <?php echo ($index === 0) ? '1' : '0'; ?>; transition: opacity 0.8s ease-in-out; z-index: <?php echo ($index === 0) ? '2' : '1'; ?>;">
                
                <a href="<?php echo htmlspecialchars($banner['lien_ket']); ?>" style="display: block; width: 100%; height: 100%; position: relative;">
                    <!-- Full-bleed background banner image -->
                    <img src="<?php echo $banner['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($banner['ten_banner']); ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                </a>
            </div>
        <?php endforeach; ?>
        
    </div>

    <!-- Slider Navigation Buttons -->
    <button id="prev-slide" style="position: absolute; left: 25px; top: 50%; transform: translateY(-50%); z-index: 15; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255,255,255,0.15); color: #fff; width: 48px; height: 48px; border-radius: 50%; font-size: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button id="next-slide" style="position: absolute; right: 25px; top: 50%; transform: translateY(-50%); z-index: 15; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255,255,255,0.15); color: #fff; width: 48px; height: 48px; border-radius: 50%; font-size: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <!-- Slider Dots (Pill style bars) -->
    <div style="position: absolute; bottom: 25px; left: 50%; transform: translateX(-50%); z-index: 15; display: flex; gap: 8px;">
        <?php foreach ($banners_slider as $index => $banner): ?>
            <span class="slider-dot <?php echo ($index === 0) ? 'active' : ''; ?>" 
                  data-index="<?php echo $index; ?>"
                  style="width: <?php echo ($index === 0) ? '24px' : '12px'; ?>; height: 4px; border-radius: 2px; background-color: <?php echo ($index === 0) ? 'var(--primary)' : 'rgba(255,255,255,0.4)'; ?>; cursor: pointer; transition: all 0.3s ease;"></span>
        <?php endforeach; ?>
    </div>
</section>

<!-- Deal Tốt - Giá Hời (Hot Deals) Section -->
<section class="section hot-deals-section" style="background: linear-gradient(135deg, #ffffff 0%, #fef2f2 100%); padding: 50px 0; border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <!-- Deal Header -->
        <div class="deal-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                <div class="deal-title-wrapper" style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-fire-flame-curved" style="color: #ef4444; font-size: 28px; animation: pulse 1.5s infinite;"></i>
                    <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; color: #1e293b; margin: 0; letter-spacing: -0.5px;">DEAL TỐT - <span style="color: #ef4444;">GIÁ HỜI</span></h2>
                </div>
                <!-- Countdown -->
                <div class="countdown-container" style="display: flex; align-items: center; gap: 10px; background: #fee2e2; padding: 6px 16px; border-radius: 30px; border: 1px solid #fca5a5;">
                    <span style="font-size: 13px; font-weight: 700; color: #991b1b; text-transform: uppercase;">KẾT THÚC SAU:</span>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span id="hours" style="background: #ef4444; color: #fff; font-weight: 800; font-size: 14px; padding: 4px 8px; border-radius: 4px; min-width: 28px; text-align: center; display: inline-block;">02</span>
                        <span style="font-weight: 800; color: #ef4444;">:</span>
                        <span id="minutes" style="background: #ef4444; color: #fff; font-weight: 800; font-size: 14px; padding: 4px 8px; border-radius: 4px; min-width: 28px; text-align: center; display: inline-block;">45</span>
                        <span style="font-weight: 800; color: #ef4444;">:</span>
                        <span id="seconds" style="background: #ef4444; color: #fff; font-weight: 800; font-size: 14px; padding: 4px 8px; border-radius: 4px; min-width: 28px; text-align: center; display: inline-block;">12</span>
                    </div>
                </div>
            </div>
            
            <!-- Deal Tabs -->
            <div class="deal-tabs" style="display: flex; gap: 8px;">
                <button class="deal-tab-btn active" data-deal-tab="deals" style="padding: 10px 22px; font-weight: 800; border-radius: 25px; border: none; cursor: pointer; transition: all 0.3s ease; font-size: 14px;">Giá Tốt - Deal Hời</button>
                <button class="deal-tab-btn" data-deal-tab="newest" style="padding: 10px 22px; font-weight: 800; border-radius: 25px; border: none; cursor: pointer; transition: all 0.3s ease; font-size: 14px;">Hàng Mới</button>
                <button class="deal-tab-btn" data-deal-tab="bestsellers" style="padding: 10px 22px; font-weight: 800; border-radius: 25px; border: none; cursor: pointer; transition: all 0.3s ease; font-size: 14px;">Bán Chạy</button>
            </div>
        </div>
        
        <!-- Tab Content Panes -->
        <!-- 1. Deals Pane -->
        <div class="deal-tab-pane active" id="deal-pane-deals">
            <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
                <?php foreach ($sp_deals as $sp): ?>
                    <?php 
                        $percent = 0;
                        if ($sp['gia'] > 0 && $sp['gia_giam'] > 0) {
                            $percent = round((($sp['gia'] - $sp['gia_giam']) / $sp['gia']) * 100);
                        }
                        
                        // Custom stock levels and progress bars for hot sale
                        $stock_percent = 85; 
                        $stock_text = "Sắp cháy hàng";
                        if ($sp['id'] == 9) { $stock_percent = 78; $stock_text = "🔥 Vừa bán 45 đôi"; }
                        elseif ($sp['id'] == 10) { $stock_percent = 92; $stock_text = "⚡ Đang cháy hàng"; }
                        elseif ($sp['id'] == 11) { $stock_percent = 65; $stock_text = "🔥 Đang bán chạy"; }
                        elseif ($sp['id'] == 12) { $stock_percent = 40; $stock_text = "🔥 Sắp cháy hàng"; }
                    ?>
                    <div class="product-card hot-sale-card" style="position: relative; border-radius: 12px; overflow: hidden; background: #ffffff; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05); display: flex; flex-direction: column; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
                        
                        <!-- Hot Sale Badge -->
                        <div class="hot-sale-badge" style="position: absolute; top: 12px; left: 12px; z-index: 10; background: linear-gradient(90deg, #ef4444 0%, #f97316 100%); color: #ffffff; font-weight: 800; font-size: 11px; padding: 4px 10px; border-radius: 20px; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3); text-transform: uppercase; letter-spacing: 0.5px;">
                            HOT SALE
                        </div>

                        <!-- Image Wrapper -->
                        <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" class="product-img-wrapper" style="position: relative; display: block; aspect-ratio: 4/3; background: #f8fafc; overflow: hidden; display: flex; align-items: center; justify-content: center; padding: 15px;">
                            <img src="<?php echo $sp['hinh_anh']; ?>" alt="<?php echo htmlspecialchars($sp['ten_sanpham']); ?>" style="max-height: 100%; max-width: 100%; object-fit: contain; transition: transform 0.5s ease;" class="deal-img">
                            <?php if ($percent > 0): ?>
                                <span class="badge-tag sale" style="position: absolute; top: 12px; right: 12px; background: #ef4444; color: #ffffff; font-weight: 800; font-size: 12px; padding: 3px 8px; border-radius: 6px;">-<?php echo $percent; ?>%</span>
                            <?php endif; ?>
                        </a>

                        <!-- Product Info -->
                        <div class="product-info" style="padding: 16px; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;">
                            <div>
                                <span class="product-cat" style="font-size: 11px; font-weight: 800; color: #ef4444; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">
                                    <?php 
                                        if (strpos(strtolower($sp['ten_sanpham']), 'adidas') !== false) echo 'ADIDAS';
                                        elseif (strpos(strtolower($sp['ten_sanpham']), 'puma') !== false) echo 'PUMA';
                                        elseif (strpos(strtolower($sp['ten_sanpham']), 'kelme') !== false) echo 'KELME';
                                        else echo 'SOCCER';
                                    ?>
                                </span>
                                <h3 class="product-title" style="font-size: 15px; font-weight: 700; line-height: 1.4; margin: 0 0 10px 0; min-height: 42px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" style="color: #1e293b; text-decoration: none; transition: color 0.2s;"><?php echo htmlspecialchars($sp['ten_sanpham']); ?></a>
                                </h3>
                            </div>

                            <div>
                                <!-- Color Swatches for Kelme TF (ID 12) -->
                                <?php if ($sp['id'] == 12): ?>
                                    <div class="color-swatches" style="display: flex; gap: 6px; margin-bottom: 12px; align-items: center;">
                                        <span style="font-size: 11px; color: #64748b; font-weight: 600;">Màu sắc:</span>
                                        <span class="swatch-dot active" style="width: 14px; height: 14px; border-radius: 50%; background: #cbd5e1; border: 2px solid #ef4444; cursor: pointer; outline: 1px solid #cbd5e1; outline-offset: 1px;" data-color="Bạc"></span>
                                        <span class="swatch-dot" style="width: 14px; height: 14px; border-radius: 50%; background: #2563eb; border: 2px solid #ffffff; cursor: pointer; outline: 1px solid #cbd5e1;" data-color="Xanh dương"></span>
                                        <span class="swatch-dot" style="width: 14px; height: 14px; border-radius: 50%; background: #1e293b; border: 2px solid #ffffff; cursor: pointer; outline: 1px solid #cbd5e1;" data-color="Đen"></span>
                                    </div>
                                <?php endif; ?>

                                <!-- Price Row -->
                                <div class="product-price-row" style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 12px;">
                                    <?php if ($sp['gia_giam'] > 0): ?>
                                        <span class="price" style="font-size: 17px; font-weight: 800; color: #ef4444;"><?php echo number_format($sp['gia_giam'], 0, ',', '.'); ?>đ</span>
                                        <span class="price-old" style="font-size: 13px; font-weight: 500; color: #94a3b8; text-decoration: line-through;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                    <?php else: ?>
                                        <span class="price" style="font-size: 17px; font-weight: 800; color: #1e293b;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Stock Exhaustion Indicator -->
                                <div class="deal-stock-bar" style="margin-top: 8px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                        <span style="font-size: 11px; font-weight: 700; color: #ef4444;"><?php echo $stock_text; ?></span>
                                        <span style="font-size: 11px; font-weight: 600; color: #64748b;"><?php echo $stock_percent; ?>%</span>
                                    </div>
                                    <div style="width: 100%; height: 6px; background: #fee2e2; border-radius: 3px; overflow: hidden;">
                                        <div style="width: <?php echo $stock_percent; ?>%; height: 100%; background: linear-gradient(90deg, #f97316 0%, #ef4444 100%); border-radius: 3px;"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div style="text-align: center; margin-top: 40px;">
                <a href="index.php?act=sanpham" class="btn-primary" style="background: linear-gradient(90deg, #ef4444 0%, #ea580c 100%); color: #ffffff; font-size: 15px; font-weight: 800; padding: 12px 35px; border-radius: 30px; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); border: none; display: inline-block;">
                    XEM TẤT CẢ <i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i>
                </a>
            </div>
        </div>

        <!-- 2. Newest Pane (Loads 4 latest products) -->
        <div class="deal-tab-pane" id="deal-pane-newest" style="display: none;">
            <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
                <?php foreach (array_slice($sp_turf, 0, 4) as $sp): ?>
                    <div class="product-card" style="border-radius: 12px; overflow: hidden; background: #ffffff; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05); display: flex; flex-direction: column;">
                        <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" class="product-img-wrapper" style="position: relative; display: block; aspect-ratio: 4/3; background: #f8fafc; overflow: hidden; display: flex; align-items: center; justify-content: center; padding: 15px;">
                            <img src="<?php echo $sp['hinh_anh']; ?>" alt="shoe" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                        </a>
                        <div class="product-info" style="padding: 16px; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;">
                            <div>
                                <span class="product-cat" style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 6px;">Mới Nhất</span>
                                <h3 class="product-title" style="font-size: 15px; font-weight: 700; line-height: 1.4; margin: 0 0 10px 0; min-height: 42px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" style="color: #1e293b; text-decoration: none;"><?php echo htmlspecialchars($sp['ten_sanpham']); ?></a>
                                </h3>
                            </div>
                            <div class="product-price-row" style="display: flex; align-items: baseline; gap: 8px;">
                                <?php if ($sp['gia_giam'] > 0): ?>
                                    <span class="price" style="font-size: 16px; font-weight: 800; color: #ef4444;"><?php echo number_format($sp['gia_giam'], 0, ',', '.'); ?>đ</span>
                                    <span class="price-old" style="font-size: 12px; font-weight: 500; color: #94a3b8; text-decoration: line-through;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                <?php else: ?>
                                    <span class="price" style="font-size: 16px; font-weight: 800; color: #1e293b;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 3. Bestsellers Pane (Loads 4 outstanding products) -->
        <div class="deal-tab-pane" id="deal-pane-bestsellers" style="display: none;">
            <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
                <?php foreach (array_slice($ds_dacbiet, 0, 4) as $sp): ?>
                    <div class="product-card" style="border-radius: 12px; overflow: hidden; background: #ffffff; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05); display: flex; flex-direction: column;">
                        <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" class="product-img-wrapper" style="position: relative; display: block; aspect-ratio: 4/3; background: #f8fafc; overflow: hidden; display: flex; align-items: center; justify-content: center; padding: 15px;">
                            <img src="<?php echo $sp['hinh_anh']; ?>" alt="shoe" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                        </a>
                        <div class="product-info" style="padding: 16px; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;">
                            <div>
                                <span class="product-cat" style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 6px;">Bán chạy nhất</span>
                                <h3 class="product-title" style="font-size: 15px; font-weight: 700; line-height: 1.4; margin: 0 0 10px 0; min-height: 42px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" style="color: #1e293b; text-decoration: none;"><?php echo htmlspecialchars($sp['ten_sanpham']); ?></a>
                                </h3>
                            </div>
                            <div class="product-price-row" style="display: flex; align-items: baseline; gap: 8px;">
                                <?php if ($sp['gia_giam'] > 0): ?>
                                    <span class="price" style="font-size: 16px; font-weight: 800; color: #ef4444;"><?php echo number_format($sp['gia_giam'], 0, ',', '.'); ?>đ</span>
                                    <span class="price-old" style="font-size: 12px; font-weight: 500; color: #94a3b8; text-decoration: line-through;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                <?php else: ?>
                                    <span class="price" style="font-size: 16px; font-weight: 800; color: #1e293b;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Outstanding Products Section -->
<section class="section" style="background-color: var(--white); border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <div class="section-title">
            <h2>Sản phẩm <span>nổi bật</span></h2>
            <a href="index.php?act=sanpham" class="view-all">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        
        <div class="product-grid">
            <?php foreach ($ds_dacbiet as $sp): ?>
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
    </div>
</section>

<!-- Sub Banner Promotion Block -->
<?php if (count($banners_sub) > 0): ?>
    <section class="section container" style="padding: 40px 20px;">
        <?php foreach ($banners_sub as $sub): ?>
            <div style="background-color: var(--dark); border-radius: var(--radius); overflow: hidden; display: grid; grid-template-columns: 1fr 1fr; align-items: center; box-shadow: var(--shadow-lg);">
                <div style="padding: 50px; color: var(--white);">
                    <span style="color: var(--primary); font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 10px;">Ưu đãi độc quyền</span>
                    <h2 style="font-size: 32px; font-weight: 800; text-transform: uppercase; line-height: 1.2; margin-bottom: 20px;"><?php echo htmlspecialchars($sub['ten_banner']); ?></h2>
                    <p style="color: #cbd5e1; font-size: 15px; margin-bottom: 25px; line-height: 1.6;">Dòng giày bóng đá làm từ da thật mang lại cảm giác ôm chân tuyệt đối. Ưu đãi số lượng có hạn.</p>
                    <a href="<?php echo htmlspecialchars($sub['lien_ket']); ?>" class="btn-primary">Khám phá bộ sưu tập</a>
                </div>
                <div style="background-color: #1e293b; height: 100%; display: flex; align-items: center; justify-content: center; padding: 30px;">
                    <img src="<?php echo $sub['hinh_anh']; ?>" alt="Sub promo banner" style="max-height: 240px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));">
                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<!-- Dynamic Category Products switcher (tabs) -->
<section class="section" style="background-color: #f1f5f9; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
    <div class="container">
        
        <div class="section-title" style="flex-direction: column; align-items: center; text-align: center; margin-bottom: 40px;">
            <h2>Sản phẩm <span>theo danh mục</span></h2>
            <p style="color: var(--text-muted); font-size: 14px; margin-top: 8px; max-width: 500px;">Dễ dàng lựa chọn dòng giày thích hợp với mặt sân thi đấu của bạn</p>
            
            <!-- Tab buttons -->
            <div class="tabs-list" style="display: flex; gap: 10px; margin-top: 25px; flex-wrap: wrap; justify-content: center;">
                <button class="tab-btn active" data-tab="turf" style="padding: 10px 20px; font-family: var(--font); font-weight: 700; border-radius: 20px; border: none; cursor: pointer; transition: var(--transition);">SÂN CỎ NHÂN TẠO (TF)</button>
                <button class="tab-btn" data-tab="grass" style="padding: 10px 20px; font-family: var(--font); font-weight: 700; border-radius: 20px; border: none; cursor: pointer; transition: var(--transition);">SÂN CỎ TỰ NHIÊN (FG/SG)</button>
                <button class="tab-btn" data-tab="futsal" style="padding: 10px 20px; font-family: var(--font); font-weight: 700; border-radius: 20px; border: none; cursor: pointer; transition: var(--transition);">SÂN FUTSAL (IC)</button>
            </div>
        </div>

        <!-- Tab Panes -->
        <!-- 1. Turf Pane -->
        <div class="tab-pane active" id="tab-turf">
            <div class="product-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px;">
                <?php 
                $sliced_turf = array_slice($sp_turf, 0, 8);
                $reversed_turf = array_reverse($sliced_turf);
                foreach ($reversed_turf as $sp): 
                ?>
                    <div class="product-card" style="position: relative;">
                        <!-- Badges -->
                        <?php if ($sp['id'] >= 104 && $sp['id'] <= 107): ?>
                            <span style="position: absolute; top: 12px; left: 12px; background-color: #ef4444; color: #ffffff; font-weight: 800; font-size: 11px; padding: 4px 8px; border-radius: 4px; text-transform: uppercase; z-index: 10; font-family: var(--font);">HÀNG MỚI VỀ</span>
                        <?php endif; ?>
                        
                        <?php if ($sp['gia_giam'] > 0 && $sp['id'] >= 104 && $sp['id'] <= 107): ?>
                            <?php $percent = round((($sp['gia'] - $sp['gia_giam']) / $sp['gia']) * 100); ?>
                            <span style="position: absolute; top: 12px; right: 12px; background-color: #ef4444; color: #ffffff; font-weight: 800; font-size: 11px; padding: 4px 8px; border-radius: 4px; z-index: 10; font-family: var(--font);">-<?php echo $percent; ?>%</span>
                        <?php endif; ?>

                        <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" class="product-img-wrapper" style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; padding: 15px;">
                            <img src="<?php echo $sp['hinh_anh']; ?>" alt="shoe" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                        </a>
                        <div class="product-info" style="padding: 15px;">
                            <span class="product-cat" style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 5px;">Cỏ Nhân Tạo (TF)</span>
                            <h3 class="product-title" style="font-size: 13.5px; font-weight: 700; height: 50px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; margin-bottom: 10px; line-height: 1.45;">
                                <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" style="color: #1e293b;"><?php echo htmlspecialchars($sp['ten_sanpham']); ?></a>
                            </h3>
                            <div class="product-price-row" style="display: flex; align-items: baseline; gap: 8px;">
                                <?php if ($sp['gia_giam'] > 0): ?>
                                    <span class="price" style="color: #ef4444; font-weight: 800; font-size: 15px;"><?php echo number_format($sp['gia_giam'], 0, ',', '.'); ?>đ</span>
                                    <span class="price-old" style="color: #94a3b8; text-decoration: line-through; font-size: 12px; font-weight: 500;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                <?php else: ?>
                                    <span class="price" style="color: #ef4444; font-weight: 800; font-size: 15px;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: 40px;">
                <a href="index.php?act=sanpham&id_danhmuc=1" style="display: inline-block; padding: 12px 38px; border: 1.5px solid #0f172a; color: #0f172a; background: #ffffff; font-weight: 700; text-transform: uppercase; font-size: 13px; transition: all 0.2s ease; cursor: pointer; letter-spacing: 0.5px;" onmouseover="this.style.background='#0f172a'; this.style.color='#ffffff';" onmouseout="this.style.background='#ffffff'; this.style.color='#0f172a';">XEM THÊM</a>
            </div>
        </div>

        <!-- 2. Grass Pane -->
        <div class="tab-pane" id="tab-grass" style="display: none;">
            <div class="product-grid">
                <?php foreach (array_slice($sp_grass, 0, 4) as $sp): ?>
                    <div class="product-card">
                        <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" class="product-img-wrapper">
                            <img src="<?php echo $sp['hinh_anh']; ?>" alt="shoe">
                        </a>
                        <div class="product-info">
                            <span class="product-cat">Cỏ Tự Nhiên (FG/SG)</span>
                            <h3 class="product-title"><a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>"><?php echo htmlspecialchars($sp['ten_sanpham']); ?></a></h3>
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
            <div style="text-align: center; margin-top: 30px;">
                <a href="index.php?act=sanpham&id_danhmuc=2" class="btn-primary" style="background-color: var(--dark); color: var(--white); font-size: 14px; padding: 10px 25px;">Xem toàn bộ Giày cỏ tự nhiên</a>
            </div>
        </div>

        <!-- 3. Futsal Pane -->
        <div class="tab-pane" id="tab-futsal" style="display: none;">
            <div class="product-grid">
                <?php foreach (array_slice($sp_futsal, 0, 4) as $sp): ?>
                    <div class="product-card">
                        <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" class="product-img-wrapper">
                            <img src="<?php echo $sp['hinh_anh']; ?>" alt="shoe">
                        </a>
                        <div class="product-info">
                            <span class="product-cat">Futsal (IC)</span>
                            <h3 class="product-title"><a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>"><?php echo htmlspecialchars($sp['ten_sanpham']); ?></a></h3>
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
            <div style="text-align: center; margin-top: 30px;">
                <a href="index.php?act=sanpham&id_danhmuc=3" class="btn-primary" style="background-color: var(--dark); color: var(--white); font-size: 14px; padding: 10px 25px;">Xem toàn bộ Giày Futsal</a>
            </div>
        </div>

    </div>
</section>

<!-- Balls New Arrival Section -->
<section class="section container" style="margin-top: 50px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; padding-bottom: 10px;">
        <div>
            <span style="font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase;">Quả Bóng</span>
            <h2 style="font-size: 24px; font-weight: 800; color: #1e293b; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">NEW ARRIVAL</h2>
        </div>
        <a href="index.php?act=sanpham&id_danhmuc=4" style="font-size: 14px; font-weight: 600; color: var(--text-dark); text-decoration: underline;">Xem tất cả</a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px;">
        <?php foreach ($sp_balls as $ball): ?>
            <div class="product-card" style="border: none; padding: 0; box-shadow: none;">
                <a href="index.php?act=chitiet&id=<?php echo $ball['id']; ?>" class="product-image" style="background-color: #f8fafc; aspect-ratio: 1; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 20px;">
                    <img src="<?php echo $ball['hinh_anh']; ?>" alt="<?php echo $ball['ten_sanpham']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                </a>
                <div class="product-info" style="padding: 0;">
                    <span style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px;">KELME</span>
                    <h3 class="product-title" style="font-size: 14px; font-weight: 700; height: 40px; margin-bottom: 10px;">
                        <a href="index.php?act=chitiet&id=<?php echo $ball['id']; ?>" style="color: #1e293b;"><?php echo $ball['ten_sanpham']; ?></a>
                    </h3>
                    <div class="product-price" style="display: flex; align-items: center; gap: 10px;">
                        <span class="price-new" style="color: #ef4444; font-weight: 700; font-size: 15px;"><?php echo number_format($ball['gia_giam'] ?? $ball['gia'], 0, ',', '.'); ?>đ</span>
                        <?php if ($ball['gia_giam']): ?>
                            <span class="price-old" style="text-decoration: line-through; color: #94a3b8; font-size: 12px;"><?php echo number_format($ball['gia'], 0, ',', '.'); ?>đ</span>
                            <span style="background-color: #ef4444; color: white; font-size: 10px; font-weight: bold; padding: 2px 6px; border-radius: 10px;">
                                -<?php echo round((($ball['gia'] - $ball['gia_giam']) / $ball['gia']) * 100); ?>%
                            </span>
                        <?php endif; ?>
                    </div>
                    <!-- Color Swatches Mock -->
                    <div style="display: flex; gap: 6px; margin-top: 15px; align-items: center;">
                        <?php if ($ball['id'] == 69 || $ball['id'] == 70): ?>
                            <img src="assets/images/ball_kelme_1_1782372758164.png" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid #cbd5e1; object-fit: cover;">
                            <img src="assets/images/ball_kelme_2_1782372767938.png" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid #cbd5e1; object-fit: cover;">
                            <div style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid #cbd5e1; background-color: #facc15;"></div>
                            <div style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid #cbd5e1; background-color: #e2e8f0;"></div>
                            <span style="font-size: 12px; font-weight: 600; color: #64748b; margin-left: 4px;">+1</span>
                        <?php else: ?>
                            <div style="width: 24px; height: 24px; border-radius: 50%; border: 2px solid #16a34a; background-color: #16a34a;"></div>
                            <div style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid #cbd5e1; background-color: #facc15;"></div>
                            <div style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid #cbd5e1; background-color: #fef08a;"></div>
                            <div style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid #cbd5e1; background-color: #ffffff;"></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Blog Section (Articles Feed) -->
<section class="section container">
    <div class="section-title">
        <h2>Tin tức <span>& cẩm nang</span></h2>
        <a href="index.php?act=tintuc" class="view-all">Xem tất cả bài viết <i class="fa-solid fa-arrow-right"></i></a>
    </div>

    <!-- Articles Feed Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px;">
        <?php foreach ($ds_baiviet as $bv): ?>
            <article style="background-color: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); display: flex; flex-direction: column; transition: var(--transition);"
                     onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='var(--shadow-lg)';"
                     onmouseout="this.style.transform='none'; this.style.boxShadow='var(--shadow)';">
                
                <a href="index.php?act=chitiet-baiviet&id=<?php echo $bv['id']; ?>" style="display: block; aspect-ratio: 16/9; overflow: hidden; background-color: #f1f5f9;">
                    <img src="<?php echo $bv['hinh_anh']; ?>" alt="blog-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                </a>

                <div style="padding: 22px; display: flex; flex-direction: column; flex-grow: 1;">
                    <span style="font-size: 11px; color: var(--text-muted); font-weight: 600; display: block; margin-bottom: 8px;"><i class="fa-regular fa-calendar"></i> <?php echo $bv['ngay_dang']; ?></span>
                    <h3 style="font-size: 16px; font-weight: 800; line-height: 1.4; margin-bottom: 10px; height: 44px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        <a href="index.php?act=chitiet-baiviet&id=<?php echo $bv['id']; ?>" style="color: var(--text-dark);"><?php echo htmlspecialchars($bv['tieu_de']); ?></a>
                    </h3>
                    <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 15px; height: 58px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                        <?php echo htmlspecialchars($bv['mo_ta_ngan']); ?>
                    </p>
                    <a href="index.php?act=chitiet-baiviet&id=<?php echo $bv['id']; ?>" class="btn-link" style="margin-top: auto; font-size: 13px; font-weight: 700;">Đọc tiếp <i class="fa-solid fa-angle-right"></i></a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<!-- Features & Services Section -->
<section class="section" style="background-color: #1e293b; color: #ffffff; padding: 60px 0; border-top: 5px solid var(--primary);">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; text-align: center;">
            <div style="padding: 20px;">
                <div style="width: 70px; height: 70px; background-color: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; color: var(--primary);">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">Giao Hàng Siêu Tốc</h4>
                <p style="font-size: 13px; color: #94a3b8; line-height: 1.6;">Miễn phí vận chuyển toàn quốc cho đơn hàng từ 1.000.000đ. Nhận hàng trong 2-3 ngày làm việc.</p>
            </div>
            
            <div style="padding: 20px;">
                <div style="width: 70px; height: 70px; background-color: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; color: var(--primary);">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">100% Chính Hãng</h4>
                <p style="font-size: 13px; color: #94a3b8; line-height: 1.6;">Cam kết đền bù gấp 10 lần nếu phát hiện hàng giả. Sản phẩm nhập khẩu chính ngạch đầy đủ tem tag.</p>
            </div>
            
            <div style="padding: 20px;">
                <div style="width: 70px; height: 70px; background-color: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; color: var(--primary);">
                    <i class="fa-solid fa-rotate-left"></i>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">Đổi Trả Dễ Dàng</h4>
                <p style="font-size: 13px; color: #94a3b8; line-height: 1.6;">Hỗ trợ đổi size hoặc trả hàng trong vòng 7 ngày nếu không vừa ý hoặc sản phẩm có lỗi từ nhà sản xuất.</p>
            </div>
            
            <div style="padding: 20px;">
                <div style="width: 70px; height: 70px; background-color: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; color: var(--primary);">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">Hỗ Trợ 24/7</h4>
                <p style="font-size: 13px; color: #94a3b8; line-height: 1.6;">Đội ngũ chuyên viên tư vấn luôn sẵn sàng giải đáp mọi thắc mắc và giúp bạn chọn đôi giày ưng ý nhất.</p>
            </div>
        </div>
    </div>
</section>

<!-- Top Brands Section -->
<section class="section" style="background-color: #f8fafc; padding: 40px 0; border-bottom: 1px solid var(--border-color);">
    <div class="container" style="text-align: center;">
        <p style="font-size: 13px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 25px;">Đối tác & Thương hiệu phân phối chính thức</p>
        
        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 40px; opacity: 0.6;">
            <!-- Brand names as stylized text placeholders (acting as logos) -->
            <div style="font-family: 'Arial Black', Impact, sans-serif; font-size: 28px; font-weight: 900; color: #1e293b; font-style: italic; letter-spacing: -1px;">NIKE</div>
            <div style="font-family: 'Century Gothic', Arial, sans-serif; font-size: 24px; font-weight: 800; color: #1e293b; letter-spacing: 2px;">adidas</div>
            <div style="font-family: 'Times New Roman', Times, serif; font-size: 28px; font-weight: 800; color: #1e293b; letter-spacing: 1px;">MIZUNO</div>
            <div style="font-family: 'Arial Black', sans-serif; font-size: 26px; font-weight: 900; color: #1e293b; letter-spacing: 3px;">PUMA</div>
            <div style="font-family: 'Trebuchet MS', sans-serif; font-size: 24px; font-weight: 800; color: #1e293b; text-transform: uppercase;">Kamito</div>
            <div style="font-family: Arial, sans-serif; font-size: 22px; font-weight: 900; color: #1e293b; letter-spacing: 1px;">WIKA</div>
            <div style="font-family: 'Courier New', Courier, monospace; font-size: 26px; font-weight: 900; color: #1e293b; letter-spacing: -1px;">KELME</div>
        </div>
    </div>
</section>


<!-- SNEAKER Section -->
<style>
@media (max-width: 1024px) {
    #sneaker-container {
        grid-template-columns: repeat(3, 1fr) !important;
    }
}
@media (max-width: 768px) {
    #sneaker-container {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}
</style>
<section class="section" style="background-color: #ffffff; border-top: 1px solid var(--border-color); padding: 50px 0;">
    <div class="container">
        
        <div class="section-title" style="flex-direction: column; align-items: center; text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 30px; font-weight: 800; text-transform: uppercase; color: #1e293b; letter-spacing: 1px;">SNEAKER</h2>
            <p style="color: var(--text-muted); font-size: 14px; margin-top: 8px;">Tổng hợp những mẫu giày Sneaker thể thao thời trang cực Hot</p>
        </div>

        <!-- Sneaker Grid -->
        <div id="sneaker-container" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px;">
            <?php 
            $count = 0;
            foreach ($sp_sneakers as $sp): 
                $count++;
                $display_style = ($count > 10) ? 'display: none;' : 'display: flex;';
            ?>
                <div class="sneaker-item product-card" style="<?php echo $display_style; ?> position: relative; border: 1px solid #f1f5f9; padding: 15px; border-radius: 8px; flex-direction: column; justify-content: space-between; background: #ffffff;">
                    <!-- Trả góp 0% badge -->
                    <span style="position: absolute; top: 12px; left: 12px; background: #facc15; color: #1e293b; font-size: 9px; font-weight: 800; padding: 3px 8px; border-radius: 4px; z-index: 5; text-transform: uppercase; letter-spacing: 0.5px;">Trả góp 0%</span>
                    
                    <!-- Shopping bag icon top-right -->
                    <div style="position: absolute; top: 12px; right: 12px; z-index: 5; color: #94a3b8; font-size: 14px; background: #ffffff; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>

                    <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" class="product-img-wrapper" style="background-color: #f8fafc; display: flex; align-items: center; justify-content: center; padding: 15px; height: 160px; overflow: hidden; border-radius: 6px; margin-bottom: 12px; width: 100%;">
                        <img src="<?php echo $sp['hinh_anh']; ?>" alt="sneaker" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                    </a>
                    
                    <div class="product-info" style="padding: 0; text-align: left; display: flex; flex-direction: column; justify-content: space-between; flex-grow: 1;">
                        <h3 class="product-title" style="font-size: 13.5px; font-weight: 700; height: 54px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 1.4; margin-bottom: 10px;">
                            <a href="index.php?act=chitiet&id=<?php echo $sp['id']; ?>" style="color: #334155; text-decoration: none;"><?php echo htmlspecialchars($sp['ten_sanpham']); ?></a>
                        </h3>
                        <div class="product-price-row" style="margin-top: auto; padding-top: 5px; display: flex; justify-content: center;">
                            <span class="price" style="color: #000000; font-weight: 800; font-size: 16px;"><?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Xem thêm Button -->
        <?php if (count($sp_sneakers) > 10): ?>
            <div style="text-align: center; margin-top: 35px;">
                <button id="load-more-sneakers" style="display: inline-block; padding: 12px 42px; border: 1.5px solid #0f172a; color: #0f172a; background: #ffffff; font-weight: 700; text-transform: uppercase; font-size: 13px; transition: all 0.2s ease; cursor: pointer; letter-spacing: 0.5px;" onmouseover="this.style.background='#0f172a'; this.style.color='#ffffff';" onmouseout="this.style.background='#ffffff'; this.style.color='#0f172a';">XEM THÊM</button>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- Bottom Double Banners (Sneaker Daily + Spa Giày) -->
<section class="section container" style="padding: 40px 20px; border-top: 1px solid #f1f5f9;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
        <!-- Left: Sneaker Daily Story -->
        <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: #1e293b; aspect-ratio: 12/5; min-height: 200px;">
            <img src="assets/images/banner_sneaker_story.svg" alt="Câu chuyện Sneaker Daily" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>
        
        <!-- Right: Spa Giày -->
        <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: #fffbeb; aspect-ratio: 12/5; min-height: 200px; border: 1px solid #fcd34d;">
            <img src="assets/images/banner_sneaker_spa.svg" alt="Dịch vụ hài lòng 100%" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>
    </div>
</section>

<!-- Javascript for Load More (Xem thêm) Sneaker -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const loadMoreBtn = document.getElementById("load-more-sneakers");
    if (loadMoreBtn) {
        let currentVisible = 10;
        const totalItems = <?php echo count($sp_sneakers); ?>;
        const items = document.querySelectorAll(".sneaker-item");

        loadMoreBtn.addEventListener("click", function() {
            let shownCount = 0;
            for (let i = currentVisible; i < items.length; i++) {
                if (shownCount < 10) {
                    items[i].style.display = "flex";
                    shownCount++;
                } else {
                    break;
                }
            }
            currentVisible += shownCount;

            if (currentVisible >= totalItems) {
                loadMoreBtn.style.display = "none";
            }
        });
    }
});
</script>

<!-- Về Chúng Tôi Section -->
<section style="background: #fff; padding: 60px 0; border-top: 1px solid #f1f5f9;">
    <div class="container">
        <div style="display: flex; align-items: center; gap: 60px; flex-wrap: wrap;">

            <!-- Left: Logo -->
            <div style="flex: 0 0 auto; display: flex; flex-direction: column; align-items: center; justify-content: center; min-width: 200px;">
                <img src="assets/images/logo.png" alt="Unifootball Logo"
                     style="width: 180px; height: auto; object-fit: contain; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.10));">
            </div>

            <!-- Right: Content -->
            <div style="flex: 1; min-width: 260px;">
                <div style="font-size: 13px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #94a3b8; margin-bottom: 10px;">Về Chúng Tôi</div>
                <h2 style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; color: #1e293b; margin-bottom: 18px; border-bottom: 2px solid #1e293b; display: inline-block; padding-bottom: 4px;">VỀ CHÚNG TÔI</h2>
                <p style="font-size: 14px; color: #475569; line-height: 1.85; margin-bottom: 20px;">
                    Unifootball – Hệ Thống Giày Bóng Đá Chính Hãng Uy Tín Tại Đà Nẵng. Unifootball là thương hiệu chuyên doanh bán lẻ các sản phẩm bóng đá chính hãng có trụ sở chính tại Đà Nẵng. Với mục tiêu mang lại trải nghiệm chuyên nghiệp cho người chơi thể thao, cửa hàng cung cấp danh mục sản phẩm phong phú từ các thương hiệu toàn cầu như Nike, Adidas, Mizuno, Puma đến các thương hiệu Việt Nam uy tín như Kamito, Wika, Zocker. Tại đây, khách hàng có thể tìm thấy mọi loại giày phù hợp với các mặt sân: từ giày cỏ nhân tạo (TF), cỏ tự nhiên (FG) đến giày Futsal (IC). Unifootball còn chú trọng các dòng sản phẩm đặc thù như giày dành cho người chân bè, giày trẻ em và các phân khúc giá rẻ dưới 800.000 VNĐ để phục vụ mọi đối tượng khách hàng. Ngoài ra, hệ thống còn cung cấp áo thi đấu các CLB (bao gồm giải V-League), găng tay thủ môn và phụ kiện thể thao đi kèm dịch vụ in ấn chất lượng cao.
                </p>
                <a href="index.php?act=gioithieu" style="font-size: 13px; font-weight: 700; color: #1e293b; text-decoration: underline; display: inline-flex; align-items: center; gap: 5px; transition: color 0.2s;">
                    Xem chi tiết <i class="fa-solid fa-angle-right" style="font-size: 11px;"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================== -->
<!-- PHONG CÁCH THI ĐẤU Section (Bottom of Homepage)        -->
<!-- ====================================================== -->
<section style="background: #0f172a; padding: 70px 0; position: relative; overflow: hidden;">
    <!-- Background texture -->
    <div style="position: absolute; inset: 0; background: radial-gradient(ellipse at 20% 50%, rgba(239,68,68,0.08) 0%, transparent 60%), radial-gradient(ellipse at 80% 50%, rgba(59,130,246,0.08) 0%, transparent 60%); pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 1;">
        <!-- Section Header -->
        <div style="text-align: center; margin-bottom: 50px;">
            <span style="display: inline-block; font-size: 11px; font-weight: 800; letter-spacing: 4px; text-transform: uppercase; color: #ef4444; margin-bottom: 12px; background: rgba(239,68,68,0.1); padding: 5px 16px; border-radius: 20px;">DANH MỤC SẢN PHẨM</span>
            <h2 style="font-size: 36px; font-weight: 900; color: #ffffff; text-transform: uppercase; letter-spacing: -1px; margin: 0 0 12px;">
                VỊ TRÍ – <span style="color: #ef4444;">PHONG CÁCH</span>
            </h2>
            <p style="color: #94a3b8; font-size: 15px; max-width: 520px; margin: 0 auto; line-height: 1.6;">Chọn đôi giày phù hợp với phong cách thi đấu và vị trí sở trường của bạn trên sân</p>
        </div>

        <!-- Style Cards Grid CSS -->
        <style>
            .style-card {
                text-decoration: none; 
                display: block; 
                position: relative; 
                border-radius: 14px; 
                overflow: hidden; 
                aspect-ratio: 4/3; 
                border: 1px solid rgba(255,255,255,0.08); 
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.4s ease;
            }
            .style-card:hover {
                transform: translateY(-6px); 
                box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
                border-color: rgba(255,255,255,0.18);
            }
            .style-card-img-wrapper {
                position: absolute; 
                right: 15px; 
                top: 45%; 
                transform: translateY(-50%) rotate(-12deg); 
                width: 170px; 
                height: 125px; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                filter: drop-shadow(0 12px 18px rgba(0,0,0,0.5)); 
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), filter 0.4s ease;
                z-index: 2;
            }
            .style-card:hover .style-card-img-wrapper {
                transform: translateY(-52%) rotate(-5deg) scale(1.08);
                filter: drop-shadow(0 20px 30px rgba(0,0,0,0.65));
            }
        </style>

        <!-- Style Cards Grid - Row 1 -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">

            <!-- Card 1: Tiền Đạo -->
            <a href="index.php?act=sanpham&keyword=Nike&id_danhmuc=1" class="style-card" style="background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);">
                <!-- BG Illustration -->
                <div style="position: absolute; inset: 0; pointer-events: none;">
                    <svg viewBox="0 0 400 300" width="100%" height="100%" style="position: absolute; inset: 0; opacity: 0.12;">
                        <circle cx="320" cy="80" r="120" fill="#ef4444" opacity="0.6"/>
                        <circle cx="80" cy="220" r="80" fill="#f97316" opacity="0.4"/>
                        <path d="M 0 200 Q 200 100 400 180 L 400 300 L 0 300 Z" fill="#ef4444" opacity="0.1"/>
                    </svg>
                </div>
                <!-- Real Shoe Image -->
                <div class="style-card-img-wrapper">
                    <img src="uploads/adidas_f50_messi_tf.png" alt="Tiền đạo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
                <!-- Content -->
                <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 22px 24px; background: linear-gradient(transparent, rgba(0,0,0,0.85));">
                    <div style="font-size: 10px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #ef4444; margin-bottom: 4px;">STRIKER</div>
                    <div style="font-size: 22px; font-weight: 900; color: #ffffff; text-transform: uppercase; letter-spacing: -0.5px;">TIỀN ĐẠO</div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">Tốc độ · Sức mạnh · Dứt điểm</div>
                </div>
                <div style="position: absolute; top: 16px; right: 16px; background: #ef4444; color: #fff; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">Xem ngay →</div>
            </a>

            <!-- Card 2: Tiền Vệ -->
            <a href="index.php?act=sanpham&keyword=Adidas&id_danhmuc=1" class="style-card" style="background: linear-gradient(135deg, #1a2744 0%, #0f172a 100%);">
                <!-- BG Illustration -->
                <div style="position: absolute; inset: 0; pointer-events: none;">
                    <svg viewBox="0 0 400 300" width="100%" height="100%" style="position: absolute; inset: 0; opacity: 0.12;">
                        <circle cx="300" cy="60" r="130" fill="#3b82f6" opacity="0.6"/>
                        <circle cx="100" cy="240" r="70" fill="#06b6d4" opacity="0.4"/>
                    </svg>
                </div>
                <!-- Real Shoe Image -->
                <div class="style-card-img-wrapper">
                    <img src="uploads/nike_phantom_g_pro_tf.png" alt="Tiền vệ" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
                <!-- Content -->
                <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 22px 24px; background: linear-gradient(transparent, rgba(0,0,0,0.85));">
                    <div style="font-size: 10px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #3b82f6; margin-bottom: 4px;">MIDFIELDER</div>
                    <div style="font-size: 22px; font-weight: 900; color: #ffffff; text-transform: uppercase; letter-spacing: -0.5px;">TIỀN VỆ</div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">Kỹ thuật · Tầm nhìn · Chuyền bóng</div>
                </div>
                <div style="position: absolute; top: 16px; right: 16px; background: #3b82f6; color: #fff; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">Xem ngay →</div>
            </a>

            <!-- Card 3: Hậu Vệ -->
            <a href="index.php?act=sanpham&keyword=Mizuno&id_danhmuc=1" class="style-card" style="background: linear-gradient(135deg, #1a2e1a 0%, #0f172a 100%);">
                <!-- BG Illustration -->
                <div style="position: absolute; inset: 0; pointer-events: none;">
                    <svg viewBox="0 0 400 300" width="100%" height="100%" style="position: absolute; inset: 0; opacity: 0.12;">
                        <circle cx="310" cy="70" r="120" fill="#22c55e" opacity="0.6"/>
                        <circle cx="90" cy="230" r="80" fill="#10b981" opacity="0.4"/>
                    </svg>
                </div>
                <!-- Real Shoe Image -->
                <div class="style-card-img-wrapper">
                    <img src="uploads/nike_tiempo_ligera_tf.png" alt="Hậu vệ" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
                <!-- Content -->
                <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 22px 24px; background: linear-gradient(transparent, rgba(0,0,0,0.85));">
                    <div style="font-size: 10px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #22c55e; margin-bottom: 4px;">DEFENDER</div>
                    <div style="font-size: 22px; font-weight: 900; color: #ffffff; text-transform: uppercase; letter-spacing: -0.5px;">HẬU VỆ</div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">Chắc chắn · Bền bỉ · Kiên cường</div>
                </div>
                <div style="position: absolute; top: 16px; right: 16px; background: #22c55e; color: #fff; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">Xem ngay →</div>
            </a>
        </div>

        <!-- Style Cards Grid - Row 2 -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">

            <!-- Card 4: Tốc Độ -->
            <a href="index.php?act=sanpham&keyword=Phantom&id_danhmuc=1" class="style-card" style="background: linear-gradient(135deg, #2d1b4e 0%, #0f172a 100%);">
                <!-- BG Illustration -->
                <div style="position: absolute; inset: 0; pointer-events: none;">
                    <svg viewBox="0 0 400 300" width="100%" height="100%" style="position: absolute; inset: 0; opacity: 0.12;">
                        <circle cx="300" cy="70" r="120" fill="#a855f7" opacity="0.6"/>
                        <circle cx="100" cy="240" r="75" fill="#d946ef" opacity="0.4"/>
                    </svg>
                </div>
                <!-- Real Shoe Image -->
                <div class="style-card-img-wrapper">
                    <img src="uploads/adidas_f50_hyperfast_tf.png" alt="Tốc độ" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
                <!-- Content -->
                <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 22px 24px; background: linear-gradient(transparent, rgba(0,0,0,0.85));">
                    <div style="font-size: 10px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #a855f7; margin-bottom: 4px;">SPEED</div>
                    <div style="font-size: 22px; font-weight: 900; color: #ffffff; text-transform: uppercase; letter-spacing: -0.5px;">TỐC ĐỘ</div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">Siêu nhẹ · Bứt phá · Sprint</div>
                </div>
                <div style="position: absolute; top: 16px; right: 16px; background: #a855f7; color: #fff; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">Xem ngay →</div>
            </a>

            <!-- Card 5: Kỹ Thuật -->
            <a href="index.php?act=sanpham&keyword=Copa&id_danhmuc=1" class="style-card" style="background: linear-gradient(135deg, #2d1f0e 0%, #0f172a 100%);">
                <!-- BG Illustration -->
                <div style="position: absolute; inset: 0; pointer-events: none;">
                    <svg viewBox="0 0 400 300" width="100%" height="100%" style="position: absolute; inset: 0; opacity: 0.12;">
                        <circle cx="300" cy="70" r="120" fill="#f59e0b" opacity="0.6"/>
                        <circle cx="100" cy="240" r="75" fill="#f97316" opacity="0.4"/>
                    </svg>
                </div>
                <!-- Real Shoe Image -->
                <div class="style-card-img-wrapper">
                    <img src="uploads/adidas_predator_tf.png" alt="Kỹ thuật" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
                <!-- Content -->
                <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 22px 24px; background: linear-gradient(transparent, rgba(0,0,0,0.85));">
                    <div style="font-size: 10px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #f59e0b; margin-bottom: 4px;">TECHNIQUE</div>
                    <div style="font-size: 22px; font-weight: 900; color: #ffffff; text-transform: uppercase; letter-spacing: -0.5px;">KỸ THUẬT</div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">Cảm giác bóng · Kiểm soát · Da thật</div>
                </div>
                <div style="position: absolute; top: 16px; right: 16px; background: #f59e0b; color: #fff; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">Xem ngay →</div>
            </a>

            <!-- Card 6: Kiểm Soát -->
            <a href="index.php?act=sanpham&keyword=Predator&id_danhmuc=1" class="style-card" style="background: linear-gradient(135deg, #0c2233 0%, #0f172a 100%);">
                <!-- BG Illustration -->
                <div style="position: absolute; inset: 0; pointer-events: none;">
                    <svg viewBox="0 0 400 300" width="100%" height="100%" style="position: absolute; inset: 0; opacity: 0.12;">
                        <circle cx="300" cy="70" r="120" fill="#0ea5e9" opacity="0.6"/>
                        <circle cx="100" cy="240" r="75" fill="#06b6d4" opacity="0.4"/>
                    </svg>
                </div>
                <!-- Real Shoe Image -->
                <div class="style-card-img-wrapper">
                    <img src="uploads/zocker_winner_energy_db.png" alt="Kiểm soát" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
                <!-- Content -->
                <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 22px 24px; background: linear-gradient(transparent, rgba(0,0,0,0.85));">
                    <div style="font-size: 10px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #0ea5e9; margin-bottom: 4px;">CONTROL</div>
                    <div style="font-size: 22px; font-weight: 900; color: #ffffff; text-transform: uppercase; letter-spacing: -0.5px;">KIỂM SOÁT</div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">Bám sân · Cân bằng · Tầm nhìn</div>
                </div>
                <div style="position: absolute; top: 16px; right: 16px; background: #0ea5e9; color: #fff; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">Xem ngay →</div>
            </a>
        </div>

        <!-- Bottom CTA -->
        <div style="text-align: center; margin-top: 45px;">
            <a href="index.php?act=sanpham" style="display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(135deg, #ef4444, #f97316); color: #ffffff; padding: 14px 40px; border-radius: 30px; font-weight: 800; font-size: 14px; text-decoration: none; letter-spacing: 0.5px; text-transform: uppercase; box-shadow: 0 8px 24px rgba(239,68,68,0.3); transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 32px rgba(239,68,68,0.45)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 24px rgba(239,68,68,0.3)';">
                <i class="fa-solid fa-store"></i> Xem Toàn Bộ Sản Phẩm
            </a>
        </div>
    </div>
</section>

<?php
// ─── Auto-generate shoe SVG images on first page load ──────────────────────
// This block runs silently and only creates files if they don't already exist.
if (!file_exists(__DIR__ . '/../uploads/shoe_68.svg') || !file_exists(__DIR__ . '/../uploads/adidas_f50_messi_tf.png')) {
    $target_dir = __DIR__ . '/../uploads';
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    $palettes = [
        ['base'=>'#ef4444','accent'=>'#fbbf24','sole'=>'#1e293b'],
        ['base'=>'#3b82f6','accent'=>'#06b6d4','sole'=>'#0f172a'],
        ['base'=>'#22c55e','accent'=>'#86efac','sole'=>'#14532d'],
        ['base'=>'#a855f7','accent'=>'#e879f9','sole'=>'#3b0764'],
        ['base'=>'#f97316','accent'=>'#fde68a','sole'=>'#1e293b'],
        ['base'=>'#0ea5e9','accent'=>'#e0f2fe','sole'=>'#0c4a6e'],
        ['base'=>'#1e293b','accent'=>'#94a3b8','sole'=>'#0f172a'],
        ['base'=>'#ec4899','accent'=>'#fbcfe8','sole'=>'#831843'],
        ['base'=>'#f59e0b','accent'=>'#ffffff','sole'=>'#78350f'],
        ['base'=>'#10b981','accent'=>'#a7f3d0','sole'=>'#064e3b'],
        ['base'=>'#6366f1','accent'=>'#c7d2fe','sole'=>'#312e81'],
    ];
    $brands_short = ['NIK','ADI','MZN','PUM','KAM','ZCK','WKA','PAN','JGB','KLM','NMS'];

    for ($i = 1; $i <= 68; $i++) {
        $p   = $palettes[($i-1) % count($palettes)];
        $br  = $brands_short[($i-1) % count($brands_short)];
        $num = str_pad($i, 2, '0', STR_PAD_LEFT);
        $uid = 'h'.$i;
        $svg = '<?xml version="1.0" encoding="UTF-8"?>'.
'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 280 200" width="280" height="200">'.
'<defs>'.
'<linearGradient id="bg_'.$uid.'" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#f8fafc"/><stop offset="100%" stop-color="#e2e8f0"/></linearGradient>'.
'<linearGradient id="body_'.$uid.'" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="'.$p['base'].'"/><stop offset="100%" stop-color="'.$p['sole'].'"/></linearGradient>'.
'<filter id="shd_'.$uid.'"><feDropShadow dx="2" dy="4" stdDeviation="4" flood-color="rgba(0,0,0,0.18)"/></filter>'.
'</defs>'.
'<rect width="280" height="200" fill="url(#bg_'.$uid.')" rx="12"/>'.
'<ellipse cx="148" cy="158" rx="100" ry="12" fill="'.$p['sole'].'" opacity="0.85"/>'.
'<path d="M 48 155 Q 50 100 100 80 Q 130 65 170 85 Q 210 100 238 138 Q 248 155 235 158 Z" fill="url(#body_'.$uid.')" stroke="'.$p['sole'].'" stroke-width="1.5" filter="url(#shd_'.$uid.')"/>'.
'<path d="M 48 155 Q 50 110 90 88 Q 110 78 130 80 Q 90 90 70 120 Z" fill="'.$p['accent'].'" opacity="0.55"/>'.
'<path d="M 120 90 Q 170 100 220 138" stroke="'.$p['accent'].'" stroke-width="8" fill="none" stroke-linecap="round" opacity="0.9"/>'.
'<path d="M 130 80 Q 140 50 155 45 Q 165 43 168 60 Q 162 70 155 78 Z" fill="'.$p['base'].'" stroke="'.$p['accent'].'" stroke-width="1"/>'.
'<line x1="138" y1="75" x2="158" y2="72" stroke="#ffffff" stroke-width="2" opacity="0.8"/>'.
'<line x1="140" y1="82" x2="162" y2="79" stroke="#ffffff" stroke-width="2" opacity="0.8"/>'.
'<circle cx="75" cy="160" r="4" fill="'.$p['accent'].'" stroke="'.$p['sole'].'" stroke-width="1"/>'.
'<circle cx="110" cy="163" r="4" fill="'.$p['accent'].'" stroke="'.$p['sole'].'" stroke-width="1"/>'.
'<circle cx="150" cy="165" r="4" fill="'.$p['accent'].'" stroke="'.$p['sole'].'" stroke-width="1"/>'.
'<circle cx="190" cy="163" r="4" fill="'.$p['accent'].'" stroke="'.$p['sole'].'" stroke-width="1"/>'.
'<circle cx="225" cy="158" r="4" fill="'.$p['accent'].'" stroke="'.$p['sole'].'" stroke-width="1"/>'.
'<rect x="8" y="8" width="54" height="22" rx="4" fill="'.$p['sole'].'" opacity="0.85"/>'.
'<text x="35" y="23" font-family="Arial Black,sans-serif" font-size="10" font-weight="900" fill="'.$p['accent'].'" text-anchor="middle" letter-spacing="1">'.$br.'</text>'.
'<rect x="222" y="8" width="50" height="22" rx="4" fill="'.$p['base'].'" opacity="0.9"/>'.
'<text x="247" y="23" font-family="Arial,sans-serif" font-size="10" font-weight="900" fill="#ffffff" text-anchor="middle">#'.$num.'</text>'.
'</svg>';
        file_put_contents($target_dir.'/shoe_'.$i.'.svg', $svg);
    }

    // Copy real PNG images for 8 turf shoes
    $brain = 'C:/Users/Vinacom/.gemini/antigravity/brain/e0be63cd-6aa9-413c-8655-0089df006eae/';
    $turf_imgs = [
        'adidas_f50_messi_tf_1782467951407.png'     => 'adidas_f50_messi_tf.png',
        'adidas_f50_hyperfast_tf_1782467971520.png' => 'adidas_f50_hyperfast_tf.png',
        'adidas_predator_tf_1782467987134.png'      => 'adidas_predator_tf.png',
        'nike_phantom_g_pro_tf_1782468003716.png'   => 'nike_phantom_g_pro_tf.png',
        'nike_tiempo_ligera_tf_1782468041941.png'   => 'nike_tiempo_ligera_tf.png',
        'nike_tiempo_maestro_tf_1782468057762.png'  => 'nike_tiempo_maestro_tf.png',
        'nike_phantom_g_academy_tf_1782468078375.png'=> 'nike_phantom_g_academy_tf.png',
        'zocker_winner_energy_db_1782468096238.png' => 'zocker_winner_energy_db.png',
    ];
    foreach ($turf_imgs as $src => $dst) {
        if (file_exists($brain.$src) && !file_exists($target_dir.'/'.$dst)) {
            @copy($brain.$src, $target_dir.'/'.$dst);
        }
    }
}
?>

