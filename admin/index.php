<?php
// Admin Panel Front Controller

session_start();

// Include database connections and model scripts
require_once __DIR__ . '/../model/connect.php';
require_once __DIR__ . '/../model/danhmuc.php';
require_once __DIR__ . '/../model/sanpham.php';
require_once __DIR__ . '/../model/taikhoan.php';
require_once __DIR__ . '/../model/donhang.php';
require_once __DIR__ . '/../model/banner.php';
require_once __DIR__ . '/../model/baiviet.php';
require_once __DIR__ . '/../model/binhluan.php';

// Include Admin Controller
require_once __DIR__ . '/../controller/AdminController.php';

// Instantiate controller (Constructor automatically restricts non-admin sessions)
$controller = new AdminController();

// Route parameter Act
$act = isset($_GET['act']) ? $_GET['act'] : 'dashboard';

switch ($act) {
    case 'dashboard':
        $controller->dashboard();
        break;

    // Categories CRUD routes
    case 'danhmuc-list':    $controller->danhmuc_list();   break;
    case 'danhmuc-add':     $controller->danhmuc_add();    break;
    case 'danhmuc-edit':    $controller->danhmuc_edit();   break;
    case 'danhmuc-delete':  $controller->danhmuc_delete(); break;

    // Products CRUD routes
    case 'sanpham-list':    $controller->sanpham_list();   break;
    case 'sanpham-add':     $controller->sanpham_add();    break;
    case 'sanpham-edit':    $controller->sanpham_edit();   break;
    case 'sanpham-delete':  $controller->sanpham_delete(); break;

    // Orders routes
    case 'donhang-list':    $controller->donhang_list();   break;
    case 'donhang-detail':  $controller->donhang_detail(); break;
    case 'donhang-status':  $controller->donhang_status(); break;
    case 'donhang-delete':  $controller->donhang_delete_order(); break;

    // Users routes
    case 'taikhoan-list':   $controller->taikhoan_list();  break;
    case 'taikhoan-add':    $controller->taikhoan_add();   break;
    case 'taikhoan-edit':   $controller->taikhoan_edit();  break;
    case 'taikhoan-role':   $controller->taikhoan_role();  break;
    case 'taikhoan-delete': $controller->taikhoan_delete_user(); break;
    case 'profile':         $controller->profile();        break;

    // Banner routes
    case 'banner-list':     $controller->banner_list();    break;
    case 'banner-add':      $controller->banner_add();     break;
    case 'banner-edit':     $controller->banner_edit();    break;
    case 'banner-delete':   $controller->banner_delete_banner(); break;

    // Articles/News routes
    case 'baiviet-list':    $controller->baiviet_list();   break;
    case 'baiviet-add':     $controller->baiviet_add();    break;
    case 'baiviet-edit':    $controller->baiviet_edit();   break;
    case 'baiviet-delete':  $controller->baiviet_delete_article(); break;

    // Comment routes
    case 'binhluan-list':   $controller->binhluan_list();  break;
    case 'binhluan-delete': $controller->binhluan_delete_comment(); break;

    // Statistics & Reports
    case 'thongke':         $controller->thongke();        break;

    default:
        header('Location: index.php?act=dashboard');
        exit();
}
?>
