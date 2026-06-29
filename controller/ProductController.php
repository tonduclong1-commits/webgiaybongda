<?php
// ProductController.php - Handles product catalog listing, search, and detail displays

class ProductController {

    public function products() {
        // Search filter keyword
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        // Category filter
        $id_danhmuc = isset($_GET['id_danhmuc']) ? (int)$_GET['id_danhmuc'] : 0;
        // Sorting preference
        $sort = isset($_GET['sort']) ? trim($_GET['sort']) : '';

        // Query filtered products
        $ds_sanpham = sanpham_all($keyword, $id_danhmuc, $sort);
        // Load categories list for sidebar filter widget
        $ds_danhmuc = danhmuc_all();

        include 'view/header.php';
        include 'view/sanpham.php';
        include 'view/footer.php';
    }

    public function detail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id > 0) {
            // Handle comment submission
            if (isset($_POST['guibinhluan']) && isset($_SESSION['user'])) {
                $noi_dung = trim($_POST['noi_dung']);
                if (!empty($noi_dung)) {
                    $id_user = $_SESSION['user']['id'];
                    $ngay_binh_luan = date('d-m-Y');
                    
                    try {
                        binhluan_insert($noi_dung, $id_user, $id, $ngay_binh_luan);
                        // Redirect to prevent form resubmission
                        header('Location: index.php?act=chitiet&id=' . $id);
                        exit();
                    } catch (Exception $e) {
                        // Suppressed or logged
                    }
                }
            }

            // Increment view count
            sanpham_tang_luot_xem($id);
            
            // Get product detail info
            $chi_tiet = sanpham_get_by_id($id);
            
            if ($chi_tiet) {
                // Get related products in same category
                $ds_cungloai = sanpham_cung_loai($id, $chi_tiet['id_danhmuc'], 4);
                
                // Fetch product comments list
                $ds_binhluan = binhluan_get_by_product($id);
                
                include 'view/header.php';
                include 'view/chitiet.php';
                include 'view/footer.php';
            } else {
                header('Location: index.php');
                exit();
            }
        } else {
            header('Location: index.php');
            exit();
        }
    }
}
?>
