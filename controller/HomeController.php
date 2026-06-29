<?php
// HomeController.php - Handles homepage, static views, and contact submissions

class HomeController {

    public function home() {
        // Load banners dynamically
        $banners_slider = banner_get_by_position('slider');
        $banners_sub = banner_get_by_position('sub_banner');

        // Load outstanding products
        $ds_dacbiet = sanpham_dac_biet(4);

        // Load hot deal products
        $sp_deals = sanpham_get_deals();

        // Load categories list
        $ds_danhmuc = danhmuc_all();

        // Load products by category for homepage tabs (encourage requirement)
        $sp_turf = sanpham_all('', 1);   // TF Turf
        $sp_grass = sanpham_all('', 2);  // FG Grass
        $sp_futsal = sanpham_all('', 3); // IC Indoor
        $sp_balls = sanpham_all('', 4);  // Footballs
        $sp_sneakers = sanpham_all('', 6); // Sneakers
        
        // Sort sneakers: premium (dac_biet=1) first, then by ID ascending
        usort($sp_sneakers, function($a, $b) {
            if ($a['dac_biet'] != $b['dac_biet']) {
                return $b['dac_biet'] <=> $a['dac_biet'];
            }
            return $a['id'] <=> $b['id'];
        });

        // Load latest blog posts (encourage requirement)
        $ds_baiviet = baiviet_all(3); // Get 3 latest posts

        include 'view/header.php';
        include 'view/home.php';
        include 'view/footer.php';
    }

    public function about() {
        include 'view/header.php';
        include 'view/gioithieu.php';
        include 'view/footer.php';
    }

    public function contact() {
        include 'view/header.php';
        include 'view/lienhe.php';
        include 'view/footer.php';
    }

    public function brands() {
        // Fetch all products for the new Brands grid layout
        $ds_sanpham = sanpham_all();
        
        include 'view/header.php';
        include 'view/thuonghieu.php';
        include 'view/footer.php';
    }

    public function pickleball() {
        include 'view/header.php';
        include 'view/pickleball.php';
        include 'view/footer.php';
    }
}
?>
