<?php get_header(); ?>
<?php setPostViews(get_the_ID()); ?>
    <section id="main" class="my-4">
        <div class="container">
            <?php
            if (!is_product()):
                global $post;
                    get_template_part('template/content/single-post');
            else:
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
            endif; ?>
        </div>
    </section>
<?php get_footer(); ?>