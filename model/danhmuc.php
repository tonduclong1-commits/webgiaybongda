<?php
/**
 * Model Categories (Danh mục sản phẩm)
 * 
 * Quản lý danh mục phân loại sản phẩm trong cửa hàng.
 * Bảng database: `danhmuc` (id, ten_danhmuc)
 * 
 * Các hàm:
 * - danhmuc_all()           : Lấy tất cả danh mục
 * - danhmuc_get_by_id()     : Lấy chi tiết một danh mục
 * - danhmuc_get_name()      : Lấy tên danh mục theo ID
 * - danhmuc_search()        : Tìm kiếm danh mục theo từ khóa
 * - danhmuc_insert()        : Thêm danh mục mới
 * - danhmuc_update()        : Cập nhật tên danh mục
 * - danhmuc_delete()        : Xóa danh mục
 * - danhmuc_count_products(): Đếm số sản phẩm trong danh mục
 */

require_once __DIR__ . '/connect.php';

// ============================================================
// ĐỌC DỮ LIỆU (READ)
// ============================================================

/**
 * Lấy tất cả danh mục sản phẩm, sắp xếp theo ID tăng dần
 * 
 * @return array Mảng các danh mục (id, ten_danhmuc)
 * 
 * @example
 *   $ds = danhmuc_all();
 *   foreach ($ds as $dm) {
 *       echo $dm['id'] . ' - ' . $dm['ten_danhmuc'];
 *   }
 */
function danhmuc_all() {
    $sql = "SELECT * FROM danhmuc ORDER BY id ASC";
    return pdo_query($sql);
}

/**
 * Lấy thông tin chi tiết một danh mục theo ID
 * 
 * @param int $id ID của danh mục cần lấy
 * @return array|false Bản ghi danh mục hoặc false nếu không tìm thấy
 * 
 * @example
 *   $dm = danhmuc_get_by_id(3);
 *   echo $dm['ten_danhmuc']; // "Giày Nike"
 */
function danhmuc_get_by_id($id) {
    $sql = "SELECT * FROM danhmuc WHERE id = ?";
    return pdo_query_one($sql, $id);
}

/**
 * Lấy chỉ tên danh mục theo ID (dùng khi chỉ cần tên)
 * 
 * @param int $id ID danh mục
 * @return string|null Tên danh mục hoặc null nếu không tồn tại
 * 
 * @example
 *   echo danhmuc_get_name(2); // "Giày Adidas"
 */
function danhmuc_get_name($id) {
    $sql = "SELECT ten_danhmuc FROM danhmuc WHERE id = ?";
    return pdo_query_value($sql, $id);
}

/**
 * Tìm kiếm danh mục theo từ khóa (tìm kiếm theo tên, không phân biệt hoa thường)
 * 
 * @param string $keyword Từ khóa tìm kiếm
 * @return array Mảng các danh mục khớp với từ khóa
 * 
 * @example
 *   $results = danhmuc_search("nike");
 */
function danhmuc_search($keyword) {
    $sql = "SELECT * FROM danhmuc WHERE ten_danhmuc LIKE ? ORDER BY id ASC";
    return pdo_query($sql, "%" . $keyword . "%");
}

/**
 * Đếm số lượng sản phẩm thuộc một danh mục
 * 
 * @param int $id ID danh mục
 * @return int Số lượng sản phẩm trong danh mục
 * 
 * @example
 *   $count = danhmuc_count_products(2); // 15
 */
function danhmuc_count_products($id) {
    $sql = "SELECT COUNT(*) FROM sanpham WHERE id_danhmuc = ?";
    return (int) pdo_query_value($sql, $id);
}

// ============================================================
// THÊM MỚI (CREATE)
// ============================================================

/**
 * Thêm danh mục mới vào cơ sở dữ liệu
 * 
 * @param string $ten_danhmuc Tên danh mục (phải là duy nhất)
 * @return int ID của danh mục vừa được thêm
 * @throws PDOException Nếu tên danh mục đã tồn tại (UNIQUE constraint)
 * 
 * @example
 *   $new_id = danhmuc_insert("Giày Mizuno");
 */
function danhmuc_insert($ten_danhmuc) {
    $sql = "INSERT INTO danhmuc (ten_danhmuc) VALUES (?)";
    return pdo_execute($sql, $ten_danhmuc);
}

// ============================================================
// CẬP NHẬT (UPDATE)
// ============================================================

/**
 * Cập nhật tên danh mục
 * 
 * @param int    $id          ID danh mục cần cập nhật
 * @param string $ten_danhmuc Tên danh mục mới
 * @throws PDOException Nếu tên mới đã tồn tại (UNIQUE constraint)
 * 
 * @example
 *   danhmuc_update(3, "Giày Nike - Mới");
 */
function danhmuc_update($id, $ten_danhmuc) {
    $sql = "UPDATE danhmuc SET ten_danhmuc = ? WHERE id = ?";
    pdo_execute($sql, $ten_danhmuc, $id);
}

// ============================================================
// XÓA (DELETE)
// ============================================================

/**
 * Xóa danh mục theo ID
 * Lưu ý: Các sản phẩm thuộc danh mục này cũng sẽ bị xóa (CASCADE)
 * 
 * @param int $id ID danh mục cần xóa
 * 
 * @example
 *   danhmuc_delete(5);
 */
function danhmuc_delete($id) {
    $sql = "DELETE FROM danhmuc WHERE id = ?";
    pdo_execute($sql, $id);
}
?>
