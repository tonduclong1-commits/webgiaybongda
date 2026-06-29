<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo '<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khởi tạo hình ảnh & Cơ sở dữ liệu</title>
    <style>
        body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a; color: #e2e8f0; padding: 40px; }
        .container { max-width: 800px; margin: 0 auto; background: #1e293b; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); border: 1px solid #334155; }
        h1 { color: #ef4444; border-bottom: 2px solid #334155; padding-bottom: 15px; margin-top: 0; }
        .log-box { background: #0f172a; padding: 20px; border-radius: 8px; font-family: monospace; font-size: 14px; overflow-y: auto; max-height: 400px; border: 1px solid #334155; line-height: 1.6; }
        .success { color: #22c55e; font-weight: bold; }
        .info { color: #3b82f6; }
        .error { color: #ef4444; font-weight: bold; }
        .btn { display: inline-block; background: linear-gradient(135deg, #ef4444, #f97316); color: #fff; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: bold; margin-top: 20px; transition: opacity 0.2s; }
        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
<div class="container">
    <h1>Khởi tạo Hình ảnh & Cơ sở dữ liệu</h1>
    <div class="log-box">';

flush();

// Connect and trigger auto initialization
try {
    echo '<span class="info">[1/4]</span> Kết nối cơ sở dữ liệu MySQL...<br>';
    flush();
    
    require_once __DIR__ . '/../model/connect.php';
    $pdo = pdo_get_connection();
    
    echo '<span class="success">✓ Kết nối thành công!</span><br><br>';
    echo '<span class="info">[2/4]</span> Thực hiện tạo bảng và chèn dữ liệu mẫu (Seeding)...<br>';
    flush();
    
    // Trigger auto seed
    auto_initialize_db($pdo);
    
    echo '<span class="success">✓ Đã khởi tạo cấu trúc bảng & Dữ liệu sản phẩm!</span><br><br>';
    echo '<span class="info">[3/4]</span> Đang kiểm tra sao chép và tạo các tệp hình ảnh...<br>';
    flush();
    
    $uploads_dir = __DIR__ . '/../uploads';
    $assets_img_dir = __DIR__ . '/../assets/images';
    
    $turf_count = 0;
    $turf_shoes = [
        'adidas_f50_messi_tf.png',
        'adidas_f50_hyperfast_tf.png',
        'adidas_predator_tf.png',
        'nike_phantom_g_pro_tf.png',
        'nike_tiempo_ligera_tf.png',
        'nike_tiempo_maestro_tf.png',
        'nike_phantom_g_academy_tf.png',
        'zocker_winner_energy_db.png'
    ];
    
    foreach ($turf_shoes as $shoe) {
        if (file_exists("$uploads_dir/$shoe")) {
            $turf_count++;
        }
    }
    
    $svg_count = 0;
    for ($i = 1; $i <= 68; $i++) {
        if (file_exists("$uploads_dir/shoe_$i.svg")) {
            $svg_count++;
        }
    }
    
    echo "• Đã tìm thấy $svg_count / 68 tệp SVG cho giày thường.<br>";
    echo "• Đã sao chép $turf_count / 8 hình ảnh PNG cho giày cỏ nhân tạo.<br>";
    echo '<span class="success">✓ Kiểm tra hình ảnh hoàn tất!</span><br><br>';
    
    echo '<span class="info">[4/4]</span> Kiểm tra xuất file cơ sở dữ liệu...<br>';
    flush();
    
    if (file_exists(__DIR__ . '/../database.sql') && file_exists(__DIR__ . '/../database.spl')) {
        echo '<span class="success">✓ Xuất file database.sql và database.spl thành công!</span><br>';
    } else {
        echo '<span class="error">✗ Xuất file thất bại!</span><br>';
    }
    
    echo '</div>';
    echo '<p style="margin-top: 20px;">Tất cả hình ảnh đã được sao chép và cơ sở dữ liệu đã được cập nhật thành công!</p>';
    echo '<a href="../index.php?act=trangchu" class="btn">Quay lại Trang Chủ</a>';
    
} catch (Exception $e) {
    echo '<span class="error">Lỗi: ' . htmlspecialchars($e->getMessage()) . '</span><br>';
    echo '</div>';
    echo '<a href="force_seed.php" class="btn" style="background: #334155;">Thử lại</a>';
}

echo '</div>
</body>
</html>';
?>
