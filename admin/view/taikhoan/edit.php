<!-- Admin Edit User View (taikhoan/edit.php) -->
<div style="background-color: var(--white); border: 1px solid var(--border-color); box-shadow: var(--shadow); border-radius: var(--radius); padding: 35px; max-width: 600px; margin: 0 auto;">
    
    <h2 style="font-weight: 800; font-size: 20px; text-transform: uppercase; margin-bottom: 25px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
        Cập nhật tài khoản
    </h2>

    <!-- PHP Error Alerts -->
    <?php if (isset($error) && !empty($error)): ?>
        <div class="admin-alert danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?act=taikhoan-edit&id=<?php echo $tk['id']; ?>" method="POST" id="editUserForm">
        <!-- Account ID -->
        <div class="form-group">
            <label class="form-label">ID tài khoản</label>
            <input type="text" class="form-control" style="background-color: #f1f5f9; cursor: not-allowed;" 
                   value="<?php echo $tk['id']; ?>" readonly>
        </div>

        <!-- Username -->
        <div class="form-group">
            <label class="form-label" for="username">Tên đăng nhập <span style="color: var(--danger)">*</span></label>
            <input type="text" name="username" id="username" class="form-control" 
                   value="<?php echo htmlspecialchars($tk['user']); ?>" required>
        </div>

        <!-- Password (Reset Option) -->
        <div class="form-group">
            <label class="form-label" for="password">Mật khẩu mới (Đặt lại)</label>
            <div style="position: relative;">
                <input type="password" name="password" id="password" class="form-control" 
                       placeholder="Để trống nếu không muốn thay đổi mật khẩu cũ">
                <button type="button" class="password-toggle" onclick="togglePassVisibility('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer;">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
            <span style="font-size: 11px; color: var(--text-muted);">Bỏ trống nếu không muốn đặt lại mật khẩu mới cho người dùng này.</span>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label class="form-label" for="email">Địa chỉ Email <span style="color: var(--danger)">*</span></label>
            <input type="email" name="email" id="email" class="form-control" 
                   value="<?php echo htmlspecialchars($tk['email']); ?>" required>
        </div>

        <!-- Phone -->
        <div class="form-group">
            <label class="form-label" for="dien_thoai">Số điện thoại</label>
            <input type="text" name="dien_thoai" id="dien_thoai" class="form-control" 
                   value="<?php echo htmlspecialchars($tk['dien_thoai']); ?>">
        </div>

        <!-- Role -->
        <div class="form-group">
            <label class="form-label" for="vai_tro">Vai trò phân quyền <span style="color: var(--danger)">*</span></label>
            <select name="vai_tro" id="vai_tro" class="form-control" required>
                <option value="0" <?php echo ($tk['vai_tro'] == 0) ? 'selected' : ''; ?>>👤 Khách hàng (User)</option>
                <option value="1" <?php echo ($tk['vai_tro'] == 1) ? 'selected' : ''; ?>>👑 Quản trị viên (Admin)</option>
            </select>
        </div>

        <div style="display: flex; gap: 15px; margin-top: 30px; border-top: 1px solid var(--border-color); padding-top: 25px;">
            <button type="submit" name="capnhat" class="btn-primary" style="padding: 10px 25px; border-radius: 6px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-check"></i> Cập nhật tài khoản
            </button>
            <a href="index.php?act=taikhoan-list" class="btn-primary" 
               style="background-color: transparent; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px 25px; border-radius: 6px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-xmark"></i> Hủy / Quay lại
            </a>
        </div>
    </form>
</div>

<script>
function togglePassVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-regular', 'fa-eye');
        icon.classList.add('fa-solid', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-solid', 'fa-eye-slash');
        icon.classList.add('fa-regular', 'fa-eye');
    }
}
</script>
