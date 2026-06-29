<!-- About Us Page View (gioithieu) -->
<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=gioithieu");
    exit();
}

// Auto-copy generated banner images if they don't exist yet
$nike_src  = 'C:/Users/Vinacom/.gemini/antigravity/brain/e0be63cd-6aa9-413c-8655-0089df006eae/nike_banner_1782379549822.png';
$nike_dst  = 'assets/images/nike_banner.png';
$adidas_src = 'C:/Users/Vinacom/.gemini/antigravity/brain/e0be63cd-6aa9-413c-8655-0089df006eae/adidas_banner_1782379564042.png';
$adidas_dst = 'assets/images/adidas_banner.png';
if (!file_exists($nike_dst)   && file_exists($nike_src))   { @copy($nike_src,   $nike_dst); }
if (!file_exists($adidas_dst) && file_exists($adidas_src)) { @copy($adidas_src, $adidas_dst); }
?>


<style>
    .brand-banner-section {
        margin: 50px 0;
    }
    .brand-banner-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }
    @media (max-width: 768px) {
        .brand-banner-row { grid-template-columns: 1fr; }
    }
    .brand-banner-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 16/7;
        display: flex;
        align-items: flex-end;
        cursor: pointer;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .brand-banner-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    .brand-banner-card img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .brand-banner-card:hover img {
        transform: scale(1.05);
    }
    .brand-banner-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.1) 60%, transparent 100%);
        z-index: 1;
    }
    .brand-banner-content {
        position: relative;
        z-index: 2;
        padding: 24px 28px;
        color: white;
        width: 100%;
    }
    .brand-banner-tag {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: rgba(255,255,255,0.7);
        margin-bottom: 6px;
    }
    .brand-banner-title {
        font-size: 24px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -0.5px;
        margin-bottom: 10px;
        line-height: 1.1;
    }
    .brand-banner-btn {
        display: inline-block;
        background: white;
        color: #1e293b;
        font-size: 11px;
        font-weight: 800;
        padding: 7px 18px;
        border-radius: 20px;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: background 0.2s ease;
    }
    .brand-banner-btn:hover {
        background: #f1f5f9;
    }
</style>

