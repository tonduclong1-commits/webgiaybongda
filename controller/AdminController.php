<?php
// AdminController - Full CRUD for all admin modules

class AdminController {

    public function __construct() {
        $this->check_admin();
        if (!is_dir(__DIR__ . '/../uploads')) {
            mkdir(__DIR__ . '/../uploads', 0777, true);
        }
    }

    private function check_admin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['vai_tro'] != 1) {
            header('Location: ../index.php?act=dangnhap');
            exit();
        }
    }

    /* =========================================================================
     * DASHBOARD
     * ========================================================================= */
    public function dashboard() {
        $total_categories = count(danhmuc_all());
        $db = pdo_get_connection();
        $total_products  = $db->query("SELECT COUNT(*) FROM sanpham")->fetchColumn();
        $total_users     = $db->query("SELECT COUNT(*) FROM taikhoan")->fetchColumn();
        $total_orders    = $db->query("SELECT COUNT(*) FROM donhang")->fetchColumn();
        $total_revenue   = $db->query("SELECT SUM(tong_tien) FROM donhang WHERE trang_thai=2")->fetchColumn();
        $total_revenue   = $total_revenue ? $total_revenue : 0;
        $recent_orders   = pdo_query("SELECT * FROM donhang ORDER BY id DESC LIMIT 8");
        include 'view/header.php';
        include 'view/dashboard.php';
        include 'view/footer.php';
    }

    /* =========================================================================
     * CATEGORY CRUD (Danh mục)
     * ========================================================================= */
    public function danhmuc_list() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $ds_danhmuc = $keyword != '' ? danhmuc_search($keyword) : danhmuc_all();
        include 'view/header.php';
        include 'view/danhmuc/list.php';
        include 'view/footer.php';
    }

    public function danhmuc_add() {
        if (isset($_POST['themmoi'])) {
            $ten_danhmuc = trim($_POST['ten_danhmuc']);
            if (empty($ten_danhmuc)) {
                $error = "Tên danh mục không được bỏ trống.";
            } else {
                try {
                    danhmuc_insert($ten_danhmuc);
                    header('Location: index.php?act=danhmuc-list&success=1');
                    exit();
                } catch (Exception $e) {
                    $error = "Tên danh mục này đã tồn tại.";
                }
            }
        }
        include 'view/header.php';
        include 'view/danhmuc/add.php';
        include 'view/footer.php';
    }

    public function danhmuc_edit() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) { header('Location: index.php?act=danhmuc-list'); exit(); }
        $danhmuc = danhmuc_get_by_id($id);
        if (!$danhmuc) { header('Location: index.php?act=danhmuc-list'); exit(); }

        if (isset($_POST['capnhat'])) {
            $ten_danhmuc = trim($_POST['ten_danhmuc']);
            if (empty($ten_danhmuc)) {
                $error = "Tên danh mục không được bỏ trống.";
            } else {
                try {
                    danhmuc_update($id, $ten_danhmuc);
                    header('Location: index.php?act=danhmuc-list&success=2');
                    exit();
                } catch (Exception $e) {
                    $error = "Tên danh mục này đã tồn tại.";
                }
            }
        }
        include 'view/header.php';
        include 'view/danhmuc/edit.php';
        include 'view/footer.php';
    }

    public function danhmuc_delete() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            try {
                $products = pdo_query("SELECT hinh_anh FROM sanpham WHERE id_danhmuc = ?", $id);
                foreach ($products as $p) {
                    if (strpos($p['hinh_anh'], 'uploads/') === 0) {
                        $f = __DIR__ . '/../' . $p['hinh_anh'];
                        if (file_exists($f)) @unlink($f);
                    }
                }
                danhmuc_delete($id);
            } catch (Exception $e) {}
        }
        header('Location: index.php?act=danhmuc-list&success=3');
        exit();
    }

    /* =========================================================================
     * PRODUCT CRUD (Sản phẩm)
     * ========================================================================= */
    public function sanpham_list() {
        $keyword    = isset($_GET['keyword'])    ? trim($_GET['keyword'])    : '';
        $id_danhmuc = isset($_GET['id_danhmuc']) ? (int)$_GET['id_danhmuc'] : 0;
        $ds_sanpham = sanpham_all($keyword, $id_danhmuc);
        $ds_danhmuc = danhmuc_all();
        include 'view/header.php';
        include 'view/sanpham/list.php';
        include 'view/footer.php';
    }

    public function sanpham_add() {
        $ds_danhmuc = danhmuc_all();
        if (isset($_POST['themmoi'])) {
            $ten_sanpham = trim($_POST['ten_sanpham']);
            $gia         = (double)$_POST['gia'];
            $gia_giam    = ($_POST['gia_giam'] !== '') ? (double)$_POST['gia_giam'] : null;
            $mo_ta       = trim($_POST['mo_ta']);
            $id_danhmuc  = (int)$_POST['id_danhmuc'];
            $dac_biet    = isset($_POST['dac_biet']) ? 1 : 0;

            if (empty($ten_sanpham) || $gia <= 0 || $id_danhmuc <= 0) {
                $error = "Vui lòng nhập tên sản phẩm, giá bán hợp lệ và chọn danh mục.";
            } else {
                $hinh_anh = 'assets/images/placeholder.png';
                if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['hinh_anh']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                        $new_name = time() . '_' . uniqid() . '.' . $ext;
                        $dest = __DIR__ . '/../uploads/' . $new_name;
                        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $dest)) {
                            $hinh_anh = 'uploads/' . $new_name;
                        } else { $error = "Lỗi khi lưu ảnh."; }
                    } else { $error = "Định dạng ảnh không hỗ trợ."; }
                }
                if (!isset($error)) {
                    sanpham_insert($ten_sanpham, $gia, $gia_giam, $hinh_anh, $mo_ta, $id_danhmuc, $dac_biet);
                    header('Location: index.php?act=sanpham-list&success=1');
                    exit();
                }
            }
        }
        include 'view/header.php';
        include 'view/sanpham/add.php';
        include 'view/footer.php';
    }

    public function sanpham_edit() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) { header('Location: index.php?act=sanpham-list'); exit(); }
        $sanpham = sanpham_get_by_id($id);
        if (!$sanpham) { header('Location: index.php?act=sanpham-list'); exit(); }
        $ds_danhmuc = danhmuc_all();

        if (isset($_POST['capnhat'])) {
            $ten_sanpham = trim($_POST['ten_sanpham']);
            $gia         = (double)$_POST['gia'];
            $gia_giam    = ($_POST['gia_giam'] !== '') ? (double)$_POST['gia_giam'] : null;
            $mo_ta       = trim($_POST['mo_ta']);
            $id_danhmuc  = (int)$_POST['id_danhmuc'];
            $dac_biet    = isset($_POST['dac_biet']) ? 1 : 0;

            if (empty($ten_sanpham) || $gia <= 0 || $id_danhmuc <= 0) {
                $error = "Vui lòng nhập đầy đủ thông tin hợp lệ.";
            } else {
                $hinh_anh = $sanpham['hinh_anh'];
                if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['hinh_anh']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                        $new_name = time() . '_' . uniqid() . '.' . $ext;
                        $dest = __DIR__ . '/../uploads/' . $new_name;
                        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $dest)) {
                            if (strpos($sanpham['hinh_anh'], 'uploads/') === 0) {
                                $old = __DIR__ . '/../' . $sanpham['hinh_anh'];
                                if (file_exists($old)) unlink($old);
                            }
                            $hinh_anh = 'uploads/' . $new_name;
                        } else { $error = "Lỗi khi lưu ảnh mới."; }
                    } else { $error = "Định dạng ảnh không hỗ trợ."; }
                }
                if (!isset($error)) {
                    sanpham_update($id, $ten_sanpham, $gia, $gia_giam, $hinh_anh, $mo_ta, $id_danhmuc, $dac_biet);
                    header('Location: index.php?act=sanpham-list&success=2');
                    exit();
                }
            }
        }
        include 'view/header.php';
        include 'view/sanpham/edit.php';
        include 'view/footer.php';
    }

    public function sanpham_delete() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $sp = sanpham_get_by_id($id);
            if ($sp) {
                sanpham_delete($id);
                if (strpos($sp['hinh_anh'], 'uploads/') === 0) {
                    $f = __DIR__ . '/../' . $sp['hinh_anh'];
                    if (file_exists($f)) unlink($f);
                }
            }
        }
        header('Location: index.php?act=sanpham-list&success=3');
        exit();
    }

    /* =========================================================================
     * ORDER MANAGEMENT (Đơn hàng)
     * ========================================================================= */
    public function donhang_list() {
        $trang_thai = isset($_GET['trang_thai']) ? (int)$_GET['trang_thai'] : -1;
        $keyword    = isset($_GET['keyword'])    ? trim($_GET['keyword'])    : '';

        if ($keyword != '') {
            $ds_donhang = pdo_query(
                "SELECT * FROM donhang WHERE nguoi_nhan LIKE ? OR dien_thoai LIKE ? OR email LIKE ? ORDER BY id DESC",
                "%$keyword%", "%$keyword%", "%$keyword%"
            );
        } elseif ($trang_thai >= 0) {
            $ds_donhang = pdo_query("SELECT * FROM donhang WHERE trang_thai = ? ORDER BY id DESC", $trang_thai);
        } else {
            $ds_donhang = donhang_all();
        }

        // Stats
        $db = pdo_get_connection();
        $stats = [
            'all'       => $db->query("SELECT COUNT(*) FROM donhang")->fetchColumn(),
            'cho'       => $db->query("SELECT COUNT(*) FROM donhang WHERE trang_thai=0")->fetchColumn(),
            'dang_giao' => $db->query("SELECT COUNT(*) FROM donhang WHERE trang_thai=1")->fetchColumn(),
            'hoan_thanh'=> $db->query("SELECT COUNT(*) FROM donhang WHERE trang_thai=2")->fetchColumn(),
            'da_huy'    => $db->query("SELECT COUNT(*) FROM donhang WHERE trang_thai=3")->fetchColumn(),
        ];

        include 'view/header.php';
        include 'view/donhang/list.php';
        include 'view/footer.php';
    }

    public function donhang_detail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) { header('Location: index.php?act=donhang-list'); exit(); }
        $donhang = donhang_get_by_id($id);
        if (!$donhang) { header('Location: index.php?act=donhang-list'); exit(); }
        $chi_tiet = donhang_get_details($id);
        include 'view/header.php';
        include 'view/donhang/detail.php';
        include 'view/footer.php';
    }

    public function donhang_status() {
        $id         = isset($_GET['id'])         ? (int)$_GET['id']         : 0;
        $trang_thai = isset($_GET['trang_thai']) ? (int)$_GET['trang_thai'] : 0;
        if ($id > 0) {
            donhang_update_status($id, $trang_thai);
        }
        header('Location: index.php?act=donhang-detail&id=' . $id . '&success=1');
        exit();
    }

    public function donhang_delete_order() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            pdo_execute("DELETE FROM chitiet_donhang WHERE id_donhang = ?", $id);
            pdo_execute("DELETE FROM donhang WHERE id = ?", $id);
        }
        header('Location: index.php?act=donhang-list&success=3');
        exit();
    }

    /* =========================================================================
     * USER MANAGEMENT (Tài khoản)
     * ========================================================================= */
    public function taikhoan_list() {
        $keyword    = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $ds_taikhoan = taikhoan_all($keyword);
        include 'view/header.php';
        include 'view/taikhoan/list.php';
        include 'view/footer.php';
    }

    public function taikhoan_role() {
        $id      = isset($_GET['id'])      ? (int)$_GET['id']      : 0;
        $vai_tro = isset($_GET['vai_tro']) ? (int)$_GET['vai_tro'] : 0;
        if ($id > 0) {
            taikhoan_update_role($id, $vai_tro);
        }
        header('Location: index.php?act=taikhoan-list&success=1');
        exit();
    }

    public function taikhoan_delete_user() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        // Prevent deleting own account
        if ($id > 0 && $id != $_SESSION['user']['id']) {
            taikhoan_delete($id);
        }
        header('Location: index.php?act=taikhoan-list&success=3');
        exit();
    }

    /* =========================================================================
     * BANNER MANAGEMENT (Banner)
     * ========================================================================= */
    public function banner_list() {
        $ds_banner = pdo_query("SELECT * FROM banner ORDER BY id ASC");
        include 'view/header.php';
        include 'view/banner/list.php';
        include 'view/footer.php';
    }

    public function banner_add() {
        if (isset($_POST['themmoi'])) {
            $ten_banner = trim($_POST['ten_banner']);
            $lien_ket   = trim($_POST['lien_ket']);
            $vi_tri     = isset($_POST['vi_tri']) ? trim($_POST['vi_tri']) : 'slider';

            if (empty($ten_banner)) {
                $error = "Tên banner không được trống.";
            } else {
                $hinh_anh = '';
                if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['hinh_anh']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                        $new_name = 'banner_' . time() . '_' . uniqid() . '.' . $ext;
                        $dest = __DIR__ . '/../uploads/' . $new_name;
                        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $dest)) {
                            $hinh_anh = 'uploads/' . $new_name;
                        } else { $error = "Lỗi khi lưu ảnh."; }
                    } else { $error = "Định dạng ảnh không hỗ trợ."; }
                }
                if (!isset($error)) {
                    pdo_execute(
                        "INSERT INTO banner (ten_banner, hinh_anh, lien_ket, vi_tri) VALUES (?,?,?,?)",
                        $ten_banner, $hinh_anh, $lien_ket, $vi_tri
                    );
                    header('Location: index.php?act=banner-list&success=1');
                    exit();
                }
            }
        }
        include 'view/header.php';
        include 'view/banner/add.php';
        include 'view/footer.php';
    }

    public function banner_edit() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) { header('Location: index.php?act=banner-list'); exit(); }
        $banner = pdo_query_one("SELECT * FROM banner WHERE id=?", $id);
        if (!$banner) { header('Location: index.php?act=banner-list'); exit(); }

        if (isset($_POST['capnhat'])) {
            $ten_banner = trim($_POST['ten_banner']);
            $lien_ket   = trim($_POST['lien_ket']);
            $vi_tri     = isset($_POST['vi_tri']) ? trim($_POST['vi_tri']) : 'slider';
            $hinh_anh   = $banner['hinh_anh'];

            if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['hinh_anh']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                    $new_name = 'banner_' . time() . '_' . uniqid() . '.' . $ext;
                    $dest = __DIR__ . '/../uploads/' . $new_name;
                    if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $dest)) {
                        if (strpos($banner['hinh_anh'], 'uploads/') === 0) {
                            $old = __DIR__ . '/../' . $banner['hinh_anh'];
                            if (file_exists($old)) unlink($old);
                        }
                        $hinh_anh = 'uploads/' . $new_name;
                    }
                }
            }

            pdo_execute("UPDATE banner SET ten_banner=?, hinh_anh=?, lien_ket=?, vi_tri=? WHERE id=?",
                $ten_banner, $hinh_anh, $lien_ket, $vi_tri, $id);
            header('Location: index.php?act=banner-list&success=2');
            exit();
        }
        include 'view/header.php';
        include 'view/banner/edit.php';
        include 'view/footer.php';
    }

    public function banner_delete_banner() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $banner = pdo_query_one("SELECT * FROM banner WHERE id=?", $id);
            if ($banner) {
                pdo_execute("DELETE FROM banner WHERE id=?", $id);
                if (strpos($banner['hinh_anh'], 'uploads/') === 0) {
                    $f = __DIR__ . '/../' . $banner['hinh_anh'];
                    if (file_exists($f)) unlink($f);
                }
            }
        }
        header('Location: index.php?act=banner-list&success=3');
        exit();
    }

    /* =========================================================================
     * NEWS/ARTICLE MANAGEMENT (Bài viết)
     * ========================================================================= */
    public function baiviet_list() {
        $keyword   = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $ds_baiviet = $keyword != '' ? baiviet_search($keyword) : baiviet_all();
        include 'view/header.php';
        include 'view/baiviet/list.php';
        include 'view/footer.php';
    }

    public function baiviet_add() {
        if (isset($_POST['themmoi'])) {
            $tieu_de  = trim($_POST['tieu_de']);
            $noi_dung = trim($_POST['noi_dung']);
            $tac_gia  = trim($_POST['tac_gia']);
            $ngay_dang = date('Y-m-d');

            if (empty($tieu_de) || empty($noi_dung)) {
                $error = "Tiêu đề và nội dung không được trống.";
            } else {
                $hinh_anh = '';
                if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['hinh_anh']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                        $new_name = 'news_' . time() . '_' . uniqid() . '.' . $ext;
                        $dest = __DIR__ . '/../uploads/' . $new_name;
                        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $dest)) {
                            $hinh_anh = 'uploads/' . $new_name;
                        }
                    }
                }
                baiviet_insert($tieu_de, $noi_dung, $hinh_anh, $tac_gia, $ngay_dang);
                header('Location: index.php?act=baiviet-list&success=1');
                exit();
            }
        }
        include 'view/header.php';
        include 'view/baiviet/add.php';
        include 'view/footer.php';
    }

    public function baiviet_edit() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) { header('Location: index.php?act=baiviet-list'); exit(); }
        $baiviet = baiviet_get_by_id($id);
        if (!$baiviet) { header('Location: index.php?act=baiviet-list'); exit(); }

        if (isset($_POST['capnhat'])) {
            $tieu_de  = trim($_POST['tieu_de']);
            $noi_dung = trim($_POST['noi_dung']);
            $tac_gia  = trim($_POST['tac_gia']);
            $hinh_anh = $baiviet['hinh_anh'];

            if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['hinh_anh']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                    $new_name = 'news_' . time() . '_' . uniqid() . '.' . $ext;
                    $dest = __DIR__ . '/../uploads/' . $new_name;
                    if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $dest)) {
                        if (strpos($baiviet['hinh_anh'], 'uploads/') === 0) {
                            $old = __DIR__ . '/../' . $baiviet['hinh_anh'];
                            if (file_exists($old)) unlink($old);
                        }
                        $hinh_anh = 'uploads/' . $new_name;
                    }
                }
            }
            baiviet_update($id, $tieu_de, $noi_dung, $hinh_anh, $tac_gia);
            header('Location: index.php?act=baiviet-list&success=2');
            exit();
        }
        include 'view/header.php';
        include 'view/baiviet/edit.php';
        include 'view/footer.php';
    }

    public function baiviet_delete_article() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $bv = baiviet_get_by_id($id);
            if ($bv) {
                baiviet_delete($id);
                if (strpos($bv['hinh_anh'], 'uploads/') === 0) {
                    $f = __DIR__ . '/../' . $bv['hinh_anh'];
                    if (file_exists($f)) unlink($f);
                }
            }
        }
        header('Location: index.php?act=baiviet-list&success=3');
        exit();
    }

    /* =========================================================================
     * COMMENT MANAGEMENT (Bình luận)
     * ========================================================================= */

    /**
     * Danh sách tất cả bình luận — có lọc theo sản phẩm và từ khóa
     */
    public function binhluan_list() {
        $keyword   = isset($_GET['keyword'])  ? trim($_GET['keyword'])  : '';
        $id_pro    = isset($_GET['id_pro'])   ? (int)$_GET['id_pro']   : 0;

        if ($keyword != '') {
            $sql = "SELECT bl.*, tk.user, sp.ten_sanpham, sp.hinh_anh AS anh_sp
                    FROM binhluan bl
                    INNER JOIN taikhoan tk ON bl.id_user = tk.id
                    INNER JOIN sanpham  sp ON bl.id_pro  = sp.id
                    WHERE bl.noi_dung LIKE ? OR tk.user LIKE ?
                    ORDER BY bl.id DESC";
            $ds_binhluan = pdo_query($sql, "%$keyword%", "%$keyword%");
        } elseif ($id_pro > 0) {
            $sql = "SELECT bl.*, tk.user, sp.ten_sanpham, sp.hinh_anh AS anh_sp
                    FROM binhluan bl
                    INNER JOIN taikhoan tk ON bl.id_user = tk.id
                    INNER JOIN sanpham  sp ON bl.id_pro  = sp.id
                    WHERE bl.id_pro = ?
                    ORDER BY bl.id DESC";
            $ds_binhluan = pdo_query($sql, $id_pro);
        } else {
            $ds_binhluan = binhluan_all();
        }

        // Thống kê
        $db = pdo_get_connection();
        $total_comments  = $db->query("SELECT COUNT(*) FROM binhluan")->fetchColumn();
        $total_products_with_comments = $db->query("SELECT COUNT(DISTINCT id_pro) FROM binhluan")->fetchColumn();
        $most_commented  = pdo_query_one(
            "SELECT sp.ten_sanpham, COUNT(bl.id) as cnt
             FROM binhluan bl
             INNER JOIN sanpham sp ON bl.id_pro = sp.id
             GROUP BY bl.id_pro ORDER BY cnt DESC LIMIT 1"
        );

        // Danh sách sản phẩm để lọc
        $ds_sanpham_filter = pdo_query(
            "SELECT sp.id, sp.ten_sanpham, COUNT(bl.id) as cnt
             FROM sanpham sp
             INNER JOIN binhluan bl ON sp.id = bl.id_pro
             GROUP BY sp.id ORDER BY cnt DESC"
        );

        include 'view/header.php';
        include 'view/binhluan/list.php';
        include 'view/footer.php';
    }

    /**
     * Xóa một bình luận
     */
    public function binhluan_delete_comment() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            binhluan_delete($id);
        }
        $back = isset($_GET['back']) ? $_GET['back'] : 'binhluan-list';
        header('Location: index.php?act=' . $back . '&success=3');
        exit();
    }

    /* =========================================================================
     * USER CRUD EXTENSION (Thêm/Sửa thành viên)
     * ========================================================================= */
    
    public function taikhoan_add() {
        if (isset($_POST['themmoi'])) {
            $user       = trim($_POST['username']);
            $email      = trim($_POST['email']);
            $dien_thoai = trim($_POST['dien_thoai']);
            $pass       = $_POST['password'];
            $vai_tro    = (int)$_POST['vai_tro'];

            if (empty($user) || empty($email) || empty($pass)) {
                $error = "Vui lòng điền đầy đủ các thông tin bắt buộc.";
            } else {
                $dup = taikhoan_exists($user, $email, $dien_thoai);
                if ($dup) {
                    if (in_array('user', $dup)) $error = "Tên đăng nhập đã tồn tại.";
                    elseif (in_array('email', $dup)) $error = "Email đã tồn tại.";
                    elseif (in_array('dien_thoai', $dup)) $error = "Số điện thoại đã tồn tại.";
                } else {
                    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                    pdo_execute(
                        "INSERT INTO taikhoan (user, pass, email, dien_thoai, vai_tro) VALUES (?, ?, ?, ?, ?)",
                        $user, $hashed_pass, $email, $dien_thoai, $vai_tro
                    );
                    header('Location: index.php?act=taikhoan-list&success=1');
                    exit();
                }
            }
        }
        include 'view/header.php';
        include 'view/taikhoan/add.php';
        include 'view/footer.php';
    }

    public function taikhoan_edit() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) { header('Location: index.php?act=taikhoan-list'); exit(); }
        $tk = taikhoan_get_by_id($id);
        if (!$tk) { header('Location: index.php?act=taikhoan-list'); exit(); }

        if (isset($_POST['capnhat'])) {
            $user       = trim($_POST['username']);
            $email      = trim($_POST['email']);
            $dien_thoai = trim($_POST['dien_thoai']);
            $pass       = $_POST['password'];
            $vai_tro    = (int)$_POST['vai_tro'];

            if (empty($user) || empty($email)) {
                $error = "Vui lòng điền đầy đủ các thông tin bắt buộc.";
            } else {
                $db = pdo_get_connection();
                $stmt = $db->prepare("SELECT id, user, email, dien_thoai FROM taikhoan WHERE (user=? OR email=? OR (dien_thoai!='' AND dien_thoai=?)) AND id != ?");
                $stmt->execute([$user, $email, $dien_thoai, $id]);
                $dup = $stmt->fetch();
                if ($dup) {
                    if ($dup['user'] == $user) $error = "Tên đăng nhập đã bị trùng.";
                    elseif ($dup['email'] == $email) $error = "Email đã bị trùng.";
                    else $error = "Số điện thoại đã bị trùng.";
                } else {
                    if (!empty($pass)) {
                        $hashed = password_hash($pass, PASSWORD_DEFAULT);
                        pdo_execute(
                            "UPDATE taikhoan SET user=?, email=?, dien_thoai=?, pass=?, vai_tro=? WHERE id=?",
                            $user, $email, $dien_thoai, $hashed, $vai_tro, $id
                        );
                    } else {
                        pdo_execute(
                            "UPDATE taikhoan SET user=?, email=?, dien_thoai=?, vai_tro=? WHERE id=?",
                            $user, $email, $dien_thoai, $vai_tro, $id
                        );
                    }
                    header('Location: index.php?act=taikhoan-list&success=2');
                    exit();
                }
            }
        }
        include 'view/header.php';
        include 'view/taikhoan/edit.php';
        include 'view/footer.php';
    }

    /* =========================================================================
     * PERSONAL PROFILE MANAGEMENT (Quản lý tài khoản cá nhân)
     * ========================================================================= */
    
    public function profile() {
        $id = $_SESSION['user']['id'];
        $tk = taikhoan_get_by_id($id);

        if (isset($_POST['capnhat'])) {
            $user       = trim($_POST['username']);
            $email      = trim($_POST['email']);
            $dien_thoai = trim($_POST['dien_thoai']);
            $old_pass   = $_POST['old_password'];
            $new_pass   = $_POST['new_password'];

            if (empty($user) || empty($email)) {
                $error = "Tên đăng nhập và email không được bỏ trống.";
            } else {
                $db = pdo_get_connection();
                $stmt = $db->prepare("SELECT id, user, email, dien_thoai FROM taikhoan WHERE (user=? OR email=? OR (dien_thoai!='' AND dien_thoai=?)) AND id != ?");
                $stmt->execute([$user, $email, $dien_thoai, $id]);
                $dup = $stmt->fetch();
                if ($dup) {
                    if ($dup['user'] == $user) $error = "Tên đăng nhập đã bị trùng.";
                    elseif ($dup['email'] == $email) $error = "Email đã bị trùng.";
                    else $error = "Số điện thoại đã bị trùng.";
                } else {
                    if (!empty($new_pass)) {
                        $user_db = pdo_query_one("SELECT pass FROM taikhoan WHERE id=?", $id);
                        if (!password_verify($old_pass, $user_db['pass'])) {
                            $error = "Mật khẩu cũ không chính xác.";
                        } else {
                            $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
                            pdo_execute(
                                "UPDATE taikhoan SET user=?, email=?, dien_thoai=?, pass=? WHERE id=?",
                                $user, $email, $dien_thoai, $hashed, $id
                            );
                            $_SESSION['user'] = taikhoan_get_by_id($id);
                            $success_msg = "Cập nhật tài khoản và mật khẩu thành công!";
                        }
                    } else {
                        pdo_execute(
                            "UPDATE taikhoan SET user=?, email=?, dien_thoai=? WHERE id=?",
                            $user, $email, $dien_thoai, $id
                        );
                        $_SESSION['user'] = taikhoan_get_by_id($id);
                        $success_msg = "Cập nhật thông tin tài khoản thành công!";
                    }
                }
            }
            // Fetch updated info
            $tk = taikhoan_get_by_id($id);
        }
        include 'view/header.php';
        include 'view/taikhoan/profile.php';
        include 'view/footer.php';
    }

    /* =========================================================================
     * STATISTICS & REPORTS (Báo cáo & Thống kê)
     * ========================================================================= */
    
    public function thongke() {
        $db = pdo_get_connection();
        
        // 1. General Stats
        $total_categories = count(danhmuc_all());
        $total_products   = $db->query("SELECT COUNT(*) FROM sanpham")->fetchColumn();
        $total_users      = $db->query("SELECT COUNT(*) FROM taikhoan")->fetchColumn();
        $total_orders     = $db->query("SELECT COUNT(*) FROM donhang")->fetchColumn();
        $total_revenue    = $db->query("SELECT SUM(tong_tien) FROM donhang WHERE trang_thai=2")->fetchColumn();
        $total_revenue    = $total_revenue ? $total_revenue : 0;
        $total_comments   = $db->query("SELECT COUNT(*) FROM binhluan")->fetchColumn();
        
        // Average order value (Completed orders)
        $avg_order_val = $db->query("SELECT AVG(tong_tien) FROM donhang WHERE trang_thai=2")->fetchColumn();
        $avg_order_val = $avg_order_val ? $avg_order_val : 0;
        
        // Success rate
        $completed_orders = $db->query("SELECT COUNT(*) FROM donhang WHERE trang_thai=2")->fetchColumn();
        $canceled_orders  = $db->query("SELECT COUNT(*) FROM donhang WHERE trang_thai=3")->fetchColumn();
        $success_rate = ($total_orders > 0) ? round(($completed_orders / $total_orders) * 100, 1) : 0;

        // 2. Order Status Breakdown
        $orders_by_status = [
            'cho'       => $db->query("SELECT COUNT(*) FROM donhang WHERE trang_thai=0")->fetchColumn(),
            'dang_giao' => $db->query("SELECT COUNT(*) FROM donhang WHERE trang_thai=1")->fetchColumn(),
            'hoan_thanh'=> $completed_orders,
            'da_huy'    => $canceled_orders,
        ];

        // 3. Category Product Distribution
        $category_distribution = pdo_query(
            "SELECT d.ten_danhmuc, COUNT(s.id) AS cnt 
             FROM danhmuc d 
             LEFT JOIN sanpham s ON d.id = s.id_danhmuc 
             GROUP BY d.id"
        );

        // 4. Top 5 Most Viewed Shoes
        $top_viewed_shoes = pdo_query(
            "SELECT ten_sanpham, luot_xem 
             FROM sanpham 
             ORDER BY luot_xem DESC 
             LIMIT 5"
        );

        // 5. Monthly revenue aggregation in PHP (handles database date format variations)
        $all_orders = pdo_query("SELECT ngay_dat, tong_tien, trang_thai FROM donhang");
        $monthly_revenue = [];
        $monthly_order_count = [];
        
        foreach ($all_orders as $o) {
            $date_str = $o['ngay_dat'];
            $parts = explode('-', $date_str);
            $month_year = '';
            if (count($parts) === 3) {
                if (strlen($parts[0]) === 4) { // YYYY-MM-DD
                    $month_year = $parts[1] . '/' . $parts[0];
                } else { // DD-MM-YYYY
                    $month_year = $parts[1] . '/' . $parts[2];
                }
            }
            if ($month_year != '') {
                if (!isset($monthly_revenue[$month_year])) {
                    $monthly_revenue[$month_year] = 0;
                    $monthly_order_count[$month_year] = 0;
                }
                if ($o['trang_thai'] == 2) { // Completed orders
                    $monthly_revenue[$month_year] += $o['tong_tien'];
                }
                $monthly_order_count[$month_year]++;
            }
        }
        
        // Sort months chronologically
        uksort($monthly_revenue, function($a, $b) {
            $t1 = DateTime::createFromFormat('m/Y', $a);
            $t2 = DateTime::createFromFormat('m/Y', $b);
            return $t1 <=> $t2;
        });
        
        // 6. Top 5 Best Selling Products (based on quantities in completed orders)
        $top_sold_shoes = pdo_query(
            "SELECT ctdh.ten_sanpham, SUM(ctdh.so_luong) AS sold_qty, SUM(ctdh.gia * ctdh.so_luong) AS revenue
             FROM chitiet_donhang ctdh 
             INNER JOIN donhang dh ON ctdh.id_donhang = dh.id 
             WHERE dh.trang_thai = 2 
             GROUP BY ctdh.id_sanpham 
             ORDER BY sold_qty DESC 
             LIMIT 5"
        );

        include 'view/header.php';
        include 'view/thongke/index.php';
        include 'view/footer.php';
    }
}
?>
