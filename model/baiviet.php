<?php
require_once __DIR__ . '/connect.php';

/**
 * Lấy danh sách bài viết/tin tức mới nhất
 * @param int $limit Giới hạn số lượng bài viết lấy ra (0 là lấy hết)
 * @return array Danh sách bài viết
 */
function baiviet_all($limit = 0) {
    $sql = "SELECT * FROM baiviet ORDER BY id DESC";
    if ($limit > 0) {
        $sql .= " LIMIT " . (int)$limit;
    }
    return pdo_query($sql);
}

/**
 * Lấy chi tiết bài viết theo ID
 * @param int $id ID bài viết
 * @return array Chi tiết bài viết
 */
function baiviet_get_by_id($id) {
    $sql = "SELECT * FROM baiviet WHERE id = ?";
    return pdo_query_one($sql, $id);
}

/**
 * Thêm bài viết mới
 */
function baiviet_insert($tieu_de, $noi_dung, $hinh_anh, $tac_gia, $ngay_dang) {
    $sql = "INSERT INTO baiviet (tieu_de, noi_dung, hinh_anh, tac_gia, ngay_dang) VALUES (?, ?, ?, ?, ?)";
    return pdo_execute($sql, $tieu_de, $noi_dung, $hinh_anh, $tac_gia, $ngay_dang);
}

/**
 * Cập nhật bài viết
 */
function baiviet_update($id, $tieu_de, $noi_dung, $hinh_anh, $tac_gia) {
    $sql = "UPDATE baiviet SET tieu_de=?, noi_dung=?, hinh_anh=?, tac_gia=? WHERE id=?";
    pdo_execute($sql, $tieu_de, $noi_dung, $hinh_anh, $tac_gia, $id);
}

/**
 * Xóa bài viết
 */
function baiviet_delete($id) {
    $sql = "DELETE FROM baiviet WHERE id=?";
    pdo_execute($sql, $id);
}

/**
 * Tìm kiếm bài viết
 */
function baiviet_search($keyword) {
    $sql = "SELECT * FROM baiviet WHERE tieu_de LIKE ? ORDER BY id DESC";
    return pdo_query($sql, "%$keyword%");
}
?>
