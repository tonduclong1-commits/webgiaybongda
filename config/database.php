<?php
// Configuration & Database connection helper with Auto-Installer

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'web_giay_bong_da');

function get_connection() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    try {
        // 1. Establish connection to MySQL server first (without database)
        $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $temp_pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

        // 2. Create database if not exists
        $temp_pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        // 3. Connect directly to the database
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, $options);

        // 4. Auto-create tables and seed data if not present
        auto_initialize_db($pdo);

        return $pdo;
    } catch (PDOException $e) {
        die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
    }
}

function auto_initialize_db($pdo) {
    // 1. Create table danhmuc
    $pdo->exec("CREATE TABLE IF NOT EXISTS `danhmuc` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `ten_danhmuc` VARCHAR(255) NOT NULL UNIQUE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 2. Create table sanpham
    $pdo->exec("CREATE TABLE IF NOT EXISTS `sanpham` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `ten_sanpham` VARCHAR(255) NOT NULL,
        `gia` DOUBLE NOT NULL,
        `gia_giam` DOUBLE DEFAULT NULL,
        `hinh_anh` VARCHAR(255) NOT NULL,
        `mo_ta` TEXT NULL,
        `id_danhmuc` INT NOT NULL,
        `dac_biet` INT DEFAULT 0,
        `luot_xem` INT DEFAULT 0,
        FOREIGN KEY (`id_danhmuc`) REFERENCES `danhmuc`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 3. Create table taikhoan
    $pdo->exec("CREATE TABLE IF NOT EXISTS `taikhoan` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user` VARCHAR(50) NOT NULL UNIQUE,
        `pass` VARCHAR(255) NOT NULL,
        `email` VARCHAR(100) NOT NULL UNIQUE,
        `dien_thoai` VARCHAR(20) DEFAULT NULL,
        `vai_tro` INT DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 4. Create table banner
    $pdo->exec("CREATE TABLE IF NOT EXISTS `banner` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `ten_banner` VARCHAR(255) NOT NULL,
        `hinh_anh` VARCHAR(255) NOT NULL,
        `lien_ket` VARCHAR(255) NULL,
        `vi_tri` VARCHAR(50) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 5. Create table baiviet
    $pdo->exec("CREATE TABLE IF NOT EXISTS `baiviet` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `tieu_de` VARCHAR(255) NOT NULL,
        `hinh_anh` VARCHAR(255) NOT NULL,
        `ngay_dang` VARCHAR(20) NOT NULL,
        `mo_ta_ngan` TEXT NOT NULL,
        `noi_dung` TEXT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 6. Create table binhluan
    $pdo->exec("CREATE TABLE IF NOT EXISTS `binhluan` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `noi_dung` TEXT NOT NULL,
        `id_user` INT NOT NULL,
        `id_pro` INT NOT NULL,
        `ngay_binh_luan` VARCHAR(20) NOT NULL,
        FOREIGN KEY (`id_user`) REFERENCES `taikhoan`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`id_pro`) REFERENCES `sanpham`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 7. Create table donhang (Orders)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `donhang` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `id_user` INT NULL,
        `nguoi_nhan` VARCHAR(255) NOT NULL,
        `email` VARCHAR(100) NOT NULL,
        `dien_thoai` VARCHAR(20) NOT NULL,
        `dia_chi` TEXT NOT NULL,
        `ngay_dat` VARCHAR(20) NOT NULL,
        `tong_tien` DOUBLE NOT NULL,
        `pttt` INT DEFAULT 0, -- 0: COD, 1: CK ngân hàng
        `trang_thai` INT DEFAULT 0, -- 0: Chờ xử lý, 1: Đang giao, 2: Hoàn thành, 3: Đã hủy
        FOREIGN KEY (`id_user`) REFERENCES `taikhoan`(`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 8. Create table chitiet_donhang (Order Details)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `chitiet_donhang` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `id_donhang` INT NOT NULL,
        `id_sanpham` INT NOT NULL,
        `ten_sanpham` VARCHAR(255) NOT NULL,
        `hinh_anh` VARCHAR(255) NOT NULL,
        `gia` DOUBLE NOT NULL,
        `so_luong` INT NOT NULL,
        `size` VARCHAR(10) NULL,
        FOREIGN KEY (`id_donhang`) REFERENCES `donhang`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Seed Categories
    $stmtCountDM = $pdo->query("SELECT COUNT(*) FROM danhmuc");
    if ($stmtCountDM->fetchColumn() <= 0) {
        $pdo->exec("INSERT INTO `danhmuc` (`id`, `ten_danhmuc`) VALUES
            (1, 'Giày Cỏ Nhân Tạo TF'),
            (2, 'Giày Cỏ Tự Nhiên (FG)'),
            (3, 'Giày Futsal (IC)'),
            (4, 'Quả Bóng');");
    }

    // Seed Admin account
    $stmtCountTK = $pdo->query("SELECT COUNT(*) FROM taikhoan WHERE vai_tro = 1");
    if ($stmtCountTK->fetchColumn() <= 0) {
        // Password: 123456 (bcrypt hash)
        $admin_pass = password_hash('123456', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO `taikhoan` (`user`, `pass`, `email`, `dien_thoai`, `vai_tro`) VALUES (?, ?, ?, ?, 1)");
        $stmt->execute(['admin', $admin_pass, 'admin123@gmail.com', '0987654321']);
    }

    // Seed Banners (8 slider + 1 sub_banner = 9 total)
    $stmtCountBN = $pdo->query("SELECT COUNT(*) FROM banner");
    if ($stmtCountBN->fetchColumn() < 9) {
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $pdo->exec("TRUNCATE TABLE banner;");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
        
        $pdo->exec("INSERT INTO `banner` (`id`, `ten_banner`, `hinh_anh`, `lien_ket`, `vi_tri`) VALUES
            (1, 'Nike Attack Pack - Strike Fast', 'assets/images/banner_nike_attack.png', 'index.php?act=sanpham&keyword=Nike', 'slider'),
            (2, 'Adidas F50 Speed - Unleash Speed', 'assets/images/banner_main2.svg', 'index.php?act=sanpham&keyword=Adidas', 'slider'),
            (3, 'Mizuno Japan - Gold Craftsmanship', 'assets/images/banner_main3.svg', 'index.php?act=sanpham&keyword=Mizuno', 'slider'),
            (4, 'Puma Future Tech - Play Without Limits', 'assets/images/banner_main4.svg', 'index.php?act=sanpham&keyword=Puma', 'slider'),
            (5, 'Kamito TA11 Pro - Đam Mê Chinh Phục', 'assets/images/banner_main5.svg', 'index.php?act=sanpham&keyword=Kamito', 'slider'),
            (6, 'Zocker Inspire Pro - Chạm Tinh Tế', 'assets/images/banner_main6.svg', 'index.php?act=sanpham&keyword=Zocker', 'slider'),
            (7, 'Wika Neo Flash - Bứt Tốc Đỉnh Cao', 'assets/images/banner_main7.svg', 'index.php?act=sanpham&keyword=Wika', 'slider'),
            (8, 'Kelme Star Futsal - Indoor Master', 'assets/images/banner_main8.svg', 'index.php?act=sanpham&keyword=Kelme', 'slider'),
            (9, 'Mizuno Japan - Đỉnh cao da thật', 'assets/images/banner_sub.svg', 'index.php?act=sanpham&id_danhmuc=2', 'sub_banner');");
    }
    
    // Ensure the Nike Attack Pack banner file is copied
    if (!file_exists(__DIR__ . '/../assets/images/banner_nike_attack.png')) {
        @copy("C:/Users/Vinacom/.gemini/antigravity/brain/e0be63cd-6aa9-413c-8655-0089df006eae/media__1782369699811.png", __DIR__ . '/../assets/images/banner_nike_attack.png');
    }

    // Seed Articles
    $stmtCountBV = $pdo->query("SELECT COUNT(*) FROM baiviet");
    if ($stmtCountBV->fetchColumn() <= 0) {
        $pdo->exec("INSERT INTO `baiviet` (`id`, `tieu_de`, `hinh_anh`, `ngay_dang`, `mo_ta_ngan`, `noi_dung`) VALUES
            (1, 'Cách chọn size giày bóng đá chuẩn nhất cho chân bè', 'assets/images/baiviet1.svg', '23-06-2026', 'Chân bè mang giày gì thoải mái? Xem ngay cẩm nang chọn size giày bóng đá cực chuẩn cho người chân bè ngang phong trào.', 'Bàn chân bè (bàn chân rộng bề ngang) luôn là nỗi lo lắng của nhiều cầu thủ khi chọn mua giày bóng đá...'),
            (2, 'So sánh đinh TF và đinh FG: Khi nào nên sử dụng?', 'assets/images/baiviet2.svg', '21-06-2026', 'Phân biệt chi tiết giữa giày bóng đá sân cỏ nhân tạo (TF) và sân cỏ tự nhiên (FG) để bảo vệ cổ chân tốt nhất khi vận động.', 'Sử dụng sai loại đinh giày trên mặt sân không phù hợp là nguyên nhân hàng đầu dẫn đến các chấn thương...'),
            (3, 'Top 5 đôi giày cỏ nhân tạo bán chạy nhất năm 2026', 'assets/images/baiviet3.svg', '18-06-2026', 'Tổng hợp những mẫu giày đá banh sân cỏ nhân tạo được người chơi phong trào ưa chuộng và săn lùng nhiều nhất phân khúc.', 'Đâu là những cái tên đang thống trị các sân cỏ phong trào năm nay...');");
    }

    // Generate PNGs
    generate_shoe_pngs();
    generate_banner_svgs();
    
    // Update first banner to use the actual Nike Attack Pack PNG
    $pdo->exec("UPDATE banner SET hinh_anh = 'assets/images/banner_nike_attack.png' WHERE id = 1 AND hinh_anh = 'assets/images/banner_main1.svg';");

    // Seed 72 products
    $stmtCountPro = $pdo->query("SELECT COUNT(*) FROM sanpham");
    if (true) { // Force refresh and seed to ensure PNG image extensions are updated
        // Ensure category 4 exists before inserting products that reference it
        $pdo->exec("INSERT IGNORE INTO `danhmuc` (`id`, `ten_danhmuc`) VALUES (4, 'Quả Bóng');");
        
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $pdo->exec("TRUNCATE TABLE sanpham;");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

        $brands = ["Nike", "Adidas", "Mizuno", "Puma", "Kamito", "Zocker", "Wika", "Pan", "Jogarbola", "Kelme", "NMS"];
        $silos = [
            "Nike" => ["Mercurial Vapor", "Tiempo Legend", "Phantom GX", "Air Zoom Superfly"],
            "Adidas" => ["Predator Accuracy", "F50 League", "Copa Pure", "X Crazyfast"],
            "Mizuno" => ["Morelia Neo IV", "Mizuno Alpha", "Monarcida Neo Select", "Morelia Sala"],
            "Puma" => ["Future Play", "Ultra Match", "King Pro", "Future Ultimate"],
            "Kamito" => ["Velocidad II", "TA11 Pro", "Kamito KL", "Cobra"],
            "Zocker" => ["inspire Pro", "Winner", "Zocker Space", "Zocker Focus"],
            "Wika" => ["Wika Neo", "Wika Flash", "Wika Legend", "Wika Submax"],
            "Pan" => ["Pan Vigor", "Pan Wave", "Pan Super Sonic", "Pan Fighter"],
            "Jogarbola" => ["JGBL Color", "Jogarbola Koha", "Jogarbola 9018", "Jogarbola Swift"],
            "Kelme" => ["Kelme Star", "Kelme Intense", "Kelme Champion", "Kelme Madrid"],
            "NMS" => ["NMS Classico", "NMS Captain", "NMS Elite", "NMS Pro"]
        ];
        
        for ($i = 1; $i <= 68; $i++) {
            $brand = $brands[($i - 1) % count($brands)];
            $brand_silos = $silos[$brand];
            $silo = $brand_silos[($i - 1) % count($brand_silos)];
            
            $ten_sanpham = $brand . " " . $silo . " #" . $i;
            $gia = 800000 + ($i * 30000); 
            $gia_giam = ($i % 3 == 0) ? $gia * 0.85 : ($i % 4 == 0 ? $gia * 0.9 : null);
            
            $hinh_anh = "uploads/shoe_" . $i . ".svg";
            $id_danhmuc = ($i % 3 == 0) ? 3 : (($i % 2 == 0) ? 2 : 1);
            $dac_biet = ($i % 5 == 0) ? 1 : 0;
            $luot_xem = $i * 12;
            
            $mo_ta = "Giày bóng đá " . $brand . " " . $silo . " chính hãng phiên bản #" . $i . " mang thiết kế hiện đại, chất liệu bền bỉ, hỗ trợ tối đa hiệu suất ra sân của bạn.";
            
            $stmtInsert = $pdo->prepare("INSERT INTO `sanpham` (`id`, `ten_sanpham`, `gia`, `gia_giam`, `hinh_anh`, `mo_ta`, `id_danhmuc`, `dac_biet`, `luot_xem`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtInsert->execute([$i, $ten_sanpham, $gia, $gia_giam, $hinh_anh, $mo_ta, $id_danhmuc, $dac_biet, $luot_xem]);
        }
        
        // Re-inject the 4 specific Hot Deals (from previous runs) with high-quality images
        $pdo->exec("UPDATE sanpham SET ten_sanpham = 'Adidas Copa Pure 3 League TF - Pure Victory', gia = 2100000, gia_giam = 1250000, hinh_anh = 'assets/images/adidas_copa_pure3.png', mo_ta = 'Giày bóng đá Adidas Copa Pure 3 League TF chính hãng với thiết kế phom da mềm êm chân, hỗ trợ kiểm soát chạm bóng tối ưu.', id_danhmuc = 1, dac_biet = 1 WHERE id = 9;");
        $pdo->exec("UPDATE sanpham SET ten_sanpham = 'Adidas F50 League TF IF1336 - Xanh/Hồng', gia = 2400000, gia_giam = 1490000, hinh_anh = 'assets/images/adidas_f50_league.png', mo_ta = 'Dòng sản phẩm F50 tốc độ huyền thoại của Adidas, sắc xanh phối hồng cá tính và đệm đế giảm áp suất gót chân.', id_danhmuc = 1, dac_biet = 1 WHERE id = 10;");
        $pdo->exec("UPDATE sanpham SET ten_sanpham = 'Puma Future 8 Pro Cage TT Audacity - 108366-03', gia = 2999000, gia_giam = 1750000, hinh_anh = 'assets/images/puma_future8.png', mo_ta = 'Thiết kế giày đinh dăm chuyên dụng cho sân cỏ nhân tạo với chất liệu thun co giãn ôm khít cổ chân cực tốt.', id_danhmuc = 1, dac_biet = 1 WHERE id = 11;");
        $pdo->exec("UPDATE sanpham SET ten_sanpham = 'Giày Bóng Đá Kelme TF Mã 8531ZX1036', gia = 1040000, gia_giam = 936000, hinh_anh = 'assets/images/kelme_tf.png', mo_ta = 'Giày bóng đá Kelme chính hãng bền bỉ, thích hợp cho người chân bè, thiết kế màu bạc thời thượng và ôm chân thoải mái.', id_danhmuc = 1, dac_biet = 1 WHERE id = 12;");
        
        // Insert 4 new football products
        $pdo->exec("INSERT INTO `sanpham` (`id`, `ten_sanpham`, `gia`, `gia_giam`, `hinh_anh`, `mo_ta`, `id_danhmuc`, `dac_biet`, `luot_xem`) VALUES
            (69, 'Quả Bóng Đá Kelme Mã 9086842', 420000, NULL, 'assets/images/ball_kelme_1_1782372758164.png', 'Quả bóng Kelme tiêu chuẩn, da PU bền bỉ, độ nảy tốt trên mọi mặt sân cỏ nhân tạo.', 4, 1, 150),
            (70, 'Quả Bóng Đá Kelme Mã 9886130', 370000, NULL, 'assets/images/ball_kelme_2_1782372767938.png', 'Bóng đá KELME dán nhiệt cao cấp, độ bám dính siêu tốt, không thấm nước.', 4, 1, 120),
            (71, 'Quả Bóng Đá Kelme MÃ 8101QU5001', 710000, NULL, 'assets/images/ball_kelme_3_1782372779163.png', 'Quả bóng chuẩn FIFA Quality, màu sắc nổi bật, cảm giác chạm bóng êm ái, thích hợp thi đấu chuyên nghiệp.', 4, 1, 300),
            (72, 'Quả Bóng Đá AFC Challenge League mã AFC25QU5000C', 2300000, 2100000, 'assets/images/ball_afc_4_1782372790473.png', 'Quả bóng chính thức giải đấu AFC Challenge League. Công nghệ dán nhiệt không đường may.', 4, 1, 500);");
    }
    
    // Force update the football images in case the seed block was skipped
    $pdo->exec("UPDATE sanpham SET hinh_anh = 'assets/images/ball_kelme_1_1782372758164.png' WHERE id = 69;");
    $pdo->exec("UPDATE sanpham SET hinh_anh = 'assets/images/ball_kelme_2_1782372767938.png' WHERE id = 70;");
    $pdo->exec("UPDATE sanpham SET hinh_anh = 'assets/images/ball_kelme_3_1782372779163.png' WHERE id = 71;");
    $pdo->exec("UPDATE sanpham SET hinh_anh = 'assets/images/ball_afc_4_1782372790473.png' WHERE id = 72;");

    // Ensure Pickleball category (ID 5) exists
    $stmtPB = $pdo->query("SELECT COUNT(*) FROM danhmuc WHERE id = 5");
    if ($stmtPB->fetchColumn() <= 0) {
        $pdo->exec("INSERT INTO `danhmuc` (`id`, `ten_danhmuc`) VALUES (5, 'Pickleball');");
    }

    // Ensure Pickleball category (ID 5) exists
    $stmtPB = $pdo->query("SELECT COUNT(*) FROM danhmuc WHERE id = 5");
    if ($stmtPB->fetchColumn() <= 0) {
        $pdo->exec("INSERT INTO `danhmuc` (`id`, `ten_danhmuc`) VALUES (5, 'Pickleball');");
    }

    // Seed Pickleball products (starting from ID 73)
    $pdo->exec("DELETE FROM sanpham WHERE id_danhmuc = 5 OR (id BETWEEN 73 AND 120);");
    
    $uploads_dir = __DIR__ . '/../uploads';
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    // SVG templates
    $paddle_svg = function($border_color, $grip_color, $decal_color, $brand, $model) {
        $uniq = uniqid();
        return '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 240" width="100%" height="100%">
    <defs>
        <linearGradient id="padFace_' . $uniq . '" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="#1e293b" />
            <stop offset="100%" stop-color="#0f172a" />
        </linearGradient>
    </defs>
    
    <!-- Outer background shadow -->
    <rect x="52" y="12" width="96" height="126" rx="26" fill="rgba(0,0,0,0.06)"/>
    
    <!-- Grip / Handle -->
    <rect x="91" y="135" width="18" height="85" rx="4" fill="' . $grip_color . '" stroke="#94a3b8" stroke-width="1"/>
    <!-- Grip wrap lines -->
    <path d="M 91 150 L 109 155 M 91 165 L 109 170 M 91 180 L 109 185 M 91 195 L 109 200 M 91 210 L 109 215" stroke="#e2e8f0" stroke-width="1"/>
    <rect x="88" y="215" width="24" height="10" rx="2" fill="#0f172a"/>
    
    <!-- Throat/neck -->
    <path d="M 82 135 L 118 135 L 110 120 L 90 120 Z" fill="#475569"/>
    
    <!-- Paddle Face -->
    <rect x="50" y="10" width="100" height="120" rx="24" fill="url(#padFace_' . $uniq . ')" stroke="#1e293b" stroke-width="2"/>
    
    <!-- Outer edge guard -->
    <rect x="48" y="8" width="104" height="124" rx="26" fill="none" stroke="' . $border_color . '" stroke-width="3"/>
    
    <!-- Graphic decals on face -->
    <path d="M 60 25 Q 100 15 140 25" fill="none" stroke="' . $decal_color . '" stroke-width="3"/>
    <path d="M 60 115 Q 100 125 140 115" fill="none" stroke="' . $decal_color . '" stroke-width="3"/>
    
    <!-- Brand / Text -->
    <text x="100" y="55" font-family="\'Arial\', sans-serif" font-size="15" font-weight="900" fill="#ffffff" text-anchor="middle" letter-spacing="2">' . $brand . '</text>
    <text x="100" y="75" font-family="\'Arial\', sans-serif" font-size="9" font-weight="900" fill="' . $decal_color . '" text-anchor="middle" letter-spacing="1">' . $model . '</text>
    <text x="100" y="95" font-family="\'Arial\', sans-serif" font-size="6" font-weight="700" fill="rgba(255,255,255,0.4)" text-anchor="middle" letter-spacing="1.5">PROFESSIONAL</text>
</svg>';
    };

    $shoe_svg = function($base_color, $accent_color, $brand, $model) {
        return '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="100%" height="100%">
    <rect width="200" height="200" fill="#f8fafc" rx="12" stroke="#e2e8f0" stroke-width="2"/>
    <path d="M 30 150 Q 100 155 170 150 L 170 142 Q 100 148 30 142 Z" fill="#475569"/>
    <path d="M 32 140 Q 55 90 90 85 Q 110 80 135 110 L 168 132 Q 175 142 155 142 Z" fill="' . $base_color . '" stroke="#334155" stroke-width="1.5"/>
    <path d="M 90 85 Q 105 115 115 130" stroke="' . $accent_color . '" stroke-width="6" fill="none" stroke-linecap="round" opacity="0.8"/>
    <text x="100" y="175" font-family="\'Arial\', sans-serif" font-size="11" font-weight="900" fill="#1e293b" text-anchor="middle">' . $brand . ' ' . $model . '</text>
</svg>';
    };

    $ball_svg = function($color, $brand, $model) {
        return '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="100%" height="100%">
    <rect width="200" height="200" fill="#f8fafc" rx="12" stroke="#e2e8f0" stroke-width="2"/>
    <circle cx="100" cy="100" r="60" fill="' . $color . '" stroke="#475569" stroke-width="2"/>
    <circle cx="70" cy="70" r="8" fill="#f8fafc" stroke="#475569" stroke-width="1.5"/>
    <circle cx="100" cy="60" r="8" fill="#f8fafc" stroke="#475569" stroke-width="1.5"/>
    <circle cx="130" cy="70" r="8" fill="#f8fafc" stroke="#475569" stroke-width="1.5"/>
    <circle cx="60" cy="100" r="8" fill="#f8fafc" stroke="#475569" stroke-width="1.5"/>
    <circle cx="100" cy="100" r="8" fill="#f8fafc" stroke="#475569" stroke-width="1.5"/>
    <circle cx="140" cy="100" r="8" fill="#f8fafc" stroke="#475569" stroke-width="1.5"/>
    <circle cx="70" cy="130" r="8" fill="#f8fafc" stroke="#475569" stroke-width="1.5"/>
    <circle cx="100" cy="140" r="8" fill="#f8fafc" stroke="#475569" stroke-width="1.5"/>
    <circle cx="130" cy="130" r="8" fill="#f8fafc" stroke="#475569" stroke-width="1.5"/>
    <text x="100" y="180" font-family="\'Arial\', sans-serif" font-size="10" font-weight="900" fill="#475569" text-anchor="middle">' . $brand . ' ' . $model . '</text>
</svg>';
    };

    $bag_svg = function($color, $brand, $model) {
        return '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="100%" height="100%">
    <rect width="200" height="200" fill="#f8fafc" rx="12" stroke="#e2e8f0" stroke-width="2"/>
    <path d="M 60 160 L 60 70 Q 60 30, 100 30 Q 140 30, 140 70 L 140 160 Z" fill="' . $color . '" stroke="#1e293b" stroke-width="2"/>
    <path d="M 70 80 L 130 80 L 130 160 L 70 160 Z" fill="#1e293b" opacity="0.2"/>
    <path d="M 85 30 L 85 20 Q 85 15, 100 15 Q 115 15, 115 20 L 115 30" fill="none" stroke="#475569" stroke-width="3"/>
    <text x="100" y="185" font-family="\'Arial\', sans-serif" font-size="11" font-weight="900" fill="#1e293b" text-anchor="middle">' . $brand . ' ' . $model . '</text>
</svg>';
    };

    // Write SVG files to uploads/
    file_put_contents($uploads_dir . '/joola_agassi_pro_v.svg', $paddle_svg('#3b82f6', '#ffffff', '#3b82f6', 'JOOLA', 'AGASSI PRO V'));
    file_put_contents($uploads_dir . '/joola_hyperion_pro_v.svg', $paddle_svg('#06b6d4', '#ffffff', '#06b6d4', 'JOOLA', 'HYPERION PRO'));
    file_put_contents($uploads_dir . '/joola_perseus_pro_v.svg', $paddle_svg('#ef4444', '#ffffff', '#ef4444', 'JOOLA', 'PERSEUS PRO'));
    file_put_contents($uploads_dir . '/voltano_apex_pro.svg', $paddle_svg('#22c55e', '#1e293b', '#22c55e', 'VOLTANO', 'APEX PRO'));
    file_put_contents($uploads_dir . '/zocker_aspire.svg', $paddle_svg('#d946ef', '#ffffff', '#d946ef', 'ZOCKER', 'ASPIRE'));
    file_put_contents($uploads_dir . '/nike_vapor_pro_3.svg', $shoe_svg('#e2e8f0', '#ff5722', 'NIKE', 'VAPOR PRO 3'));
    file_put_contents($uploads_dir . '/nike_vapor_12.svg', $shoe_svg('#1e293b', '#eab308', 'NIKE', 'VAPOR 12'));
    file_put_contents($uploads_dir . '/babolat_jet_mach_4.svg', $shoe_svg('#3b82f6', '#ffffff', 'BABOLAT', 'JET MACH 4'));

    file_put_contents($uploads_dir . '/asics_court_ff_3.svg', $shoe_svg('#ffffff', '#ec4899', 'ASICS', 'COURT FF 3'));
    file_put_contents($uploads_dir . '/asics_game_ff.svg', $shoe_svg('#ffffff', '#0ea5e9', 'ASICS', 'GAME FF'));
    file_put_contents($uploads_dir . '/asics_gel_challenger_15.svg', $shoe_svg('#ffffff', '#94a3b8', 'ASICS', 'GEL CHALLENGER 15'));
    
    file_put_contents($uploads_dir . '/pickleball_joola_3s_dual.svg', $ball_svg('#facc15', 'JOOLA', '3S DUAL'));
    file_put_contents($uploads_dir . '/asics_gel_game_ff_cobalt.svg', $shoe_svg('#ffffff', '#1d4ed8', 'ASICS', 'GEL GAME FF'));
    file_put_contents($uploads_dir . '/asics_gel_game_gs_purple.svg', $shoe_svg('#ffffff', '#a855f7', 'ASICS', 'GEL GAME GS'));
    file_put_contents($uploads_dir . '/asics_gel_resolution_x.svg', $shoe_svg('#3b82f6', '#ffffff', 'ASICS', 'GEL RESOLUTION X'));
    file_put_contents($uploads_dir . '/asics_gel_game_gs_teal.svg', $shoe_svg('#0d9488', '#ffffff', 'ASICS', 'GEL GAME GS'));
    file_put_contents($uploads_dir . '/asics_upcourt_6_pink.svg', $shoe_svg('#f472b6', '#ffffff', 'ASICS', 'UPCOURT 6'));

    // Generate new 9 pickleball shoes from screenshot
    file_put_contents($uploads_dir . '/asics_gel_dedicate_8_mint.svg', $shoe_svg('#bbf7d0', '#ffffff', 'ASICS', 'DEDICATE 8'));
    file_put_contents($uploads_dir . '/asics_gel_dedicate_8_wide.svg', $shoe_svg('#ffffff', '#1e3a8a', 'ASICS', 'DEDICATE 8 WIDE'));
    file_put_contents($uploads_dir . '/asics_gel_game_ff_white_black.svg', $shoe_svg('#ffffff', '#0f172a', 'ASICS', 'GEL GAME FF'));
    file_put_contents($uploads_dir . '/nike_court_vapor_pro_3_black.svg', $shoe_svg('#ffffff', '#0f172a', 'NIKE', 'VAPOR PRO 3'));
    file_put_contents($uploads_dir . '/nike_court_vapor_pro_navy.svg', $shoe_svg('#ffffff', '#1e3a8a', 'NIKE', 'VAPOR PRO'));
    file_put_contents($uploads_dir . '/nike_court_lite_4_blue.svg', $shoe_svg('#ffffff', '#ff6b00', 'NIKE', 'COURT LITE 4'));
    file_put_contents($uploads_dir . '/nike_vapor_pro_3_orange.svg', $shoe_svg('#94a3b8', '#ff6b00', 'NIKE', 'VAPOR PRO 3 HC'));
    file_put_contents($uploads_dir . '/nike_vapor_pro_3_purple.svg', $shoe_svg('#818cf8', '#ffffff', 'NIKE', 'VAPOR PRO 3 HC'));
    file_put_contents($uploads_dir . '/joma_p_stroke_white.svg', $shoe_svg('#ffffff', '#3b82f6', 'JOMA', 'P.STROKE'));

    file_put_contents($uploads_dir . '/gift_socks.svg', '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100%" height="100%">
    <rect width="100%" height="100%" fill="#fef2f2" rx="10" stroke="#fca5a5" stroke-width="1.5"/>
    <path d="M 35 25 L 55 25 C 60 25, 60 45, 60 60 L 60 75 C 60 85, 45 85, 35 75 Z" fill="#ffffff" stroke="#f43f5e" stroke-width="2.5"/>
    <path d="M 35 25 L 35 75" fill="none" stroke="#cbd5e1" stroke-width="2"/>
    <text x="50" y="90" font-family="Arial" font-size="7" font-weight="bold" fill="#f43f5e" text-anchor="middle">SPORT SOCKS</text>
</svg>');

    // Insert new Pickleball products matching the screenshot (Prices & discounts match screenshot exactly)
    $pdo->exec("INSERT INTO `sanpham` (`id`, `ten_sanpham`, `gia`, `gia_giam`, `hinh_anh`, `mo_ta`, `id_danhmuc`, `dac_biet`, `luot_xem`) VALUES
        (73, 'Giày Pickleball Asics Gel Dedicate 8 - 1042A257-300 - Xanh Mint/Trắng', 2300000, 1950000, 'uploads/asics_gel_dedicate_8_mint.svg', 'Giày chơi Pickleball Asics Gel Dedicate 8 chính hãng, phiên bản màu xanh mint thời thượng kết hợp đế cao su bám sân.', 5, 1, 350),
        (74, 'Giày Pickleball Asics Gel Dedicate 8 Wide - 1041A410-105 - White/Midnight', 2000000, 1650000, 'uploads/asics_gel_dedicate_8_wide.svg', 'Thiết kế bề ngang rộng (Wide) chuyên biệt cho người chân bè, mang lại cảm giác thoải mái khi di chuyển.', 5, 1, 290),
        (75, 'Giày Pickleball Asics Gel Game FF - 1041A489 101 - White/Black', 2000000, 1650000, 'uploads/asics_gel_game_ff_white_black.svg', 'Dòng sản phẩm Gel Game FF giảm chấn tối ưu, bám sân cực tốt cho các bước chạy nhanh nhẹn.', 5, 1, 410),
        (76, 'Giày Pickleball Nike Court Air Zoom Vapor Pro 3 Hc - FZ2161-101 - Trắng/Đen', 3500000, 2750000, 'uploads/nike_court_vapor_pro_3_black.svg', 'Giày chơi Pickleball Nike Court Air Zoom Vapor Pro 3 ôm sát bàn chân, đế bám sân cực tốt.', 5, 1, 480),
        (77, 'Giày Pickleball Nike Court Air Zoom Vapor Pro - CZ0220-133 - Màu Trắng Xanh Navy', 3000000, 2350000, 'uploads/nike_court_vapor_pro_navy.svg', 'Giày chơi Pickleball Nike Court Air Zoom Vapor Pro nhẹ nhàng, sắc nét cùng gam màu trắng xanh navy cổ điển.', 5, 1, 320),
        (78, 'Giày Pickleball Nike Court Lite 4 - FD6574-106 - Xanh/Trắng', 2070000, 1550000, 'uploads/nike_court_lite_4_blue.svg', 'Giày chơi Pickleball Nike Court Lite 4 chính hãng bền bỉ, êm ái cho người chơi phong trào.', 5, 1, 280),
        (79, 'Giày Pickleball Nike Vapor Pro 3 HC PRM - HV1376-100 - Màu Trắng Cam', 3000000, 2350000, 'uploads/nike_vapor_pro_3_orange.svg', 'Giày Pickleball Nike Vapor Pro 3 phiên bản Premium đặc sắc với điểm nhấn màu cam cá tính.', 5, 1, 310),
        (80, 'Giày Nike Court Air Zoom Vapor Pro 3 HC FZ2158-401 - Màu Tím Khoai Môn', 3000000, 2350000, 'uploads/nike_vapor_pro_3_purple.svg', 'Phiên bản màu tím khoai môn độc đáo, đệm khí Zoom Air êm ái phản hồi lực tốt.', 5, 1, 430),
        (81, 'Giày Pickleball Joma P.Stroke Men - PSTROS2502 - Màu Trắng', 1970000, 1450000, 'uploads/joma_p_stroke_white.svg', 'Giày chơi Pickleball Joma chính hãng bền bỉ, ôm chân thoải mái, chống lật cổ chân.', 5, 1, 195),
        (82, 'Vợt Pickleball Joola Agassi Pro V', 9400000, 5800000, 'uploads/joola_agassi_pro_v.svg', 'Vợt Pickleball Joola Agassi Pro V thiết kế vân carbon nhám hỗ trợ tạo xoáy cao, lõi 16mm/14mm cho khả năng kiểm soát tuyệt đối.', 5, 1, 480),
        (83, 'Vợt Pickleball Joola Hyperion Pro V', 9400000, 5800000, 'uploads/joola_hyperion_pro_v.svg', 'Dòng vợt Pickleball Joola Hyperion Pro V tối ưu lực đập bóng và diện tích điểm ngọt rộng.', 5, 1, 390),
        (84, 'Vợt Pickleball Joola Perseus Pro V', 9400000, 5800000, 'uploads/joola_perseus_pro_v.svg', 'Vợt Pickleball Joola Perseus Pro V được sử dụng bởi các vận động viên chuyên nghiệp hàng đầu.', 5, 1, 560),
        (85, 'Vợt Pickleball Voltano Apex Pro', 6000000, 3800000, 'uploads/voltano_apex_pro.svg', 'Vợt Voltano Apex Pro mang lại độ nảy tối ưu cùng khả năng trợ lực vượt trội.', 5, 0, 240),
        (86, 'Vợt Pickleball Zocker Aspire', 2900000, 1800000, 'uploads/zocker_aspire.svg', 'Vợt Zocker Aspire phom cán dài thời thượng, sợi thủy tinh kết hợp carbon.', 5, 0, 195),
        (87, 'Giày Pickleball Nike Court Vapor 12', 3800000, 2400000, 'uploads/nike_vapor_12.svg', 'Giày chơi Pickleball Nike Court Vapor 12 nhẹ nhàng, linh hoạt cho những bước chạy bứt tốc.', 5, 0, 215),
        (88, 'Giày Pickleball Babolat Jet Mach 4', 5000000, 3200000, 'uploads/babolat_jet_mach_4.svg', 'Giày chơi Pickleball Babolat Jet Mach 4 với công nghệ đế Michelin siêu bền bỉ.', 5, 1, 410),
        (89, 'Giày Pickleball Asics Court FF 3 -1041A370-106 - Trắng/Hồng/Xanh', 4200000, 3300000, 'uploads/asics_court_ff_3.svg', 'Giày Pickleball Asics Court FF 3 chính hãng thiết kế phom ôm chân, tăng độ linh hoạt khi di chuyển.', 5, 1, 520),
        (90, 'Giày Pickleball Asics Game FF Clay/OC - 1041A489-104 - White/Dark Neptune', 3000000, 1950000, 'uploads/asics_game_ff.svg', 'Giày Asics Game FF nhẹ nhàng, giảm chấn tối ưu cho những bước bứt tốc nhanh nhẹn.', 5, 1, 380),
        (91, 'Giày Pickleball Asics Gel Challenger 15 - 1042A294-102 - Màu Trắng', 3500000, 2399000, 'uploads/asics_gel_challenger_15.svg', 'Dòng sản phẩm Gel Challenger 15 độ bám vượt trội trên mọi bề mặt sân Pickleball.', 5, 1, 490),
        (92, 'Bóng Pickleball Joola 3S Dual - 3 Quả', 200000, 150000, 'uploads/pickleball_joola_3s_dual.svg', 'Bóng Pickleball Joola 3S Dual chuyên dụng độ bền cao, độ nảy chuẩn.', 5, 0, 180),
        (93, 'Hộp 3 Quả Bóng Pickleball Franklin Signature', 250000, 180000, 'uploads/pickleball_franklin_sig.svg', 'Bóng Franklin Signature tiêu chuẩn thi đấu USAPA.', 5, 0, 140),
        (94, 'Bóng Pickleball Facolos Elite - Hộp 6 Quả', 500000, 350000, 'uploads/pickleball_facolos_elite.svg', 'Bóng Facolos Elite hộp 6 quả, độ nảy và phom tròn hoàn hảo.', 5, 0, 220),
        (95, 'Balo Pickleball Joola Backpack', 1200000, 850000, 'uploads/pickleball_joola_backpack.svg', 'Balo đựng vợt Pickleball Joola thời trang kháng nước cực tốt.', 5, 0, 160),
        (96, 'Vợt Pickleball Selkirk Vanguard', 4800000, 3900000, 'uploads/pickleball_selkirk_vanguard.svg', 'Vợt Selkirk Vanguard cao cấp mặt sợi carbon siêu êm.', 5, 1, 310),
        (97, 'Vợt Pickleball Facolos Elite', 3800000, 2900000, 'uploads/pickleball_facolos_elite.svg', 'Vợt Facolos Elite trợ lực đập bóng cực mạnh mẽ.', 5, 0, 275),
        (98, 'Vợt Pickleball Kamito Dominus', 2100000, 1500000, 'uploads/pickleball_kamito_dominus.svg', 'Vợt Kamito Dominus phom đầm tay cho người mới bắt đầu.', 5, 0, 230),
        (99, 'Giày Pickleball Asics Gel Game FF - 1041A489-103 - White/Dark Cobalt', 3000000, 1650000, 'uploads/asics_gel_game_ff_cobalt.svg', 'Giày chơi Pickleball Asics Gel Game FF cao cấp, thiết kế thăng bằng ổn định.', 5, 0, 195),
        (100, 'Giày Pickleball Asics Gel Game GS 1044A083 - 110 White Greyish Purple', 2500000, 1350000, 'uploads/asics_gel_game_gs_purple.svg', 'Giày chơi Pickleball trẻ em và thiếu niên Asics Gel Game GS siêu êm nhẹ.', 5, 0, 110),
        (101, 'Giày Pickleball Asics Gel Resolution X GS 1044A081 - 400', 3000000, 1650000, 'uploads/asics_gel_resolution_x.svg', 'Giày chơi Pickleball Asics Gel Resolution X GS hỗ trợ kiểm soát bước chạy và bảo vệ mắt cá.', 5, 0, 240),
        (102, 'Giày Pickleball Asics Gel Game GS 1044A052 - 406 Teal Blue/White', 2600000, 1400000, 'uploads/asics_gel_game_gs_teal.svg', 'Giày Pickleball Asics Gel Game GS màu xanh ngọc thời thượng bám sân.', 5, 0, 165),
        (103, 'Giày Pickleball Asics Upcourt 6 - 1074A045 701 - Màu hồng', 2600000, 1699000, 'uploads/asics_upcourt_6_pink.svg', 'Giày Pickleball nữ Asics Upcourt 6 sắc hồng xinh xắn bền bỉ.', 5, 0, 180);");

    // Seed the 8 high-quality turf products matching user screenshots
    $pdo->exec("INSERT INTO `sanpham` (`id`, `ten_sanpham`, `gia`, `gia_giam`, `hinh_anh`, `mo_ta`, `id_danhmuc`, `dac_biet`, `luot_xem`) VALUES
        (104, 'Giày đá bóng cỏ nhân tạo Adidas F50 Messi League TF El Ultimo Tango - Ivory/Semi Blue Burst/Icey Blue IH1903', 2700000, 2450000, 'uploads/adidas_f50_messi_tf.png', 'Giày đá bóng cỏ nhân tạo Adidas F50 Messi League TF chính hãng màu trắng xanh sang trọng.', 1, 1, 450),
        (105, 'Giày đá bóng cỏ nhân tạo Adidas F50 Hyperfast League TF Road to Glory - Solar Turbo/Core Black/Gold Metallic IH4582', 2600000, 2350000, 'uploads/adidas_f50_hyperfast_tf.png', 'Giày Adidas F50 Hyperfast League TF Road to Glory phiên bản màu hồng cá tính nổi bật.', 1, 1, 390),
        (106, 'Giày đá bóng cỏ nhân tạo Adidas Predator League Fold-over Tongue TF Road to Glory - Solar Turbo/Thermal Chrome/Core Black IH7212', 2700000, 2350000, 'uploads/adidas_predator_tf.png', 'Giày Adidas Predator League Fold-over Tongue TF Road to Glory có lưỡi gà gập cổ điển cực đẹp.', 1, 1, 420),
        (107, 'Giày đá bóng cỏ nhân tạo Nike Phantom 6 Pro Low Cut TF Breakout - Pink/White/Black IQ2155-900', 4109000, 3250000, 'uploads/nike_phantom_g_pro_tf.png', 'Giày bóng đá Nike Phantom 6 Pro Low Cut TF Breakout màu hồng trắng đen cao cấp chuyên nghiệp.', 1, 1, 510),
        (108, 'Giày đá bóng cỏ nhân tạo Nike Tiempo Ligera Pro TF Breakout - Pink/Black IQ2384-901', 4239000, 3350000, 'uploads/nike_tiempo_ligera_tf.png', 'Dòng giày da bê thật Nike Tiempo Ligera Pro TF Breakout êm ái ôm khít bàn chân bè.', 1, 0, 310),
        (109, 'Giày đá bóng cỏ nhân tạo Nike Tiempo Maestro Academy TF Breakout - Pink/Black IQ2388-901', 2479000, 2250000, 'uploads/nike_tiempo_maestro_tf.png', 'Giày bóng đá Nike Tiempo Maestro Academy TF Breakout chính hãng bền bỉ.', 1, 0, 280),
        (110, 'Giày đá bóng cỏ nhân tạo Nike Phantom 6 Academy Low Cut TF Breakout - Pink/White/Black IQ2399-900', 2629000, 2450000, 'uploads/nike_phantom_g_academy_tf.png', 'Giày Nike Phantom 6 Academy Low Cut TF Breakout màu hồng bám sân cỏ nhân tạo cực tốt.', 1, 0, 330),
        (111, 'Giày đá bóng cỏ nhân tạo Zocker Winner Energy Gen II - Dark Blue SNS-010-DB', 699000, NULL, 'uploads/zocker_winner_energy_db.png', 'Giày bóng đá Zocker Winner Energy Gen II thiết kế màu xanh dương đậm khỏe khoắn độ bền cao.', 1, 0, 190);");

    // Ensure Sneaker category (ID 6) exists
    $stmtSN = $pdo->query("SELECT COUNT(*) FROM danhmuc WHERE id = 6");
    if ($stmtSN->fetchColumn() <= 0) {
        $pdo->exec("INSERT INTO `danhmuc` (`id`, `ten_danhmuc`) VALUES (6, 'Sneaker');");
    }

    // Seed Sneaker products (140 items, IDs 120 to 259)
    $pdo->exec("DELETE FROM sanpham WHERE id_danhmuc = 6 OR (id BETWEEN 120 AND 259);");
    
    // First 10 premium sneakers matching screenshot
    $premium_sneakers = [
        ['Giày Nike Freak 5 \'Alphabet Bros\' DX4985-600', 3200000, 'uploads/sneaker_1.svg'],
        ['Giày Nike SB Air Max Ishod \'Silver Bullet\' HF3062-001', 3390000, 'uploads/sneaker_2.svg'],
        ['Giày Nike Air Max DN \'Black White\' (WMNS) FJ3145-002', 4200000, 'uploads/sneaker_3.svg'],
        ['Giày Li-Ning cầu lông Feiying AYTU001-4', 1190000, 'uploads/sneaker_4.svg'],
        ['Giày Air Jordan 1 Mid SE Craft \'Inside Out - White Sail\' DM9652-120', 3900000, 'uploads/sneaker_5.svg'],
        ['Giày New Balance 878 \'Navy Silver\' CM878KE1', 2290000, 'uploads/sneaker_6.svg'],
        ['Giày Nike Air Force 1 Boot NN \'Dark Smoke Grey Crater\' DD0747-001', 9890000, 'uploads/sneaker_7.svg'],
        ['Giày Air Jordan 1 Low \'Denim\' IH0648-141', 3090000, 'uploads/sneaker_8.svg'],
        ['Giày Air Jordan 1 Low \'Pine Green\' 553558-301', 11490000, 'uploads/sneaker_9.svg'],
        ['Giày Li-Ning Blade DF-01 Pro \'White Blue Red\' AYAT005-1', 2290000, 'uploads/sneaker_10.svg'],
    ];

    $brands = ['Nike', 'Adidas', 'Jordan', 'Li-Ning', 'New Balance', 'Puma', 'Mizuno', 'Asics'];
    $silo_names = ['Court Pro', 'Air Max Zoom', 'Retro Classic', 'Super Speed', 'City Walk', 'Style Runner', 'Flex Comfort'];

    for ($i = 0; $i < 140; $i++) {
        $prod_id = 120 + $i;
        $hinh_anh = "uploads/sneaker_" . ($i + 1) . ".svg";
        $mo_ta = "Giày Sneaker thể thao chính hãng cao cấp, thiết kế phom dáng ôm chân cực êm ái, bám đường tốt, phù hợp đi chơi và vận động thể thao.";
        $id_danhmuc = 6;
        $dac_biet = ($i < 10) ? 1 : 0;
        $luot_xem = rand(100, 800);

        if ($i < count($premium_sneakers)) {
            $name = $premium_sneakers[$i][0];
            $price = $premium_sneakers[$i][1];
            $price_giam = ($i % 3 === 0) ? $price * 0.9 : null;
        } else {
            $brand = $brands[$i % count($brands)];
            $silo = $silo_names[$i % count($silo_names)];
            $name = "Giày " . $brand . " " . $silo . " #" . ($i + 1);
            $price = rand(150, 450) * 10000;
            $price_giam = ($i % 3 == 0) ? $price * 0.85 : null;
        }

        $stmtIns = $pdo->prepare("INSERT INTO `sanpham` (`id`, `ten_sanpham`, `gia`, `gia_giam`, `hinh_anh`, `mo_ta`, `id_danhmuc`, `dac_biet`, `luot_xem`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtIns->execute([$prod_id, $name, $price, $price_giam, $hinh_anh, $mo_ta, $id_danhmuc, $dac_biet, $luot_xem]);
    }

    // Seed Orders to achieve exactly 1,000,000,220đ completed revenue
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("TRUNCATE TABLE chitiet_donhang;");
    $pdo->exec("TRUNCATE TABLE donhang;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    // Fetch all products to use for order details
    $stmtProds = $pdo->query("SELECT id, ten_sanpham, hinh_anh, gia, gia_giam FROM sanpham");
    $all_products = $stmtProds->fetchAll(PDO::FETCH_ASSOC);

    $target_completed_revenue = 1000000220;
    $running_revenue = 0;
    $num_completed = 250;
    
    // Seed Completed Orders (trang_thai = 2)
    for ($i = 1; $i <= $num_completed; $i++) {
        $order_id = $i;
        $status = 2; // Completed
        
        // Random date from Jan to Jun 2026
        $m = str_pad(rand(1, 6), 2, '0', STR_PAD_LEFT);
        $d = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
        $h = str_pad(rand(8, 22), 2, '0', STR_PAD_LEFT);
        $min = str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
        $s = str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
        $ngay_dat = "$d-$m-2026 $h:$min:$s";
        
        $nguoi_nhan = "Khách hàng #" . $order_id;
        $email = "customer$order_id@gmail.com";
        $phone = "09" . rand(10000000, 99999999);
        $address = "Hà Nội, Việt Nam";
        $pttt = rand(0, 1);
        
        // Calculate order total
        if ($i === $num_completed) {
            // Last order gets the remaining exact amount to hit the target
            $order_total = $target_completed_revenue - $running_revenue;
        } else {
            // Random amount between 1,000,000 and 6,000,000
            $order_total = rand(100, 600) * 10000;
            // Prevent overshoot
            if ($running_revenue + $order_total > $target_completed_revenue - 100000) {
                $order_total = rand(5, 10) * 10000;
            }
        }
        
        $running_revenue += $order_total;
        
        // Insert order
        $stmtOrd = $pdo->prepare("INSERT INTO `donhang` (`id`, `nguoi_nhan`, `email`, `dien_thoai`, `dia_chi`, `ngay_dat`, `tong_tien`, `pttt`, `trang_thai`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtOrd->execute([$order_id, $nguoi_nhan, $email, $phone, $address, $ngay_dat, $order_total, $pttt, $status]);
        
        // Insert order details
        if ($i === $num_completed) {
            // Last order: insert a custom item matching the exact amount
            $stmtDet = $pdo->prepare("INSERT INTO `chitiet_donhang` (`id_donhang`, `id_sanpham`, `ten_sanpham`, `hinh_anh`, `gia`, `so_luong`, `size`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmtDet->execute([$order_id, 104, 'Combo Giày bóng đá chuyên nghiệp', 'uploads/adidas_f50_messi_tf.png', $order_total, 1, '41']);
        } else {
            // Randomly select 1 to 2 products
            $items_count = rand(1, 2);
            $subtotal = 0;
            for ($k = 0; $k < $items_count; $k++) {
                $p = $all_products[rand(0, count($all_products) - 1)];
                $p_price = $p['gia_giam'] ? $p['gia_giam'] : $p['gia'];
                $qty = 1;
                
                // Scale price to match order total on the last item
                if ($k === $items_count - 1) {
                    $item_price = $order_total - $subtotal;
                } else {
                    $item_price = min($p_price, $order_total - $subtotal - 10000);
                    if ($item_price <= 0) $item_price = 10000;
                }
                $subtotal += $item_price * $qty;
                
                $size = rand(39, 43);
                $stmtDet = $pdo->prepare("INSERT INTO `chitiet_donhang` (`id_donhang`, `id_sanpham`, `ten_sanpham`, `hinh_anh`, `gia`, `so_luong`, `size`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmtDet->execute([$order_id, $p['id'], $p['ten_sanpham'], $p['hinh_anh'], $item_price, $qty, $size]);
            }
        }
    }

    // Seed other order statuses (pending, shipping, cancelled)
    $other_statuses = [
        0 => 15, // Pending
        1 => 10, // Shipping
        3 => 15, // Cancelled
    ];
    $order_id_counter = $num_completed + 1;
    foreach ($other_statuses as $status => $count) {
        for ($j = 0; $j < $count; $j++) {
            $order_id = $order_id_counter++;
            
            $m = str_pad(rand(5, 6), 2, '0', STR_PAD_LEFT); // Mostly recent months
            $d = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
            $h = str_pad(rand(8, 22), 2, '0', STR_PAD_LEFT);
            $min = str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
            $s = str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
            $ngay_dat = "$d-$m-2026 $h:$min:$s";
            
            $nguoi_nhan = "Khách hàng #" . $order_id;
            $email = "customer$order_id@gmail.com";
            $phone = "09" . rand(10000000, 99999999);
            $address = "Hà Nội, Việt Nam";
            $pttt = rand(0, 1);
            $order_total = rand(50, 300) * 10000;
            
            $stmtOrd = $pdo->prepare("INSERT INTO `donhang` (`id`, `nguoi_nhan`, `email`, `dien_thoai`, `dia_chi`, `ngay_dat`, `tong_tien`, `pttt`, `trang_thai`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtOrd->execute([$order_id, $nguoi_nhan, $email, $phone, $address, $ngay_dat, $order_total, $pttt, $status]);
            
            // Insert single item detail
            $p = $all_products[rand(0, count($all_products) - 1)];
            $size = rand(39, 43);
            $stmtDet = $pdo->prepare("INSERT INTO `chitiet_donhang` (`id_donhang`, `id_sanpham`, `ten_sanpham`, `hinh_anh`, `gia`, `so_luong`, `size`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmtDet->execute([$order_id, $p['id'], $p['ten_sanpham'], $p['hinh_anh'], $order_total, 1, $size]);
        }
    }

    // Auto-export the seeded database to root database.sql and database.spl files
    $export_script = __DIR__ . '/../scratch/export_db.php';
    if (file_exists($export_script)) {
        require_once $export_script;
        if (function_exists('export_database')) {
            @export_database();
        }
    }
}

function generate_shoe_pngs() {
    $target_dir = __DIR__ . '/../uploads';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Brand colors palette for beautiful SVG shoe illustrations
    $palettes = [
        ['base' => '#ef4444', 'accent' => '#fbbf24', 'sole' => '#1e293b'],
        ['base' => '#3b82f6', 'accent' => '#06b6d4', 'sole' => '#0f172a'],
        ['base' => '#22c55e', 'accent' => '#86efac', 'sole' => '#14532d'],
        ['base' => '#a855f7', 'accent' => '#e879f9', 'sole' => '#3b0764'],
        ['base' => '#f97316', 'accent' => '#fde68a', 'sole' => '#1e293b'],
        ['base' => '#0ea5e9', 'accent' => '#e0f2fe', 'sole' => '#0c4a6e'],
        ['base' => '#1e293b', 'accent' => '#94a3b8', 'sole' => '#0f172a'],
        ['base' => '#ec4899', 'accent' => '#fbcfe8', 'sole' => '#831843'],
        ['base' => '#f59e0b', 'accent' => '#ffffff', 'sole' => '#78350f'],
        ['base' => '#10b981', 'accent' => '#a7f3d0', 'sole' => '#064e3b'],
        ['base' => '#6366f1', 'accent' => '#c7d2fe', 'sole' => '#312e81'],
    ];

    $brands_short = ['NIK','ADI','MZN','PUM','KAM','ZCK','WKA','PAN','JGB','KLM','NMS'];

    for ($i = 1; $i <= 68; $i++) {
        $filepath = $target_dir . '/shoe_' . $i . '.svg';
        $p = $palettes[($i - 1) % count($palettes)];
        $br = $brands_short[($i - 1) % count($brands_short)];
        $num = str_pad($i, 2, '0', STR_PAD_LEFT);
        $uid = 'sh' . $i;

        $svg = <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 280 200" width="280" height="200">
  <defs>
    <linearGradient id="bg_{$uid}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#f8fafc"/>
      <stop offset="100%" stop-color="#e2e8f0"/>
    </linearGradient>
    <linearGradient id="body_{$uid}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{$p['base']}"/>
      <stop offset="100%" stop-color="{$p['sole']}"/>
    </linearGradient>
    <filter id="shd_{$uid}">
      <feDropShadow dx="2" dy="4" stdDeviation="4" flood-color="rgba(0,0,0,0.18)"/>
    </filter>
  </defs>
  <!-- Background -->
  <rect width="280" height="200" fill="url(#bg_{$uid})" rx="12"/>
  <!-- Sole -->
  <ellipse cx="148" cy="158" rx="100" ry="12" fill="{$p['sole']}" opacity="0.85"/>
  <!-- Shoe body -->
  <path d="M 48 155 Q 50 100 100 80 Q 130 65 170 85 Q 210 100 238 138 Q 248 155 235 158 Z"
        fill="url(#body_{$uid})" stroke="{$p['sole']}" stroke-width="1.5" filter="url(#shd_{$uid})"/>
  <!-- Toe cap highlight -->
  <path d="M 48 155 Q 50 110 90 88 Q 110 78 130 80 Q 90 90 70 120 Z"
        fill="{$p['accent']}" opacity="0.55"/>
  <!-- Swoosh / stripe -->
  <path d="M 120 90 Q 170 100 220 138" stroke="{$p['accent']}" stroke-width="8"
        fill="none" stroke-linecap="round" opacity="0.9"/>
  <!-- Tongue -->
  <path d="M 130 80 Q 140 50 155 45 Q 165 43 168 60 Q 162 70 155 78 Z"
        fill="{$p['base']}" stroke="{$p['accent']}" stroke-width="1"/>
  <!-- Laces -->
  <line x1="138" y1="75" x2="158" y2="72" stroke="#ffffff" stroke-width="2" opacity="0.8"/>
  <line x1="140" y1="82" x2="162" y2="79" stroke="#ffffff" stroke-width="2" opacity="0.8"/>
  <!-- Studs -->
  <circle cx="75" cy="160" r="4" fill="{$p['accent']}" stroke="{$p['sole']}" stroke-width="1"/>
  <circle cx="110" cy="163" r="4" fill="{$p['accent']}" stroke="{$p['sole']}" stroke-width="1"/>
  <circle cx="150" cy="165" r="4" fill="{$p['accent']}" stroke="{$p['sole']}" stroke-width="1"/>
  <circle cx="190" cy="163" r="4" fill="{$p['accent']}" stroke="{$p['sole']}" stroke-width="1"/>
  <circle cx="225" cy="158" r="4" fill="{$p['accent']}" stroke="{$p['sole']}" stroke-width="1"/>
  <!-- Brand label -->
  <rect x="8" y="8" width="54" height="22" rx="4" fill="{$p['sole']}" opacity="0.85"/>
  <text x="35" y="23" font-family="Arial Black, sans-serif" font-size="10" font-weight="900"
        fill="{$p['accent']}" text-anchor="middle" letter-spacing="1">{$br}</text>
  <!-- Number badge -->
  <rect x="222" y="8" width="50" height="22" rx="4" fill="{$p['base']}" opacity="0.9"/>
  <text x="247" y="23" font-family="Arial, sans-serif" font-size="10" font-weight="900"
        fill="#ffffff" text-anchor="middle">#{$num}</text>
</svg>
SVG;
        file_put_contents($filepath, $svg);
    }

    // Also copy the real product PNG images from brain for hot deals, balls, and turf shoes
    $brain = 'C:/Users/Vinacom/.gemini/antigravity/brain/e0be63cd-6aa9-413c-8655-0089df006eae/';
    
    // 1. Copy Hot Deals and Ball images to assets/images/
    $assets_imgs = [
        'adidas_copa_pure3_1782363991391.png' => 'adidas_copa_pure3.png',
        'adidas_f50_league_1782364011484.png' => 'adidas_f50_league.png',
        'puma_future8_1782364025777.png' => 'puma_future8.png',
        'kelme_tf_1782364037924.png' => 'kelme_tf.png',
        'ball_kelme_1_1782372758164.png' => 'ball_kelme_1_1782372758164.png',
        'ball_kelme_2_1782372767938.png' => 'ball_kelme_2_1782372767938.png',
        'ball_kelme_3_1782372779163.png' => 'ball_kelme_3_1782372779163.png',
        'ball_afc_4_1782372790473.png' => 'ball_afc_4_1782372790473.png',
    ];
    $img_dir = __DIR__ . '/../assets/images/';
    if (!is_dir($img_dir)) mkdir($img_dir, 0777, true);
    foreach ($assets_imgs as $src => $dst) {
        if (file_exists($brain . $src)) {
            @copy($brain . $src, $img_dir . $dst);
        }
    }

    // 2. Copy Turf Shoes PNG images to uploads/
    $uploads_imgs = [
        'adidas_f50_messi_tf_1782467951407.png' => 'adidas_f50_messi_tf.png',
        'adidas_f50_hyperfast_tf_1782467971520.png' => 'adidas_f50_hyperfast_tf.png',
        'adidas_predator_tf_1782467987134.png' => 'adidas_predator_tf.png',
        'nike_phantom_g_pro_tf_1782468003716.png' => 'nike_phantom_g_pro_tf.png',
        'nike_tiempo_ligera_tf_1782468041941.png' => 'nike_tiempo_ligera_tf.png',
        'nike_tiempo_maestro_tf_1782468057762.png' => 'nike_tiempo_maestro_tf.png',
        'nike_phantom_g_academy_tf_1782468078375.png' => 'nike_phantom_g_academy_tf.png',
        'zocker_winner_energy_db_1782468096238.png' => 'zocker_winner_energy_db.png',
    ];
    foreach ($uploads_imgs as $src => $dst) {
        if (file_exists($brain . $src)) {
            @copy($brain . $src, $target_dir . '/' . $dst);
        }
    }

    // Generate 140 Sneaker SVGs
    $sneaker_palettes = [
        ['base' => '#800020', 'accent' => '#ffd700', 'sole' => '#e2e8f0'], // 1. Nike Freak 5 (Maroon/Gold)
        ['base' => '#cbd5e1', 'accent' => '#ef4444', 'sole' => '#0f172a'], // 2. Nike SB Air Max (Silver/Red)
        ['base' => '#0f172a', 'accent' => '#ffffff', 'sole' => '#1e293b'], // 3. Nike Air Max DN (Black/White)
        ['base' => '#0ea5e9', 'accent' => '#ffffff', 'sole' => '#ffffff'], // 4. Li-Ning Feiying (Cyan/White)
        ['base' => '#fafaf9', 'accent' => '#a8a29e', 'sole' => '#78716c'], // 5. Air Jordan 1 Mid (Cream/Grey)
        ['base' => '#1e3a8a', 'accent' => '#cbd5e1', 'sole' => '#0f172a'], // 6. New Balance 878 (Navy/Silver)
        ['base' => '#292524', 'accent' => '#1c1917', 'sole' => '#44403c'], // 7. AF1 Boot (Dark/Crater)
        ['base' => '#3b82f6', 'accent' => '#ffffff', 'sole' => '#cbd5e1'], // 8. Jordan 1 Denim (Denim/White)
        ['base' => '#15803d', 'accent' => '#ffffff', 'sole' => '#111827'], // 9. Jordan 1 Pine Green (Green/White)
        ['base' => '#f8fafc', 'accent' => '#3b82f6', 'sole' => '#ef4444'], // 10. Li-Ning Blade (White/Blue/Red)
    ];

    $extra_palettes = [
        ['base' => '#f43f5e', 'accent' => '#fda4af', 'sole' => '#881337'],
        ['base' => '#8b5cf6', 'accent' => '#ddd6fe', 'sole' => '#4c1d95'],
        ['base' => '#06b6d4', 'accent' => '#cffafe', 'sole' => '#164e63'],
        ['base' => '#eab308', 'accent' => '#fef9c3', 'sole' => '#713f12'],
        ['base' => '#10b981', 'accent' => '#d1fae5', 'sole' => '#064e3b'],
        ['base' => '#6366f1', 'accent' => '#e0e7ff', 'sole' => '#312e81'],
        ['base' => '#ec4899', 'accent' => '#fbcfe8', 'sole' => '#831843'],
        ['base' => '#f97316', 'accent' => '#ffedd5', 'sole' => '#7c2d12'],
        ['base' => '#14b8a6', 'accent' => '#ccfbf1', 'sole' => '#115e59'],
        ['base' => '#a855f7', 'accent' => '#f3e8ff', 'sole' => '#581c87'],
    ];

    for ($j = 1; $j <= 140; $j++) {
        $filepath = $target_dir . '/sneaker_' . $j . '.svg';
        if ($j <= 10) {
            $p = $sneaker_palettes[$j - 1];
        } else {
            $p = $extra_palettes[($j - 11) % count($extra_palettes)];
        }
        $uid = 'snk' . $j;
        $num_badge = str_pad($j, 3, '0', STR_PAD_LEFT);

        $svg = '<?xml version="1.0" encoding="UTF-8"?>'.
'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 280 200" width="280" height="200">'.
  '<defs>'.
    '<linearGradient id="bg_'.$uid.'" x1="0%" y1="0%" x2="100%" y2="100%">'.
      '<stop offset="0%" stop-color="#f8fafc"/>'.
      '<stop offset="100%" stop-color="#cbd5e1"/>'.
    '</linearGradient>'.
    '<linearGradient id="body_'.$uid.'" x1="0%" y1="0%" x2="100%" y2="100%">'.
      '<stop offset="0%" stop-color="'.$p['base'].'"/><stop offset="100%" stop-color="'.$p['sole'].'"/></linearGradient>'.
    '<filter id="shd_'.$uid.'"><feDropShadow dx="2" dy="4" stdDeviation="4" flood-color="rgba(0,0,0,0.15)"/></filter>'.
  '</defs>'.
  '<rect width="280" height="200" fill="url(#bg_'.$uid.')" rx="12"/>'.
  '<ellipse cx="148" cy="162" rx="100" ry="10" fill="#94a3b8" opacity="0.4"/>'.
  '<path d="M 46 150 Q 140 156 234 150 L 230 160 Q 140 162 48 160 Z" fill="'.$p['sole'].'" filter="url(#shd_'.$uid.')"/>'.
  '<path d="M 48 150 Q 50 95 100 78 Q 130 65 170 85 Q 210 100 234 135 L 234 150 Z" fill="url(#body_'.$uid.')" stroke="'.$p['sole'].'" stroke-width="1.5" filter="url(#shd_'.$uid.')"/>'.
  '<path d="M 48 150 Q 50 105 90 85 Q 110 75 130 78 Q 90 88 70 115 Z" fill="'.$p['accent'].'" opacity="0.6"/>'.
  '<path d="M 120 85 Q 170 95 215 130" stroke="'.$p['accent'].'" stroke-width="8" fill="none" stroke-linecap="round" opacity="0.95"/>'.
  '<path d="M 130 78 Q 140 48 155 43 Q 165 41 168 58 Q 162 68 155 76 Z" fill="'.$p['base'].'" stroke="'.$p['accent'].'" stroke-width="1"/>'.
  '<line x1="138" y1="72" x2="158" y2="69" stroke="#ffffff" stroke-width="2" opacity="0.85"/>'.
  '<line x1="140" y1="79" x2="162" y2="76" stroke="#ffffff" stroke-width="2" opacity="0.85"/>'.
  '<rect x="8" y="8" width="54" height="22" rx="4" fill="#0f172a" opacity="0.85"/>'.
  '<text x="35" y="22" font-family="Arial Black,sans-serif" font-size="7" font-weight="900" fill="'.$p['accent'].'" text-anchor="middle">SNEAKER</text>'.
  '<rect x="222" y="8" width="50" height="22" rx="4" fill="'.$p['base'].'" opacity="0.9"/>'.
  '<text x="247" y="22" font-family="Arial,sans-serif" font-size="8" font-weight="900" fill="#ffffff" text-anchor="middle">#'.$num_badge.'</text>'.
'</svg>';
        file_put_contents($filepath, $svg);
    }
}

function hsl_to_hex_php($h, $s, $l) {
    $c = (1 - abs(2 * $l - 1)) * $s;
    $x = $c * (1 - abs(fmod($h * 6, 2) - 1));
    $m = $l - $c / 2;
    
    if ($h < 1/6) { $r = $c; $g = $x; $b = 0; }
    elseif ($h < 2/6) { $r = $x; $g = $c; $b = 0; }
    elseif ($h < 3/6) { $r = 0; $g = $c; $b = $x; }
    elseif ($h < 4/6) { $r = 0; $g = $x; $b = $c; }
    elseif ($h < 5/6) { $r = $x; $g = 0; $b = $c; }
    else { $r = $c; $g = 0; $b = $x; }
    
    $r = intval(($r + $m) * 255);
    $g = intval(($g + $m) * 255);
    $b = intval(($b + $m) * 255);
    
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

function generate_banner_svgs() {
    $target_dir = __DIR__ . '/../assets/images';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $banners_data = [
        1 => [
            "title" => "NIKE",
            "subtitle" => "ATTACK PACK",
            "desc" => "STRIKE FAST. PLAY FASTER.",
            "bg_from" => "#050b14",
            "bg_to" => "#0a192f",
            "accent" => "#ec4899",
            "logo" => "M 10 20 C 60 20, 110 5, 140 25 C 100 35, 50 45, 10 35 Z",
            "shoe_color" => "#ffffff",
            "shoe_accent" => "#ec4899",
            "sole_color" => "#1e293b",
            "glow_color" => "#3b82f6"
        ],
        2 => [
            "title" => "ADIDAS",
            "subtitle" => "F50 LEAGUE",
            "desc" => "UNLEASH REAL SPEED.",
            "bg_from" => "#1e1b4b",
            "bg_to" => "#311042",
            "accent" => "#06b6d4",
            "logo" => "M 10 30 L 25 15 L 45 45 L 30 45 Z M 25 30 L 40 15 L 60 45 L 45 45 Z M 40 30 L 55 15 L 75 45 L 60 45 Z",
            "shoe_color" => "#06b6d4",
            "shoe_accent" => "#ec4899",
            "sole_color" => "#0f172a",
            "glow_color" => "#ec4899"
        ],
        3 => [
            "title" => "MIZUNO",
            "subtitle" => "JAPAN CLASS",
            "desc" => "CRAFTED FOR CHAMPIONS.",
            "bg_from" => "#1c1917",
            "bg_to" => "#44403c",
            "accent" => "#eab308",
            "logo" => "M 10 25 C 30 15, 60 12, 90 17 C 105 19, 125 25, 140 38 C 110 28, 85 28, 60 33 Q 45 36, 10 25 Z",
            "shoe_color" => "#ffffff",
            "shoe_accent" => "#eab308",
            "sole_color" => "#1c1917",
            "glow_color" => "#eab308"
        ],
        4 => [
            "title" => "PUMA",
            "subtitle" => "FUTURE ULTIMATE",
            "desc" => "PLAY WITH NO LIMITS.",
            "bg_from" => "#090d16",
            "bg_to" => "#1f2937",
            "accent" => "#22c55e",
            "logo" => "M 10 30 C 50 20, 110 -10, 170 0 C 145 -5, 80 10, 20 35 Z",
            "shoe_color" => "#1e293b",
            "shoe_accent" => "#22c55e",
            "sole_color" => "#090d16",
            "glow_color" => "#22c55e"
        ],
        5 => [
            "title" => "KAMITO",
            "subtitle" => "TA11 PRO",
            "desc" => "ĐAM MÊ CHINH PHỤC.",
            "bg_from" => "#450a0a",
            "bg_to" => "#7f1d1d",
            "accent" => "#f59e0b",
            "logo" => "M 10 15 L 25 15 L 10 40 L -5 40 Z M 25 20 L 40 20 L 25 45 L 10 45 Z",
            "shoe_color" => "#ef4444",
            "shoe_accent" => "#f59e0b",
            "sole_color" => "#18181b",
            "glow_color" => "#f59e0b"
        ],
        6 => [
            "title" => "ZOCKER",
            "subtitle" => "INSPIRE PRO",
            "desc" => "CHẠM BÓNG TINH TẾ.",
            "bg_from" => "#065f46",
            "bg_to" => "#0f766e",
            "accent" => "#38bdf8",
            "logo" => "M 20 30 A 10 10 0 1 0 40 30 A 10 10 0 1 0 20 30 M 25 30 A 5 5 0 1 0 35 30 A 5 5 0 1 0 25 30",
            "shoe_color" => "#e2e8f0",
            "shoe_accent" => "#38bdf8",
            "sole_color" => "#0f172a",
            "glow_color" => "#38bdf8"
        ],
        7 => [
            "title" => "WIKA",
            "subtitle" => "NEO FLASH",
            "desc" => "BỨT TỐC ĐỈNH CAO.",
            "bg_from" => "#0c4a6e",
            "bg_to" => "#0369a1",
            "accent" => "#f97316",
            "logo" => "M 10 15 L 18 15 L 3 40 L -5 40 Z M 20 12 L 28 12 L 13 37 L 5 37 Z M 30 9 L 38 9 L 23 34 L 15 34 Z",
            "shoe_color" => "#f97316",
            "shoe_accent" => "#0c4a6e",
            "sole_color" => "#0f172a",
            "glow_color" => "#38bdf8"
        ],
        8 => [
            "title" => "KELME",
            "subtitle" => "STAR INDOOR",
            "desc" => "LÀM CHỦ SÂN TRONG NHÀ.",
            "bg_from" => "#18181b",
            "bg_to" => "#27272a",
            "accent" => "#ffffff",
            "logo" => "M 20 28 A 6 6 0 1 0 32 28 A 6 6 0 1 0 20 28 M 14 18 A 3 3 0 1 0 20 18 A 3 3 0 1 0 14 18 M 22 14 A 3 3 0 1 0 28 14 A 3 3 0 1 0 22 14 M 30 18 A 3 3 0 1 0 36 18 A 3 3 0 1 0 30 18",
            "shoe_color" => "#e4e4e7",
            "shoe_accent" => "#ffffff",
            "sole_color" => "#b45309",
            "glow_color" => "#ffffff"
        ]
    ];

    foreach ($banners_data as $i => $data) {
        $filepath = $target_dir . '/banner_main' . $i . '.svg';
        
        $svg_content = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 500" width="100%" height="100%">
  <defs>
    <linearGradient id="bg_grad' . $i . '" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="' . $data['bg_from'] . '"/>
      <stop offset="100%" stop-color="' . $data['bg_to'] . '"/>
    </linearGradient>
    <linearGradient id="glow_grad' . $i . '" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="' . $data['glow_color'] . '" stop-opacity="0.7"/>
      <stop offset="100%" stop-color="' . $data['accent'] . '" stop-opacity="0"/>
    </linearGradient>
    <filter id="blur_eff">
      <feGaussianBlur stdDeviation="30" />
    </filter>
  </defs>
  <rect width="100%" height="100%" fill="url(#bg_grad' . $i . ')"/>
  
  <!-- Abstract Speed Lines -->
  <path d="M -100 250 L 1300 250" stroke="url(#glow_grad' . $i . ')" stroke-width="150" opacity="0.12" />
  <path d="M 0 220 Q 300 150, 600 280 T 1200 220" fill="none" stroke="' . $data['accent'] . '" stroke-width="3" opacity="0.25"/>
  <path d="M 100 280 Q 400 350, 800 200 T 1100 280" fill="none" stroke="' . $data['glow_color'] . '" stroke-width="2" opacity="0.15"/>
  
  <!-- Tech Grids -->
  <line x1="50" y1="0" x2="50" y2="500" stroke="' . $data['accent'] . '" stroke-width="0.5" opacity="0.1" stroke-dasharray="5 5"/>
  <line x1="1150" y1="0" x2="1150" y2="500" stroke="' . $data['accent'] . '" stroke-width="0.5" opacity="0.1" stroke-dasharray="5 5"/>

  <!-- Left Content: Bold Sporty Typography -->
  <g transform="translate(100, 110)">
    <!-- Logo Badge -->
    <path d="' . $data['logo'] . '" fill="' . $data['accent'] . '" opacity="0.95" />
    
    <!-- Titles -->
    <text x="0" y="90" font-family="Arial Black, Impact, sans-serif" font-weight="900" font-size="70" fill="#ffffff" letter-spacing="1">' . $data['title'] . '</text>
    <text x="0" y="165" font-family="Arial Black, Impact, sans-serif" font-weight="900" font-size="80" fill="' . $data['accent'] . '" letter-spacing="1">' . $data['subtitle'] . '</text>
    <text x="0" y="215" font-family="Segoe UI, Roboto, Arial, sans-serif" font-weight="bold" font-size="20" fill="#e2e8f0" letter-spacing="3">' . $data['desc'] . '</text>
    
    <!-- Features -->
    <g transform="translate(0, 260)" font-family="Segoe UI, Roboto, sans-serif" font-size="14" font-weight="bold" fill="#cbd5e1">
      <circle cx="10" cy="-5" r="5" fill="' . $data['accent'] . '"/>
      <text x="25" y="0">ĐỆM ĐẾ GIẢM CHẤN</text>
      <circle cx="230" cy="-5" r="5" fill="' . $data['accent'] . '"/>
      <text x="245" y="0">DA MỀM CẢM GIÁC CỰC TỐT</text>
    </g>
  </g>

  <!-- Right Content: Shoe Silhouette Showcase -->
  <g transform="translate(710, 30)">
    <!-- Back light glow -->
    <circle cx="200" cy="220" r="170" fill="' . $data['accent'] . '" opacity="0.2" filter="url(#blur_eff)"/>
    <circle cx="150" cy="200" r="110" fill="' . $data['glow_color'] . '" opacity="0.15" filter="url(#blur_eff)"/>
    
    <!-- Sole & Studs -->
    <path d="M 40 335 L 360 335 L 340 345 L 60 345 Z" fill="' . $data['sole_color'] . '" />
    <circle cx="80" cy="348" r="4" fill="' . $data['accent'] . '" />
    <circle cx="120" cy="348" r="4" fill="' . $data['accent'] . '" />
    <circle cx="160" cy="348" r="4" fill="' . $data['accent'] . '" />
    <circle cx="240" cy="348" r="4" fill="' . $data['glow_color'] . '" />
    <circle cx="280" cy="348" r="4" fill="' . $data['glow_color'] . '" />
    <circle cx="320" cy="348" r="4" fill="' . $data['glow_color'] . '" />

    <!-- Shoe Upper Body -->
    <path d="M 45 335 C 40 270, 90 240, 130 250 C 180 200, 230 150, 300 160 C 335 165, 345 190, 360 220 C 385 240, 410 290, 400 335 Z" fill="' . $data['shoe_color'] . '" stroke="#1e293b" stroke-width="2"/>
    <path d="M 45 335 C 40 270, 90 240, 130 250 C 180 200, 230 150, 300 160 Z" fill="#0f172a" opacity="0.12"/>
    
    <!-- Dynamic overlay lines / stripes -->
    <path d="M 120 290 C 200 270, 260 210, 330 230 C 290 250, 200 320, 110 305 Z" fill="none" stroke="' . $data['shoe_accent'] . '" stroke-width="8" stroke-linecap="round" opacity="0.8"/>
    <path d="M 130 298 C 190 285, 240 235, 310 250 C 285 265, 205 315, 122 305 Z" fill="none" stroke="#ffffff" stroke-width="4" stroke-linecap="round" opacity="0.6"/>
    
    <!-- Sock Collar -->
    <path d="M 230 155 C 240 100, 310 100, 320 155" fill="none" stroke="' . $data['shoe_accent'] . '" stroke-width="12" stroke-linecap="round"/>
    <path d="M 233 155 C 243 105, 307 105, 317 155" fill="none" stroke="#ffffff" stroke-width="6" stroke-linecap="round"/>
    
    <!-- Laces -->
    <path d="M 200 180 L 250 220" fill="none" stroke="#1e293b" stroke-width="4" stroke-linecap="round" opacity="0.7" />
    <path d="M 215 170 L 265 210" fill="none" stroke="#1e293b" stroke-width="4" stroke-linecap="round" opacity="0.7" />
  </g>
</svg>';
        
        file_put_contents($filepath, $svg_content);
    }
    
    // Sub banner
    $sub_filepath = $target_dir . '/banner_sub.svg';
    $sub_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 280" width="100%" height="100%">
  <defs>
    <linearGradient id="sub_bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#0f172a"/>
      <stop offset="100%" stop-color="#1e293b"/>
    </linearGradient>
  </defs>
  <rect width="100%" height="100%" fill="url(#sub_bg)" rx="12"/>
  <circle cx="1000" cy="140" r="110" fill="#eab308" opacity="0.1" filter="blur(30px)"/>
  
  <g transform="translate(80, 50)">
    <text x="0" y="20" font-family="Segoe UI, sans-serif" font-weight="800" font-size="12" fill="#eab308" letter-spacing="1">MIZUNO JAPAN</text>
    <text x="0" y="65" font-family="Arial Black, Impact, sans-serif" font-weight="900" font-size="40" fill="#ffffff">ĐỈNH CAO DA THẬT K-LEATHER</text>
    <text x="0" y="110" font-family="Segoe UI, sans-serif" font-size="16" fill="#94a3b8">Cảm giác bóng tối ưu, siêu mềm mại, ôm chân hoàn hảo tuyệt đối.</text>
    
    <!-- Button mock -->
    <rect x="0" y="135" width="160" height="40" rx="8" fill="#eab308"/>
    <text x="80" y="160" font-family="Segoe UI, sans-serif" font-weight="bold" font-size="14" fill="#000" text-anchor="middle">XEM BỘ SƯU TẬP</text>
  </g>
</svg>';
    file_put_contents($sub_filepath, $sub_svg);

    // Banners for bottom of Homepage (Sneaker Story & Spa)
    $story_filepath = $target_dir . '/banner_sneaker_story.svg';
    $story_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 250" width="100%" height="100%">
      <defs>
          <linearGradient id="g1" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#1e293b"/>
              <stop offset="100%" stop-color="#0f172a"/>
          </linearGradient>
      </defs>
      <rect width="600" height="250" fill="url(#g1)" rx="12"/>
      <path d="M 350 0 L 600 0 L 600 250 L 300 250 Z" fill="#ef4444" opacity="0.15"/>
      <g transform="translate(420, 40)" stroke="#ef4444" stroke-width="2" fill="none" opacity="0.7">
          <rect x="0" y="0" width="120" height="150" rx="8" stroke="#ffffff"/>
          <line x1="0" y1="50" x2="120" y2="50" stroke="#ffffff"/>
          <line x1="0" y1="100" x2="120" y2="100" stroke="#ffffff"/>
          <path d="M 20 40 Q 40 20 60 40 L 90 40" stroke="#ef4444" stroke-width="4" stroke-linecap="round"/>
          <path d="M 20 90 Q 40 70 60 90 L 90 90" stroke="#eab308" stroke-width="4" stroke-linecap="round"/>
          <path d="M 20 140 Q 40 120 60 140 L 90 140" stroke="#3b82f6" stroke-width="4" stroke-linecap="round"/>
      </g>
      <g transform="translate(40, 90)">
          <rect width="250" height="50" rx="8" fill="rgba(0,0,0,0.6)" />
          <text x="125" y="32" font-family="\'Segoe UI\', Roboto, sans-serif" font-size="16" font-weight="900" fill="#ffffff" text-anchor="middle" letter-spacing="1">Câu chuyện Sneaker Daily</text>
      </g>
  </svg>';
    file_put_contents($story_filepath, $story_svg);

    $spa_filepath = $target_dir . '/banner_sneaker_spa.svg';
    $spa_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 250" width="100%" height="100%">
      <defs>
          <linearGradient id="g2" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#fffbeb"/>
              <stop offset="100%" stop-color="#fef3c7"/>
          </linearGradient>
      </defs>
      <rect width="600" height="250" fill="url(#g2)" rx="12" stroke="#fcd34d" stroke-width="1"/>
      <path d="M 0 0 L 250 0 L 300 250 L 0 250 Z" fill="#facc15" opacity="0.1"/>
      <g transform="translate(420, 60)">
          <path d="M 10 100 Q 50 60 90 100 L 120 100 Q 130 110 110 110 Z" fill="none" stroke="#d97706" stroke-width="3" stroke-linecap="round"/>
          <path d="M 60 40 L 65 50 L 75 55 L 65 60 L 60 70 L 55 60 L 45 55 L 55 50 Z" fill="#f59e0b"/>
          <path d="M 110 30 L 113 37 L 120 40 L 113 43 L 110 50 L 107 43 L 100 40 L 107 37 Z" fill="#3b82f6"/>
          <circle cx="30" cy="50" r="10" fill="none" stroke="#3b82f6" stroke-width="1.5" opacity="0.5"/>
          <circle cx="45" cy="30" r="6" fill="none" stroke="#3b82f6" stroke-width="1.5" opacity="0.5"/>
          <circle cx="85" cy="25" r="8" fill="none" stroke="#3b82f6" stroke-width="1.5" opacity="0.5"/>
      </g>
      <g transform="translate(40, 70)">
          <rect width="260" height="90" rx="8" fill="rgba(0,0,0,0.75)"/>
          <text x="130" y="32" font-family="\'Segoe UI\', Roboto, sans-serif" font-size="15" font-weight="900" fill="#fcd34d" text-anchor="middle" letter-spacing="1">MIỄN PHÍ</text>
          <text x="130" y="52" font-family="\'Segoe UI\', Roboto, sans-serif" font-size="12" font-weight="700" fill="#ffffff" text-anchor="middle" letter-spacing="0.5">SPA GIÀY CHUYÊN NGHIỆP</text>
          <text x="130" y="75" font-family="\'Segoe UI\', Roboto, sans-serif" font-size="14" font-weight="900" fill="#ffffff" text-anchor="middle">Dịch vụ hài lòng 100%</text>
      </g>
  </svg>';
    file_put_contents($spa_filepath, $spa_svg);
}
?>
