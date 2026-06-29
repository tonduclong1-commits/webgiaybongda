<?php
// ClientController class to process all public client actions

class ClientController {
    
    public function home() {
        // Get outstanding products
        $ds_dacbiet = sanpham_dac_biet(4);
        // Get new products
        $ds_moi = sanpham_moi(4);

        include 'view/header.php';
        include 'view/home.php';
        include 'view/footer.php';
    }

    public function products() {
        // Search filter keyword
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        // Category filter
        $id_danhmuc = isset($_GET['id_danhmuc']) ? (int)$_GET['id_danhmuc'] : 0;
        // Sorting preference
        $sort = isset($_GET['sort']) ? trim($_GET['sort']) : '';

        // Query filtered products
        $ds_sanpham = sanpham_all($keyword, $id_danhmuc, $sort);
        // Load categories for sidebar filter
        $ds_danhmuc = danhmuc_all();

        include 'view/header.php';
        include 'view/sanpham.php';
        include 'view/footer.php';
    }

    public function detail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            // Increment view count
            sanpham_tang_luot_xem($id);
            // Get product detail info
            $chi_tiet = sanpham_get_by_id($id);
            
            if ($chi_tiet) {
                // Get related products in same category
                $ds_cungloai = sanpham_cung_loai($id, $chi_tiet['id_danhmuc'], 4);
                
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

    public function register() {
        if (isset($_POST['dangky'])) {
            $user = trim($_POST['user']);
            $email = trim($_POST['email']);
            $dien_thoai = trim($_POST['dien_thoai']);
            $pass = $_POST['pass'];
            $repass = $_POST['repass'];

            // Validation
            if (empty($user) || empty($email) || empty($pass) || empty($repass)) {
                $error = "Vui lòng nhập đầy đủ các trường thông tin bắt buộc.";
            } elseif ($pass !== $repass) {
                $error = "Mật khẩu xác nhận nhập lại không trùng khớp.";
            } elseif (strlen($pass) < 6) {
                $error = "Mật khẩu phải chứa ít nhất 6 ký tự.";
            } else {
                // Check if user/email already exists
                $check_exists = taikhoan_exists($user, $email);
                if ($check_exists) {
                    if (in_array('user', $check_exists) && in_array('email', $check_exists)) {
                        $error = "Tên đăng nhập và Email này đã tồn tại.";
                    } elseif (in_array('user', $check_exists)) {
                        $error = "Tên đăng nhập đã bị đăng ký.";
                    } else {
                        $error = "Địa chỉ Email đã được sử dụng.";
                    }
                } else {
                    // Success, perform insertion
                    try {
                        taikhoan_insert($user, $pass, $email, $dien_thoai);
                        $success = "Đăng ký thành viên mới thành công! Bạn có thể chuyển sang trang Đăng nhập.";
                        unset($_POST);
                    } catch (Exception $e) {
                        $error = "Đã xảy ra lỗi hệ thống: " . $e->getMessage();
                    }
                }
            }
        }

        include 'view/header.php';
        include 'view/dangky.php';
        include 'view/footer.php';
    }

    public function login() {
        // If already logged in, redirect
        if (isset($_SESSION['user'])) {
            header('Location: index.php');
            exit();
        }

        if (isset($_POST['dangnhap'])) {
            $user = trim($_POST['user']);
            $pass = $_POST['pass'];

            if (empty($user) || empty($pass)) {
                $error = "Vui lòng điền đầy đủ cả tên đăng nhập và mật khẩu.";
            } else {
                $login_check = taikhoan_check($user, $pass);
                if ($login_check) {
                    $_SESSION['user'] = $login_check;
                    header('Location: index.php');
                    exit();
                } else {
                    $error = "Tên đăng nhập hoặc mật khẩu không chính xác.";
                }
            }
        }

        include 'view/header.php';
        include 'view/dangnhap.php';
        include 'view/footer.php';
    }

    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: index.php');
        exit();
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
}
?>
