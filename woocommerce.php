
<?php get_header(); ?>

<section id="main" class="my-4">
    <div class="container">
        <?php if ( have_posts() ) : ?>
            <div class="woocommerce"><?php @woocommerce_content(); ?></div>

        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>
