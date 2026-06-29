<!-- Contact Page View (lienhe) -->
<?php
if (!defined('DB_HOST')) {
    header("Location: ../index.php?act=lienhe");
    exit();
}
?>

<div class="container">
    <div class="info-layout">
        
        <div class="info-header">
            <h1>Liên hệ với chúng tôi</h1>
            <p>Mọi thắc mắc, góp ý hoặc yêu cầu hỗ trợ, vui lòng gửi tin nhắn cho chúng tôi</p>
        </div>

        <!-- Dynamic Form Submission Alert -->
        <?php if (isset($_POST['gửi_liên_hệ'])): ?>
            <div class="alert alert-success" style="margin-bottom: 30px;">
                <i class="fa-solid fa-circle-check"></i> <strong>Gửi thông tin thành công!</strong> Cảm ơn bạn <strong><?php echo htmlspecialchars($_POST['name']); ?></strong>. Chúng tôi đã nhận được thông tin liên hệ và sẽ phản hồi lại qua email <em><?php echo htmlspecialchars($_POST['email']); ?></em> trong vòng 24 giờ làm việc.
            </div>
        <?php endif; ?>

        <div class="info-content">
            <div class="info-grid" style="grid-template-columns: 1fr 1.2fr; gap: 50px;">
                
                <!-- Left: Contact Details and Maps -->
                <div class="contact-details">
                    <h2 style="font-size: 20px; font-weight: 700; color: var(--text-dark); margin-bottom: 20px;">Thông tin liên lạc</h2>
                    
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <strong>Trụ sở cửa hàng</strong>
                            <p style="font-size: 14px; margin-top: 5px;">123 Đường Ba Tháng Hai, Phường 11, Quận 10, Thành phố Hồ Chí Minh</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <strong>Đường dây nóng</strong>
                            <p style="font-size: 14px; margin-top: 5px;">1900 6789 (Hỗ trợ 24/7)</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <strong>Thư điện tử</strong>
                            <p style="font-size: 14px; margin-top: 5px;">support@antigravitysports.vn</p>
                        </div>
                    </div>

                    <!-- Google Maps Embed -->
                    <div style="margin-top: 20px; border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border-color); box-shadow: var(--shadow);">
                        <iframe src="https://maps.google.com/maps?q=123%20Ba%20Th%C3%A1ng%20Hai%2C%20Qu%E1%BA%ADn%2010%2C%20Th%E1%BB%93%20Ch%C3%AD%20Minh&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                                width="100%" 
                                height="220" 
                                style="border:0; display: block;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <!-- Right: Contact Form -->
                <div>
                    <h2 style="font-size: 20px; font-weight: 700; color: var(--text-dark); margin-bottom: 20px;">Gửi phản hồi trực tuyến</h2>
                    
                    <form action="index.php?act=lienhe" method="POST" id="contact-form">
                        <!-- Full Name -->
                        <div class="form-group">
                            <label for="name">Họ và tên <span style="color: var(--danger)">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nhập họ và tên..." required>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Địa chỉ Email <span style="color: var(--danger)">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com" required>
                        </div>

                        <!-- Subject -->
                        <div class="form-group">
                            <label for="subject">Chủ đề cần hỗ trợ</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Tư vấn phom giày, khiếu nại đơn hàng...">
                        </div>

                        <!-- Message -->
                        <div class="form-group">
                            <label for="message">Nội dung tin nhắn <span style="color: var(--danger)">*</span></label>
                            <textarea name="message" id="message" rows="5" class="form-control" style="resize: vertical; min-height: 120px;" placeholder="Nhập chi tiết nội dung cần hỗ trợ..." required></textarea>
                        </div>

                        <button type="submit" name="gửi_liên_hệ" class="btn-primary" style="width: 100%; padding: 12px; margin-top: 10px;">
                            Gửi phản hồi <i class="fa-regular fa-paper-plane" style="margin-left: 5px;"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <!-- Store Gallery Banner Section -->
        <div style="margin-top: 50px; border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border-color); box-shadow: var(--shadow); background: #ffffff;">
            <?php
            $store_src = 'C:/Users/Vinacom/.gemini/antigravity/brain/e0be63cd-6aa9-413c-8655-0089df006eae/media__1782464015406.png';
            $store_dst = __DIR__ . '/../assets/images/store_gallery.png';
            if (!file_exists($store_dst) && file_exists($store_src)) {
                @copy($store_src, $store_dst);
            }
            ?>
            <img src="assets/images/store_gallery.png" alt="Hệ thống cửa hàng Sport9" style="width: 100%; height: auto; display: block; object-fit: contain;">
        </div>

    </div>
</div>
