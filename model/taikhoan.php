<?php
/**
 * Model User (Tài khoản người dùng)
 * 
 * Quản lý tài khoản khách hàng và quản trị viên.
 * Bảng database: `taikhoan` (id, user, pass, email, dien_thoai, vai_tro)
 * 
 * Cột vai_tro: 0 = Khách hàng, 1 = Admin
 * Mật khẩu được mã hóa bằng bcrypt (password_hash / password_verify).
 * 
 * Các hàm:
 * - taikhoan_insert()       : Đăng ký tài khoản mới
 * - taikhoan_check()        : Kiểm tra đăng nhập
 * - taikhoan_exists()       : Kiểm tra trùng lặp (user/email/SĐT)
 * - taikhoan_get_by_id()    : Lấy thông tin tài khoản theo ID
 * - taikhoan_all()          : Lấy tất cả tài khoản (dành cho Admin)
 * - taikhoan_update()       : Cập nhật thông tin cá nhân
 * - taikhoan_update_role()  : Thay đổi vai trò (nâng/hạ Admin)
 * - taikhoan_delete()       : Xóa tài khoản
 */

require_once __DIR__ . '/connect.php';

// ============================================================
// XÁC THỰC (AUTHENTICATION)
// ============================================================

/**
 * Đăng ký tài khoản mới
 * Mật khẩu sẽ được mã hóa tự động bằng bcrypt trước khi lưu.
 * 
 * @param string $user       Tên đăng nhập (duy nhất)
 * @param string $pass       Mật khẩu dạng thô (chưa mã hóa)
 * @param string $email      Địa chỉ email (duy nhất)
 * @param string $dien_thoai Số điện thoại (duy nhất)
 * @return int ID tài khoản vừa tạo
 * @throws PDOException Nếu user/email/phone đã tồn tại (UNIQUE constraint)
 * 
 * @example
 *   taikhoan_insert("nguyenvan_a", "matkhau123", "a@gmail.com", "0901234567");
 */
function taikhoan_insert($user, $pass, $email, $dien_thoai) {
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO taikhoan (user, pass, email, dien_thoai, vai_tro) VALUES (?, ?, ?, ?, 0)";
    return pdo_execute($sql, $user, $hashed_pass, $email, $dien_thoai);
}

/**
 * Kiểm tra thông tin đăng nhập
 * 
 * @param string $user Tên đăng nhập
 * @param string $pass Mật khẩu dạng thô (chưa mã hóa)
 * @return array|false Bản ghi tài khoản nếu đúng, false nếu sai
 * 
 * @example
 *   $account = taikhoan_check("nguyenvan_a", "matkhau123");
 *   if ($account) {
 *       $_SESSION['user'] = $account;
 *   } else {
 *       echo "Sai tài khoản hoặc mật khẩu!";
 *   }
 */
function taikhoan_check($user, $pass) {
    $sql     = "SELECT * FROM taikhoan WHERE user = ?";
    $account = pdo_query_one($sql, $user);

    if ($account && password_verify($pass, $account['pass'])) {
        return $account;
    }

    return false;
}

/**
 * Kiểm tra xem tài khoản / email / số điện thoại đã tồn tại chưa
 * Dùng khi đăng ký để tránh trùng lặp.
 * 
 * @param string $user       Tên đăng nhập cần kiểm tra
 * @param string $email      Email cần kiểm tra
 * @param string $dien_thoai Số điện thoại cần kiểm tra
 * @return array|false Mảng các trường bị trùng (['user'], ['email'], ['dien_thoai']), hoặc false nếu không có trùng
 * 
 * @example
 *   $dup = taikhoan_exists("nguyenvan_a", "a@gmail.com", "0901234567");
 *   if ($dup) {
 *       if (in_array('email', $dup)) echo "Email đã được sử dụng!";
 *   }
 */
function taikhoan_exists($user, $email, $dien_thoai) {
    $sql    = "SELECT * FROM taikhoan WHERE user = ? OR email = ? OR dien_thoai = ?";
    $result = pdo_query_one($sql, $user, $email, $dien_thoai);

    if ($result) {
        $duplicated = [];
        if ($result['user']        === $user)       $duplicated[] = 'user';
        if ($result['email']       === $email)      $duplicated[] = 'email';
        if ($result['dien_thoai']  === $dien_thoai) $duplicated[] = 'dien_thoai';
        return $duplicated;
    }

    return false;
}

