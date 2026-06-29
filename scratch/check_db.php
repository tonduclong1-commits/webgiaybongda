<?php
require_once __DIR__ . '/../model/connect.php';
try {
    $conn = pdo_get_connection();
    echo "Connected successfully to database!<br>";
    
    // Check danhmuc
    $dm = pdo_query("SELECT * FROM danhmuc");
    echo "<h3>Danh muc list:</h3>";
    foreach ($dm as $d) {
        echo "ID: {$d['id']} - Name: {$d['ten_danhmuc']}<br>";
    }
    
    // Check counts
    $count = pdo_query_value("SELECT COUNT(*) FROM sanpham");
    echo "<h3>Total products in database: $count</h3>";
    
    // Check some products
    $products = pdo_query("SELECT id, ten_sanpham, hinh_anh, id_danhmuc FROM sanpham ORDER BY id DESC LIMIT 15");
    echo "<h3>Latest 15 products in database:</h3>";
    foreach ($products as $p) {
        echo "ID: {$p['id']} - Name: {$p['ten_sanpham']} - Image: {$p['hinh_anh']} - Category: {$p['id_danhmuc']}<br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
