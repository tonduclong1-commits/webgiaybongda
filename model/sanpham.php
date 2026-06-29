<?php
/**
 * Model Products (Sản phẩm)
 * 
 * Quản lý toàn bộ thông tin sản phẩm giày bóng đá.
 * Bảng database: `sanpham` (id, ten_sanpham, gia, gia_giam, hinh_anh, mo_ta, id_danhmuc, dac_biet, luot_xem)
 * 
 * Các hàm:
 * - sanpham_all()          : Lấy tất cả sản phẩm (có hỗ trợ lọc, tìm kiếm, sắp xếp)
 * - sanpham_get_by_id()    : Lấy chi tiết một sản phẩm (kèm tên danh mục)
 * - sanpham_moi()          : Lấy sản phẩm mới nhất
 * - sanpham_dac_biet()     : Lấy sản phẩm nổi bật
 * - sanpham_cung_loai()    : Lấy sản phẩm cùng danh mục
 * - sanpham_get_deals()    : Lấy sản phẩm deal hot
 * - sanpham_tang_luot_xem(): Tăng lượt xem sản phẩm
 * - sanpham_insert()       : Thêm sản phẩm mới
 * - sanpham_update()       : Cập nhật sản phẩm
 * - sanpham_delete()       : Xóa sản phẩm
 */

require_once __DIR__ . '/connect.php';

// ============================================================
// ĐỌC DỮ LIỆU (READ)
// ============================================================

/**
 * Lấy danh sách sản phẩm với hỗ trợ tìm kiếm, lọc danh mục và sắp xếp
 * 
 * @param string $keyword    Từ khóa tìm kiếm theo tên sản phẩm (mặc định: '')
 * @param int    $id_danhmuc Lọc theo ID danh mục, 0 = tất cả (mặc định: 0)
 * @param string $sort       Kiểu sắp xếp: 'gia_tang' | 'gia_giam' | 'ten_az' | '' (mặc định: mới nhất)
 * @return array Mảng sản phẩm kèm tên danh mục (ten_danhmuc)
 * 
 * @example
 *   // Lấy tất cả sản phẩm
 *   $all = sanpham_all();
 * 
 *   // Tìm kiếm theo tên
 *   $results = sanpham_all('Nike Mercurial');
 * 
 *   // Lọc theo danh mục và sắp xếp giá tăng dần
 *   $list = sanpham_all('', 2, 'gia_tang');
 */
function sanpham_all($keyword = '', $id_danhmuc = 0, $sort = '') {
    $sql    = "SELECT sp.*, dm.ten_danhmuc 
               FROM sanpham sp 
               LEFT JOIN danhmuc dm ON sp.id_danhmuc = dm.id 
               WHERE 1";
    $params = [];

    // Lọc theo từ khóa
    if ($keyword != '') {
        $sql .= " AND sp.ten_sanpham LIKE ?";
        $params[] = "%" . $keyword . "%";
    }

    // Lọc theo danh mục
    if ($id_danhmuc > 0) {
        $sql .= " AND sp.id_danhmuc = ?";
        $params[] = $id_danhmuc;
    }

    // Sắp xếp
    switch ($sort) {
        case 'gia_tang':
            $sql .= " ORDER BY COALESCE(sp.gia_giam, sp.gia) ASC";
            break;
        case 'gia_giam':
            $sql .= " ORDER BY COALESCE(sp.gia_giam, sp.gia) DESC";
            break;
        case 'ten_az':
            $sql .= " ORDER BY sp.ten_sanpham ASC";
            break;
        default:
            $sql .= " ORDER BY sp.id DESC"; // Mặc định: mới nhất lên trên
    }

    return pdo_query($sql, $params);
}

/**
 * Lấy thông tin chi tiết một sản phẩm theo ID (kèm tên danh mục)
 * 
 * @param int $id ID sản phẩm
 * @return array|false Bản ghi sản phẩm hoặc false nếu không tìm thấy
 * 
 * @example
 *   $sp = sanpham_get_by_id(10);
 *   echo $sp['ten_sanpham'];   // "Nike Mercurial Vapor"
 *   echo $sp['ten_danhmuc'];   // "Giày Nike"
 */
function sanpham_get_by_id($id) {
    $sql = "SELECT sp.*, dm.ten_danhmuc 
            FROM sanpham sp 
            LEFT JOIN danhmuc dm ON sp.id_danhmuc = dm.id 
            WHERE sp.id = ?";
    return pdo_query_one($sql, $id);
}

/**
 * Lấy danh sách sản phẩm mới nhất
 * 
 * @param int $limit Số lượng sản phẩm cần lấy (mặc định: 8)
 * @return array Mảng sản phẩm mới nhất
 * 
 * @example
 *   $moi = sanpham_moi(4); // Lấy 4 sản phẩm mới nhất
 */
function sanpham_moi($limit = 8) {
    $sql = "SELECT * FROM sanpham ORDER BY id DESC LIMIT ?";
    return pdo_query($sql, $limit);
}

/**
 * Lấy danh sách sản phẩm nổi bật (dac_biet = 1)
 * 
 * @param int $limit Số lượng sản phẩm cần lấy (mặc định: 8)
 * @return array Mảng sản phẩm nổi bật
 * 
 * @example
 *   $featured = sanpham_dac_biet(6);
 */
