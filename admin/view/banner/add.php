<!-- Admin: Thêm Banner -->
<div style="max-width:640px;">
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
        <a href="index.php?act=banner-list" class="btn-sm btn-view"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
        <div class="page-title" style="margin:0;">➕ Thêm Banner</div>
    </div>

    <?php if (isset($error)): ?>
        <div class="admin-alert danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card-admin">
        <form method="POST" enctype="multipart/form-data" action="index.php?act=banner-add">
            <div class="form-group">
                <label class="form-label">Tên Banner <span style="color:red;">*</span></label>
                <input type="text" name="ten_banner" class="form-control" required placeholder="Ví dụ: Nike Mercurial Sale">
            </div>

            <div class="form-group">
                <label class="form-label">Loại Banner <span style="color:red;">*</span></label>
                <select name="vi_tri" class="form-control">
                    <option value="slider">Slider chính (trang chủ)</option>
                    <option value="sub_banner">Sub Banner</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Liên kết khi bấm vào</label>
                <input type="text" name="lien_ket" class="form-control" placeholder="Ví dụ: index.php?act=sanpham&keyword=Nike">
            </div>

            <div class="form-group">
                <label class="form-label">Hình ảnh Banner</label>
                <input type="file" name="hinh_anh" class="form-control" accept="image/*" id="bannerImgInput">
                <div style="margin-top:10px;">
                    <img id="bannerPreview" src="#" alt="Preview" style="display:none;max-height:160px;border-radius:8px;border:1px solid #e2e8f0;">
                </div>
                <div style="font-size:12px;color:#94a3b8;margin-top:6px;">Khuyến nghị kích thước: 1920x600px. Định dạng: JPG, PNG, WEBP.</div>
            </div>

            <button type="submit" name="themmoi" class="btn-sm btn-success" style="padding:12px 30px;font-size:14px;">
                <i class="fa-solid fa-plus"></i> Thêm Banner
            </button>
        </form>
    </div>
</div>
<script>
document.getElementById('bannerImgInput').addEventListener('change', function() {
    const preview = document.getElementById('bannerPreview');
    if (this.files && this.files[0]) {
        preview.src = URL.createObjectURL(this.files[0]);
        preview.style.display = 'block';
    }
});
</script>
