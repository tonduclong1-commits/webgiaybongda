<?php
// CartController.php - Handles shopping cart actions and checkout flow
require_once __DIR__ . '/../model/sanpham.php';
require_once __DIR__ . '/../model/donhang.php';

class CartController {

    /**
     * Khởi tạo giỏ hàng nếu chưa tồn tại
     */
    public function __construct() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $size = isset($_POST['size']) ? htmlspecialchars($_POST['size']) : '39';
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

            if ($id > 0 && $quantity > 0) {
                // Lấy thông tin sản phẩm từ database
                $product = sanpham_get_by_id($id);
                if ($product) {
                    $cart_key = $id . '_' . $size; // Unique key cho mỗi cặp ID + Size
                    
                    if (isset($_SESSION['cart'][$cart_key])) {
                        $_SESSION['cart'][$cart_key]['quantity'] += $quantity;
                    } else {
                        // Xác định giá bán (ưu tiên giá giảm nếu có)
                        $gia_ban = ($product['gia_giam'] > 0) ? $product['gia_giam'] : $product['gia'];
                        
                        $_SESSION['cart'][$cart_key] = [
                            'id' => $id,
                            'ten_sanpham' => $product['ten_sanpham'],
                            'hinh_anh' => $product['hinh_anh'],
                            'gia' => $gia_ban,
                            'size' => $size,
                            'quantity' => $quantity
                        ];
                    }
                }
            }
        }
        header('Location: index.php?act=giohang');
        exit();
    }

    /**
     * Hiển thị giỏ hàng
     */
    public function view() {
        $cart = $_SESSION['cart'];
        
        // Tính tổng tiền
        $tong_tien = 0;
        foreach ($cart as $item) {
            $tong_tien += $item['gia'] * $item['quantity'];
        }

        include 'view/header.php';
        include 'view/giohang.php';
        include 'view/footer.php';
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $cart_key => $quantity) {
                $quantity = intval($quantity);
                if ($quantity <= 0) {
                    unset($_SESSION['cart'][$cart_key]);
                } else {
                    if (isset($_SESSION['cart'][$cart_key])) {
                        $_SESSION['cart'][$cart_key]['quantity'] = $quantity;
                    }
                }
            }
        }
        header('Location: index.php?act=giohang');
        exit();
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function delete() {
        $key = isset($_GET['key']) ? htmlspecialchars($_GET['key']) : '';
        if ($key != '' && isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
        }
        header('Location: index.php?act=giohang');
        exit();
    }

    /**
     * Hiển thị trang thanh toán
     */
    public function checkout() {
        if (empty($_SESSION['cart'])) {
            header('Location: index.php?act=sanpham');
            exit();
        }

        $cart = $_SESSION['cart'];
        $tong_tien = 0;
        foreach ($cart as $item) {
            $tong_tien += $item['gia'] * $item['quantity'];
        }

        // Tự động điền thông tin nếu đã đăng nhập
        $user_info = isset($_SESSION['user']) ? $_SESSION['user'] : null;

        include 'view/header.php';
        include 'view/thanhtoan.php';
        include 'view/footer.php';
    }

    /**
     * Xử lý đặt hàng (lưu vào CSDL)
     */
    public function placeOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_SESSION['cart'])) {
                header('Location: index.php?act=sanpham');
                exit();
            }

            $nguoi_nhan = isset($_POST['nguoi_nhan']) ? trim(htmlspecialchars($_POST['nguoi_nhan'])) : '';
            $email = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : '';
            $dien_thoai = isset($_POST['dien_thoai']) ? trim(htmlspecialchars($_POST['dien_thoai'])) : '';
            $dia_chi = isset($_POST['dia_chi']) ? trim(htmlspecialchars($_POST['dia_chi'])) : '';
            $pttt = isset($_POST['pttt']) ? intval($_POST['pttt']) : 0; // 0: COD, 1: CK ngân hàng

            if (empty($nguoi_nhan) || empty($email) || empty($dien_thoai) || empty($dia_chi)) {
                $_SESSION['error_checkout'] = "Vui lòng nhập đầy đủ thông tin giao hàng!";
                header('Location: index.php?act=thanhtoan');
                exit();
            }

            // Tính tổng tiền
            $tong_tien = 0;
            foreach ($_SESSION['cart'] as $item) {
                $tong_tien += $item['gia'] * $item['quantity'];
            }

            $id_user = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
            $ngay_dat = date('d-m-Y H:i:s');

            try {
                // 1. Lưu vào bảng donhang
                $id_donhang = donhang_insert($id_user, $nguoi_nhan, $email, $dien_thoai, $dia_chi, $ngay_dat, $tong_tien, $pttt);

                if ($id_donhang > 0) {
                    // 2. Lưu chi tiết đơn hàng
                    foreach ($_SESSION['cart'] as $item) {
                        chitiet_donhang_insert(
                            $id_donhang, 
                            $item['id'], 
                            $item['ten_sanpham'], 
                            $item['hinh_anh'], 
                            $item['gia'], 
                            $item['quantity'], 
                            $item['size']
                        );
                    }

                    // 3. Xóa giỏ hàng sau khi đặt thành công
                    $_SESSION['cart'] = [];

                    // Chuyển tới trang thành công
                    header("Location: index.php?act=donhang-success&id=" . $id_donhang);
                    exit();
                } else {
                    $_SESSION['error_checkout'] = "Không thể tạo đơn hàng. Vui lòng thử lại!";
                    header('Location: index.php?act=thanhtoan');
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error_checkout'] = "Đã xảy ra lỗi hệ thống: " . $e->getMessage();
                header('Location: index.php?act=thanhtoan');
                exit();
            }
        } else {
            header('Location: index.php?act=trangchu');
            exit();
        }
    }

    /**
     * Trang hoàn tất đặt hàng thành công
     */
    public function success() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $order = donhang_get_by_id($id);
        
        if (!$order) {
            header('Location: index.php?act=trangchu');
            exit();
        }

        $order_details = donhang_get_details($id);

        include 'view/header.php';
        include 'view/donhang_success.php';
        include 'view/footer.php';
    }
}
?>
