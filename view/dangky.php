<!-- Register Page View (dangky) -->
<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=dangky");
    exit();
}
?>

<div class="container">
    <div class="auth-wrapper">
        <div class="auth-card">
            
            <div class="auth-header">
                <h2>Đăng ký tài khoản</h2>
                <p>Trở thành thành viên để nhận voucher giảm giá 15%</p>
            </div>

            <!-- PHP Error Alerts -->
            <?php if (isset($error) && !empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success) && !empty($success)): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?act=dangky" method="POST" id="register-form">
                <!-- Username -->
                <div class="form-group">
                    <label for="user">Tên đăng nhập <span style="color: var(--danger)">*</span></label>
                    <input type="text" name="user" id="user" class="form-control" placeholder="Nhập tên tài khoản..." value="<?php echo isset($_POST['user']) ? htmlspecialchars($_POST['user']) : ''; ?>" required autocomplete="username">
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Địa chỉ Email <span style="color: var(--danger)">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required autocomplete="email">
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="dien_thoai">Số điện thoại <span style="color: var(--danger)">*</span></label>
                    <input type="tel" name="dien_thoai" id="dien_thoai" class="form-control" placeholder="098xxxxxxxx" value="<?php echo isset($_POST['dien_thoai']) ? htmlspecialchars($_POST['dien_thoai']) : ''; ?>" required autocomplete="tel">
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="pass">Mật khẩu <span style="color: var(--danger)">*</span></label>
                    <input type="password" name="pass" id="pass" class="form-control" placeholder="Tối thiểu 6 ký tự..." required autocomplete="new-password">
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="repass">Nhập lại mật khẩu <span style="color: var(--danger)">*</span></label>
                    <input type="password" name="repass" id="repass" class="form-control" placeholder="Nhập lại mật khẩu..." required autocomplete="new-password">
                </div>

                <button type="submit" name="dangky" class="btn-primary" style="width: 100%; padding: 12px; margin-top: 10px;">
                    Đăng ký tài khoản
                </button>
            </form>

            <div class="auth-footer">
                Đã có tài khoản? <a href="index.php?act=dangnhap">Đăng nhập ngay</a>
            </div>

        </div>
    </div>
</div>
