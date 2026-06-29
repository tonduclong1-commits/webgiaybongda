<?php
/**
 * Model Connect - Kết nối và thao tác cơ sở dữ liệu
 * 
 * Cung cấp các hàm trừu tượng hóa thao tác PDO, giúp các model khác
 * không cần viết lại code kết nối lặp đi lặp lại.
 * 
 * Các hàm chính:
 * - pdo_get_connection() : Lấy đối tượng kết nối PDO (singleton)
 * - pdo_execute()        : Thực thi INSERT / UPDATE / DELETE
 * - pdo_query()          : SELECT nhiều bản ghi
 * - pdo_query_one()      : SELECT một bản ghi
 * - pdo_query_value()    : SELECT một giá trị đơn lẻ
 */

require_once __DIR__ . '/../config/database.php';

// ============================================================
// HÀM KẾT NỐI
// ============================================================

/**
 * Lấy đối tượng kết nối PDO (Singleton - chỉ tạo 1 lần)
 * 
 * @return PDO Đối tượng kết nối cơ sở dữ liệu
 */
function pdo_get_connection() {
    return get_connection();
}

// ============================================================
// HÀM THỰC THI (INSERT / UPDATE / DELETE)
// ============================================================

/**
 * Thực thi câu lệnh SQL thao tác dữ liệu (INSERT, UPDATE, DELETE)
 * 
 * @param string $sql  Câu lệnh SQL với tham số ?
 * @param mixed  ...$args Danh sách giá trị tham số (hoặc mảng)
 * @return int ID bản ghi vừa INSERT (nếu có), ngược lại 0
 * @throws PDOException Nếu câu lệnh thất bại
 * 
 * @example
 *   pdo_execute("INSERT INTO danhmuc (ten_danhmuc) VALUES (?)", "Nike");
 *   pdo_execute("UPDATE sanpham SET gia=? WHERE id=?", 500000, 3);
 *   pdo_execute("DELETE FROM binhluan WHERE id=?", 5);
 */
function pdo_execute($sql, ...$args) {
    // Hỗ trợ cả truyền mảng hoặc danh sách tham số
    if (isset($args[0]) && is_array($args[0])) {
        $args = $args[0];
    }

    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($args);
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        throw $e;
    }
}

// ============================================================
// HÀM TRUY VẤN (SELECT)
// ============================================================

/**
 * Thực thi câu lệnh SELECT, trả về nhiều bản ghi
 * 
 * @param string $sql  Câu lệnh SQL SELECT
 * @param mixed  ...$args Danh sách giá trị tham số
 * @return array Mảng các bản ghi (mảng kết hợp)
 * @throws PDOException Nếu câu lệnh thất bại
 * 
 * @example
 *   $all = pdo_query("SELECT * FROM danhmuc");
 *   $list = pdo_query("SELECT * FROM sanpham WHERE id_danhmuc=?", 2);
 */
function pdo_query($sql, ...$args) {
    if (isset($args[0]) && is_array($args[0])) {
        $args = $args[0];
    }

    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

/**
 * Thực thi câu lệnh SELECT, trả về MỘT bản ghi duy nhất
 * 
 * @param string $sql  Câu lệnh SQL SELECT
 * @param mixed  ...$args Danh sách giá trị tham số
 * @return array|false Bản ghi hoặc false nếu không tìm thấy
 * @throws PDOException Nếu câu lệnh thất bại
 * 
 * @example
 *   $sp = pdo_query_one("SELECT * FROM sanpham WHERE id=?", 5);
 */
function pdo_query_one($sql, ...$args) {
    if (isset($args[0]) && is_array($args[0])) {
        $args = $args[0];
    }

    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

/**
 * Thực thi câu lệnh SELECT, trả về MỘT giá trị đơn lẻ (cột đầu tiên)
 * 
 * @param string $sql  Câu lệnh SQL SELECT (thường dùng COUNT, SUM, MAX...)
 * @param mixed  ...$args Danh sách giá trị tham số
 * @return mixed|null Giá trị hoặc null nếu không có kết quả
 * @throws PDOException Nếu câu lệnh thất bại
 * 
 * @example
 *   $total = pdo_query_value("SELECT COUNT(*) FROM sanpham");
 *   $name  = pdo_query_value("SELECT ten_danhmuc FROM danhmuc WHERE id=?", 2);
 */
function pdo_query_value($sql, ...$args) {
    if (isset($args[0]) && is_array($args[0])) {
        $args = $args[0];
    }

    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($args);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row ? $row[0] : null;
    } catch (PDOException $e) {
        throw $e;
    }
}
?>
