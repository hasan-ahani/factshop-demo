<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
    'woocommerce-product-gallery--columns-' . absint( $columns ),
    'images',
) );
?>
<?php

if (!cs_get_option('show-product-img-little')) {
    $attachment_ids = $product->get_gallery_image_ids();
    if ($attachment_ids && $product->get_image_id()) :?>
        <!--Carousel Wrapper-->
        <div id="product-gallery" class="carousel slide carousel-fade carousel-thumbnails" data-ride="carousel">
            <!--Slides-->
            <div class="carousel-inner" role="listbox">
                <?php
                $i = 0;
                if(has_post_thumbnail()):?>
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="<?php echo get_the_post_thumbnail_url(); ?>"/>
                    </div>
                    <?php
                    $i++;
                endif;
                foreach ($attachment_ids as $attachment_id) :?>
                    <div class="carousel-item <?php echo ($i == 0) ? "active" : null; ?>">
                        <img class="d-block w-100" src="<?php echo wp_get_attachment_url($attachment_id); ?>">
                    </div>
                    <?php
                    $i++;
                endforeach; ?>
            </div>
            <!--/.Slides-->
            <!--Controls-->
            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#product-gallery" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#product-gallery" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
            <!--/.Controls-->
            <ol class="carousel-indicators">
                <?php
                $i = 0;
                if(has_post_thumbnail()):?>
                    <li class="active"  data-target="#product-gallery"
                        data-slide-to="<?php echo $i; ?>">
                        <img class="d-block w-100 img-fluid" src="<?php echo get_the_post_thumbnail_url(); ?>">
                    </li>
                    <?php
                    $i++;
                endif;
                foreach ($attachment_ids as $attachment_id) :?>
                    <li class="<?php echo ($i == 0) ? "active" : null; ?>" data-target="#product-gallery"
                        data-slide-to="<?php echo $i; ?>">
                        <img class="d-block w-100" src="<?php echo wp_get_attachment_url($attachment_id); ?>"
                             class="img-fluid">
                    </li>
                    <?php
                    $i++;
                endforeach; ?>
            </ol>
        </div>
        <!--/.Carousel Wrapper-->
    <?php
    else:
        ?>
        <div class="card post-image my-4">
            <?php the_post_thumbnail('full'); ?>
        </div>

    <?php
    endif;
}