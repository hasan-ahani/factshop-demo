<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;


?>
<div class="post-meta">
    <?php
    echo apply_filters( 'woocommerce_loop_add_to_cart_link',
    	sprintf( '<a href="%s" data-quantity="%s" class="tocart" %s>%s</a>',
    		esc_url( $product->add_to_cart_url() ),
    		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
    		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            cs_get_option('translate-addtocart','افزود به سبد خرید')
    	),
    $product, $args );
    ?>
    <a  class="user" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
</div>
<?php $previewonline = get_post_meta(get_the_ID(), 'previewonline', true);
if($previewonline != ''):?>
    <a href="<?php echo $previewonline;?>" target="_blank" class="product-show"><?php echo cs_get_option('translate-preview','پیشنمایش آنلاین');?></a>
<?php endif;?>
