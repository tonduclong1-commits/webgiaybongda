<?php
require_once __DIR__ . '/connect.php';

/**
 * Thêm đơn hàng mới và trả về ID đơn hàng vừa tạo
 */
function donhang_insert($id_user, $nguoi_nhan, $email, $dien_thoai, $dia_chi, $ngay_dat, $tong_tien, $pttt) {
    $sql = "INSERT INTO donhang (id_user, nguoi_nhan, email, dien_thoai, dia_chi, ngay_dat, tong_tien, pttt, trang_thai) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)";
    return pdo_execute($sql, $id_user, $nguoi_nhan, $email, $dien_thoai, $dia_chi, $ngay_dat, $tong_tien, $pttt);
}

/**
 * Thêm chi tiết đơn hàng
 */
function chitiet_donhang_insert($id_donhang, $id_sanpham, $ten_sanpham, $hinh_anh, $gia, $so_luong, $size) {
    $sql = "INSERT INTO chitiet_donhang (id_donhang, id_sanpham, ten_sanpham, hinh_anh, gia, so_luong, size) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $id_donhang, $id_sanpham, $ten_sanpham, $hinh_anh, $gia, $so_luong, $size);
}

/**
 * Lấy thông tin đơn hàng theo ID
 */
function donhang_get_by_id($id) {
    $sql = "SELECT * FROM donhang WHERE id = ?";
    return pdo_query_one($sql, $id);
}

/**
 * Lấy danh sách chi tiết đơn hàng
 */
function donhang_get_details($id_donhang) {
    $sql = "SELECT * FROM chitiet_donhang WHERE id_donhang = ?";
    return pdo_query($sql, $id_donhang);
}

/**
 * Lấy lịch sử đơn hàng của User
 */
function donhang_get_by_user($id_user) {
    $sql = "SELECT * FROM donhang WHERE id_user = ? ORDER BY id DESC";
    return pdo_query($sql, $id_user);
}

/**
 * Lấy tất cả đơn hàng (cho Admin quản lý)
 */
function donhang_all() {
    $sql = "SELECT * FROM donhang ORDER BY id DESC";
    return pdo_query($sql);
}

/**
 * Cập nhật trạng thái đơn hàng
 */
function donhang_update_status($id, $trang_thai) {
    $sql = "UPDATE donhang SET trang_thai = ? WHERE id = ?";
    pdo_execute($sql, $trang_thai, $id);
}
?>