<div class="container">
    <div class="info-layout">
        
        <div class="info-header">
            <h1>Giới thiệu cửa hàng</h1>
            <p>Antigravity Sports - Sự lựa chọn số một của các chân sút đích thực</p>
        </div>

        <div class="info-content">
            <h2 style="color: var(--text-dark); font-size: 22px; font-weight: 700; margin-bottom: 15px;">Câu chuyện thương hiệu</h2>
            <p style="margin-bottom: 20px; line-height: 1.8;">
                Được thành lập từ năm 2020, Antigravity Sports tự hào mang đến cho cộng đồng yêu bóng đá Việt Nam những sản phẩm giày đá banh chính hãng tốt nhất. Chúng tôi hiểu rằng, đôi giày không chỉ là phụ kiện bảo vệ đôi chân, mà còn là người bạn đồng hành tin cậy, giúp nâng tầm kỹ thuật và tiếp thêm sự tự tin cho các cầu thủ trên sân đấu.
            </p>

            <p style="margin-bottom: 30px; line-height: 1.8;">
                Chúng tôi chuyên phân phối và cung cấp các dòng sản phẩm giày đá bóng cỏ nhân tạo (TF), cỏ tự nhiên (FG/SG) và trong nhà (IC) đến từ các thương hiệu thể thao nổi tiếng toàn cầu như Nike, Adidas, Puma, Mizuno và Kamito. Tất cả sản phẩm được bán ra đều có đầy đủ giấy tờ, bảo hành chính hãng và hỗ trợ đổi size linh hoạt.
            </p>

            <!-- Brand Slider with navigation arrows -->
            <div class="brand-banner-section">
                <h2 style="color: var(--text-dark); font-size: 22px; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">
                    Thương Hiệu Nổi Bật
                </h2>

                <!-- Slider Container -->
                <div style="position: relative; overflow: hidden; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                    
                    <!-- Slides Track -->
                    <div id="brand-slider-track" style="display: flex; transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); will-change: transform;">

                        <!-- Slide 1: Nike -->
                        <div class="brand-slide" style="min-width: 100%; height: 320px; position: relative; flex-shrink: 0; background: linear-gradient(135deg, #1a0000 0%, #7f1d1d 40%, #991b1b 70%, #b91c1c 100%);">
                            <?php if (file_exists('assets/images/nike_banner.png')): ?>
                                <img src="assets/images/nike_banner.png" alt="Nike" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.6;">
                            <?php endif; ?>
                            <div style="position:absolute;inset:0;background:linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);"></div>
                            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:50px 60px;">
                                <div>
                                    <div style="font-size:11px;font-weight:800;letter-spacing:3px;color:rgba(255,255,255,0.6);text-transform:uppercase;margin-bottom:12px;">Thương Hiệu</div>
                                    <div style="font-size:52px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:-2px;line-height:1;margin-bottom:8px;font-style:italic;">NIKE</div>
                                    <div style="font-size:14px;color:rgba(255,255,255,0.75);margin-bottom:25px;">Tốc Độ &amp; Kĩ Thuật Đỉnh Cao</div>
                                    <a href="index.php?act=sanpham&keyword=Nike" style="display:inline-block;background:#ef4444;color:white;font-size:12px;font-weight:800;padding:10px 24px;border-radius:25px;text-decoration:none;text-transform:uppercase;letter-spacing:1px;">Xem Sản Phẩm &rarr;</a>
                                </div>
                            </div>
                            <div style="position:absolute;top:20px;right:20px;font-size:11px;font-weight:700;background:rgba(255,255,255,0.15);color:white;padding:4px 12px;border-radius:20px;backdrop-filter:blur(8px);">1 / 8</div>
                        </div>

                        <!-- Slide 2: Adidas -->
                        <div class="brand-slide" style="min-width: 100%; height: 320px; position: relative; flex-shrink: 0; background: linear-gradient(135deg, #000814 0%, #023e8a 40%, #0077b6 70%, #00b4d8 100%);">
                            <?php if (file_exists('assets/images/adidas_banner.png')): ?>
                                <img src="assets/images/adidas_banner.png" alt="Adidas" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.6;">
                            <?php endif; ?>
                            <div style="position:absolute;inset:0;background:linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);"></div>
                            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:50px 60px;">
                                <div>
                                    <div style="font-size:11px;font-weight:800;letter-spacing:3px;color:rgba(255,255,255,0.6);text-transform:uppercase;margin-bottom:12px;">Thương Hiệu</div>
                                    <div style="font-size:52px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:-2px;line-height:1;margin-bottom:8px;font-style:italic;">ADIDAS</div>
                                    <div style="font-size:14px;color:rgba(255,255,255,0.75);margin-bottom:25px;">Sáng Tạo Không Ngừng Nghỉ</div>
                                    <a href="index.php?act=sanpham&keyword=Adidas" style="display:inline-block;background:#0077b6;color:white;font-size:12px;font-weight:800;padding:10px 24px;border-radius:25px;text-decoration:none;text-transform:uppercase;letter-spacing:1px;">Xem Sản Phẩm &rarr;</a>
                                </div>
                            </div>
                            <div style="position:absolute;top:20px;right:20px;font-size:11px;font-weight:700;background:rgba(255,255,255,0.15);color:white;padding:4px 12px;border-radius:20px;backdrop-filter:blur(8px);">2 / 8</div>
                        </div>

                        <!-- Slide 3: Puma -->
                        <div class="brand-slide" style="min-width: 100%; height: 320px; position: relative; flex-shrink: 0; background: linear-gradient(135deg, #1a1a00 0%, #713f12 40%, #ca8a04 70%, #facc15 100%);">
                            <div style="position:absolute;inset:0;background:linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);"></div>
                            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:50px 60px;">
                                <div>
                                    <div style="font-size:11px;font-weight:800;letter-spacing:3px;color:rgba(255,255,255,0.6);text-transform:uppercase;margin-bottom:12px;">Thương Hiệu</div>
                                    <div style="font-size:52px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:-2px;line-height:1;margin-bottom:8px;font-style:italic;">PUMA</div>
                                    <div style="font-size:14px;color:rgba(255,255,255,0.75);margin-bottom:25px;">Linh Hoạt &amp; Bứt Phá</div>
                                    <a href="index.php?act=sanpham&keyword=Puma" style="display:inline-block;background:#ca8a04;color:white;font-size:12px;font-weight:800;padding:10px 24px;border-radius:25px;text-decoration:none;text-transform:uppercase;letter-spacing:1px;">Xem Sản Phẩm &rarr;</a>
                                </div>
                            </div>
                            <div style="position:absolute;top:20px;right:20px;font-size:11px;font-weight:700;background:rgba(255,255,255,0.15);color:white;padding:4px 12px;border-radius:20px;backdrop-filter:blur(8px);">3 / 8</div>
                        </div>

                        <!-- Slide 4: Mizuno -->
                        <div class="brand-slide" style="min-width: 100%; height: 320px; position: relative; flex-shrink: 0; background: linear-gradient(135deg, #001219 0%, #005f73 40%, #0a9396 70%, #94d2bd 100%);">
                            <div style="position:absolute;inset:0;background:linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);"></div>
                            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:50px 60px;">
                                <div>
                                    <div style="font-size:11px;font-weight:800;letter-spacing:3px;color:rgba(255,255,255,0.6);text-transform:uppercase;margin-bottom:12px;">Thương Hiệu</div>
                                    <div style="font-size:52px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:-2px;line-height:1;margin-bottom:8px;font-style:italic;">MIZUNO</div>
                                    <div style="font-size:14px;color:rgba(255,255,255,0.75);margin-bottom:25px;">Tinh Hoa Nhật Bản</div>
                                    <a href="index.php?act=sanpham&keyword=Mizuno" style="display:inline-block;background:#0a9396;color:white;font-size:12px;font-weight:800;padding:10px 24px;border-radius:25px;text-decoration:none;text-transform:uppercase;letter-spacing:1px;">Xem Sản Phẩm &rarr;</a>
                                </div>
                            </div>
                            <div style="position:absolute;top:20px;right:20px;font-size:11px;font-weight:700;background:rgba(255,255,255,0.15);color:white;padding:4px 12px;border-radius:20px;backdrop-filter:blur(8px);">4 / 8</div>
                        </div>

                        <!-- Slide 5: Kamito -->
                        <div class="brand-slide" style="min-width: 100%; height: 320px; position: relative; flex-shrink: 0; background: linear-gradient(135deg, #052e16 0%, #166534 40%, #16a34a 70%, #4ade80 100%);">
                            <div style="position:absolute;inset:0;background:linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);"></div>
                            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:50px 60px;">
                                <div>
                                    <div style="font-size:11px;font-weight:800;letter-spacing:3px;color:rgba(255,255,255,0.6);text-transform:uppercase;margin-bottom:12px;">Thương Hiệu</div>
                                    <div style="font-size:52px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:-2px;line-height:1;margin-bottom:8px;font-style:italic;">KAMITO</div>
                                    <div style="font-size:14px;color:rgba(255,255,255,0.75);margin-bottom:25px;">Tự Hào Thương Hiệu Việt</div>
                                    <a href="index.php?act=sanpham&keyword=Kamito" style="display:inline-block;background:#16a34a;color:white;font-size:12px;font-weight:800;padding:10px 24px;border-radius:25px;text-decoration:none;text-transform:uppercase;letter-spacing:1px;">Xem Sản Phẩm &rarr;</a>
                                </div>
                            </div>
                            <div style="position:absolute;top:20px;right:20px;font-size:11px;font-weight:700;background:rgba(255,255,255,0.15);color:white;padding:4px 12px;border-radius:20px;backdrop-filter:blur(8px);">5 / 8</div>
                        </div>

                        <!-- Slide 6: Kelme -->
                        <div class="brand-slide" style="min-width: 100%; height: 320px; position: relative; flex-shrink: 0; background: linear-gradient(135deg, #431407 0%, #9a3412 40%, #ea580c 70%, #fb923c 100%);">
                            <div style="position:absolute;inset:0;background:linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);"></div>
                            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:50px 60px;">
                                <div>
                                    <div style="font-size:11px;font-weight:800;letter-spacing:3px;color:rgba(255,255,255,0.6);text-transform:uppercase;margin-bottom:12px;">Thương Hiệu</div>
                                    <div style="font-size:52px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:-2px;line-height:1;margin-bottom:8px;font-style:italic;">KELME</div>
                                    <div style="font-size:14px;color:rgba(255,255,255,0.75);margin-bottom:25px;">Hiệu Năng Vượt Trội</div>
                                    <a href="index.php?act=sanpham&keyword=Kelme" style="display:inline-block;background:#ea580c;color:white;font-size:12px;font-weight:800;padding:10px 24px;border-radius:25px;text-decoration:none;text-transform:uppercase;letter-spacing:1px;">Xem Sản Phẩm &rarr;</a>
                                </div>
                            </div>
                            <div style="position:absolute;top:20px;right:20px;font-size:11px;font-weight:700;background:rgba(255,255,255,0.15);color:white;padding:4px 12px;border-radius:20px;backdrop-filter:blur(8px);">6 / 8</div>
                        </div>

                        <!-- Slide 7: Zocker -->
                        <div class="brand-slide" style="min-width: 100%; height: 320px; position: relative; flex-shrink: 0; background: linear-gradient(135deg, #1e0036 0%, #4c1d95 40%, #7c3aed 70%, #a78bfa 100%);">
                            <div style="position:absolute;inset:0;background:linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);"></div>
                            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:50px 60px;">
                                <div>
                                    <div style="font-size:11px;font-weight:800;letter-spacing:3px;color:rgba(255,255,255,0.6);text-transform:uppercase;margin-bottom:12px;">Thương Hiệu</div>
                                    <div style="font-size:52px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:-2px;line-height:1;margin-bottom:8px;font-style:italic;">ZOCKER</div>
                                    <div style="font-size:14px;color:rgba(255,255,255,0.75);margin-bottom:25px;">Phong Cách Trẻ Trung Năng Động</div>
                                    <a href="index.php?act=sanpham&keyword=Zocker" style="display:inline-block;background:#7c3aed;color:white;font-size:12px;font-weight:800;padding:10px 24px;border-radius:25px;text-decoration:none;text-transform:uppercase;letter-spacing:1px;">Xem Sản Phẩm &rarr;</a>
                                </div>
                            </div>
                            <div style="position:absolute;top:20px;right:20px;font-size:11px;font-weight:700;background:rgba(255,255,255,0.15);color:white;padding:4px 12px;border-radius:20px;backdrop-filter:blur(8px);">7 / 8</div>
                        </div>

                        <!-- Slide 8: Wika -->
                        <div class="brand-slide" style="min-width: 100%; height: 320px; position: relative; flex-shrink: 0; background: linear-gradient(135deg, #1c0000 0%, #881337 40%, #e11d48 70%, #fb7185 100%);">
                            <div style="position:absolute;inset:0;background:linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);"></div>
                            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:50px 60px;">
                                <div>
                                    <div style="font-size:11px;font-weight:800;letter-spacing:3px;color:rgba(255,255,255,0.6);text-transform:uppercase;margin-bottom:12px;">Thương Hiệu</div>
                                    <div style="font-size:52px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:-2px;line-height:1;margin-bottom:8px;font-style:italic;">WIKA</div>
                                    <div style="font-size:14px;color:rgba(255,255,255,0.75);margin-bottom:25px;">Chất Lượng Việt Nam</div>
                                    <a href="index.php?act=sanpham&keyword=Wika" style="display:inline-block;background:#e11d48;color:white;font-size:12px;font-weight:800;padding:10px 24px;border-radius:25px;text-decoration:none;text-transform:uppercase;letter-spacing:1px;">Xem Sản Phẩm &rarr;</a>
                                </div>
                            </div>
                            <div style="position:absolute;top:20px;right:20px;font-size:11px;font-weight:700;background:rgba(255,255,255,0.15);color:white;padding:4px 12px;border-radius:20px;backdrop-filter:blur(8px);">8 / 8</div>
                        </div>

                    </div><!-- end track -->

                    <!-- Prev Button -->
                    <button id="brand-prev" onclick="brandSlide(-1)" style="position:absolute;left:18px;top:50%;transform:translateY(-50%);z-index:20;width:46px;height:46px;border-radius:50%;background:rgba(255,255,255,0.18);border:2px solid rgba(255,255,255,0.4);color:#fff;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(8px);transition:all 0.2s ease;" onmouseover="this.style.background='rgba(255,255,255,0.35)'" onmouseout="this.style.background='rgba(255,255,255,0.18)'">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <!-- Next Button -->
                    <button id="brand-next" onclick="brandSlide(1)" style="position:absolute;right:18px;top:50%;transform:translateY(-50%);z-index:20;width:46px;height:46px;border-radius:50%;background:rgba(255,255,255,0.18);border:2px solid rgba(255,255,255,0.4);color:#fff;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(8px);transition:all 0.2s ease;" onmouseover="this.style.background='rgba(255,255,255,0.35)'" onmouseout="this.style.background='rgba(255,255,255,0.18)'">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <!-- Dots -->
                    <div style="position:absolute;bottom:16px;left:50%;transform:translateX(-50%);display:flex;gap:6px;z-index:20;" id="brand-dots">
                        <?php for($i=0;$i<8;$i++): ?>
                            <span class="bsdot" data-idx="<?php echo $i;?>" onclick="brandGoTo(<?php echo $i;?>)" style="width:<?php echo $i==0?'24px':'8px';?>;height:4px;border-radius:2px;background:<?php echo $i==0?'white':'rgba(255,255,255,0.4)';?>;cursor:pointer;transition:all 0.3s;display:inline-block;"></span>
                        <?php endfor; ?>
                    </div>
                </div>

                <script>
                (function(){
                    var cur = 0, total = 8;
                    var track = document.getElementById('brand-slider-track');
                    var dots  = document.querySelectorAll('.bsdot');
                    var autoplay;

                    function update() {
                        track.style.transform = 'translateX(-' + (cur * 100) + '%)';
                        dots.forEach(function(d, i) {
                            d.style.width     = i === cur ? '24px' : '8px';
                            d.style.background = i === cur ? 'white' : 'rgba(255,255,255,0.4)';
                        });
                    }

                    window.brandSlide = function(dir) {
                        cur = (cur + dir + total) % total;
                        update();
                        resetAuto();
                    };
                    window.brandGoTo = function(idx) {
                        cur = idx;
                        update();
                        resetAuto();
                    };

                    function resetAuto() {
                        clearInterval(autoplay);
                        autoplay = setInterval(function(){ brandSlide(1); }, 4500);
                    }
                    resetAuto();
                })();
                </script>
            </div>

            <h2 style="color: var(--text-dark); font-size: 22px; font-weight: 700; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Giá trị cốt lõi & Cam kết dịch vụ</h2>
            
            <div class="info-grid">
                <!-- Box 1 -->
                <div class="feature-box">
                    <h3><i class="fa-solid fa-medal" style="color: var(--primary-dark); margin-right: 8px;"></i> Chất lượng hàng đầu</h3>
                    <p>Cam kết 100% sản phẩm bán ra đều là hàng chính hãng từ nhà sản xuất. Phát hiện hàng giả đền bù gấp 10 lần giá trị đơn hàng.</p>
                </div>

                <!-- Box 2 -->
                <div class="feature-box">
                    <h3><i class="fa-solid fa-truck-fast" style="color: var(--primary-dark); margin-right: 8px;"></i> Vận chuyển siêu tốc</h3>
                    <p>Hỗ trợ giao hàng toàn quốc nhanh chóng. Nhận hàng, kiểm tra hàng thoải mái trước khi thanh toán (COD).</p>
                </div>

                <!-- Box 3 -->
                <div class="feature-box">
                    <h3><i class="fa-solid fa-arrows-spin" style="color: var(--primary-dark); margin-right: 8px;"></i> Hỗ trợ đổi trả 30 ngày</h3>
                    <p>Nếu mang giày không vừa chân hoặc không ưng ý, khách hàng có thể liên hệ đổi size hoặc đổi mẫu hoàn toàn miễn phí trong vòng 30 ngày.</p>
                </div>

                <!-- Box 4 -->
                <div class="feature-box">
                    <h3><i class="fa-solid fa-handshake-angle" style="color: var(--primary-dark); margin-right: 8px;"></i> Tư vấn chuyên nghiệp</h3>
                    <p>Đội ngũ hỗ trợ viên am hiểu sâu sắc về cấu trúc bàn chân (bè hay thon) để giúp quý khách lựa chọn phom giày phù hợp nhất.</p>
                </div>
            </div>
            
            <div style="margin-top: 40px; text-align: center;">
                <p style="font-weight: 700; margin-bottom: 15px;">Bạn đã sẵn sàng nâng cấp trải nghiệm thi đấu của mình?</p>
                <a href="index.php?act=sanpham" class="btn-primary">Khám phá sản phẩm ngay</a>
            </div>
        </div>

        <!-- Store Gallery Banner Section -->
        <div style="margin-top: 50px; border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border-color); box-shadow: var(--shadow); background: #ffffff;">
            <?php
            $store_src = 'C:/Users/Vinacom/.gemini/antigravity/brain/e0be63cd-6aa9-413c-8655-0089df006eae/media__1782464015406.png';
            $store_dst = __DIR__ . '/../assets/images/store_gallery.png';
            if (!file_exists($store_dst) && file_exists($store_src)) {
                @copy($store_src, $store_dst);
            }
            ?>
            <img src="assets/images/store_gallery.png" alt="Hệ thống cửa hàng Sport9" style="width: 100%; height: auto; display: block; object-fit: contain;">
        </div>

    </div>
</div>
