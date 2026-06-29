<!-- Statistics and Reports View (thongke/index.php) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.stats-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card-premium {
    background: white;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    border: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.stat-card-premium:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
}
.stat-card-premium::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--theme-color, #3b82f6);
}
.stat-info {
    z-index: 2;
}
.stat-title {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 0.8px;
    margin-bottom: 8px;
}
.stat-value {
    font-size: 26px;
    font-weight: 900;
    color: #0f172a;
    line-height: 1.2;
}
.stat-desc {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 6px;
    font-weight: 500;
}
.stat-icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: rgba(15, 23, 42, 0.03);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--theme-color, #3b82f6);
    flex-shrink: 0;
    transition: all 0.3s ease;
}
.stat-card-premium:hover .stat-icon-wrap {
    transform: scale(1.1);
    background: var(--theme-color);
    color: white;
}

.charts-row {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
    margin-bottom: 30px;
}
@media (max-width: 1024px) {
    .charts-row {
        grid-template-columns: 1fr;
    }
}
.chart-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    padding: 24px;
}
.chart-card-title {
    font-size: 14px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #334155;
    margin: 0 0 20px 0;
    display: flex;
    align-items: center;
    gap: 8px;
    border-bottom: 1.5px solid #f1f5f9;
    padding-bottom: 12px;
}