function sanpham_dac_biet($limit = 8) {
    $sql = "SELECT * FROM sanpham WHERE dac_biet = 1 ORDER BY id DESC LIMIT ?";
    return pdo_query($sql, $limit);
}

/**
 * Lấy danh sách sản phẩm cùng danh mục (dùng để gợi ý sản phẩm liên quan)
 * 
 * @param int $id         ID sản phẩm hiện tại (sẽ bị loại trừ khỏi kết quả)
 * @param int $id_danhmuc ID danh mục cần lấy sản phẩm
 * @param int $limit      Số lượng sản phẩm tối đa (mặc định: 4)
 * @return array Mảng sản phẩm cùng loại (ngẫu nhiên)
 * 
 * @example
 *   $related = sanpham_cung_loai(10, 2, 4);
 */
function sanpham_cung_loai($id, $id_danhmuc, $limit = 4) {
    $sql = "SELECT * FROM sanpham WHERE id_danhmuc = ? AND id <> ? ORDER BY RAND() LIMIT ?";
    return pdo_query($sql, $id_danhmuc, $id, $limit);
}

/**
 * Lấy sản phẩm Deal Hot cho trang chủ
 * 
 * @return array Mảng sản phẩm deal hot
 */
function sanpham_get_deals() {
    $sql = "SELECT * FROM sanpham WHERE dac_biet = 1 ORDER BY RAND() LIMIT 4";
    return pdo_query($sql);
}

/**
 * Tăng lượt xem của sản phẩm lên 1
 * Nên gọi hàm này mỗi khi người dùng mở trang chi tiết sản phẩm.
 * 
 * @param int $id ID sản phẩm cần tăng lượt xem
 * 
 * @example
 *   sanpham_tang_luot_xem(10);
 */
function sanpham_tang_luot_xem($id) {
    $sql = "UPDATE sanpham SET luot_xem = luot_xem + 1 WHERE id = ?";
    pdo_execute($sql, $id);
}

// ============================================================
// THÊM MỚI (CREATE)
// ============================================================

/**
 * Thêm sản phẩm mới vào cơ sở dữ liệu
 * 
 * @param string     $ten_sanpham Tên sản phẩm
 * @param float      $gia         Giá gốc (VNĐ)
 * @param float|null $gia_giam    Giá khuyến mãi (null nếu không giảm giá)
 * @param string     $hinh_anh    Đường dẫn ảnh sản phẩm (vd: 'uploads/img.jpg')
 * @param string     $mo_ta       Mô tả chi tiết sản phẩm
 * @param int        $id_danhmuc  ID danh mục sản phẩm
 * @param int        $dac_biet    1 = Sản phẩm nổi bật, 0 = Thường
 * @return int ID sản phẩm vừa thêm
 * 
 * @example
 *   $id = sanpham_insert("Nike Mercurial", 1500000, 1200000, "uploads/nike.jpg", "Mô tả...", 1, 1);
 */
function sanpham_insert($ten_sanpham, $gia, $gia_giam, $hinh_anh, $mo_ta, $id_danhmuc, $dac_biet) {
    $sql = "INSERT INTO sanpham (ten_sanpham, gia, gia_giam, hinh_anh, mo_ta, id_danhmuc, dac_biet, luot_xem) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
    return pdo_execute($sql, $ten_sanpham, $gia, $gia_giam, $hinh_anh, $mo_ta, $id_danhmuc, $dac_biet);
}

// ============================================================
// CẬP NHẬT (UPDATE)
// ============================================================

/**
 * Cập nhật thông tin sản phẩm (không thay đổi lượt xem)
 * 
 * @param int        $id          ID sản phẩm cần cập nhật
 * @param string     $ten_sanpham Tên sản phẩm mới
 * @param float      $gia         Giá gốc mới
 * @param float|null $gia_giam    Giá khuyến mãi mới (null để bỏ giảm giá)
 * @param string     $hinh_anh    Đường dẫn ảnh mới
 * @param string     $mo_ta       Mô tả mới
 * @param int        $id_danhmuc  ID danh mục mới
 * @param int        $dac_biet    Trạng thái nổi bật mới (0 hoặc 1)
 * 
 * @example
 *   sanpham_update(10, "Nike Mercurial V2", 1600000, null, "uploads/new.jpg", "Mô tả...", 1, 0);
 */
function sanpham_update($id, $ten_sanpham, $gia, $gia_giam, $hinh_anh, $mo_ta, $id_danhmuc, $dac_biet) {
    $sql = "UPDATE sanpham 
            SET ten_sanpham = ?, gia = ?, gia_giam = ?, hinh_anh = ?, mo_ta = ?, id_danhmuc = ?, dac_biet = ? 
            WHERE id = ?";
    pdo_execute($sql, $ten_sanpham, $gia, $gia_giam, $hinh_anh, $mo_ta, $id_danhmuc, $dac_biet, $id);
}

// ============================================================
// XÓA (DELETE)
// ============================================================

/**
 * Xóa sản phẩm theo ID khỏi cơ sở dữ liệu
 * Lưu ý: Cần xóa file ảnh trên server riêng (nếu cần), hàm này chỉ xóa bản ghi DB.
 * 
 * @param int $id ID sản phẩm cần xóa
 * 
 * @example
 *   sanpham_delete(10);
 */
function sanpham_delete($id) {
    $sql = "DELETE FROM sanpham WHERE id = ?";
    pdo_execute($sql, $id);
}
?>
