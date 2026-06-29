<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=dangnhap");
    exit();
}
?>
<!-- Login Page (dangnhap.php) -->
<style>
.auth-page-wrap {
    min-height: calc(100vh - 120px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 16px;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}
.auth-box {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.10);
    padding: 44px 40px 36px;
    width: 100%;
    max-width: 440px;
}
.auth-box .brand-mark {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 28px;
}
.auth-box .brand-mark img {
    height: 42px;
}
.auth-box h2 {
    font-size: 24px;
    font-weight: 900;
    color: #1e293b;
    margin-bottom: 4px;
}
.auth-box .subtitle {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 28px;
}
.auth-input-group {
    position: relative;
    margin-bottom: 18px;
}
.auth-input-group label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 7px;
}
.auth-input-group .input-icon-wrap {
    position: relative;
}
.auth-input-group .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
}
.auth-input-group input {
    width: 100%;
    padding: 11px 14px 11px 40px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
    outline: none;
}
.auth-input-group input:focus {
    border-color: #1e293b;
    box-shadow: 0 0 0 3px rgba(30,41,59,0.08);
}
.auth-input-group .toggle-pass {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #94a3b8;
    font-size: 14px;
}
.btn-auth {
    width: 100%;
    padding: 13px;
    background: #1e293b;
    color: white;
    font-weight: 800;
    font-size: 15px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
    margin-top: 6px;
}
.btn-auth:hover { background: #0f172a; transform: translateY(-1px); }
.auth-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 22px 0;
    color: #94a3b8;
    font-size: 12px;
}
.auth-divider::before, .auth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e2e8f0;
}
.demo-box {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1px solid #86efac;
    border-radius: 10px;
    padding: 14px 16px;
    font-size: 13px;
    color: #166534;
    margin-top: 20px;
}
.demo-box strong { display: block; margin-bottom: 8px; font-size: 13px; }
.demo-tag {
    display: inline-block;
    background: #1e293b;
    color: white;
    padding: 2px 9px;
    border-radius: 5px;
    font-family: monospace;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
}
.alert-auth {
    padding: 11px 15px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 18px;
}
.alert-auth.error { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; }
.alert-auth.success { background: #f0fdf4; color: #166534; border: 1px solid #86efac; }
</style>

<div class="auth-page-wrap">
    <div class="auth-box">

        <!-- Brand -->
        <div class="brand-mark">
            <img src="assets/images/logo.png" alt="Logo" onerror="this.style.display='none'">
            <div>
                <div style="font-size:18px;font-weight:900;color:#1e293b;line-height:1.1;">Unifootball</div>
                <div style="font-size:11px;color:#64748b;">Hệ thống giày bóng đá chính hãng</div>
            </div>
        </div>

        <h2>Đăng nhập</h2>
        <p class="subtitle">Nhập tên đăng nhập hoặc email và mật khẩu để tiếp tục</p>

        <!-- Alerts -->
        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert-auth error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($success) && !empty($success)): ?>
            <div class="alert-auth success"><i class="fa-solid fa-circle-check"></i> <?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Form -->
        <form action="index.php?act=dangnhap" method="POST" id="login-form" autocomplete="on">

            <div class="auth-input-group">
                <label for="user">Tên đăng nhập hoặc Email</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input type="text" name="user" id="user"
                           placeholder="admin hoặc admin123@gmail.com"
                           value="<?php echo isset($_POST['user']) ? htmlspecialchars($_POST['user']) : ''; ?>"
                           required autocomplete="username">
                </div>
            </div>

            <div class="auth-input-group">
                <label for="pass">Mật khẩu</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="pass" id="pass"
                           placeholder="Nhập mật khẩu..."
                           required autocomplete="current-password">
                    <i class="fa-solid fa-eye toggle-pass" id="togglePass" onclick="togglePassword()"></i>
                </div>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;font-size:13px;">
                <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-weight:600;color:#475569;">
                    <input type="checkbox" name="remember" style="accent-color:#1e293b;"> Ghi nhớ đăng nhập
                </label>
                <a href="#" style="color:#64748b;" onclick="alert('Vui lòng liên hệ Admin để khôi phục mật khẩu.');event.preventDefault();">Quên mật khẩu?</a>
            </div>

            <button type="submit" name="dangnhap" class="btn-auth">
                <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
            </button>
        </form>

        <!-- Demo box -->
        <div class="demo-box">
            <strong><i class="fa-solid fa-key"></i> Tài khoản Admin Demo:</strong>
            Email: <span class="demo-tag" onclick="document.getElementById('user').value='admin123@gmail.com'">admin123@gmail.com</span>
            &nbsp; Mật khẩu: <span class="demo-tag" onclick="document.getElementById('pass').value='123456'">123456</span>
            <br><small style="display:block;margin-top:6px;color:#15803d;">👆 Nhấn vào để điền tự động</small>
        </div>

        <div class="auth-divider">hoặc</div>

        <div style="text-align:center;font-size:14px;color:#475569;">
            Chưa có tài khoản? <a href="index.php?act=dangky" style="color:#1e293b;font-weight:800;">Đăng ký ngay →</a>
        </div>

    </div>
</div>

<script>
function togglePassword() {
    const pass  = document.getElementById('pass');
    const icon  = document.getElementById('togglePass');
    if (pass.type === 'password') {
        pass.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        pass.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
