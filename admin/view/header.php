<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị - Soccer Sports</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-sidebar { background: #0f172a; }
        .sidebar-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px; border-radius: 8px;
            font-weight: 600; font-size: 14px; color: #94a3b8;
            text-decoration: none; transition: all 0.2s;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.06); color: #e2e8f0; }
        .sidebar-link.active { background: rgba(57,255,20,0.12); color: #39ff14; }
        .sidebar-group-label {
            font-size: 10px; font-weight: 800; letter-spacing: 1.5px;
            color: #475569; text-transform: uppercase;
            padding: 14px 14px 6px;
        }
        .admin-alert { padding: 10px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 18px; }
        .admin-alert.success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .admin-alert.danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .admin-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .admin-table th { background: #f8fafc; font-weight: 700; text-align: left; padding: 12px 16px; border-bottom: 2px solid #e2e8f0; color: #475569; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        .admin-table td { padding: 13px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .admin-table tr:hover td { background: #fafbfc; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .badge-wait    { background: #fef3c7; color: #92400e; }
        .badge-ship    { background: #dbeafe; color: #1e40af; }
        .badge-done    { background: #dcfce7; color: #166534; }
        .badge-cancel  { background: #fee2e2; color: #991b1b; }
        .badge-admin   { background: #f3e8ff; color: #7e22ce; }
        .badge-user    { background: #f1f5f9; color: #475569; }
        .btn-sm { padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; border: none; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: opacity 0.2s; }
        .btn-sm:hover { opacity: 0.85; }
        .btn-edit   { background: #3b82f6; color: white; }
        .btn-delete { background: #ef4444; color: white; }
        .btn-view   { background: #0f172a; color: white; }
        .btn-success{ background: #22c55e; color: white; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-weight: 700; font-size: 13px; color: #374151; margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 10px 14px; border: 1.5px solid #e2e8f0;
            border-radius: 8px; font-size: 14px; outline: none;
            transition: border-color 0.2s; box-sizing: border-box;
        }
        .form-control:focus { border-color: #3b82f6; }
        textarea.form-control { resize: vertical; min-height: 120px; }
        .card-admin { background: white; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); padding: 28px; }
        .page-title { font-size: 22px; font-weight: 800; color: #1e293b; margin-bottom: 24px; }
    </style>
</head>
<body style="background-color:#f1f5f9; font-family: 'Inter', sans-serif;">

<div style="display: grid; grid-template-columns: 230px 1fr; min-height: 100vh;">

    <!-- Sidebar -->
    <aside class="admin-sidebar" style="padding: 0; display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh; overflow-y: auto;">

        <!-- Logo -->
        <div style="padding: 24px 20px 16px; border-bottom: 1px solid #1e293b;">
            <a href="index.php" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <div style="width: 34px; height: 34px; background: #39ff14; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-gauge-high" style="color: #0f172a; font-size: 16px;"></i>
                </div>
                <span style="font-size: 16px; font-weight: 800; color: white;">Admin<span style="color: #39ff14;">Panel</span></span>
            </a>
        </div>

        <!-- Nav -->
        <nav style="flex: 1; padding: 12px 12px; overflow-y: auto;">

            <!-- Dashboard -->
            <a href="index.php?act=dashboard" class="sidebar-link <?php echo (!isset($_GET['act']) || $_GET['act']=='dashboard') ? 'active' : ''; ?>">
                <i class="fa-solid fa-chart-pie" style="width:16px;"></i> Bảng điều khiển
            </a>

            <!-- Catalogue -->
            <div class="sidebar-group-label">Quản lý nội dung</div>
            <a href="index.php?act=danhmuc-list" class="sidebar-link <?php echo (isset($_GET['act']) && strpos($_GET['act'],'danhmuc')!==false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-list-ul" style="width:16px;"></i> Danh mục
            </a>
            <a href="index.php?act=sanpham-list" class="sidebar-link <?php echo (isset($_GET['act']) && strpos($_GET['act'],'sanpham')!==false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-shoe-prints" style="width:16px;"></i> Sản phẩm
            </a>
            <a href="index.php?act=baiviet-list" class="sidebar-link <?php echo (isset($_GET['act']) && strpos($_GET['act'],'baiviet')!==false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-newspaper" style="width:16px;"></i> Bài viết / Tin tức
            </a>
            <a href="index.php?act=banner-list" class="sidebar-link <?php echo (isset($_GET['act']) && strpos($_GET['act'],'banner')!==false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-image" style="width:16px;"></i> Banner slider
            </a>

            <!-- Business -->
            <div class="sidebar-group-label">Kinh doanh & Báo cáo</div>
            <a href="index.php?act=thongke" class="sidebar-link <?php echo (isset($_GET['act']) && $_GET['act']=='thongke') ? 'active' : ''; ?>">
                <i class="fa-solid fa-chart-line" style="width:16px;"></i> Thống kê doanh thu
            </a>
            <a href="index.php?act=donhang-list" class="sidebar-link <?php echo (isset($_GET['act']) && strpos($_GET['act'],'donhang')!==false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-box-open" style="width:16px;"></i> Đơn hàng
                <?php
                    $pending = pdo_query_value("SELECT COUNT(*) FROM donhang WHERE trang_thai=0");
                    if ($pending > 0): ?>
                    <span style="margin-left:auto;background:#ef4444;color:white;font-size:10px;font-weight:800;padding:2px 7px;border-radius:20px;"><?php echo $pending; ?></span>
                <?php endif; ?>
            </a>
            <a href="index.php?act=taikhoan-list" class="sidebar-link <?php echo (isset($_GET['act']) && strpos($_GET['act'],'taikhoan')!==false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-users" style="width:16px;"></i> Người dùng
            </a>
            <a href="index.php?act=binhluan-list" class="sidebar-link <?php echo (isset($_GET['act']) && strpos($_GET['act'],'binhluan')!==false) ? 'active' : ''; ?>">
                <i class="fa-solid fa-comments" style="width:16px;"></i> Bình luận
                <?php
                    $pending_bl = pdo_query_value("SELECT COUNT(*) FROM binhluan");
                    if ($pending_bl > 0): ?>
                    <span style="margin-left:auto;background:#6366f1;color:white;font-size:10px;font-weight:800;padding:2px 7px;border-radius:20px;"><?php echo $pending_bl; ?></span>
                <?php endif; ?>
            </a>

        </nav>

        <!-- Footer links -->
        <div style="border-top: 1px solid #1e293b; padding: 12px;">
            <a href="../index.php" class="sidebar-link">
                <i class="fa-solid fa-arrow-up-right-from-square" style="width:16px;"></i> Xem website
            </a>
            <a href="../index.php?act=dangxuat" class="sidebar-link" style="color:#f87171;">
                <i class="fa-solid fa-power-off" style="width:16px;"></i> Đăng xuất
            </a>
        </div>
    </aside>

    <!-- Main content -->
    <div style="display: flex; flex-direction: column; overflow-y: auto;">

        <!-- Topbar -->
        <header style="background: white; border-bottom: 1px solid #e2e8f0; padding: 14px 32px; position: sticky; top: 0; z-index: 10; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-weight: 800; font-size: 16px; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                <?php
                    $act_now = isset($_GET['act']) ? $_GET['act'] : 'dashboard';
                    $titles = [
                        'dashboard'    => '📊 Bảng điều khiển',
                        'danhmuc-list' => '📂 Quản lý danh mục',
                        'danhmuc-add'  => '➕ Thêm danh mục',
                        'danhmuc-edit' => '✏️ Sửa danh mục',
                        'sanpham-list' => '👟 Quản lý sản phẩm',
                        'sanpham-add'  => '➕ Thêm sản phẩm',
                        'sanpham-edit' => '✏️ Sửa sản phẩm',
                        'donhang-list'   => '📦 Quản lý đơn hàng',
                        'donhang-detail' => '📋 Chi tiết đơn hàng',
                        'taikhoan-list'  => '👤 Quản lý người dùng',
                        'taikhoan-add'   => '➕ Thêm người dùng',
                        'taikhoan-edit'  => '✏️ Sửa người dùng',
                        'profile'        => '⚙️ Hồ sơ cá nhân',
                        'thongke'        => '📈 Thống kê & Báo cáo',
                        'banner-list'    => '🖼️ Quản lý banner',
                        'banner-add'     => '➕ Thêm banner',
                        'banner-edit'    => '✏️ Sửa banner',
                        'baiviet-list'   => '📰 Quản lý bài viết',
                        'baiviet-add'    => '➕ Thêm bài viết',
                        'baiviet-edit'   => '✏️ Sửa bài viết',
                        'binhluan-list'  => '💬 Quản lý bình luận',
                    ];
                    echo $titles[$act_now] ?? 'Quản trị';
                ?>
            </h3>
            <a href="index.php?act=profile" style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #475569; text-decoration: none; border: 1.5px solid #e2e8f0; padding: 6px 14px; border-radius: 20px; background: #f8fafc; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9';this.style.borderColor='#cbd5e1'" onmouseout="this.style.background='#f8fafc';this.style.borderColor='#e2e8f0'">
                <i class="fa-solid fa-user-gear" style="font-size: 14px; color: #64748b;"></i>
                <span>Hồ sơ: <?php echo htmlspecialchars($_SESSION['user']['user']); ?></span>
            </a>
        </header>

        <main style="padding: 32px; flex-grow: 1;">
            <?php if (isset($_GET['success'])): ?>
                <div class="admin-alert success">
                    <?php
                        $msgs = ['1' => '✅ Thêm mới thành công!', '2' => '✅ Cập nhật thành công!', '3' => '🗑️ Đã xóa thành công!'];
                        echo $msgs[$_GET['success']] ?? '✅ Thao tác thành công!';
                    ?>
                </div>
            <?php endif; ?>
