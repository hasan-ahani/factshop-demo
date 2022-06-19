<div class="card mb-4 p-4 pzr">
    <form enctype="multipart/form-data" action="" method="POST">
        <div class="avatar-upload">
            <div class="image-avatar-background"   style="background-image: url(<?php echo fs_get_avatar_url(get_current_user_ID());?>);"></div>
            <div class="avatar-edit">
                <input type="hidden" name="MAX_FILE_SIZE" value="524288" />
                <label for="imageUpload"></label>
                <input name="profile_pic" id="imageUpload" accept=".png, .jpg, .jpeg" type="file" size="25" /><br><br>
            </div>
            <?php $pic = get_user_meta( get_current_user_ID(), 'profile_pic');
            if(!empty($pic[0])):?>
                <a class="avatar-remove" href="?remove_avatar=true" onclick="return confirm('آیا از حذف آواتار مطمئن هستید؟')">
                    <i class="fas fa-trash"></i>
                </a>
            <?php endif;?>
            <div class="avatar-preview">
                <div id="imagePreview" style="background-image: url(<?php echo fs_get_avatar_url(get_current_user_ID());?>);">
                </div>
            </div>
        </div>
        <input id="btn-submit-avatar" type="submit" class="btn btn-primary" value="تغییر آواتار" disabled/>
    </form>
</div>
<div class="alert alert-warning mb-4">حد اکثر حجم تصویر 500 کیلو بایت و فرمت پشتیبانی png | jpg | jpeg می باشد.</div>