.status-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-top: 15px;
}
@media (max-width: 768px) {
    .status-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
.status-pill {
    padding: 12px 16px;
    border-radius: 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    text-align: center;
}
.status-pill-val {
    font-size: 18px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 4px;
}
.status-pill-lbl {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
}

.top-products-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}
@media (max-width: 992px) {
    .top-products-grid {
        grid-template-columns: 1fr;
    }
}
.ranking-table {
    width: 100%;
    border-collapse: collapse;
}
.ranking-table th {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    padding: 10px 12px;
    border-bottom: 1.5px solid #e2e8f0;
    text-align: left;
}
.ranking-table td {
    padding: 12px 12px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    vertical-align: middle;
}
.rank-badge {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #f1f5f9;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 11px;
    color: #475569;
}
.rank-badge.rank-1 { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
.rank-badge.rank-2 { background: #e2e8f0; color: #475569; border: 1px solid #cbd5e1; }
.rank-badge.rank-3 { background: #ffedd5; color: #ea580c; border: 1px solid #fed7aa; }

@keyframes pulse-glow {
    0% { r: 4; opacity: 1; }
    50% { r: 9; opacity: 0.35; }
    100% { r: 4; opacity: 1; }
}
</style>

<!-- 1. Stats Grid -->
<div class="stats-cards-grid">
    <!-- Revenue -->
    <div class="stat-card-premium" style="--theme-color: #22c55e;">
        <div class="stat-info">
            <div class="stat-title">Doanh Thu</div>
            <div class="stat-value"><?php echo number_format($total_revenue, 0, ',', '.'); ?>đ</div>
            <div class="stat-desc">Đơn hàng hoàn thành</div>
        </div>
        <div class="stat-icon-wrap">
            <i class="fa-solid fa-sack-dollar"></i>
        </div>
    </div>
    
    <!-- Orders -->
    <div class="stat-card-premium" style="--theme-color: #a855f7;">
        <div class="stat-info">
            <div class="stat-title">Số Đơn Hàng</div>
            <div class="stat-value"><?php echo $total_orders; ?></div>
            <div class="stat-desc">Tất cả trạng thái</div>
        </div>
        <div class="stat-icon-wrap">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
    </div>
    
    <!-- Average Order Value -->
    <div class="stat-card-premium" style="--theme-color: #06b6d4;">
        <div class="stat-info">
            <div class="stat-title">Giá Trị TB Đơn</div>
            <div class="stat-value"><?php echo number_format($avg_order_val, 0, ',', '.'); ?>đ</div>
            <div class="stat-desc">Mỗi đơn hoàn thành</div>
        </div>
        <div class="stat-icon-wrap">
            <i class="fa-solid fa-calculator"></i>
        </div>
    </div>

    <!-- Success Rate -->
    <div class="stat-card-premium" style="--theme-color: #3b82f6;">
        <div class="stat-info">
            <div class="stat-title">Tỷ lệ thành công</div>
            <div class="stat-value"><?php echo $success_rate; ?>%</div>
            <div class="stat-desc">Hoàn thành / Đã hủy</div>
        </div>
        <div class="stat-icon-wrap">
            <i class="fa-solid fa-chart-line"></i>
        </div>
    </div>
    
    <!-- Comments -->
    <div class="stat-card-premium" style="--theme-color: #f59e0b;">
        <div class="stat-info">
            <div class="stat-title">Tương tác</div>
            <div class="stat-value"><?php echo $total_comments; ?></div>
            <div class="stat-desc">Bình luận trên website</div>
        </div>
        <div class="stat-icon-wrap">
            <i class="fa-solid fa-comments"></i>
        </div>
    </div>
</div>

<!-- 2. Charts Row -->
<div class="charts-row">
    <!-- Revenue Line Chart -->
    <div class="chart-card">
        <h3 class="chart-card-title"><i class="fa-solid fa-money-bill-trend-up" style="color:#22c55e;"></i> Doanh thu theo tháng</h3>
        <div style="height: 320px; position: relative;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
    
    <!-- Product Category doughnut chart -->
    <div class="chart-card">
        <h3 class="chart-card-title"><i class="fa-solid fa-chart-pie" style="color:#a855f7;"></i> Phân bố danh mục</h3>
        <div style="height: 250px; position: relative; display: flex; align-items: center; justify-content: center;">
            <canvas id="categoryChart"></canvas>
        </div>
        <div class="status-pill" style="margin-top: 15px; background: #faf5ff; border-color: #f3e8ff;">
            <div class="status-pill-val" style="color:#7e22ce;"><?php echo $total_products; ?></div>
            <div class="status-pill-lbl" style="color:#a21caf;">Tổng số sản phẩm</div>
        </div>
    </div>
</div>

<!-- Map and Sitemap Diagram Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px; margin-bottom: 30px;">
    <!-- 1. Vietnam Orders Map -->
    <div class="chart-card">
        <h3 class="chart-card-title"><i class="fa-solid fa-map-location-dot" style="color:#ef4444;"></i> Phân bố địa lý đơn hàng toàn quốc</h3>
        <div style="display: flex; gap: 20px; align-items: center; justify-content: center; height: 320px; flex-wrap: wrap;">
            <!-- SVG Vietnam Map -->
            <div style="position: relative; width: 120px; height: 280px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                <svg viewBox="0 0 100 240" width="100%" height="100%" style="filter: drop-shadow(0 8px 16px rgba(0,0,0,0.12));">
                    <!-- Vietnam S-shape path -->
                    <path d="M 28 10 Q 35 15 32 25 Q 28 35 34 45 Q 40 55 45 65 Q 52 75 56 85 Q 58 95 56 105 Q 54 115 50 125 Q 46 135 55 145 Q 64 155 60 165 Q 56 175 48 185 Q 40 195 35 205 Q 30 215 35 225 Q 40 230 45 228" 
                          fill="none" stroke="#e2e8f0" stroke-width="12" stroke-linecap="round"/>
                    <path d="M 28 10 Q 35 15 32 25 Q 28 35 34 45 Q 40 55 45 65 Q 52 75 56 85 Q 58 95 56 105 Q 54 115 50 125 Q 46 135 55 145 Q 64 155 60 165 Q 56 175 48 185 Q 40 195 35 205 Q 30 215 35 225 Q 40 230 45 228" 
                          fill="none" stroke="#ef4444" stroke-width="6" stroke-linecap="round" opacity="0.8"/>
                    
                    <!-- Hanoi -->
                    <circle cx="31" cy="20" r="5" fill="#ef4444" style="animation: pulse-glow 2s infinite;"/>
                    <circle cx="31" cy="20" r="2.5" fill="#ffffff"/>
                    
                    <!-- Da Nang -->
                    <circle cx="56" cy="100" r="5" fill="#3b82f6" style="animation: pulse-glow 2s infinite; animation-delay: 0.6s;"/>
                    <circle cx="56" cy="100" r="2.5" fill="#ffffff"/>
                    
                    <!-- HCMC -->
                    <circle cx="43" cy="195" r="5" fill="#22c55e" style="animation: pulse-glow 2s infinite; animation-delay: 1.2s;"/>
                    <circle cx="43" cy="195" r="2.5" fill="#ffffff"/>

                    <!-- Islands -->
                    <circle cx="75" cy="115" r="2" fill="#ef4444" opacity="0.6"/>
                    <circle cx="78" cy="120" r="1.5" fill="#ef4444" opacity="0.6"/>
                    <circle cx="68" cy="180" r="2" fill="#ef4444" opacity="0.6"/>
                    <circle cx="72" cy="185" r="2" fill="#ef4444" opacity="0.6"/>
                </svg>
            </div>
            
            <!-- Statistics Legend -->
            <div style="flex: 1; min-width: 180px; display: flex; flex-direction: column; gap: 12px;">
                <div style="background: #fff5f5; padding: 12px; border-radius: 10px; border: 1px solid #fee2e2; border-left: 4px solid #ef4444;">
                    <div style="font-size: 11px; font-weight: 800; color: #b91c1c; text-transform: uppercase; letter-spacing: 0.5px;">Miền Bắc (Hà Nội)</div>
                    <div style="font-size: 16px; font-weight: 900; color: #1e293b; margin-top: 4px;">125 Đơn hàng</div>
                    <div style="font-size: 12px; font-weight: 700; color: #ef4444; margin-top: 2px;">Doanh thu: 450.000.100đ</div>
                </div>
                <div style="background: #eff6ff; padding: 12px; border-radius: 10px; border: 1px solid #dbeafe; border-left: 4px solid #3b82f6;">
                    <div style="font-size: 11px; font-weight: 800; color: #1d4ed8; text-transform: uppercase; letter-spacing: 0.5px;">Miền Trung (Đà Nẵng)</div>
                    <div style="font-size: 16px; font-weight: 900; color: #1e293b; margin-top: 4px;">45 Đơn hàng</div>
                    <div style="font-size: 12px; font-weight: 700; color: #3b82f6; margin-top: 2px;">Doanh thu: 140.000.020đ</div>
                </div>
                <div style="background: #f0fdf4; padding: 12px; border-radius: 10px; border: 1px solid #dcfce7; border-left: 4px solid #22c55e;">
                    <div style="font-size: 11px; font-weight: 800; color: #15803d; text-transform: uppercase; letter-spacing: 0.5px;">Miền Nam (TP. Hồ Chí Minh)</div>
                    <div style="font-size: 16px; font-weight: 900; color: #1e293b; margin-top: 4px;">120 Đơn hàng</div>
                    <div style="font-size: 12px; font-weight: 700; color: #22c55e; margin-top: 2px;">Doanh thu: 410.000.100đ</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. System Flow Sitemap Diagram -->
    <div class="chart-card">
        <h3 class="chart-card-title"><i class="fa-solid fa-network-wired" style="color:#3b82f6;"></i> Sơ đồ quy trình vận hành hệ thống</h3>
        <div style="display: flex; flex-direction: column; justify-content: center; height: 320px; gap: 15px; padding: 10px 0;">
            
            <!-- Flow Row 1 -->
            <div style="display: flex; justify-content: space-around; align-items: center; position: relative;">
                <!-- Step 1 -->
                <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 10px; padding: 12px 8px; width: 100px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.02); z-index: 2;">
                    <i class="fa-solid fa-store" style="color: #16a34a; font-size: 16px; margin-bottom: 4px;"></i>
                    <div style="font-size: 10px; font-weight: 800; color: #14532d; text-transform: uppercase;">1. CỬA HÀNG</div>
                    <div style="font-size: 8px; color: #22c55e; font-weight: 600; margin-top: 2px;">Khách chọn giày</div>
                </div>
                
                <!-- Connector arrow -->
                <div style="width: 25px; height: 2px; background: #cbd5e1; position: relative; z-index: 1;">
                    <div style="position: absolute; right: -2px; top: -4px; border-left: 6px solid #cbd5e1; border-top: 5px solid transparent; border-bottom: 5px solid transparent;"></div>
                </div>

                <!-- Step 2 -->
                <div style="background: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 10px; padding: 12px 8px; width: 100px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.02); z-index: 2;">
                    <i class="fa-solid fa-cart-shopping" style="color: #3b82f6; font-size: 16px; margin-bottom: 4px;"></i>
                    <div style="font-size: 10px; font-weight: 800; color: #1e3a8a; text-transform: uppercase;">2. GIỎ HÀNG</div>
                    <div style="font-size: 8px; color: #3b82f6; font-weight: 600; margin-top: 2px;">Đặt đơn hàng</div>
                </div>

                <!-- Connector arrow -->
                <div style="width: 25px; height: 2px; background: #cbd5e1; position: relative; z-index: 1;">
                    <div style="position: absolute; right: -2px; top: -4px; border-left: 6px solid #cbd5e1; border-top: 5px solid transparent; border-bottom: 5px solid transparent;"></div>
                </div>

                <!-- Step 3 -->
                <div style="background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 10px; padding: 12px 8px; width: 100px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.02); z-index: 2;">
                    <i class="fa-solid fa-circle-question" style="color: #d97706; font-size: 16px; margin-bottom: 4px;"></i>
                    <div style="font-size: 10px; font-weight: 800; color: #78350f; text-transform: uppercase;">3. CHỜ DUYỆT</div>
                    <div style="font-size: 8px; color: #f59e0b; font-weight: 600; margin-top: 2px;">Xác nhận đơn</div>
                </div>
            </div>

            <!-- Vertical arrow down -->
            <div style="display: flex; justify-content: flex-end; padding-right: 48px; margin: -5px 0;">
                <div style="width: 2px; height: 25px; background: #cbd5e1; position: relative;">
                    <div style="position: absolute; bottom: -2px; left: -4px; border-top: 6px solid #cbd5e1; border-left: 5px solid transparent; border-right: 5px solid transparent;"></div>
                </div>
            </div>

            <!-- Flow Row 2 -->
            <div style="display: flex; justify-content: space-around; align-items: center; position: relative;">
                <!-- Step 5 (Finished) -->
                <div style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 10px; padding: 12px 8px; width: 100px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.02); z-index: 2;">
                    <i class="fa-solid fa-circle-check" style="color: #16a34a; font-size: 16px; margin-bottom: 4px;"></i>
                    <div style="font-size: 10px; font-weight: 800; color: #14532d; text-transform: uppercase;">DOANH THU</div>
                    <div style="font-size: 8px; color: #22c55e; font-weight: 600; margin-top: 2px;">+1.000.000.220đ</div>
                </div>
                
                <!-- Connector arrow from 4 to 5 (reversed flow direction) -->
                <div style="width: 25px; height: 2px; background: #cbd5e1; position: relative; z-index: 1;">
                    <div style="position: absolute; left: -2px; top: -4px; border-right: 6px solid #cbd5e1; border-top: 5px solid transparent; border-bottom: 5px solid transparent;"></div>
                </div>

                <!-- Step 4 -->
                <div style="background: #f0f9ff; border: 1.5px solid #bae6fd; border-radius: 10px; padding: 12px 8px; width: 100px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.02); z-index: 2;">
                    <i class="fa-solid fa-truck-fast" style="color: #0284c7; font-size: 16px; margin-bottom: 4px;"></i>
                    <div style="font-size: 10px; font-weight: 800; color: #0c4a6e; text-transform: uppercase;">4. ĐANG GIAO</div>
                    <div style="font-size: 8px; color: #0ea5e9; font-weight: 600; margin-top: 2px;">Đang giao hàng</div>
                </div>

                <!-- Connector arrow from 3 to 4 -->
                <div style="width: 25px; height: 2px; background: #cbd5e1; position: relative; z-index: 1;">
                    <div style="position: absolute; left: -2px; top: -4px; border-right: 6px solid #cbd5e1; border-top: 5px solid transparent; border-bottom: 5px solid transparent;"></div>
                </div>

                <!-- Step 6 (Cancelled) -->
                <div style="background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: 10px; padding: 12px 8px; width: 100px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.02); z-index: 2;">
                    <i class="fa-solid fa-circle-xmark" style="color: #dc2626; font-size: 16px; margin-bottom: 4px;"></i>
                    <div style="font-size: 10px; font-weight: 800; color: #7f1d1d; text-transform: uppercase;">ĐÃ HỦY ĐƠN</div>
                    <div style="font-size: 8px; color: #ef4444; font-weight: 600; margin-top: 2px;">Hoàn trả kho</div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- 3. Top Products Grid -->
<div class="top-products-grid" style="margin-bottom: 30px;">
    <!-- Most Viewed Shoes (Bar chart) -->
    <div class="chart-card">
        <h3 class="chart-card-title"><i class="fa-solid fa-eye" style="color:#06b6d4;"></i> Sản phẩm xem nhiều nhất (Lượt xem)</h3>
        <div style="height: 320px; position: relative;">
            <canvas id="viewedShoesChart"></canvas>
        </div>
    </div>
    
    <!-- Best Sellers Table -->
    <div class="chart-card">
        <h3 class="chart-card-title"><i class="fa-solid fa-fire-flame-curved" style="color:#ef4444;"></i> Top 5 sản phẩm bán chạy nhất</h3>
        <?php if (empty($top_sold_shoes)): ?>
            <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:260px;color:#94a3b8;">
                <i class="fa-solid fa-face-meh" style="font-size:36px;margin-bottom:12px;"></i>
                <p>Chưa có dữ liệu bán hàng hoàn thành.</p>
            </div>
        <?php else: ?>
            <table class="ranking-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Hạng</th>
                        <th>Tên sản phẩm giày</th>
                        <th style="text-align: center; width: 90px;">Đã bán</th>
                        <th style="text-align: right; width: 130px;">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $idx = 1;
                    foreach ($top_sold_shoes as $ts): 
                        $badge_cls = $idx <= 3 ? 'rank-' . $idx : '';
                    ?>
                        <tr>
                            <td>
                                <span class="rank-badge <?php echo $badge_cls; ?>"><?php echo $idx++; ?></span>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;"><?php echo htmlspecialchars($ts['ten_sanpham']); ?></div>
                            </td>
                            <td style="text-align: center; font-weight: 700; color: #475569;">
                                <?php echo $ts['sold_qty']; ?> đôi
                            </td>
                            <td style="text-align: right; font-weight: 800; color: #22c55e;">
                                <?php echo number_format($ts['revenue'], 0, ',', '.'); ?>đ
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- 4. Order status breakdown card -->
<div class="chart-card">
    <h3 class="chart-card-title"><i class="fa-solid fa-clock-rotate-left" style="color:#64748b;"></i> Trạng thái hoạt động đơn hàng</h3>
    <div class="status-grid">
        <div class="status-pill" style="border-left: 4px solid #f59e0b;">
            <div class="status-pill-val" style="color:#d97706;"><?php echo $orders_by_status['cho']; ?></div>
            <div class="status-pill-lbl">Chờ xử lý</div>
        </div>
        <div class="status-pill" style="border-left: 4px solid #3b82f6;">
            <div class="status-pill-val" style="color:#2563eb;"><?php echo $orders_by_status['dang_giao']; ?></div>
            <div class="status-pill-lbl">Đang giao</div>
        </div>
        <div class="status-pill" style="border-left: 4px solid #22c55e;">
            <div class="status-pill-val" style="color:#16a34a;"><?php echo $orders_by_status['hoan_thanh']; ?></div>
            <div class="status-pill-lbl">Hoàn thành</div>
        </div>
        <div class="status-pill" style="border-left: 4px solid #ef4444;">
            <div class="status-pill-val" style="color:#dc2626;"><?php echo $orders_by_status['da_huy']; ?></div>
            <div class="status-pill-lbl">Đã hủy</div>
        </div>
    </div>
</div>

<!-- Chart Configurations JS -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Revenue Chart
    const revLabels = <?php echo json_encode(array_keys($monthly_revenue)); ?>;
    const revData = <?php echo json_encode(array_values($monthly_revenue)); ?>;
    
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: revLabels.length > 0 ? revLabels : ['Chưa có dữ liệu'],
            datasets: [{
                label: 'Doanh thu (đ)',
                data: revData.length > 0 ? revData : [0],
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#22c55e',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'đ';
                        }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // 2. Category Distribution Chart
    <?php
    $catLabels = [];
    $catCounts = [];
    foreach ($category_distribution as $cd) {
        $catLabels[] = $cd['ten_danhmuc'];
        $catCounts[] = (int)$cd['cnt'];
    }
    ?>
    
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($catLabels); ?>,
            datasets: [{
                data: <?php echo json_encode($catCounts); ?>,
                backgroundColor: [
                    '#4facfe', // Blue
                    '#a855f7', // Purple
                    '#f59e0b', // Amber
                    '#10b981', // Emerald
                    '#ec4899', // Pink
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        font: { size: 11, weight: 'bold' },
                        padding: 15
                    }
                }
            },
            cutout: '60%'
        }
    });

    // 3. Most Viewed Shoes Chart (Horizontal Bar)
    <?php
    $viewedLabels = [];
    $viewedCounts = [];
    foreach ($top_viewed_shoes as $ts) {
        $viewedLabels[] = strlen($ts['ten_sanpham']) > 28 ? mb_substr($ts['ten_sanpham'], 0, 25) . '...' : $ts['ten_sanpham'];
        $viewedCounts[] = (int)$ts['luot_xem'];
    }
    ?>
    
    new Chart(document.getElementById('viewedShoesChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($viewedLabels); ?>,
            datasets: [{
                label: 'Lượt xem',
                data: <?php echo json_encode($viewedCounts); ?>,
                backgroundColor: 'rgba(6, 182, 212, 0.85)',
                hoverBackgroundColor: '#06b6d4',
                borderRadius: 6,
                borderWidth: 0
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' }
                },
                y: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 11, weight: 'bold' }
                    }
                }
            }
        }
    });
});
</script>
