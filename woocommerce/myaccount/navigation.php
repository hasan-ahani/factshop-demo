<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

global $current_user;
_wp_get_current_user();
?>
<div class="col-md-3 panel-sidbar d-none d-lg-block d-xl-block d-md-block">
    <div class="sticky-sidbar">
    <?php  get_ad('myaccount','3'); ?>
    <div class="card panel-user mb-4">
        <header>
            <b><?php echo $current_user->display_name;?></b>
            <small>خوش آمدید</small>
            <a href="javascript:;" class="user-dropdown " ><i class="icon-menu"></i></a>
            <div class="user-dropdown-menu list-unstyled">
                <li><a href="<?php echo home_url('/my-account/edit-account/');?>">ویرایش پروفایل</a></li>
                <li><a href="<?php echo home_url('/my-account/customer-logout/');?>">خروج</a></li>
            </div>
        </header>
        <?php echo get_avatar($current_user->ID, '100' , '','', array('class' => 'panel-user-img'));?>
        <div class="row">
            <div class="col-6">
                <small>آخرین ورود</small>
                <small class="user-date"><?php
                    if(function_exists('wpp_jdate'))  echo wpp_jdate("Y-m-d", wf_get_last_login($current_user->ID,true));?></small>
            </div>
            <div class="col-6">
                <small>امروز</small>
                <small class="user-date"><?php if(function_exists('wpp_jdate')) echo wpp_jdate( 'Y-m-d', current_time( 'timestamp', 1 ) );?></small>
            </div>
        </div>
        <a href="<?php echo home_url('/my-account/customer-logout/');?>" class="exit"><i class="icon-exit"></i><small>خــروج</small> </a>
    </div>
    <div class="card panel-menu">
        <ul class="my-acount-menus list-unstyled">
            <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php  get_ad('myaccount','4'); ?>
    </div>
</div>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
