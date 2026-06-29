<?php
/**
 * Helper script to move Git repository configuration up one level to XAMPP htdocs.
 * This places the project files under the "WEB GIÀY BÓNG ĐÁ" directory on GitHub,
 * while maintaining the local web address: http://localhost/WEB GIÀY BÓNG ĐÁ/
 */

function delete_dir($dirPath) {
    if (!is_dir($dirPath)) {
        return;
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            delete_dir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

$src_git = 'C:/xampp/htdocs/WEB GIÀY BÓNG ĐÁ/.git';
$dst_git = 'C:/xampp/htdocs/.git';

if (is_dir($src_git)) {
    if (is_dir($dst_git)) {
        // If destination already exists, delete it first to avoid merge conflicts
        delete_dir($dst_git);
    }
    
    // Move the folder
    $success = rename($src_git, $dst_git);
    if ($success) {
        echo "<h3>1. Đã chuyển thư mục .git lên c:/xampp/htdocs/ thành công!</h3>";
    } else {
        echo "<h3>Lỗi: Không thể di chuyển thư mục .git!</h3>";
        exit;
    }
} else {
    echo "<h3>Thư mục .git gốc không tồn tại hoặc đã được di chuyển trước đó.</h3>";
}

// Write the global .gitignore in htdocs
$gitignore_content = "/*\n" .
                     "!/WEB GIÀY BÓNG ĐÁ/\n" .
                     "/WEB GIÀY BÓNG ĐÁ/.gemini/\n" .
                     "/WEB GIÀY BÓNG ĐÁ/.agents/\n" .
                     "/WEB GIÀY BÓNG ĐÁ/.vscode/\n" .
                     "/WEB GIÀY BÓNG ĐÁ/.idea/\n" .
                     "/WEB GIÀY BÓNG ĐÁ/*.log\n";

file_put_contents('C:/xampp/htdocs/.gitignore', $gitignore_content);
echo "<h3>2. Đã tạo file .gitignore tại c:/xampp/htdocs/.gitignore thành công!</h3>";
echo "<p>Vui lòng quay lại VS Code Terminal và chạy các lệnh Git ở thư mục cha để đẩy lên GitHub.</p>";
?>
