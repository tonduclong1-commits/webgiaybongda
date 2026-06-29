<?php
function export_database() {
    try {
        $db = get_connection();
        $output = "-- SQL Script for Web Giày Bóng Đá database\n";
        $output .= "CREATE DATABASE IF NOT EXISTS `web_giay_bong_da` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        $output .= "USE `web_giay_bong_da`;\n\n";
        
        $output .= "SET FOREIGN_KEY_CHECKS = 0;\n";
        $tables = ['danhmuc', 'taikhoan', 'banner', 'baiviet', 'sanpham', 'binhluan', 'donhang', 'chitiet_donhang'];
        foreach ($tables as $table) {
            $output .= "DROP TABLE IF EXISTS `$table`;\n";
        }
        $output .= "SET FOREIGN_KEY_CHECKS = 1;\n\n";
        
        foreach ($tables as $table) {
            // Get Create Table statement
            $stmt = $db->query("SHOW CREATE TABLE `$table`");
            $row = $stmt->fetch(PDO::FETCH_NUM);
            $createTableSql = $row[1];
            $output .= $createTableSql . ";\n\n";
            
            // Get data
            $stmtData = $db->query("SELECT * FROM `$table`");
            $rows = $stmtData->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) > 0) {
                $cols = array_keys($rows[0]);
                $colsEscaped = array_map(function($c) { return "`$c`"; }, $cols);
                $output .= "INSERT INTO `$table` (" . implode(', ', $colsEscaped) . ") VALUES\n";
                $valRows = [];
                foreach ($rows as $r) {
                    $vals = [];
                    foreach ($cols as $col) {
                        $val = $r[$col];
                        if ($val === null) {
                            $vals[] = 'NULL';
                        } else {
                            $vals[] = $db->quote($val);
                        }
                    }
                    $valRows[] = "(" . implode(', ', $vals) . ")";
                }
                $output .= implode(",\n", $valRows) . ";\n\n";
            }
        }
        
        // Write to database.sql and database.spl
        file_put_contents(__DIR__ . '/../database.sql', $output);
        file_put_contents(__DIR__ . '/../database.spl', $output);
        return true;
    } catch (Exception $e) {
        error_log("Database export failed: " . $e->getMessage());
        return false;
    }
}
?>
