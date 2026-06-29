<?php
/**
 * Model Comment (Bình luận sản phẩm)
 * 
 * Quản lý bình luận / đánh giá của khách hàng trên từng sản phẩm.
 * Bảng database: `binhluan` (id, noi_dung, id_user, id_pro, ngay_binh_luan)
 * 
 * Quan hệ:
 * - binhluan.id_user  → taikhoan.id   (người viết bình luận)
 * - binhluan.id_pro   → sanpham.id    (sản phẩm được bình luận)
 * 
 * Các hàm:
 * - binhluan_insert()          : Thêm bình luận mới
 * - binhluan_get_by_product()  : Lấy tất cả bình luận của một sản phẩm
 * - binhluan_get_by_user()     : Lấy tất cả bình luận của một người dùng
 * - binhluan_get_by_id()       : Lấy chi tiết một bình luận
 * - binhluan_count_by_product(): Đếm số bình luận của sản phẩm
 * - binhluan_delete()          : Xóa bình luận
 * - binhluan_all()             : Lấy tất cả bình luận (Admin)
 */

require_once __DIR__ . '/connect.php';

// ============================================================
// THÊM MỚI (CREATE)
// ============================================================

/**
 * Thêm bình luận mới cho sản phẩm
 * 
 * @param string $noi_dung       Nội dung bình luận
 * @param int    $id_user        ID người dùng (phải đăng nhập)
 * @param int    $id_pro         ID sản phẩm được bình luận
 * @param string $ngay_binh_luan Ngày giờ bình luận (vd: date('Y-m-d H:i:s'))
 * @return int ID bình luận vừa thêm
 * 
 * @example
 *   binhluan_insert("Sản phẩm rất tốt!", 5, 10, date('Y-m-d H:i:s'));
 */
function binhluan_insert($noi_dung, $id_user, $id_pro, $ngay_binh_luan) {
    $sql = "INSERT INTO binhluan (noi_dung, id_user, id_pro, ngay_binh_luan) VALUES (?, ?, ?, ?)";
    return pdo_execute($sql, $noi_dung, $id_user, $id_pro, $ngay_binh_luan);
}

// ============================================================
// ĐỌC DỮ LIỆU (READ)
// ============================================================

/**
 * Lấy danh sách tất cả bình luận của một sản phẩm (kèm tên người dùng)
 * Sắp xếp theo thứ tự mới nhất lên trên.
 * 
 * @param int $id_pro ID sản phẩm
 * @return array Mảng bình luận kèm thông tin (id, noi_dung, ngay_binh_luan, user)
 * 
 * @example
 *   $comments = binhluan_get_by_product(10);
 *   foreach ($comments as $cm) {
 *       echo $cm['user'] . ': ' . $cm['noi_dung'];
 *   }
 */
function binhluan_get_by_product($id_pro) {
    $sql = "SELECT bl.*, tk.user 
            FROM binhluan bl 
            INNER JOIN taikhoan tk ON bl.id_user = tk.id 
            WHERE bl.id_pro = ? 
            ORDER BY bl.id DESC";
    return pdo_query($sql, $id_pro);
}

/**
 * Lấy tất cả bình luận của một người dùng (kèm tên sản phẩm)
 * Dùng để hiển thị lịch sử bình luận trong trang tài khoản.
 * 
 * @param int $id_user ID người dùng
 * @return array Mảng bình luận kèm tên sản phẩm (ten_sanpham)
 * 
 * @example
 *   $my_comments = binhluan_get_by_user(5);
 */
function binhluan_get_by_user($id_user) {
    $sql = "SELECT bl.*, sp.ten_sanpham, sp.hinh_anh 
            FROM binhluan bl 
            INNER JOIN sanpham sp ON bl.id_pro = sp.id 
            WHERE bl.id_user = ? 
            ORDER BY bl.id DESC";
    return pdo_query($sql, $id_user);
}

/**
 * Lấy chi tiết một bình luận theo ID
 * 
 * @param int $id ID bình luận
 * @return array|false Bản ghi bình luận hoặc false nếu không tồn tại
 * 
 * @example
 *   $cm = binhluan_get_by_id(25);
 */
function binhluan_get_by_id($id) {
    $sql = "SELECT bl.*, tk.user, sp.ten_sanpham 
            FROM binhluan bl 
            INNER JOIN taikhoan tk ON bl.id_user = tk.id 
            INNER JOIN sanpham sp ON bl.id_pro = sp.id 
            WHERE bl.id = ?";
    return pdo_query_one($sql, $id);
}

/**
 * Đếm số lượng bình luận của một sản phẩm
 * 
 * @param int $id_pro ID sản phẩm
 * @return int Số bình luận
 * 
 * @example
 *   $count = binhluan_count_by_product(10); // 12
 */
function binhluan_count_by_product($id_pro) {
    $sql = "SELECT COUNT(*) FROM binhluan WHERE id_pro = ?";
    return (int) pdo_query_value($sql, $id_pro);
}

/**
 * Lấy tất cả bình luận (dành cho trang quản trị)
 * Kèm tên người dùng và tên sản phẩm.
 * 
 * @param int $limit Giới hạn số lượng, 0 = lấy tất cả (mặc định: 0)
 * @return array Mảng bình luận đầy đủ thông tin
 * 
 * @example
 *   $all = binhluan_all();          // Lấy tất cả
 *   $recent = binhluan_all(20);     // Lấy 20 bình luận gần nhất
 */
function binhluan_all($limit = 0) {
    $sql = "SELECT bl.*, tk.user, sp.ten_sanpham 
            FROM binhluan bl 
            INNER JOIN taikhoan tk ON bl.id_user = tk.id 
            INNER JOIN sanpham sp ON bl.id_pro = sp.id 
            ORDER BY bl.id DESC";
    if ($limit > 0) {
        $sql .= " LIMIT " . (int)$limit;
    }
    return pdo_query($sql);
}

// ============================================================
// XÓA (DELETE)
// ============================================================

/**
 * Xóa một bình luận theo ID
 * Nên kiểm tra quyền sở hữu trước khi cho phép xóa.
 * 
 * @param int $id ID bình luận cần xóa
 * 
 * @example
 *   // Chỉ cho xóa nếu là của mình hoặc là Admin
 *   if ($comment['id_user'] == $_SESSION['user']['id'] || $_SESSION['user']['vai_tro'] == 1) {
 *       binhluan_delete($id);
 *   }
 */
function binhluan_delete($id) {
    $sql = "DELETE FROM binhluan WHERE id = ?";
    pdo_execute($sql, $id);
}

/**
 * Xóa toàn bộ bình luận của một sản phẩm
 * Thường dùng trước khi xóa sản phẩm để tránh dữ liệu mồ côi.
 * 
 * @param int $id_pro ID sản phẩm
 * 
 * @example
 *   binhluan_delete_by_product(10);
 *   sanpham_delete(10);
 */
function binhluan_delete_by_product($id_pro) {
    $sql = "DELETE FROM binhluan WHERE id_pro = ?";
    pdo_execute($sql, $id_pro);
}
?>
