<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 20/8/2019
 * Time: 1:16 م
 */

class FS_Mail_Required
{
    public function __construct()
    {

        add_action( 'show_user_profile', array($this , 'extra_user_profile_fields') );
        add_action( 'edit_user_profile', array($this , 'extra_user_profile_fields') );
        add_action( 'personal_options_update', array($this , 'save_extra_user_profile_fields') );
        add_action( 'edit_user_profile_update', array($this , 'save_extra_user_profile_fields'));
        add_filter( 'manage_users_columns', array($this ,'new_modify_user_table') );
        add_filter( 'manage_users_custom_column', array($this ,'new_modify_user_table_row'), 10, 3 );
        add_filter('bulk_actions-users',array($this ,'email_confirm_bulk_actions'));
        add_filter( 'handle_bulk_actions-users', array($this ,'email_confirm_bulk_action_handler'), 10, 3 );
        add_action('user_register',  'FS_Mail_Required::new_user_confirm_email');
        add_filter('wp_authenticate_user',function ($user){
            if(get_user_meta($user->ID,'mail_confirm',true) == true or user_can($user->ID, 'administrator')){
                return $user;
            }
            return new WP_Error(465,"حساب کاربری شما فعال نمی باشد.");
        },10,2);
        add_filter( 'registration_errors', function( $errors, $sanitized_user_login, $user_email ) {
            $errors->add( 'confirm_email', __( '<strong>ثبت نام انجام شد</strong> تاییده حساب کاربری شما به ایمیل شما ارسال شد' ) );
            return $errors;
        }, 10, 3 );

        add_filter('generate_rewrite_rules', function ($wp_rewrite) {
            $wp_rewrite->rules = array_merge(
                ['email_confirm/(\d+)/?$' => 'index.php?email_confirm=$matches[1]'],
                $wp_rewrite->rules
            );
        });
        add_filter('query_vars', function ($query_vars) {
            $query_vars[] = 'email_confirm';
            return $query_vars;
        });

        add_action('template_redirect', function () {
            $email_confirm = get_query_var('email_confirm');
            if (isset($email_confirm) && isset($_GET['unique_email'])) {
                include WF_PATH . '/template/user/email_confirm.php';
                die();
            }
        });
        add_action('init', array($this, 'init_ajax_active_user'));
    }

    public function init_ajax_active_user()
    {
        add_action('wp_ajax_nopriv_ajaxactiveuser', array($this, 'ajax_active_user'));
    }

