<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product,$post;
?>
<a href="<?php echo get_permalink($post->ID) ?>"><h2><?php the_title(); ?></h2></a>
<?php if ( $price_html = $product->get_price_html() ) : ?>
	<b class="price"><?php echo $price_html; ?></b>
<?php endif; ?>

<?php if (cs_get_option('show-product-sales')): ?>
        <b class="sales"><?php echo get_post_meta( $post->ID, 'total_sales', true ); ?> <?php echo cs_get_option('translate-sale','فروش');?> </b>
<?php endif; ?>