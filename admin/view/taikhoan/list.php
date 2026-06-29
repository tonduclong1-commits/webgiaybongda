<!-- Admin: Quản lý người dùng -->

<div class="page-title">👤 Quản lý Người Dùng</div>

<!-- Search bar & Add Button -->
<div class="card-admin" style="margin-bottom:20px; display:flex; justify-content:space-between; align-items:flex-end; gap:20px; flex-wrap:wrap;">
    <form method="GET" action="index.php" style="display:flex; gap:12px; align-items:flex-end; flex-grow:1; max-width:600px; margin:0;">
        <input type="hidden" name="act" value="taikhoan-list">
        <div style="flex:1;">
            <label class="form-label" style="margin-bottom:6px; font-weight:700; font-size:13px; display:block;">Tìm kiếm tài khoản</label>
            <input type="text" name="keyword" class="form-control" placeholder="Tên đăng nhập, email..."
                   value="<?php echo htmlspecialchars(isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
        </div>
        <button type="submit" class="btn-sm btn-view" style="padding:10px 20px; height:42px; border-radius:8px;">
            <i class="fa-solid fa-search"></i> Tìm
        </button>
    </form>
    
    <a href="index.php?act=taikhoan-add" class="btn-sm btn-success" style="padding:12px 20px; border-radius:8px; display:inline-flex; align-items:center; gap:8px;">
        <i class="fa-solid fa-user-plus"></i> Thêm thành viên mới
    </a>
</div>

<!-- Table -->
<div class="card-admin">
    <?php if (empty($ds_taikhoan)): ?>
        <p style="text-align:center;color:#94a3b8;padding:40px 0;">Không có tài khoản nào phù hợp.</p>
    <?php else: ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 80px;">#ID</th>
                <th>Tên đăng nhập</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th style="width: 150px;">Vai trò</th>
                <th style="width: 250px; text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($ds_taikhoan as $tk): ?>
            <tr>
                <td><strong>#<?php echo $tk['id']; ?></strong></td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:34px;height:34px;background:#e0f2fe;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:#0369a1;font-size:13px;flex-shrink:0;">
                            <?php echo strtoupper(substr($tk['user'],0,1)); ?>
                        </div>
                        <span style="font-weight:700; color:#1e293b;"><?php echo htmlspecialchars($tk['user']); ?></span>
                        <?php if ($tk['id'] == $_SESSION['user']['id']): ?>
                            <span style="font-size:10px;background:#dcfce7;color:#166534;padding:2px 8px;border-radius:20px;font-weight:700;">Bạn</span>
                        <?php endif; ?>
                    </div>
                </td>
                <td><?php echo htmlspecialchars($tk['email']); ?></td>
                <td><?php echo htmlspecialchars($tk['dien_thoai'] ? $tk['dien_thoai'] : '-'); ?></td>
                <td>
                    <span class="badge <?php echo $tk['vai_tro'] == 1 ? 'badge-admin' : 'badge-user'; ?>">
                        <?php echo $tk['vai_tro'] == 1 ? '👑 Admin' : '👤 Khách hàng'; ?>
                    </span>
                </td>
                <td style="text-align: center;">
                    <!-- Edit details (For all accounts, even the logged in admin themselves) -->
                    <a href="index.php?act=taikhoan-edit&id=<?php echo $tk['id']; ?>"
                       class="btn-sm btn-edit" style="margin-right: 4px;">
                        <i class="fa-solid fa-pen-to-square"></i> Sửa
                    </a>
                    
                    <?php if ($tk['id'] != $_SESSION['user']['id']): ?>
                        <?php if ($tk['vai_tro'] == 1): ?>
                        <a href="index.php?act=taikhoan-role&id=<?php echo $tk['id']; ?>&vai_tro=0"
                           class="btn-sm" style="background:#f59e0b;color:white; margin-right: 4px;"
                           onclick="return confirm('Hạ xuống thành khách hàng?')">
                            <i class="fa-solid fa-user-minus"></i> Hạ quyền
                        </a>
                        <?php else: ?>
                        <a href="index.php?act=taikhoan-role&id=<?php echo $tk['id']; ?>&vai_tro=1"
                           class="btn-sm btn-success" style="margin-right: 4px;"
                           onclick="return confirm('Nâng lên Admin?')">
                            <i class="fa-solid fa-user-shield"></i> Cấp Admin
                        </a>
                        <?php endif; ?>
                        
                        <a href="index.php?act=taikhoan-delete&id=<?php echo $tk['id']; ?>"
                           class="btn-sm btn-delete"
                           onclick="return confirm('Xóa tài khoản này vĩnh viễn?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    <?php else: ?>
                        <a href="index.php?act=profile" class="btn-sm btn-view">
                            <i class="fa-solid fa-user-gear"></i> Quản lý
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
