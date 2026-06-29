<!-- Admin: Thêm Bài Viết -->
<div style="max-width:760px;">
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
        <a href="index.php?act=baiviet-list" class="btn-sm btn-view"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
        <div class="page-title" style="margin:0;">➕ Thêm Bài Viết</div>
    </div>

    <?php if (isset($error)): ?>
        <div class="admin-alert danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card-admin">
        <form method="POST" enctype="multipart/form-data" action="index.php?act=baiviet-add">
            <div class="form-group">
                <label class="form-label">Tiêu đề <span style="color:red;">*</span></label>
                <input type="text" name="tieu_de" class="form-control" required placeholder="Nhập tiêu đề bài viết...">
            </div>
            <div class="form-group">
                <label class="form-label">Tác giả</label>
                <input type="text" name="tac_gia" class="form-control" placeholder="Tên tác giả"
                       value="<?php echo htmlspecialchars($_SESSION['user']['user']); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Hình ảnh đại diện</label>
                <input type="file" name="hinh_anh" class="form-control" accept="image/*" id="newsImgInput">
                <img id="newsImgPreview" src="#" style="display:none;max-height:160px;border-radius:8px;margin-top:8px;border:1px solid #e2e8f0;">
            </div>
            <div class="form-group">
                <label class="form-label">Nội dung <span style="color:red;">*</span></label>
                <textarea name="noi_dung" class="form-control" rows="10" required
                          placeholder="Nhập nội dung bài viết..."></textarea>
            </div>
            <button type="submit" name="themmoi" class="btn-sm btn-success" style="padding:12px 30px;font-size:14px;">
                <i class="fa-solid fa-plus"></i> Đăng Bài
            </button>
        </form>
    </div>
</div>
<script>
document.getElementById('newsImgInput').addEventListener('change', function() {
    const p = document.getElementById('newsImgPreview');
    if (this.files[0]) { p.src = URL.createObjectURL(this.files[0]); p.style.display='block'; }
});
</script>
