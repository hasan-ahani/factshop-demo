<?php
if ( ! defined( 'ABSPATH' ) )
    die( 'Fizzle' );

class FS_Widget_Ad extends WP_Widget {

    function __construct() {
        parent::__construct(
            'wfn_ads', '<b>FS تبلیغات</b>',
            array( 'description' => 'ویدجت تبلیغات قالب در سایدبارها' ) // Args
        );
    }

    public function widget( $args, $instance ) {
        $date1 = $instance['created_time'];
        $date1 = strtotime($date1);
        $date1 = strtotime("+".$instance['wfn_ads_day']." day", $date1);
        if(date('Y-m-d') <= date('Y-m-d',$date1)){
            $link = ($instance["wfn_ads_link"]) ? $instance["wfn_ads_link"] : $instance["wfn_ads_photo"];
            echo '<div class="card ads">';
            echo '<a target="_blank" href="'. $link.'"><img src="'.$instance['wfn_ads_photo'].'" alt="fs_ads" /></a>';
            echo '</div>';
        }
    }

    public function form( $instance ) {

        $wfn_ads_photo = ! empty( $instance['wfn_ads_photo'] ) ? $instance['wfn_ads_photo'] : '';

        $wfn_ads_link = ! empty( $instance['wfn_ads_link'] ) ? $instance['wfn_ads_link'] : '';
        $wfn_ads_day = ! empty( $instance['wfn_ads_day'] ) ? $instance['wfn_ads_day'] : '';
        $created_time = ! empty( $instance['created_time'] ) ? $instance['created_time'] : date('Y-m-d');

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'wfn_ads_photo' ) ); ?>">آدرس تصویر تبلیغ</label>
            <input type="text" class="wpsa-url widefat" id="<?php echo esc_attr( $this->get_field_id( 'wfn_ads_photo' ) ); ?>" placeholder="آدرس تصویر تبلیغ خود را ثبت کنید" name="<?php echo esc_attr( $this->get_field_name( 'wfn_ads_photo' ) ); ?>" value="<?php echo $wfn_ads_photo; ?>"/>
            <input type="button" class="button wpsa-browse" value="افزودن تصویر" style="margin-top: 10px" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'wfn_ads_link' ) ); ?>">لینک ارجاع تبلیغ</label>
            <input type="text" class=" widefat" id="<?php echo esc_attr( $this->get_field_id( 'wfn_ads_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'wfn_ads_link' ) ); ?>" value="<?php echo $wfn_ads_link; ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'wfn_ads_day' ) ); ?>">تعداد روز های نمایش</label>
            <input type="number" class=" widefat" id="<?php echo esc_attr( $this->get_field_id( 'wfn_ads_day' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'wfn_ads_day' ) ); ?>" value="<?php echo $wfn_ads_day; ?>"/>
            <span class="description">تعداد روز هایی که تمایل دارید تبلیغ نمایش داده شود.</span>
        </p>
        <p>
            <?php if($wfn_ads_photo && $created_time):?>
                <?php
                $date = $instance['created_time'];
                $date = strtotime($date);
                $date = strtotime("+".$instance['wfn_ads_day']." day", $date);?>
                <label>تاریخ ثبت: <?php  echo wpp_jdate('Y/m/d' , $created_time);?></label><br>
                <label>تاریخ انقضا: <?php  echo wpp_jdate('Y/m/d' ,  date('Y/m/d', $date));?></label>
            <?php endif;?>
        </p>
        <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'created_time' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'created_time' ) ); ?>" value="<?php echo $created_time; ?>" hidden>

        <script>
            jQuery( document ).ready( function( $ ) {
                $( '.wpsa-browse' ).on( 'click', function( event ) {
                    event.preventDefault();
                    var self = $( this );
                    var file_frame = ( wp.media.frames.file_frame = wp.media({
                        title: self.data( 'uploader_title' ),
                        button: {
                            text: self.data( 'uploader_button_text' )
                        },
                        multiple: false
                    }) );
                    file_frame.on( 'select', function() {
                        attachment = file_frame
                            .state()
                            .get( 'selection' )
                            .first()
                            .toJSON();
                        self.prev( '.wpsa-url' ).val( attachment.url ).change();
                    });
                    file_frame.open();
                });
                $( 'input.wpsa-url' )
                    .on( 'change keyup paste input', function() {
                        var self = $( this );
                        self
                            .next()
                            .parent()
                            .children( '.wpsa-image-preview' )
                            .children( 'img' )
                            .attr( 'src', self.val() );
                    })
                    .change();
            });
        </script>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['wfn_ads_photo'] = ( ! empty( $new_instance['wfn_ads_photo'] ) ) ? sanitize_text_field( $new_instance['wfn_ads_photo'] ) : '';
        $instance['wfn_ads_link'] = ( ! empty( $new_instance['wfn_ads_link'] ) ) ? sanitize_text_field( $new_instance['wfn_ads_link'] ) : '';
        $instance['wfn_ads_day'] = ( ! empty( $new_instance['wfn_ads_day'] ) ) ? sanitize_text_field( $new_instance['wfn_ads_day'] ) : '';
        $instance['created_time'] = ( ! empty( $new_instance['created_time'] ) ) ? sanitize_text_field( $new_instance['created_time'] ) : '';
        return $instance;
    }
}