    public function ajax_active_user()
    {
        check_ajax_referer('ajax-active-user-nonce', 'security');
        $captcha = $_POST['captcha'];
        if (cs_get_option('is_google_captcha') && !empty(cs_get_option('google_captcha_sitekey')) && !empty(cs_get_option('google_captcha_secretkey'))) {
            if (isset($captcha) && !empty($captcha)) {
                $secret = cs_get_option('google_captcha_secretkey');
                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $data = array(
                    'secret' => $secret,
                    'response' => $captcha,
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                );
                $curlConfig = array(
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POSTFIELDS => $data
                );
                $ch = curl_init();
                curl_setopt_array($ch, $curlConfig);
                $response = curl_exec($ch);
                curl_close($ch);
                $jsonResponse = json_decode($response);
                if ($jsonResponse->success) {
                    $account = $_POST['user_login'];
                    if (empty($account)) {
                        $error = 'نام کاربری یا ایمیل خود را وارد کنید';
                    } else {
                        if (is_email($account)) {
                            if (email_exists($account))
                                $get_by = 'email';
                            else
                                $error = 'کاربری با این ایمیل وجود ندارد.';
                        } else if (validate_username($account)) {
                            if (username_exists($account))
                                $get_by = 'login';
                            else
                                $error = 'کاربری با این نام وجود ندارد.';
                        } else
                            $error = 'ایمیل یا نام کاربری نامعتبر';
                    }
                    if (empty ($error)) {
                        $user = get_user_by($get_by, $account);
                        $unique = sha1(rand(31, 8736985477967));
                        $new_uniq = get_user_meta($user->ID,'fs_mail_confrim_code',ture);
                        if(empty($new_uniq)){
                            update_user_meta($user->ID, 'fs_mail_confrim_code', $unique);
                        }else{
                            $unique = get_user_meta($user->ID, 'fs_mail_confrim_code', true);
                        }
                        $unique_url = home_url('email_confirm/').$user->ID.'/?unique_email='.$unique;
                        $subject = cs_get_option('email-user-verify-sub');
                        $content = cs_get_option('email-user-verify-content');
                        $from = cs_get_option('email-sender');
                        $title = cs_get_option('email-name');
                        $content = str_replace('[user-name]', $user->display_name, $content);
                        $content = str_replace('[user-email]', $user->user_email, $content);
                        $btn = '<a class="mcnButton" href="' . $unique_url . '" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; display: block; color: #007bff; font-weight: normal; text-decoration: none; font-weight: normal; letter-spacing: 1px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF; direction: rtl;text-transform:uppercase;" target="_blank" title="تایید حساب کاربری">تایید حساب کاربری</a>';
                        $mail = FS_Mail::init()
                            ->to($user->user_email)
                            ->from("$title < $from >")
                            ->subject($subject)
                            ->template(get_theme_file_path() . '/template/email/global.php', [
                                'title' => $subject,
                                'logo' => cs_get_option('email-logo', WF_URI . '/assets/img/logo.png'),
                                'site' => home_url(),
                                'image' => WF_URI . '/assets/img/user-manage.gif',
                                'subject' => $subject,
                                'content' => $content,
                                'button' => $btn,
                                'info' => cs_get_option('email-desc'),
                                'copyright' => cs_get_option('email-copyright'),
                            ])
                            ->send();
                    }
                    if ($mail)
                        $success = 'ایمیل خود را برای تایید حساب کاربری بررسی کنید.';
                    else
                        $error = 'سیستم قادر به ارسال ایمیل  رمز عبور جدید شما نیست.';

                    if (!empty($error))
                        echo json_encode(array('loggedin' => false, 'message' => __($error)));

                    if (!empty($success))
                        echo json_encode(array('loggedin' => false, 'message' => __($success)));
                } else {
                    echo json_encode(array('loggedin' => false, 'message' => __('مقدار اعتبار سنجی را وارد کنید')));
                }
            } else {
                echo json_encode(array('loggedin' => false, 'message' => __('مقدار اعتبار سنجی را وارد کنید')));
            }
        } else {
            $account = $_POST['user_login'];
            $error = false;
            if (empty($account)) {
                echo json_encode(array('loggedin' => false, 'message' => __('نام کاربری یا ایمیل خود را وارد کنید')));
                $error = true;
            } else {
                if (is_email($account)) {
                    if (!email_exists($account)){
                        echo json_encode(array('loggedin' => false, 'message' => __('کاربری با این ایمیل وجود ندارد.')));
                        $error = true;
                    }
                } else{
                    echo json_encode(array('loggedin' => false, 'message' => __( 'ایمیل نامعتبر')));
                    $error = true;
                }
            }
            if (!$error) {
                $user = get_user_by('email', $account);
                $unique = sha1(rand(31, 8736985477967));
                $new_uniq = get_user_meta($user->ID,'fs_mail_confrim_code',true);
                if(empty($new_uniq)){
                    update_user_meta($user->ID, 'fs_mail_confrim_code', $unique);
                }else{
                    $unique = get_user_meta($user->ID, 'fs_mail_confrim_code', true);
                }
                $unique_url = home_url('email_confirm/').$user->ID.'/?unique_email='.$unique;
                $subject = cs_get_option('email-user-verify-sub');
                $content = cs_get_option('email-user-verify-content');
                $from = cs_get_option('email-sender');
                $title = cs_get_option('email-name');
                $content = str_replace('[user-name]', $user->display_name, $content);
                $content = str_replace('[user-email]', $user->user_email, $content);
                $btn = '<a class="mcnButton" href="' . $unique_url . '" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; display: block; color: #007bff; font-weight: normal; text-decoration: none; font-weight: normal; letter-spacing: 1px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF; direction: rtl;text-transform:uppercase;" target="_blank" title="تایید حساب کاربری">تایید حساب کاربری</a>';
                $mail = FS_Mail::init()
                    ->to($user->user_email)
                    ->from("$title < $from >")
                    ->subject($subject)
                    ->template(get_theme_file_path() . '/template/email/global.php', [
                        'title' => $subject,
                        'logo' => cs_get_option('email-logo', WF_URI . '/assets/img/logo.png'),
                        'site' => home_url(),
                        'image' => WF_URI . '/assets/img/user-manage.gif',
                        'subject' => $subject,
                        'content' => $content,
                        'button' => $btn,
                        'info' => cs_get_option('email-desc'),
                        'copyright' => cs_get_option('email-copyright'),
                    ])
                    ->send();
                if ($mail)
                    echo json_encode(array('loggedin' => true, 'message' => __('ایمیل خود را برای تایید حساب کاربری بررسی کنید.')));
                else
                    echo json_encode(array('loggedin' => false, 'message' => __( 'سیستم قادر به ارسال ایمیل  تاییده شما نیست.')));
            }

        }
        die();
    }



    public function save_extra_user_profile_fields( $user_id ) {
        if ( !current_user_can( 'edit_user', $user_id ) ) {
            return false;
        }
        update_user_meta( $user_id, 'mail_confirm', $_POST['mail_confirm'] );
    }

