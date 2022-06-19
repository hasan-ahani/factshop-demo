<?php
if ( ! defined( 'ABSPATH' ) )
    die( 'Fizzle' );
class FS_Posts extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_payam', 'description' => 'نمایش آخرین مطالب با دسته بندی در ویدجت.' );
        parent::__construct('recent-news', '<b>FS آخرین مطالب</b>', $widget_ops);
        $this->alt_option_name = 'widget_recent_news';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_recent_news', 'widget');
        if ( !is_array($cache) )
            $cache = array();
        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;
        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }
        ob_start();
        extract($args);
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : 'آخرین مطالب';
        $postCats = $instance[ 'postCats' ];
        $cat = explode(",", $postCats);
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['per_page'] ) ) ? absint( $instance['per_page'] ) : 10;
        if ( ! $number )
            $number = 10;

        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'cat' => $cat, 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
            ?>
            <?php echo $args['before_widget']; ?>
            <?php if ( $title ) echo $args['before_title'] . $title . $args['after_title'] ; ?>
                <ul class="feather-post">
                    <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                        <li><a href="<?php the_permalink()?>">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                <?php else: ?>
                                    <img src="<?php echo WF_URI . '/assets/img/thumbnail.png'; ?>"
                                         alt="<?php the_title(); ?>">
                                <?php endif; ?>
                                <h6><?php the_title(); ?></h6>
                                <small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'; ?> </small>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php echo $args['after_widget'] ?>
            <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_payam', $cache, 'widget');
    }


    function flush_widget_cache() {
        wp_cache_delete('widget_recent_news', 'widget');
    }
    public function form( $instance ) {
        $title = isset($instance[ 'title' ]) ? $instance[ 'title' ] : 'آخرین خبر';
        $per_page = isset($instance[ 'per_page' ]) ? $instance[ 'per_page' ] : 10;
        $instance['postCats'] = !empty($instance['postCats']) ? explode(",",$instance['postCats']) : array();
        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">عنوان</label>
            <input type="text" class="widfat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" style="width: 100%;" value="<?php echo $title; ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'per_page' ) ); ?>">تعداد نمایش:</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'per_page' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'per_page' ) ); ?>" type="number" value="<?php echo esc_attr( $per_page ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'postCats' ); ?>">دسته بندی</label><br />
            <?php $args = array(
                'post_type' => 'post',
                'taxonomy' => 'category',
            );
            $terms = get_terms( $args );
            //print_r($terms);
            foreach( $terms as $id => $name ) {
                $checked = "";
                if(in_array($name->term_id,$instance['postCats'])){
                    $checked = "checked='checked'";
                }
                ?>
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('postCats'); ?>" name="<?php echo $this->get_field_name('postCats[]'); ?>" value="<?php echo $name->term_id; ?>"  <?php echo $checked; ?>/>
                <label for="<?php echo $this->get_field_id('postCats'); ?>"><?php echo $name->name; ?></label><br />

            <?php }  ?>
        </p>

        <?php

    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'per_page' ] = strip_tags( $new_instance[ 'per_page' ] );
        $instance['postCats'] = !empty($new_instance['postCats']) ? implode(",",$new_instance['postCats']) : 0;
        return $instance;
    }


}