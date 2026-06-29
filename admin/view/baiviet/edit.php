<!-- Admin: Sửa Bài Viết -->
<div style="max-width:760px;">
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
        <a href="index.php?act=baiviet-list" class="btn-sm btn-view"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
        <div class="page-title" style="margin:0;">✏️ Sửa Bài Viết #<?php echo $baiviet['id']; ?></div>
    </div>

    <?php if (isset($error)): ?>
        <div class="admin-alert danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card-admin">
        <form method="POST" enctype="multipart/form-data" action="index.php?act=baiviet-edit&id=<?php echo $baiviet['id']; ?>">
            <div class="form-group">
                <label class="form-label">Tiêu đề <span style="color:red;">*</span></label>
                <input type="text" name="tieu_de" class="form-control" required value="<?php echo htmlspecialchars($baiviet['tieu_de']); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Tác giả</label>
                <input type="text" name="tac_gia" class="form-control" value="<?php echo htmlspecialchars($baiviet['tac_gia'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Hình ảnh hiện tại</label>
                <?php if (!empty($baiviet['hinh_anh'])): ?>
                    <img src="../<?php echo $baiviet['hinh_anh']; ?>" style="max-height:120px;border-radius:8px;border:1px solid #e2e8f0;display:block;margin-bottom:10px;">
                <?php endif; ?>
                <label class="form-label">Đổi ảnh mới (tuỳ chọn)</label>
                <input type="file" name="hinh_anh" class="form-control" accept="image/*" id="editNewsInput">
                <img id="editNewsPreview" src="#" style="display:none;max-height:120px;border-radius:8px;margin-top:8px;border:1px solid #e2e8f0;">
            </div>
            <div class="form-group">
                <label class="form-label">Nội dung <span style="color:red;">*</span></label>
                <textarea name="noi_dung" class="form-control" rows="12" required><?php echo htmlspecialchars($baiviet['noi_dung']); ?></textarea>
            </div>
            <button type="submit" name="capnhat" class="btn-sm btn-edit" style="padding:12px 30px;font-size:14px;">
                <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
            </button>
        </form>
    </div>
</div>
<script>
document.getElementById('editNewsInput').addEventListener('change', function() {
    const p = document.getElementById('editNewsPreview');
    if (this.files[0]) { p.src = URL.createObjectURL(this.files[0]); p.style.display='block'; }
});
</script>