    public function extra_user_profile_fields( $user ) { ?>
        <table class="form-table">
            <tr>
                <th><label for="mail_confirm">تایید حساب کاربری</label></th>
                <td>
                    <input type="checkbox" name="mail_confirm" id="mail_confirm" value="true" <?php if(get_the_author_meta( 'mail_confirm', $user->ID )) echo 'checked'; ?>  class="regular-text" /><br />
                    <span class="description">در صورتی که تمایل به فعال سازی حساب کاربری این عضو دارید این گزینه را فعال کنید</span>
                </td>
            </tr>
        </table>
    <?php }

    function new_modify_user_table( $column ) {
        $column['mail_confirm'] = 'وضعیت حساب کاربری';
        return $column;
    }

    function new_modify_user_table_row( $val, $column_name, $user_id ) {
        switch ($column_name) {
            case 'mail_confirm' :
                if(get_the_author_meta( 'mail_confirm', $user_id )){
                    return '<span style="color: limegreen;">فعال شده</span>';
                }else{
                    return '<span style="color: red;">فعال نشده</span>';
                }
            default:
        }
        return $val;
    }


    public static function new_user_confirm_email($user_id)
    {
            $user = get_userdata($user_id);;
            $unique = sha1(rand(31, 8736985477967));
            add_user_meta($user->ID, 'fs_mail_confrim_code', $unique);
            $unique_url = home_url('email_confirm/').$user_id.'/?unique_email='.$unique;
            $subject = cs_get_option('email-user-verify-sub');
            $content = cs_get_option('email-user-verify-content');
            $from = cs_get_option('email-sender');
            $title = cs_get_option('email-name');
            $content = str_replace('[user-name]', $user->display_name, $content);
            $content = str_replace('[user-email]', $user->user_email, $content);
            $btn = '<a class="mcnButton" href="' . $unique_url . '" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; display: block; color: #007bff; font-weight: normal; text-decoration: none; font-weight: normal; letter-spacing: 1px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF; direction: rtl;text-transform:uppercase;" target="_blank" title="تایید حساب کاربری">تایید حساب کاربری</a>';
            $mail = FS_Mail::init()
                ->to($user->user_email)
                ->from("$title < $from >")
                ->subject($subject)
                ->template(get_theme_file_path() . '/template/email/global.php', [
                    'title' => $subject,
                    'logo' => cs_get_option('email-logo', WF_URI . '/assets/img/logo.png'),
                    'site' => home_url(),
                    'image' => WF_URI . '/assets/img/user-manage.gif',
                    'subject' => $subject,
                    'content' => $content,
                    'button' => $btn,
                    'info' => cs_get_option('email-desc'),
                    'copyright' => cs_get_option('email-copyright'),
                ])
                ->send();
    }

    public static function new_user_confirm_email_resend($user_id)
    {

        $user = get_userdata($user_id);
        $unique = sha1(rand(31, 8736985477967));
        $new_uniq = get_user_meta($user_id,'fs_mail_confrim_code',ture);
        if(empty($new_uniq)){
            update_user_meta($user->ID, 'fs_mail_confrim_code', $unique);
        }else{
            $unique = get_user_meta($user->ID, 'fs_mail_confrim_code', true);
        }
        $unique_url = home_url('email_confirm/').$user_id.'/?unique_email='.$unique;
        $subject = cs_get_option('email-user-verify-sub');
        $content = cs_get_option('email-user-verify-content');
        $from = cs_get_option('email-sender');
        $title = cs_get_option('email-name');
        $content = str_replace('[user-name]', $user->display_name, $content);
        $content = str_replace('[user-email]', $user->user_email, $content);
        $btn = '<a class="mcnButton" href="' . $unique_url . '" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; display: block; color: #007bff; font-weight: normal; text-decoration: none; font-weight: normal; letter-spacing: 1px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF; direction: rtl;text-transform:uppercase;" target="_blank" title="تایید حساب کاربری">تایید حساب کاربری</a>';
        $mail = FS_Mail::init()
            ->to($user->user_email)
            ->from("$title < $from >")
            ->subject($subject)
            ->template(get_theme_file_path() . '/template/email/global.php', [
                'title' => $subject,
                'logo' => cs_get_option('email-logo', WF_URI . '/assets/img/logo.png'),
                'site' => home_url(),
                'image' => WF_URI . '/assets/img/user-manage.gif',
                'subject' => $subject,
                'content' => $content,
                'button' => $btn,
                'info' => cs_get_option('email-desc'),
                'copyright' => cs_get_option('email-copyright'),
            ])
            ->send();
    }

    public function email_confirm_bulk_actions($actions){
        $actions['confirm'] = _('تایید حساب کاربری');
        return $actions;
    }

    public function email_confirm_bulk_action_handler( $redirect_to, $doaction, $users_id )
    {
        if ( $doaction !== 'confirm' ) {
            return $redirect_to;
        }
        foreach ( $users_id as $user_id ) {
            update_user_meta($user_id,'mail_confirm',true);
        }
        $redirect_to = add_query_arg( 'bulk_emailed_posts', count( $users_id ),  $redirect_to );
        return $redirect_to;
    }


}