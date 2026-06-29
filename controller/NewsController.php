<?php
// NewsController.php - Handles news blog listings and details

class NewsController {

    public function list() {
        // Fetch all blog posts
        $ds_baiviet = baiviet_all();

        include 'view/header.php';
        include 'view/baiviet.php';
        include 'view/footer.php';
    }

    public function detail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id > 0) {
            $baiviet = baiviet_get_by_id($id);
            if ($baiviet) {
                // Fetch other recent posts (excluding current post)
                $db = pdo_get_connection();
                $recent_posts = $db->prepare("SELECT * FROM baiviet WHERE id <> ? ORDER BY id DESC LIMIT 3");
                $recent_posts->execute([$id]);
                $ds_recent = $recent_posts->fetchAll();

                include 'view/header.php';
                include 'view/chitiet_baiviet.php';
                include 'view/footer.php';
            } else {
                header('Location: index.php?act=tintuc');
                exit();
            }
        } else {
            header('Location: index.php?act=tintuc');
            exit();
        }
    }
}
?>