// ============================================================
// ĐỌC DỮ LIỆU (READ)
// ============================================================

/**
 * Lấy thông tin tài khoản theo ID
 * 
 * @param int $id ID tài khoản
 * @return array|false Bản ghi tài khoản (không bao gồm mật khẩu rõ ràng), hoặc false
 * 
 * @example
 *   $user = taikhoan_get_by_id(5);
 *   echo $user['email']; // "a@gmail.com"
 */
function taikhoan_get_by_id($id) {
    $sql = "SELECT * FROM taikhoan WHERE id = ?";
    return pdo_query_one($sql, $id);
}

/**
 * Lấy tất cả tài khoản (dành cho trang quản trị)
 * Có hỗ trợ tìm kiếm theo username hoặc email.
 * 
 * @param string $keyword Từ khóa tìm kiếm (mặc định: '' = lấy tất cả)
 * @return array Mảng tài khoản, sắp xếp theo ID mới nhất
 * 
 * @example
 *   $all   = taikhoan_all();           // Lấy tất cả
 *   $found = taikhoan_all("nguyen");   // Tìm theo từ khóa
 */
function taikhoan_all($keyword = '') {
    if ($keyword != '') {
        $sql = "SELECT id, user, email, dien_thoai, vai_tro FROM taikhoan 
                WHERE user LIKE ? OR email LIKE ? ORDER BY id DESC";
        return pdo_query($sql, "%" . $keyword . "%", "%" . $keyword . "%");
    }
    $sql = "SELECT id, user, email, dien_thoai, vai_tro FROM taikhoan ORDER BY id DESC";
    return pdo_query($sql);
}

// ============================================================
// CẬP NHẬT (UPDATE)
// ============================================================

/**
 * Cập nhật thông tin cá nhân của tài khoản
 * Nếu $pass trống, mật khẩu sẽ không bị thay đổi.
 * 
 * @param int    $id         ID tài khoản cần cập nhật
 * @param string $user       Tên đăng nhập mới
 * @param string $email      Email mới
 * @param string $dien_thoai Số điện thoại mới
 * @param string $pass       Mật khẩu mới (bỏ trống để giữ nguyên mật khẩu cũ)
 * 
 * @example
 *   // Cập nhật không đổi mật khẩu
 *   taikhoan_update(5, "nguyen_b", "b@gmail.com", "0907654321");
 * 
 *   // Cập nhật đổi mật khẩu luôn
 *   taikhoan_update(5, "nguyen_b", "b@gmail.com", "0907654321", "matkhaumoi");
 */
function taikhoan_update($id, $user, $email, $dien_thoai, $pass = '') {
    if (!empty($pass)) {
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "UPDATE taikhoan SET user = ?, email = ?, dien_thoai = ?, pass = ? WHERE id = ?";
        pdo_execute($sql, $user, $email, $dien_thoai, $hashed_pass, $id);
    } else {
        $sql = "UPDATE taikhoan SET user = ?, email = ?, dien_thoai = ? WHERE id = ?";
        pdo_execute($sql, $user, $email, $dien_thoai, $id);
    }
}

/**
 * Thay đổi vai trò của tài khoản (nâng/hạ quyền)
 * 
 * @param int $id       ID tài khoản
 * @param int $vai_tro  0 = Khách hàng, 1 = Admin
 * 
 * @example
 *   taikhoan_update_role(5, 1); // Nâng lên Admin
 *   taikhoan_update_role(5, 0); // Hạ xuống Khách hàng
 */
function taikhoan_update_role($id, $vai_tro) {
    $sql = "UPDATE taikhoan SET vai_tro = ? WHERE id = ?";
    pdo_execute($sql, $vai_tro, $id);
}

// ============================================================
// XÓA (DELETE)
// ============================================================

/**
 * Xóa tài khoản theo ID
 * Lưu ý: Không nên xóa tài khoản đang đăng nhập.
 * 
 * @param int $id ID tài khoản cần xóa
 * 
 * @example
 *   taikhoan_delete(5);
 */
function taikhoan_delete($id) {
    $sql = "DELETE FROM taikhoan WHERE id = ?";
    pdo_execute($sql, $id);
}
?>
