<?php
if ( ! defined( 'ABSPATH' ) )
    die( 'Fizzle' );

class FS_Avatar
{
    public function __construct()
    {
        add_action( 'woocommerce_before_edit_account_form', array($this ,'fs_avatar_init'));
        add_filter( 'get_avatar' , array($this ,'fs_change_avatar') , 1 , 5 );
        add_filter( 'get_avatar_url' , array($this ,'filter_get_avatar_url') , 1 , 5 );
    }

    public function fs_avatar_init( $atts, $content= NULL) {
        if(isset($_GET['remove_avatar']) && ($_GET['remove_avatar'] == true) ){
            $avatar = get_user_meta( get_current_user_ID(), 'profile_pic');
            if(!empty($avatar[0])){
                update_user_meta( get_current_user_ID(), 'profile_pic', '' );
                echo '<div class="alert alert-success mb-4">آواتار با موفقیت حذف شد برای نمایش کامل تغییرات صفحه را رفرش کنید. :)</div>';
            }
        }
        $error = false;

        if(isset($_FILES['profile_pic'])){
            $profilepicture = $_FILES['profile_pic'];
            if( empty( $profilepicture ) ){
                echo '<div class="alert alert-danger mb-4">تصویر انتخاب نشده است :(</div>';
                $error = true;
            }

            if( $profilepicture['error'] ){
                echo '<div class="alert alert-danger mb-4">اندازه تصویر یا نوع تصویر نامعبتر می باشد، لطفا یک تصویر دیگر انتخاب کنید. :(</div>';
                $error = true;
            }


            if( $profilepicture['size'] > wp_max_upload_size() ){
                echo '<div class="alert alert-danger mb-4">حجم تصویر مورد نظر زیاد می باشد :(</div>';
                $error = true;
            }

            if($error == false){
                $picture_id = $this->fs_uploud_avatar($_FILES['profile_pic']);
                $user_id = get_current_user_id();
                $this->fs_save_avatar_pic($picture_id, $user_id);
                echo '<div class="alert alert-success mb-4">آواتار با موفقیت ثبت شد برای نمایش کامل تغییرات صفحه را رفرش کنید. :)</div>';
            }
        }
        get_template_part('template/user/avatar');
    }


    public function fs_save_avatar_pic($picture_id, $user_id){
        update_user_meta( $user_id, 'profile_pic', $picture_id );
    }


    public function fs_uploud_avatar( $photo ) {
        $wordpress_upload_dir = wp_upload_dir();
        $profilepicture = $photo;

        $new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $new_file_mime = finfo_file($finfo, $profilepicture['tmp_name']);
        finfo_close($finfo);

        $log = new WC_Logger();

        if( empty( $profilepicture ) )
            $log->add('custom_profile_picture','File is not selected.');
        if( $profilepicture['error'] )
            $log->add('custom_profile_picture',$profilepicture['error']);

        if( $profilepicture['size'] > wp_max_upload_size() )
            $log->add('custom_profile_picture','It is too large than expected.');

        if( !in_array( $new_file_mime, get_allowed_mime_types() ))
            $log->add('custom_profile_picture','WordPress doesn\'t allow this type of uploads.' );
        while( file_exists( $new_file_path ) ) {
            unlink($new_file_path);
            $new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
        }
        if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {
            $image = wp_get_image_editor( $new_file_path );
            if ( ! is_wp_error( $image ) ) {
                $image->resize( 200, 200, true );
                $image->save( $new_file_path);
            }
            $upload_id = wp_insert_attachment( array(
                'guid'           => $new_file_path,
                'post_mime_type' => $new_file_mime,
                'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            ), $new_file_path );
            // wp_generate_attachment_metadata() won't work if you do not include this file
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            // Generate and save the attachment metas into the database
            wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );

            return $upload_id;
        }


    }

    public function filter_get_avatar_url( $url, $id_or_email, $args ) {
        $user = false;
        if ( is_numeric( $id_or_email ) ) {
            $id = (int) $id_or_email;
            $user = get_user_by( 'id' , $id );
        } elseif ( is_object( $id_or_email ) ) {
            if ( ! empty( $id_or_email->user_id ) ) {
                $id = (int) $id_or_email->user_id;
                $user = get_user_by( 'id' , $id );
            }
        } else {
            $user = get_user_by( 'email', $id_or_email );
        }
        if ( $user && is_object( $user ) ) {
            $picture_id = get_user_meta($user->data->ID,'profile_pic');
            if(! empty($picture_id)){
                $avatar = wp_get_attachment_url( $picture_id[0] );
                if(empty($avatar)){
                    $img = (cs_get_option('local_avatar_default')) ? wp_get_attachment_url(cs_get_option('local_avatar_default')) : WF_URI."/assets/img/avatar.png";
                    $avatar = $img;
                }
            }else{
                $img = (cs_get_option('local_avatar_default')) ? wp_get_attachment_url(cs_get_option('local_avatar_default')) : WF_URI."/assets/img/avatar.png";
                $avatar = $img;

            }

        }else{
            $img = (cs_get_option('local_avatar_default')) ? wp_get_attachment_url(cs_get_option('local_avatar_default')) : WF_URI."/assets/img/avatar.png";
            $avatar = $img;

        }
        return $avatar;
    }

    public function fs_change_avatar( $avatar, $id_or_email, $size, $default, $alt ) {

        $user = false;
        if ( is_numeric( $id_or_email ) ) {
            $id = (int) $id_or_email;
            $user = get_user_by( 'id' , $id );
        } elseif ( is_object( $id_or_email ) ) {
            if ( ! empty( $id_or_email->user_id ) ) {
                $id = (int) $id_or_email->user_id;
                $user = get_user_by( 'id' , $id );
            }
        } else {
            $user = get_user_by( 'email', $id_or_email );
        }
        if ( $user && is_object( $user ) ) {
            $picture_id = get_user_meta($user->data->ID,'profile_pic');
            if(! empty($picture_id)){
                $avatar = wp_get_attachment_url( $picture_id[0] );
                if( ! empty($avatar)){
                    $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
                }else{
                    $img = (cs_get_option('local_avatar_default')) ? wp_get_attachment_url(cs_get_option('local_avatar_default')) : WF_URI."/assets/img/avatar.png";
                    $avatar = "<img src='{$img}' class='hadadn avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

                }
            }else{
                $img = (cs_get_option('local_avatar_default')) ? wp_get_attachment_url(cs_get_option('local_avatar_default')) : WF_URI."/assets/img/avatar.png";
                $avatar = "<img src='{$img}' class='hadadn avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

            }

        }else{
            $img = (cs_get_option('local_avatar_default')) ? wp_get_attachment_url(cs_get_option('local_avatar_default')) : WF_URI."/assets/img/avatar.png";
            $avatar = "<img src='{$img}' class='hadadn avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

        }
        return $avatar;
    }

}