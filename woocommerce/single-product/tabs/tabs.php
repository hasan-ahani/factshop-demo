<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
global $product;
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );?>
    <div class="card product-adtocart mb-4 p-4 d-md-none d-lg-none s-xl-none">
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
                esc_html(cs_get_option('translate-download','دانلود'))
            );

            echo $button;
        } else {
            woocommerce_template_single_add_to_cart();
        }

        ?>
        <div class="text-center mt-3 py-2 border-top"><?php echo get_star_rating(); ?></div>
    </div>
<?php if ( ! empty( $product_tabs ) ) : ?>

<div class="card content mb-4">
    <?php if (cs_get_option('show-post-share')): ?>
        <div class="share-block d-none d-sm-none d-md-none d-lg-block d-xl-block">
            <ul class="share-menu list-unstyled">
                <li>
                    <a href="https://telegram.me/share/url?url=<?php echo wp_get_shortlink(); ?> "><i
                                class="icon-telegram"></i></a></li>
                <li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo wp_get_shortlink(); ?> "><i
                                class="icon-facebook"></i></a></li>
                <li>
                    <a href="https://plus.google.com/share?url=<?php echo wp_get_shortlink(); ?> "><i
                                class="icon-google"></i></a></li>
                <li><a href="http://twitter.com/home?status=<?php echo wp_get_shortlink(); ?> "><i
                                class="icon-twitter"></i></a></li>
            </ul>
        </div>
    <?php endif; ?>
		<ul  class="nav nav-tabs wc-tabs" id="pills-tab" role="tablist">
			<?php reset($product_tabs);
            $firstWooTab = key($product_tabs); ?>
            <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<li class="nav-item   <?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
					<a class="nav-link <?php echo $key === $firstWooTab ? 'active' : ''; ?>" href="#tab-<?php echo esc_attr( $key ); ?>" data-toggle="pill" role="tab" aria-selected="true">
                        <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                    </a>

                </li>
			<?php endforeach; ?>

		</ul>

    <div class="tab-content mt-4" id="pills-tabContent">
        <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="tab-pane fade <?php echo esc_attr( $key ); ?>  <?php echo $key === $firstWooTab ? 'active show' : ''; ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
                <?php
                if ( isset( $product_tab['callback'] ) ) {
                    call_user_func( $product_tab['callback'], $key, $product_tab );
                }
                ?>
			</div>
		<?php endforeach;
		do_action( 'woocommerce_product_after_tabs' ); ?>
        <?php if (cs_get_option('show-post-share')): ?>
            <ul class="share-menu share-mobile list-unstyled d-block d-sm-block d-md-block d-lg-none d-xl-none">
                <li>
                    <a href="https://telegram.me/share/url?url=<?php echo wp_get_shortlink(); ?> "><i
                                class="icon-telegram"></i></a></li>
                <li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo wp_get_shortlink(); ?> "><i
                                class="icon-facebook"></i></a></li>
                <li>
                    <a href="https://plus.google.com/share?url=<?php echo wp_get_shortlink(); ?> "><i
                                class="icon-google"></i></a></li>
                <li><a href="http://twitter.com/home?status=<?php echo wp_get_shortlink(); ?> "><i
                                class="icon-twitter"></i></a></li>
            </ul>
        <?php endif; ?>
    </div>
</div>


<?php endif;
get_ad('product', 5);
