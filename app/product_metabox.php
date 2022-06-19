<?php
// My custom codes will be here
add_action( 'admin_init', 'wf_product_init_func' );

function wf_product_init_func() {
    //$id, $title, $callback, $page, $context, $priority, $callback_args
    add_meta_box('product_info', 'اطلاعات محصول', 'product_info_metabox', 'product');
}
add_action('save_post', 'save_wf_product_meta');

function save_wf_product_meta($post_id) {
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    if( !current_user_can( 'edit_posts' ) ) return;

    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
    // If any value present in input field, then update the post meta
    if(isset($_POST['previewonline'])) {
        // $post_id, $meta_key, $meta_value
        update_post_meta( $post_id, 'previewonline', $_POST['previewonline'] );
    }
}


function product_info_metabox() {
    global $post;

    $previewonline =   get_post_meta($post->ID, 'previewonline', true);
    ?>
    <div class="input_fields_wrap downloadable_metabox">
            <div class="inside">
                <label for="previewonline">پیشنمایش آنلاین</label>
                <input type="text" class="regular-text" id="product-renewal-amount" name="previewonline" value="<?php echo (isset($previewonline)) ? $previewonline : '';?>" placeholder="www.exapmle.com">
                <p class="description">لینک آدرس پیشنمایش را وارد کنید</p>
            </div>
    </div>

    <?php
}