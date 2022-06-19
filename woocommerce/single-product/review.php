<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
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
	exit; // Exit if accessed directly
}
?>
<li  id="li-comment-<?php comment_ID(); ?>">
    <div class="comment-meta">
        <?php echo get_avatar($comment, '45', '', '', array('class' => 'user-pic')); ?>
        <b class="comment-user"><?php comment_author_link() ?></b>
        <small class="comment-date"><?php comment_date() ?></small>
        <?php comment_reply_link(
            array(
                'reply_text' => '<i class="icon-replay"></i>پاسخ'
            , 'depth' => isset($args['args']['depth']) ? $args['args']['depth'] : (int)3
            , 'max_depth' => isset($args['args']['max_depth']) ? $args['args']['max_depth'] : (int)5
            )
        );
        do_action( 'woocommerce_review_before_comment_meta', $comment );
        ?>

    </div>
    <div class="comment-text">
        <?php



        do_action( 'woocommerce_review_before_comment_text', $comment );

        /**
         * The woocommerce_review_comment_text hook
         *
         * @hooked woocommerce_review_display_comment_text - 10
         */
        do_action( 'woocommerce_review_comment_text', $comment );

        do_action( 'woocommerce_review_after_comment_text', $comment ); ?>
    </div>

</li>