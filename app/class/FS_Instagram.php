<?php
if ( ! defined( 'ABSPATH' ) )
    die( 'Fizzle' );

class FS_Instagram extends WP_Widget
{
    function __construct() {
        parent::__construct(
            'FS_Instagram','FS ایسنتاگرام',
            array(
                'classname' => 'FS_Instagram',
                'description' => esc_html__( 'Displays your latest Instagram photos', 'wp-instagram-widget' ),
                'customize_selective_refresh' => true,
            )
        );
    }
    function widget( $args, $instance ) {
        $title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
        $username = empty( $instance['username'] ) ? '' : $instance['username'];
        $limit = empty( $instance['number'] ) ? 9 : $instance['number'];
        $size = empty( $instance['size'] ) ? 'large' : $instance['size'];
        $target = empty( $instance['target'] ) ? '_self' : $instance['target'];
        $link = empty( $instance['link'] ) ? '' : $instance['link'];
        echo $args['before_widget'];
        if ( ! empty( $title ) ) { echo $args['before_title'] . wp_kses_post( $title ) . $args['after_title']; };
        do_action( 'wpiw_before_widget', $instance );
        if ( '' !== $username ) {
            $media_array = $this->scrape_instagram( $username );
            if ( is_wp_error( $media_array ) ) {
                echo wp_kses_post( $media_array->get_error_message() );
            } else {
                // filter for images only?
                if ( $images_only = apply_filters( 'wpiw_images_only', false ) ) {
                    $media_array = array_filter( $media_array, array( $this, 'images_only' ) );
                }
                // slice list down to required limit.
                $media_array = array_slice( apply_filters( 'wpiw_media_array', $media_array ), 0, $limit );
                // filters for custom classes.
                $ulclass = apply_filters( 'wpiw_list_class', 'instagram-pics instagram-size-' . $size );
                $liclass = apply_filters( 'wpiw_item_class', '' );
                $aclass = apply_filters( 'wpiw_a_class', '' );
                $imgclass = apply_filters( 'wpiw_img_class', '' );
                $template_part = apply_filters( 'wpiw_template_part', 'parts/wp-instagram-widget.php' );
                ?><ul class="<?php echo esc_attr( $ulclass ); ?>"><?php
                foreach( $media_array as $item ) {
                    // copy the else line into a new file (parts/wp-instagram-widget.php) within your theme and customise accordingly.
                    if ( locate_template( $template_part ) !== '' ) {
                        include locate_template( $template_part );
                    } else {
                        echo '<li class="' . esc_attr( $liclass ) . '"><a href="' . esc_url( $item['link'] ) . '" target="' . esc_attr( $target ) . '"  class="' . esc_attr( $aclass ) . '"><img src="' . esc_url( $item[$size] ) . '"  alt="' . esc_attr( $item['description'] ) . '" title="' . esc_attr( $item['description'] ) . '"  class="' . esc_attr( $imgclass ) . '"/></a></li>';
                    }
                }
                ?></ul><?php
            }
        }
        $linkclass = apply_filters( 'wpiw_link_class', 'clear text-center' );
        $linkaclass = apply_filters( 'wpiw_linka_class', 'btn btn-primary mt-3 btn-sm' );
        switch ( substr( $username, 0, 1 ) ) {
            case '#':
                $url = '//instagram.com/explore/tags/' . str_replace( '#', '', $username );
                break;
            default:
                $url = '//instagram.com/' . str_replace( '@', '', $username );
                break;
        }
        if ( '' !== $link ) {
            ?><p class="<?php echo esc_attr( $linkclass ); ?>"><a href="<?php echo trailingslashit( esc_url( $url ) ); ?>" rel="me" target="<?php echo esc_attr( $target ); ?>" class="<?php echo esc_attr( $linkaclass ); ?>"><?php echo wp_kses_post( $link ); ?></a></p><?php
        }
        do_action( 'wpiw_after_widget', $instance );
        echo $args['after_widget'];
    }
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array(
            'title' => 'اینستاگرام',
            'username' => '',
            'size' => 'small',
            'link' => 'مارا دنبال کنید',
            'number' => 8,
            'target' => '_self',
        ) );
        $title = $instance['title'];
        $username = $instance['username'];
        $number = absint( $instance['number'] );
        $size = $instance['size'];
        $target = $instance['target'];
        $link = $instance['link'];
        ?>
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">عنوان:<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>">نام کاربری یا هشدگ:<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" /></label></p>
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">تعداد تصاویر<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" /></label></p>
        <p style="display: none"><label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Photo size', 'wp-instagram-widget' ); ?>:</label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" class="widefat">
                <option value="thumbnail" <?php selected( 'thumbnail', $size ); ?>><?php esc_html_e( 'Thumbnail', 'wp-instagram-widget' ); ?></option>
                <option value="small" <?php selected( 'small', $size ); ?>><?php esc_html_e( 'Small', 'wp-instagram-widget' ); ?></option>
                <option value="large" <?php selected( 'large', $size ); ?>><?php esc_html_e( 'Large', 'wp-instagram-widget' ); ?></option>
                <option value="original" <?php selected( 'original', $size ); ?>><?php esc_html_e( 'Original', 'wp-instagram-widget' ); ?></option>
            </select>
        </p>
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>">باز شدن لینک ها در:</label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" class="widefat">
                <option value="_self" <?php selected( '_self', $target ); ?>>همان صفحه</option>
                <option value="_blank" <?php selected( '_blank', $target ); ?>>صفحه جدید</option>
            </select>
        </p>
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>">متن لینک:<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" /></label></p>
        <?php
    }
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['username'] = trim( strip_tags( $new_instance['username'] ) );
        $instance['number'] = ! absint( $new_instance['number'] ) ? 9 : $new_instance['number'];
        $instance['size'] = ( ( 'thumbnail' === $new_instance['size'] || 'large' === $new_instance['size'] || 'small' === $new_instance['size'] || 'original' === $new_instance['size'] ) ? $new_instance['size'] : 'large' );
        $instance['target'] = ( ( '_self' === $new_instance['target'] || '_blank' === $new_instance['target'] ) ? $new_instance['target'] : '_self' );
        $instance['link'] = strip_tags( $new_instance['link'] );
        return $instance;
    }
    // based on https://gist.github.com/cosmocatalano/4544576.
    function scrape_instagram( $username ) {
        $username = trim( strtolower( $username ) );
        switch ( substr( $username, 0, 1 ) ) {
            case '#':
                $url              = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
                $transient_prefix = 'h';
                break;
            default:
                $url              = 'https://instagram.com/' . str_replace( '@', '', $username );
                $transient_prefix = 'u';
                break;
        }
        if ( false === ( $instagram = get_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ) ) ) ) {
            $remote = wp_remote_get( $url );
            if ( is_wp_error( $remote ) ) {
                return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'wp-instagram-widget' ) );
            }
            if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
                return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'wp-instagram-widget' ) );
            }
            $shards      = explode( 'window._sharedData = ', $remote['body'] );
            $insta_json  = explode( ';</script>', $shards[1] );
            $insta_array = json_decode( $insta_json[0], true );
            if ( ! $insta_array ) {
                return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
            }
            if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
                $images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
            } elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
                $images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
            } else {
                return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
            }
            if ( ! is_array( $images ) ) {
                return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
            }
            $instagram = array();
            foreach ( $images as $image ) {
                if ( true === $image['node']['is_video'] ) {
                    $type = 'video';
                } else {
                    $type = 'image';
                }
                $caption = __( 'Instagram Image', 'wp-instagram-widget' );
                if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
                    $caption = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
                }
                $instagram[] = array(
                    'description' => $caption,
                    'link'        => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
                    'time'        => $image['node']['taken_at_timestamp'],
                    'comments'    => $image['node']['edge_media_to_comment']['count'],
                    'likes'       => $image['node']['edge_liked_by']['count'],
                    'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
                    'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
                    'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
                    'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
                    'type'        => $type,
                );
            } // End foreach().
            // do not set an empty transient - should help catch private or empty accounts.
            if ( ! empty( $instagram ) ) {
                $instagram = base64_encode( serialize( $instagram ) );
                set_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
            }
        }
        if ( ! empty( $instagram ) ) {
            return unserialize( base64_decode( $instagram ) );
        } else {
            return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'wp-instagram-widget' ) );
        }
    }
    function images_only( $media_item ) {
        if ( 'image' === $media_item['type'] ) {
            return true;
        }
        return false;
    }

}