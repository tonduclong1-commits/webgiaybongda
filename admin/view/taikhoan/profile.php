<!-- Admin Profile & Change Password (taikhoan/profile.php) -->
<style>
.profile-container {
    max-width: 800px;
    margin: 0 auto;
}
.profile-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    overflow: hidden;
    display: grid;
    grid-template-columns: 240px 1fr;
}
@media (max-width: 768px) {
    .profile-card {
        grid-template-columns: 1fr;
    }
}
.profile-sidebar {
    background: #f8fafc;
    border-right: 1px solid #e2e8f0;
    padding: 35px 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.profile-main {
    padding: 35px;
}
.profile-avatar {
    width: 90px;
    height: 90px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 50%;
    color: white;
    font-size: 38px;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
    margin-bottom: 20px;
}
.profile-name {
    font-size: 18px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}
.profile-role-badge {
    background: #f3e8ff;
    color: #7e22ce;
    font-size: 11px;
    font-weight: 800;
    padding: 4px 12px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.profile-tab-btn {
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
    transition: all 0.2s ease;
}
.profile-tab-btn:hover {
    background: #f1f5f9;
    color: #1e293b;
}
.profile-tab-btn.active {
    background: #e2e8f0;
    color: #0f172a;
}

.profile-tab-content {
    display: none;
}
.profile-tab-content.active {
    display: block;
}
.input-with-icon {
    position: relative;
}
.input-with-icon input {
    padding-right: 40px;
}
.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    padding: 4px;
}
.password-toggle:hover {
    color: #475569;
}
</style>

<div class="profile-container">

    <!-- Notifications -->
    <?php if (isset($error) && !empty($error)): ?>
        <div class="admin-alert danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($success_msg) && !empty($success_msg)): ?>
        <div class="admin-alert success"><?php echo $success_msg; ?></div>
    <?php endif; ?>

    <div class="profile-card">
        <!-- Sidebar profile display -->
        <div class="profile-sidebar">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($tk['user'], 0, 1)); ?>
            </div>
            <h4 class="profile-name"><?php echo htmlspecialchars($tk['user']); ?></h4>
            <div class="profile-role-badge">👑 Administrator</div>
            
            <div style="width: 100%; margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                <button type="button" class="profile-tab-btn active" onclick="switchProfileTab('info-tab', this)">
                    <i class="fa-solid fa-address-card"></i> Thông tin cá nhân
                </button>
                <button type="button" class="profile-tab-btn" onclick="switchProfileTab('pass-tab', this)">
                    <i class="fa-solid fa-key"></i> Đổi mật khẩu
                </button>
            </div>
        </div>

        <!-- Main Form areas -->
        <div class="profile-main">
            <form action="index.php?act=profile" method="POST">
                
                <!-- Tab 1: Info -->
                <div id="info-tab" class="profile-tab-content active">
                    <h3 style="font-size: 16px; font-weight: 800; color: #1e293b; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 12px; margin-top: 0; margin-bottom: 20px;">
                        <i class="fa-regular fa-user" style="color: #3b82f6;"></i> Cập nhật thông tin cá nhân
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label" for="username">Tên đăng nhập <span style="color: var(--danger)">*</span></label>
                        <input type="text" name="username" id="username" class="form-control" 
                               value="<?php echo htmlspecialchars($tk['user']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Địa chỉ Email <span style="color: var(--danger)">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" 
                               value="<?php echo htmlspecialchars($tk['email']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="dien_thoai">Số điện thoại</label>
                        <input type="text" name="dien_thoai" id="dien_thoai" class="form-control" 
                               value="<?php echo htmlspecialchars($tk['dien_thoai']); ?>">
                    </div>
                </div>

                <!-- Tab 2: Password -->
                <div id="pass-tab" class="profile-tab-content">
                    <h3 style="font-size: 16px; font-weight: 800; color: #1e293b; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 12px; margin-top: 0; margin-bottom: 20px;">
                        <i class="fa-solid fa-lock" style="color: #f59e0b;"></i> Đổi mật khẩu bảo mật
                    </h3>

                    <div class="form-group">
                        <label class="form-label" for="old_password">Mật khẩu cũ hiện tại</label>
                        <div class="input-with-icon">
                            <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Nhập mật khẩu hiện tại để xác nhận">
                            <button type="button" class="password-toggle" onclick="togglePassVisibility('old_password', this)">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="new_password">Mật khẩu mới</label>
                        <div class="input-with-icon">
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Nhập mật khẩu mới">
                            <button type="button" class="password-toggle" onclick="togglePassVisibility('new_password', this)">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        <span style="font-size: 11px; color:#94a3b8;">Bỏ trống nếu không muốn đổi mật khẩu.</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="confirm_password">Xác nhận mật khẩu mới</label>
                        <div class="input-with-icon">
                            <input type="password" id="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu mới">
                            <button type="button" class="password-toggle" onclick="togglePassVisibility('confirm_password', this)">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Button footer -->
                <div style="margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px; display: flex; gap: 15px;">
                    <button type="submit" name="capnhat" class="btn-primary" style="padding: 10px 25px; border-radius: 8px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
                    </button>
                    <a href="index.php?act=dashboard" class="btn-primary" 
                       style="background-color: transparent; border: 1.5px solid #e2e8f0; color: #475569; padding: 10px 25px; border-radius: 8px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
                        Quay về Trang chủ
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function switchProfileTab(tabId, btn) {
    // Hide all tab contents
    document.querySelectorAll('.profile-tab-content').forEach(content => {
        content.classList.remove('active');
    });
    // Remove active class from buttons
    document.querySelectorAll('.profile-tab-btn').forEach(button => {
        button.classList.remove('active');
    });
    
    // Show active tab
    document.getElementById(tabId).classList.add('active');
    btn.classList.add('active');
}

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

// Client validation
document.querySelector('form').addEventListener('submit', function(e) {
    const newPass = document.getElementById('new_password').value;
    const confPass = document.getElementById('confirm_password').value;
    const oldPass = document.getElementById('old_password').value;
    
    if (newPass !== '' && oldPass === '') {
        e.preventDefault();
        alert('Vui lòng điền mật khẩu cũ hiện tại để xác nhận đổi mật khẩu.');
        // Auto-switch to password tab
        document.querySelectorAll('.profile-tab-btn')[1].click();
        return false;
    }
    
    if (newPass !== confPass) {
        e.preventDefault();
        alert('Mật khẩu mới và xác nhận mật khẩu mới không khớp nhau.');
        document.querySelectorAll('.profile-tab-btn')[1].click();
        return false;
    }
});

// Auto tab switch on error if related to password
<?php if (isset($error) && (strpos($error, 'Mật khẩu') !== false || strpos($error, 'khớp') !== false)): ?>
    document.querySelectorAll('.profile-tab-btn')[1].click();
<?php endif; ?>
</script>
