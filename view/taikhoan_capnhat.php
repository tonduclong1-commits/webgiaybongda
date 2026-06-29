<!-- Update Profile / Change Password (taikhoan_capnhat.php) -->
<style>
.profile-wrap {
    min-height: calc(100vh - 120px);
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 48px 16px;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}
.profile-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.10);
    width: 100%;
    max-width: 520px;
    overflow: hidden;
}
.profile-header-banner {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    padding: 32px 36px 24px;
    display: flex;
    align-items: center;
    gap: 18px;
}
.profile-avatar {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: rgba(57,255,20,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    font-weight: 900;
    color: #39ff14;
    border: 2px solid rgba(57,255,20,0.3);
    flex-shrink: 0;
}
.profile-header-banner h2 {
    color: white;
    font-size: 20px;
    font-weight: 800;
    margin: 0 0 4px;
}
.profile-header-banner p {
    color: #94a3b8;
    font-size: 13px;
    margin: 0;
}
/* Tabs */
.profile-tabs {
    display: flex;
    border-bottom: 1px solid #f1f5f9;
    background: #f8fafc;
}
.profile-tab {
    flex: 1;
    padding: 14px 12px;
    text-align: center;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all 0.2s;
    user-select: none;
}
.profile-tab.active { color: #1e293b; border-color: #1e293b; background: white; }
.profile-tab:hover:not(.active) { color: #1e293b; background: #f1f5f9; }
/* Tab content */
.tab-pane { display: none; padding: 28px 36px 32px; }
.tab-pane.active { display: block; }
/* Form fields */
.pf-group { margin-bottom: 20px; }
.pf-label {
    display: block;
    font-size: 11px;
    font-weight: 800;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-bottom: 7px;
}
.pf-input-wrap { position: relative; }
.pf-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
}
.pf-input {
    width: 100%;
    padding: 11px 13px 11px 38px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
    box-sizing: border-box;
}
.pf-input:focus { border-color: #1e293b; }
.pf-toggle {
    position: absolute;
    right: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    cursor: pointer;
    font-size: 14px;
}
.btn-save {
    width: 100%;
    padding: 13px;
    background: #1e293b;
    color: white;
    font-weight: 800;
    font-size: 15px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.2s;
    margin-top: 6px;
}
.btn-save:hover { background: #0f172a; }
.pf-alert {
    padding: 11px 15px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 20px;
}
.pf-alert.error   { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; }
.pf-alert.success { background: #f0fdf4; color: #166534; border: 1px solid #86efac; }
.pf-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 36px;
    border-top: 1px solid #f1f5f9;
    font-size: 13px;
    background: #f8fafc;
}
.pf-bottom a { color: #475569; text-decoration: none; font-weight: 600; transition: color 0.2s; }
.pf-bottom a:hover { color: #1e293b; }
</style>

<div class="profile-wrap">
    <div class="profile-card">

        <!-- Header banner -->
        <div class="profile-header-banner">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($_SESSION['user']['user'], 0, 1)); ?>
            </div>
            <div>
                <h2><?php echo htmlspecialchars($_SESSION['user']['user']); ?></h2>
                <p>
                    <?php echo htmlspecialchars($_SESSION['user']['email']); ?>
                    &nbsp;•&nbsp;
                    <span style="color:<?php echo $_SESSION['user']['vai_tro']==1 ? '#39ff14' : '#94a3b8'; ?>;">
                        <?php echo $_SESSION['user']['vai_tro']==1 ? '👑 Admin' : '👤 Khách hàng'; ?>
                    </span>
                </p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="profile-tabs">
            <div class="profile-tab active" id="tab-info" onclick="switchTab('info')">
                <i class="fa-solid fa-user"></i> Thông tin cá nhân
            </div>
            <div class="profile-tab" id="tab-pass" onclick="switchTab('pass')">
                <i class="fa-solid fa-lock"></i> Đổi mật khẩu
            </div>
        </div>

        <!-- Alert (shared) -->
        <?php if (isset($error) && !empty($error)): ?>
            <div style="padding: 0 36px; margin-top: 18px;">
                <div class="pf-alert error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></div>
            </div>
        <?php endif; ?>
        <?php if (isset($success) && !empty($success)): ?>
            <div style="padding: 0 36px; margin-top: 18px;">
                <div class="pf-alert success"><i class="fa-solid fa-circle-check"></i> <?php echo $success; ?></div>
            </div>
        <?php endif; ?>

        <!-- Tab: Thông tin cá nhân -->
        <div class="tab-pane active" id="pane-info">
            <form action="index.php?act=capnhat-taikhoan" method="POST">
                <input type="hidden" name="_tab" value="info">

                <div class="pf-group">
                    <label class="pf-label">Tên đăng nhập <span style="color:red">*</span></label>
                    <div class="pf-input-wrap">
                        <i class="fa-solid fa-user pf-icon"></i>
                        <input type="text" name="user" class="pf-input"
                               value="<?php echo htmlspecialchars($_SESSION['user']['user']); ?>"
                               required autocomplete="username">
                    </div>
                </div>

                <div class="pf-group">
                    <label class="pf-label">Địa chỉ Email <span style="color:red">*</span></label>
                    <div class="pf-input-wrap">
                        <i class="fa-solid fa-envelope pf-icon"></i>
                        <input type="email" name="email" class="pf-input"
                               value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>"
                               required autocomplete="email">
                    </div>
                </div>

                <div class="pf-group">
                    <label class="pf-label">Số điện thoại</label>
                    <div class="pf-input-wrap">
                        <i class="fa-solid fa-phone pf-icon"></i>
                        <input type="tel" name="dien_thoai" class="pf-input"
                               value="<?php echo htmlspecialchars($_SESSION['user']['dien_thoai'] ?? ''); ?>"
                               placeholder="Chưa cung cấp" autocomplete="tel">
                    </div>
                </div>

                <!-- Hidden pass fields (empty = no change) -->
                <input type="hidden" name="pass" value="">
                <input type="hidden" name="repass" value="">

                <button type="submit" name="capnhat" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu thông tin
                </button>
            </form>
        </div>

        <!-- Tab: Đổi mật khẩu -->
        <div class="tab-pane" id="pane-pass">
            <form action="index.php?act=capnhat-taikhoan" method="POST">
                <input type="hidden" name="_tab" value="pass">
                <!-- Send current info too so it doesn't get cleared -->
                <input type="hidden" name="user"       value="<?php echo htmlspecialchars($_SESSION['user']['user']); ?>">
                <input type="hidden" name="email"      value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>">
                <input type="hidden" name="dien_thoai" value="<?php echo htmlspecialchars($_SESSION['user']['dien_thoai'] ?? ''); ?>">

                <div class="pf-group">
                    <label class="pf-label">Mật khẩu mới <span style="color:red">*</span></label>
                    <div class="pf-input-wrap">
                        <i class="fa-solid fa-lock pf-icon"></i>
                        <input type="password" name="pass" id="new-pass" class="pf-input"
                               placeholder="Tối thiểu 6 ký tự..." required autocomplete="new-password">
                        <i class="fa-solid fa-eye pf-toggle" onclick="togglePf('new-pass', this)"></i>
                    </div>
                </div>

                <div class="pf-group">
                    <label class="pf-label">Xác nhận mật khẩu mới <span style="color:red">*</span></label>
                    <div class="pf-input-wrap">
                        <i class="fa-solid fa-lock pf-icon"></i>
                        <input type="password" name="repass" id="re-pass" class="pf-input"
                               placeholder="Nhập lại mật khẩu mới..." required autocomplete="new-password">
                        <i class="fa-solid fa-eye pf-toggle" onclick="togglePf('re-pass', this)"></i>
                    </div>
                </div>

                <div style="background:#f8fafc;border-radius:9px;padding:12px 14px;font-size:12px;color:#64748b;margin-bottom:18px;">
                    <i class="fa-solid fa-circle-info"></i>
                    Mật khẩu phải có ít nhất <strong>6 ký tự</strong>. Không chia sẻ mật khẩu với người khác.
                </div>

                <button type="submit" name="capnhat" class="btn-save" style="background:#ef4444;">
                    <i class="fa-solid fa-key"></i> Đổi mật khẩu ngay
                </button>
            </form>
        </div>

        <!-- Footer links -->
        <div class="pf-bottom">
            <a href="index.php"><i class="fa-solid fa-house"></i> Trang chủ</a>
            <a href="index.php?act=donhang"><i class="fa-solid fa-box-open"></i> Đơn hàng</a>
            <?php if ($_SESSION['user']['vai_tro'] == 1): ?>
                <a href="admin/index.php" style="color:#1e293b;font-weight:800;">
                    <i class="fa-solid fa-gauge-high"></i> Admin Panel
                </a>
            <?php endif; ?>
            <a href="index.php?act=dangxuat" style="color:#ef4444;">
                <i class="fa-solid fa-power-off"></i> Đăng xuất
            </a>
        </div>

    </div>
</div>

<script>
function switchTab(tab) {
    document.querySelectorAll('.profile-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    document.getElementById('pane-' + tab).classList.add('active');
}

function togglePf(id, icon) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Auto-switch to password tab if error on password fields
<?php if (isset($error) && (strpos($error, 'ật khẩu') !== false)): ?>
switchTab('pass');
<?php endif; ?>
</script>
