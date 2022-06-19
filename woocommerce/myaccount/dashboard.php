<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php global $current_user;?>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card panel-widget mysales mb-4 mb-md-0 mb-lg-0 mb-xl-0">
                <i class="icon-price"></i>
                <h3>سفارش ها</h3>
                <b><?php echo wc_get_customer_order_count( $current_user->ID );?></b>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card panel-widget my-comments  mb-4 mb-md-0 mb-lg-0 mb-xl-0">
                <i class="icon-comment"></i>
                <h3>دیدگاه ها</h3>
                <b><?php echo wf_count_user_comments();?></b>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card panel-widget mytikets ">
                <i class="icon-download"></i>
                <h3>دانلود های من</h3>
                <b><?php echo count(WC()->customer->get_downloadable_products());?></b>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-title mb-4">
                <div class="row">
                    <div class="col-7 "><h3>آخرین اطلاعیه ها</h3></div>
                    <div class="col-5"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>announcements">نمایش همه<i class="icon-chevron-left"></i> </a></div>
                </div>
            </div>
            <?php query_posts("&showposts=8&post_type=notification"); ?>
            <?php if( have_posts() ):?>
                <div class="notification">
                    <ul id="last-announcements" >
                        <?php while (have_posts()) : the_post(); ?>
                            <li class="<?php get_notification_unread(get_the_ID());?>">
                                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>announcements/?view=<?php the_ID(); ?>">
                                    <span class="icon-notifi"></span>
                                    <h6><?php the_title(); ?></h6>
                                    <span class="notification-date"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش';?></span>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php endif;?>
            <?php wp_reset_query(); ?>
        </div>
    </div>
<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
