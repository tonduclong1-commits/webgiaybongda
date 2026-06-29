<?php
/**
 * Safe reorganization helper.
 * Moves git configuration back to the project folder, structures files into a subfolder,
 * and creates a redirect index.php at the root of the project.
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

$parent_git = 'C:/xampp/htdocs/.git';
$project_git = 'C:/xampp/htdocs/WEB GIÀY BÓNG ĐÁ/.git';

// 1. Move .git back
if (is_dir($parent_git)) {
    if (is_dir($project_git)) {
        delete_dir($project_git);
    }
    rename($parent_git, $project_git);
    echo "<p>1. Đã đưa thư mục cấu hình Git về lại dự án.</p>";
} else {
    echo "<p>Cấu hình Git đã ở trong thư mục dự án.</p>";
}

// 2. Remove parent gitignore
if (file_exists('C:/xampp/htdocs/.gitignore')) {
    unlink('C:/xampp/htdocs/.gitignore');
}

// 3. Create subfolder inside project
$sub_dir = 'C:/xampp/htdocs/WEB GIÀY BÓNG ĐÁ/WEB GIÀY BÓNG ĐÁ';
if (!is_dir($sub_dir)) {
    mkdir($sub_dir, 0777, true);
}

// 4. Move project folders/files
$items = glob('C:/xampp/htdocs/WEB GIÀY BÓNG ĐÁ/*');
foreach ($items as $item) {
    $basename = basename($item);
    if ($basename === 'WEB GIÀY BÓNG ĐÁ' || $basename === '.git' || $basename === '.gitignore' || $basename === 'README.md' || $basename === 'scratch') {
        continue;
    }
    rename($item, $sub_dir . '/' . $basename);
}

// Move scratch contents into subfolder too
if (is_dir('C:/xampp/htdocs/WEB GIÀY BÓNG ĐÁ/scratch')) {
    if (!is_dir($sub_dir . '/scratch')) {
        mkdir($sub_dir . '/scratch', 0777, true);
    }
    $scratch_items = glob('C:/xampp/htdocs/WEB GIÀY BÓNG ĐÁ/scratch/*');
    foreach ($scratch_items as $item) {
        $basename = basename($item);
        if ($basename === 'restore_git.php') {
            continue; // Keep the script at root/scratch temporarily to run it
        }
        rename($item, $sub_dir . '/scratch/' . $basename);
    }
}

// 5. Create redirect index.php at root
$redirect_code = '<?php
header("Location: WEB GIÀY BÓNG ĐÁ/index.php");
exit;
?>';
file_put_contents('C:/xampp/htdocs/WEB GIÀY BÓNG ĐÁ/index.php', $redirect_code);

// 6. Write correct .gitignore at root
$gitignore_code = ".gemini/\n.agents/\n.vscode/\n.idea/\n*.log\n";
file_put_contents('C:/xampp/htdocs/WEB GIÀY BÓNG ĐÁ/.gitignore', $gitignore_code);

echo "<h3>Hoàn tất tái cấu trúc!</h3>";
echo "<p>Vui lòng chạy file di chuyển này trên trình duyệt, sau đó chạy lệnh git để đẩy dự án lên GitHub.</p>";
?>
