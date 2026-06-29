<?php
require_once __DIR__ . '/connect.php';

/**
 * Lấy danh sách banner theo vị trí hiển thị
 * @param string $vi_tri Vị trí hiển thị ('slider', 'sub_banner', 'sidebar')
 * @return array Danh sách banner
 */
function banner_get_by_position($vi_tri) {
    $sql = "SELECT * FROM banner WHERE vi_tri = ? ORDER BY id ASC";
    return pdo_query($sql, $vi_tri);
}
?>
