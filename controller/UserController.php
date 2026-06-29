<?php
/**
 * UserController - Xử lý đăng ký, đăng nhập, đăng xuất, cập nhật tài khoản
 */

class UserController {

    /* =========================================================
     * ĐĂNG KÝ (Register)
     * ========================================================= */
    public function register() {
        if (isset($_POST['dangky'])) {
            $user       = trim($_POST['user']);
            $email      = trim($_POST['email']);
            $dien_thoai = trim($_POST['dien_thoai']);
            $pass       = $_POST['pass'];
            $repass     = $_POST['repass'];

            // Validation
            if (empty($user) || empty($email) || empty($dien_thoai) || empty($pass) || empty($repass)) {
                $error = "Vui lòng nhập đầy đủ tất cả các trường thông tin bắt buộc.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Địa chỉ Email không đúng định dạng.";
            } elseif (!preg_match('/^(0[3|5|7|8|9])+([0-9]{8})$/', $dien_thoai)) {
                $error = "Số điện thoại không đúng định dạng (phải có 10 chữ số bắt đầu bằng 03, 05, 07, 08 hoặc 09).";
            } elseif ($pass !== $repass) {
                $error = "Mật khẩu xác nhận nhập lại không trùng khớp.";
            } elseif (strlen($pass) < 6) {
                $error = "Mật khẩu phải chứa ít nhất 6 ký tự.";
            } else {
                $check_exists = taikhoan_exists($user, $email, $dien_thoai);
                if ($check_exists) {
                    $errors_list = [];
                    if (in_array('user',        $check_exists)) $errors_list[] = "Tên đăng nhập đã bị đăng ký.";
                    if (in_array('email',       $check_exists)) $errors_list[] = "Địa chỉ Email đã được sử dụng.";
                    if (in_array('dien_thoai',  $check_exists)) $errors_list[] = "Số điện thoại này đã được sử dụng.";
                    $error = implode("<br>", $errors_list);
                } else {
                    try {
                        taikhoan_insert($user, $pass, $email, $dien_thoai);
                        $success = "Đăng ký thành viên thành công! Bạn có thể <a href='index.php?act=dangnhap'>đăng nhập ngay</a>.";
                        // Clear POST to reset form
                        $_POST = [];
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

    /* =========================================================
     * ĐĂNG NHẬP (Login)
     * Hỗ trợ đăng nhập bằng TÊN ĐĂNG NHẬP hoặc EMAIL
     * ========================================================= */
    public function login() {
        // Đã đăng nhập → chuyển về trang chủ
        if (isset($_SESSION['user'])) {
            header('Location: index.php');
            exit();
        }

        if (isset($_POST['dangnhap'])) {
            $username_or_email = trim($_POST['user']);
            $pass              = $_POST['pass'];

            if (empty($username_or_email) || empty($pass)) {
                $error = "Vui lòng điền đầy đủ tên đăng nhập / email và mật khẩu.";
            } else {
                // Thử đăng nhập bằng username
                $login_check = taikhoan_check($username_or_email, $pass);

                // Nếu không tìm thấy, thử đăng nhập bằng email
                if (!$login_check) {
                    $login_check = $this->login_by_email($username_or_email, $pass);
                }

                if ($login_check) {
                    $_SESSION['user'] = $login_check;

                    // Chuyển hướng: Admin → trang admin, User → trang chủ
                    if ($login_check['vai_tro'] == 1) {
                        header('Location: admin/index.php');
                    } else {
                        header('Location: index.php');
                    }
                    exit();
                } else {
                    $error = "Tên đăng nhập / email hoặc mật khẩu không chính xác.";
                }
            }
        }

        include 'view/header.php';
        include 'view/dangnhap.php';
        include 'view/footer.php';
    }

    /**
     * Đăng nhập bằng email (helper)
     */
    private function login_by_email($email, $pass) {
        $sql     = "SELECT * FROM taikhoan WHERE email = ?";
        $account = pdo_query_one($sql, $email);

        if ($account && password_verify($pass, $account['pass'])) {
            return $account;
        }
        return false;
    }

    /* =========================================================
     * ĐĂNG XUẤT (Logout)
     * ========================================================= */
    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: index.php');
        exit();
    }

    /* =========================================================
     * CẬP NHẬT THÔNG TIN CÁ NHÂN & ĐỔI MẬT KHẨU
     * ========================================================= */
    public function capnhat() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?act=dangnhap');
            exit();
        }

        $user_id     = $_SESSION['user']['id'];
        $current_user = taikhoan_get_by_id($user_id);

        if (isset($_POST['capnhat'])) {
            $user       = trim($_POST['user']);
            $email      = trim($_POST['email']);
            $dien_thoai = trim($_POST['dien_thoai']);
            $pass       = $_POST['pass'];
            $repass     = $_POST['repass'];

            // Validation
            if (empty($user) || empty($email)) {
                $error = "Tên đăng nhập và Email không được bỏ trống.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Địa chỉ Email không đúng định dạng.";
            } elseif (!empty($pass) && strlen($pass) < 6) {
                $error = "Mật khẩu mới phải chứa ít nhất 6 ký tự.";
            } elseif (!empty($pass) && $pass !== $repass) {
                $error = "Xác nhận mật khẩu mới nhập lại không khớp.";
            } else {
                // Kiểm tra trùng username/email với tài khoản khác
                $dup = pdo_query_one(
                    "SELECT * FROM taikhoan WHERE (user = ? OR email = ?) AND id <> ?",
                    $user, $email, $user_id
                );

                if ($dup) {
                    if ($dup['user'] === $user)  $error = "Tên đăng nhập này đã được dùng bởi tài khoản khác.";
                    else                          $error = "Email này đã được dùng bởi tài khoản khác.";
                } else {
                    try {
                        taikhoan_update($user_id, $user, $email, $dien_thoai, $pass);
                        $success = "✅ Cập nhật thông tin tài khoản thành công!";

                        // Làm mới session
                        $_SESSION['user'] = taikhoan_get_by_id($user_id);
                        $current_user     = $_SESSION['user'];
                    } catch (Exception $e) {
                        $error = "Lỗi hệ thống: " . $e->getMessage();
                    }
                }
            }
        }

        include 'view/header.php';
        include 'view/taikhoan_capnhat.php';
        include 'view/footer.php';
    }
}
?>
