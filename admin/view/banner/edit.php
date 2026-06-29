<!-- Admin: Sửa Banner -->
<div style="max-width:640px;">
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
        <a href="index.php?act=banner-list" class="btn-sm btn-view"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
        <div class="page-title" style="margin:0;">✏️ Sửa Banner #<?php echo $banner['id']; ?></div>
    </div>

    <?php if (isset($error)): ?>
        <div class="admin-alert danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card-admin">
        <form method="POST" enctype="multipart/form-data" action="index.php?act=banner-edit&id=<?php echo $banner['id']; ?>">
            <div class="form-group">
                <label class="form-label">Tên Banner <span style="color:red;">*</span></label>
                <input type="text" name="ten_banner" class="form-control" required value="<?php echo htmlspecialchars($banner['ten_banner']); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Loại Banner</label>
                <select name="vi_tri" class="form-control">
                    <option value="slider" <?php echo $banner['vi_tri']=='slider'?'selected':''; ?>>Slider chính</option>
                    <option value="sub_banner" <?php echo $banner['vi_tri']=='sub_banner'?'selected':''; ?>>Sub Banner</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Liên kết</label>
                <input type="text" name="lien_ket" class="form-control" value="<?php echo htmlspecialchars($banner['lien_ket']); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Hình ảnh hiện tại</label>
                <?php if ($banner['hinh_anh']): ?>
                    <img src="../<?php echo $banner['hinh_anh']; ?>" style="max-height:120px;border-radius:8px;border:1px solid #e2e8f0;display:block;margin-bottom:10px;">
                <?php endif; ?>
                <label class="form-label">Đổi ảnh mới (tuỳ chọn)</label>
                <input type="file" name="hinh_anh" class="form-control" accept="image/*" id="editBannerInput">
                <img id="editBannerPreview" src="#" style="display:none;max-height:120px;border-radius:8px;margin-top:8px;border:1px solid #e2e8f0;">
            </div>
            <button type="submit" name="capnhat" class="btn-sm btn-edit" style="padding:12px 30px;font-size:14px;">
                <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
            </button>
        </form>
    </div>
</div>
<script>
document.getElementById('editBannerInput').addEventListener('change', function() {
    const p = document.getElementById('editBannerPreview');
    if (this.files[0]) { p.src = URL.createObjectURL(this.files[0]); p.style.display='block'; }
});
</script>
