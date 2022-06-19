<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;
setPostViews(get_the_ID());
/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<div class="row">
    <div class="col-md-9">
        <?php get_ad('product', 1);
        remon_breadcrumbs();
        get_ad('product', 2);
        get_slider_position('single');
        get_ad('product', 3); ?>
        <div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

            <?php
            /**
             * Hook: woocommerce_before_single_product_summary.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            do_action('woocommerce_before_single_product_summary');
            ?>

            <?php
            /**
             * Hook: woocommerce_single_product_summary.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked WC_Structured_Data::generate_product_data() - 60
             */
            //            do_action( 'woocommerce_single_product_summary' );
            ?>

            <?php
            /**
             * Hook: woocommerce_after_single_product_summary.
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15
             * @hooked woocommerce_output_related_products - 20
             */
            do_action('woocommerce_after_single_product_summary');
            ?>
        </div>

        <?php do_action('woocommerce_after_single_product'); ?>
    </div>
    <?php global $post, $product; ?>
    <div class="col-md-3 sidbar">
        <div id="sidbar_product">
            <div id="product-adtocart" class="card product-adtocart p-4 d-none d-md-block d-lg-block s-xl-block">
                <?php woocommerce_template_single_price(); ?>
                <?php
                if (cs_get_option('show-product-like')) {
                    echo get_simple_likes_button(get_the_ID());
                }
                $previewonline = get_post_meta(get_the_ID(), 'previewonline', true);
                if ($previewonline != ''):?>
                        <a href="<?php echo $previewonline; ?>" target="_blank"
                           class="btn btn-primary btn-block my-3"><?php echo cs_get_option('translate-preview', 'پیشنمایش آنلاین'); ?></a>
                <?php endif;

                if ($product->is_downloadable() AND $product->get_price() == 0) {
                    ?>
                    <p class="buy-info-product"><?php echo cs_get_option('product_pyments_free'); ?></p>
                    <?php if (cs_get_option('product_mazaya_free') != ''): ?>
                        <div class="support-product-pro"><?php echo cs_get_option('product_mazaya_free'); ?></div>
                    <?php endif;
                } else {
                    ?>
                    <p class="buy-info-product"><?php echo cs_get_option('product_pyments'); ?></p>
                    <?php if (cs_get_option('product_mazaya') != ''): ?>
                        <div class="support-product-pro"><?php echo cs_get_option('product_mazaya'); ?></div>
                    <?php endif;
                }

                if ($product->is_downloadable() AND $product->get_price() == 0) {
                    $files = $product->get_files();
                    $files = array_keys($files);
                    $download_url = home_url('?download_file=' . $product->id . '&key=' . $files[0] . '&free=1');
                    $button = sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="btn btn-info btn-block"><i class="fa fa-download mr-1"></i> %s</a>',
                        esc_url($download_url),
                        esc_attr($product->id),
                        esc_attr($product->get_sku()),
                        esc_attr(isset($quantity) ? $quantity : 1),
                        esc_html(cs_get_option('translate-download', 'دانلود'))
                    );

                    echo $button;
                } else {
                    woocommerce_template_single_add_to_cart();
                }

                ?>
                <div class="text-center mt-3 py-2 border-top"><?php echo get_star_rating(); ?></div>
            </div>
            <?php if (cs_get_option('show-product-details')): ?>
                <div class="card widget">
                    <div class="widget-title"><?php echo cs_get_option('translate-productinfo', 'اطلاعات محصول'); ?></div>

                    <ul class="info-product list-unstyled ">
                        <?php echo cs_get_option('show-product-details-updated');
                        if (cs_get_option('show-product-date')): ?>
                            <li>
                                <span><?php echo cs_get_option('translate-createdate', 'تاریخ ثبت:'); ?></span><b><?php echo get_the_date('Y/m/d', $post->ID); ?></b>
                            </li>
                        <?php endif; ?>
                        <?php if (cs_get_option('show-product-updated')): ?>
                            <?php if (get_the_modified_time('Y/m/d H:i:s', $post->ID) != get_the_date('Y/m/d H:i:s', $post->ID)): ?>
                                <li>
                                    <span><?php echo cs_get_option('translate-updatedate', 'تاریخ بروزرسانی:'); ?></span><b><?php echo get_the_modified_time('Y/m/d', $post->ID); ?></b>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (cs_get_option('show-product-sales')): ?>
                                <li>
                                    <span><?php echo cs_get_option('translate-countsale', 'تعداد فروش:'); ?></span><b><?php echo get_post_meta($post->ID, 'total_sales', true); ?></b>
                                </li>
                        <?php endif; ?>
                        <?php if (cs_get_option('show-product-views')): ?>
                            <li>
                                <span><?php echo cs_get_option('translate-countview', 'تعداد بازدید:'); ?></span><b><?php echo strip_tags(getPostViews($post->ID)); ?></b>
                            </li>
                        <?php endif; ?>
                        <?php if (cs_get_option('show-product-comments')): ?>
                            <li>
                                <span><?php echo cs_get_option('translate-countcomment', 'تعداد دیدگاه:'); ?></span><b><?php echo get_comments_number(); ?></b>
                            </li>
                        <?php endif; ?>
                        <?php if ($product->is_downloadable('yes')): ?>
                            <?php if (cs_get_option('show-product-filetype')): ?>
                                <li>
                                    <span><?php echo cs_get_option('translate-filetype', 'نوع فایل:'); ?></span><b><?php echo get_type_download_file_product(); ?></b>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (cs_get_option('show-product-category')): ?>
                            <li>
                                <span><?php echo cs_get_option('translate-pcategory', 'دسته:'); ?></span><b><?php echo wc_get_product_category_list($product->get_id(), ', '); ?></b>
                            </li>
                        <?php endif; ?>
                        <?php if (cs_get_option('show-product-tags') && !cs_get_option('show-product-tagsinbox')): ?>
                            <li>
                                <span><?php echo cs_get_option('translate-ptags', 'برچسب:'); ?></span><b><?php echo wc_get_product_tag_list($product->get_id(), ', '); ?></b>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php if (cs_get_option('show-product-tags') && cs_get_option('show-product-tagsinbox')):
                    if (!empty(wc_get_product_tag_list($product->get_id()))):
                        ?>
                        <div class="card widget p-3">
                            <?php echo wc_get_product_tag_list($product->get_id(), '</li><li>', '<ul class="tag-list-large list-unstyled"><li><i class="fas fa-tags"></i></li><li>', '</li></ul>'); ?>
                        </div>
                    <?php endif;
                endif; ?>
            <?php endif; ?>
            <?php if (is_active_sidebar('sidebar-product')) : ?>
                <?php dynamic_sidebar('sidebar-product'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>