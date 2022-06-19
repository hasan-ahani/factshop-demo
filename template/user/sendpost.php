<?php
$response = array();
$title = null;
$content = null;
if (isset($_POST['wfsendpost'])) {

    if (!isset($_POST['title'])) {
        $response['success'] = false;
        $response['message'][] = 'عنوان را';
    }
    if (!wp_verify_nonce($_POST['_wpnonce'], 'wf-frontend-post')) {
        $response['success'] = false;
        $response['message'][] = 'ذخیره نشد زیرا فرم شما به نظر می رسید نامعتبر است. :(';

    }
    if (strlen($_POST['title']) < 3) {
        $response['success'] = false;
        $response['message'][] = 'لطفا یک عنوان را وارد کنید عنوان باید حداقل سه کاراکتر باشد. :(';
    }
    if (strlen($_POST['post_content']) < 100) {
        $response['success'] = false;
        $response['message'][] = 'لطفا محتوای بیش از 100 کاراکتر را وارد کنید. :(';
    }

    if (isset($response['success'])) {
        $title = (isset($_POST['title'])) ? $_POST['title'] : null;
        $content = (isset($_POST['post_content'])) ? $_POST['post_content'] : null;
        $cont = $response['message'];
        if ($cont > 0) {
            echo '<ul class="alert alert-danger list-unstyled mb-4 ">';
            foreach ($response['message'] as $message) {
                echo '<li>' . $message . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<div class="alert alert-danger mb-4">' . $response['message'][0] . '</div>';
        }

    } else {
        $post = array(
            'post_title' => $_POST['title'],
            'post_content' => $_POST['post_content'],
            'post_category' => array($_POST['cat']),
            'tags_input' => $_POST['post_tags'],
            'post_status' => 'draft',
            'post_type' => 'post'
        );
        $sendpost = wp_insert_post($post);
        if ($sendpost != 0) {
            $response['success'] = true;
            $response['message'][] = 'پست شما با موفقیت ذخیره شد! :)';
            if (isset($_POST['post_pic'])) {
                $image_id = wf_get_image_id($_POST['post_pic']);
                set_post_thumbnail($sendpost, $image_id);
            }

        }
        echo '<div class="alert alert-info mb-4">' . $response['message'][0] . '</div>';
    }

}
?>
<div id="postbox" class="card p-4">
    <form id="new_post" class="form-vertical" name="new_post" method="post">

        <p><label for="title">عنوان</label><br/>
            <input type="text" class="form-control" id="title" value="<?php echo $title; ?>" tabindex="1" size="20"
                   name="title" autocomplete="disable" required/>
        </p>

        <p>
            <label for="content">محتوا پست</label><br/>
            <?php wp_editor($content, 'post_content'); ?>
        </p>
        <div class="form-row">


            <p class="col-6"><label for="category">دسته
                    بندی</label><?php wp_dropdown_categories('show_option_none=دسته بندی&tab_index=4&taxonomy=category&class=form-control'); ?>
            </p>

            <div class="col-6">
                <label for="post_pic">تصویر شاخص</label>
                <div class=" input-group mb-3">
                    <input type="text" class="form-control" id="post_pic" hidden name="post_pic">
                    <div class="input-group">
                        <button class="btn btn-warning" id="browse-pic" type="button">افزودن تصویر شاخص</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <label for="post_tags">برچسب ها</label>

                <input type="text" value="" data-role="tagsinput" class="form-control" tabindex="5" size="16" name="post_tags" id="post_tags"/>
            </div>
            <div class="col-6"><img class="wf-image-preview" height="150" src=""/></div>
        </div>
        <?php wp_nonce_field('wf-frontend-post'); ?>
        <input type="submit" class="btn btn-primary float-left with-200 mt-4 px-4 ml-2" value="انتشار" tabindex="6"
               id="submit" name="wfsendpost"/>

    </form>
</div>
<script src='<?php echo WF_URI . '/assets/js/tags.js'; ?> '></script>
