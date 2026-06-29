<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Giày Bóng Đá Premium</title>
    <link rel="stylesheet" href="assets/css/style.css?v=1.7">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <!-- Top Promo Bar (Supersports style) -->
        <div class="promo-bar">
            <span>ƯU ĐÃI CUỐI MÙA | GIẢM ĐẾN 50% CHO NHIỀU SẢN PHẨM</span>
            <a href="index.php?act=sanpham">Xem ngay</a>
        </div>

        <div class="container">
            <div class="navbar">
                <!-- Logo -->
                <div class="logo" style="max-height: 40px; display: flex; align-items: center;">
                    <a href="index.php" style="display: block;">
                        <img src="assets/images/logo.png" alt="Soccer Sports Logo" style="height: 38px; width: auto; object-fit: contain;">
                    </a>
                </div>

                <!-- Navigation Links -->
                <ul class="nav-links">
                    <li><a href="index.php" class="<?php echo (!isset($_GET['act']) || $_GET['act'] == 'trangchu') ? 'active' : ''; ?>">Trang chủ</a></li>
                    <li>
                        <a href="index.php?act=sanpham" class="<?php echo (isset($_GET['act']) && $_GET['act'] == 'sanpham') ? 'active' : ''; ?>">
                            Giày Bóng Đá
                        </a>
                    </li>
                    <li>
                        <a href="index.php?act=pickball" class="<?php echo (isset($_GET['act']) && ($_GET['act'] == 'pickleball' || $_GET['act'] == 'pickball')) ? 'active' : ''; ?>">
                            Pickball
                        </a>
                    </li>
                    <li>
                        <a href="index.php?act=thuonghieu" class="<?php echo (isset($_GET['act']) && $_GET['act'] == 'thuonghieu') ? 'active' : ''; ?>">
                            Thương Hiệu
                        </a>
                    </li>
                    <li><a href="index.php?act=tintuc" class="<?php echo (isset($_GET['act']) && ($_GET['act'] == 'tintuc' || $_GET['act'] == 'chitiet-baiviet')) ? 'active' : ''; ?>">Tin tức</a></li>
                    <li><a href="index.php?act=gioithieu" class="<?php echo (isset($_GET['act']) && $_GET['act'] == 'gioithieu') ? 'active' : ''; ?>">Giới thiệu</a></li>
                    <li><a href="index.php?act=lienhe" class="<?php echo (isset($_GET['act']) && $_GET['act'] == 'lienhe') ? 'active' : ''; ?>">Liên hệ</a></li>
                </ul>

                <!-- Navigation Actions (Search, Cart, User) -->
                <div class="nav-actions">
                    <!-- Search Bar -->
                    <form action="index.php" method="GET" class="search-box">
                        <input type="hidden" name="act" value="sanpham">
                        <input type="text" name="keyword" placeholder="Bạn đang tìm gì..." value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>

                    <!-- Cart Icon (Dynamic) -->
                    <a href="index.php?act=giohang" class="btn-icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <?php 
                        $cart_count = 0;
                        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $item) {
                                $cart_count += $item['quantity'];
                            }
                        }
                        if ($cart_count > 0):
                        ?>
                            <span class="badge"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- User Account / Session -->
                    <div class="user-action">
                        <?php if (isset($_SESSION['user'])): ?>
                            <div class="user-info">
                                Xin chào, <a href="index.php?act=capnhat-taikhoan" style="color: var(--primary); font-weight: 700; text-decoration: underline;" title="Cập nhật thông tin tài khoản"><?php echo htmlspecialchars($_SESSION['user']['user']); ?></a>
                                <?php if ($_SESSION['user']['vai_tro'] == 1): ?>
                                    <span style="color: var(--primary); font-size: 11px; display: block;">(Admin)</span>
                                <?php endif; ?>
                                <a href="index.php?act=dangxuat" style="margin-left: 10px; color: var(--danger); font-size: 13px;" title="Đăng xuất">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="user-info">
                                <a href="index.php?act=dangnhap" title="Đăng nhập"><i class="fa-regular fa-user"></i> Đăng nhập</a>
                                <span style="color: #475569; margin: 0 5px;">|</span>
                                <a href="index.php?act=dangky">Đăng ký</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
