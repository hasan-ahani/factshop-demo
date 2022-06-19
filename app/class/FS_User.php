<?php
if (!defined('ABSPATH'))
    die('Fizzle');

class FS_User
{
    var $failed_login_limit;                    //Number of authentification accepted
    var $lockout_duration;                 //Stop authentification process for 30 minutes: 60*30 = 1800
    var $transient_name = 'attempted_login';    //Transient used

    public function __construct()
    {
        if(cs_get_option('user_email_required')){
            new FS_Mail_Required();
        }
        $this->failed_login_limit = 30;
        $this->lockout_duration = (!empty(cs_get_option('login-fail-after'))) ? cs_get_option('login-fail-after') * 60 : 1800;
        add_filter('authenticate', array($this, 'check_attempted_login'), 30, 3);
        add_action('wp_login_failed', array($this, 'login_failed'), 10, 1);
        add_action('init', array($this, 'ajax_auth_init'));
        add_action('comment_post', array($this, 'new_comment_created_notification'), 10, 2);
        add_action('user_register', array($this, 'new_user_registered_notification'));
        add_action('wp_insert_post', array($this, 'new_post_submit_notification'), 10, 3);
        add_action('publish_notification', array($this, 'new_post_submit_notification_for_users'), 10, 3);
        add_action('wp_login', array($this, 'user_login_notification'), 10, 2);
        add_action('wp_login_failed', array($this, 'user_login_failed_notification'), 10, 2);

        add_filter('generate_rewrite_rules', function ($wp_rewrite) {
            $wp_rewrite->rules = array_merge(
                ['confirm-password/(\d+)/?$' => 'index.php?confirm_password=$matches[1]'],
                $wp_rewrite->rules
            );
        });
        add_filter('query_vars', function ($query_vars) {
            $query_vars[] = 'confirm_password';
            return $query_vars;
        });
        add_action('template_redirect', function () {
            $confirm_password = get_query_var('confirm_password');
            if (isset($confirm_password) && isset($_GET['unique'])) {
                    include WF_PATH . '/template/user/forget-pass.php';
                    die();
            }
        });

    }

    public function user_login_notification($user_login, $user )
    {
        if (cs_get_option('email-user-signin-is')) {
            $user = get_user_by('login', $user_login);
            $subject = cs_get_option('email-user-signin-sub');
            $content = cs_get_option('email-user-signin-content');
            $from = cs_get_option('email-sender');
            $title = cs_get_option('email-name');
            $content = str_replace('[user-name]', $user->display_name, $content);
            $content = str_replace('[user-email]', $user->user_email, $content);
            $content = str_replace('[time]', fsdate('Y-m-d H:i', current_time('timestamp', 1)), $content);
            $content = str_replace('[ip]', get_current_ip(), $content);
            FS_Mail::init()
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
                    'info' => cs_get_option('email-desc'),
                    'copyright' => cs_get_option('email-copyright'),
                ])
                ->send();
        }
    }

    function user_login_failed_notification($username, $user = NULL)
    {
        if (cs_get_option('email-user-signin-fail-is')) {
            $user = get_user_by('login', $username);
            if(cs_get_option('user_email_required') && !get_user_meta($user->ID,'mail_confirm',true)) return false;
            $subject = cs_get_option('email-user-signin-fail-sub');
            $content = cs_get_option('email-user-signin-fail-content');
            $from = cs_get_option('email-sender');
            $title = cs_get_option('email-name');
            $content = str_replace('[user-name]', $user->display_name, $content);
            $content = str_replace('[user-email]', $user->user_email, $content);
            $content = str_replace('[time]', fsdate('Y-m-d H:i', current_time('timestamp', 1)), $content);
            $content = str_replace('[ip]', get_current_ip(), $content);
            FS_Mail::init()
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
                    'info' => cs_get_option('email-desc'),
                    'copyright' => cs_get_option('email-copyright'),
                ])
                ->send();
        }
    }

    /**
     * Lock login attempts of failed login limit is reached
     */
    public function check_attempted_login($user, $username, $password)
    {
        if (get_transient($this->transient_name)) {
            $datas = get_transient($this->transient_name);

            if ($datas['tried'] >= $this->failed_login_limit) {
                $until = get_option('_transient_timeout_' . $this->transient_name);
                $time = $this->when($until);

                //Display error message to the user when limit is reached
                return new WP_Error('too_many_tried', sprintf(__('<strong>خطا</strong>: شما به حد مجاز احراز هویت دسترسی پیدا کرده اید،%1$s دیگر دوباره امتحان کنید'), $time));
            }
        }

        return $user;
    }

    /**
     * Return difference between 2 given dates
     * @param  int $time Date as Unix timestamp
     * @return string           Return string
     */
    private function when($time)
    {
        if (!$time)
            return;

        $right_now = time();

        $diff = abs($right_now - $time);

        $second = 1;
        $minute = $second * 60;
        $hour = $minute * 60;
        $day = $hour * 24;

        if ($diff < $minute)
            return floor($diff / $second) . ' ثانیه';

        if ($diff < $minute * 2)
            return "حدود 1 دقیقه پیش";

        if ($diff < $hour)
            return floor($diff / $minute) . ' دقیقه';

        if ($diff < $hour * 2)
            return 'حدود 1 ساعت پیش';

        return floor($diff / $hour) . ' ساعت';
    }
    function new_post_submit_notification_for_users($post_id){
        $post = get_post($post_id);
        if ($post->post_type == 'notification') {
            if (cs_get_option('email-user-notification-is')) {
                $users = get_users();
                foreach ($users as $user) {
                    $subject = cs_get_option('email-user-notification-sub');
                    $content = cs_get_option('email-user-notification-content');
                    $from = cs_get_option('email-sender');
                    $title = cs_get_option('email-name');
                    $content = str_replace('[user-name]', $user->display_name, $content);
                    $content = str_replace('[user-email]', $user->user_email, $content);
                    $content = str_replace('[post-title]', $post->post_title, $content);
                    $content = str_replace('[date]', fsdate('Y-m-d H:i', current_time('timestamp', 1)), $content);
                    FS_Mail::init()
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
                            'info' => cs_get_option('email-desc'),
                            'copyright' => cs_get_option('email-copyright'),
                        ])
                        ->send();
                }

            }
        }
    }

    function new_post_submit_notification($post_id, $post, $update)
    {
        global $pagenow;
        if(in_array( $pagenow, array( 'post-new.php' )))
            return;

        if (wp_is_post_revision($post_id))
            return;

        $post_url = get_permalink($post_id);
        $post = get_post($post_id);
        $user = get_user_by('id', $post->post_author);
        $admin = get_user_by('email', get_option('admin_email'));
        if ($post->post_type == 'post') {
            if (cs_get_option('email-admin-submit-post-is')) {
                $from = cs_get_option('email-sender');
                $title = cs_get_option('email-name');
                $subject = cs_get_option('email-admin-submit-post-sub');
                $content = cs_get_option('email-admin-submit-post-content');
                $content = str_replace('[admin-name]', $admin->display_name, $content);
                $content = str_replace('[user-name]', $user->display_name, $content);
                $content = str_replace('[title]', $post->post_title, $content);
                $content = str_replace('[link]', $post_url, $content);
                $mail = FS_Mail::init()
                    ->to(get_option('admin_email'))
                    ->from("$title < $from >")
                    ->subject($subject)
                    ->template(get_theme_file_path() . '/template/email/global.php', [
                        'title' => $subject,
                        'logo' => cs_get_option('email-logo', WF_URI . '/assets/img/logo.png'),
                        'site' => home_url(),
                        'image' => WF_URI . '/assets/img/admin-manage.gif',
                        'subject' => $subject,
                        'content' => $content,
                        'info' => cs_get_option('email-desc'),
                        'copyright' => cs_get_option('email-copyright'),
                    ])
                    ->send();
            }
            if (cs_get_option('email-user-post_created-is')) {
                $subject = cs_get_option('email-user-post_created-sub');
                $content = cs_get_option('email-user-post_created-content');
                $from = cs_get_option('email-sender');
                $title = cs_get_option('email-name');
                $content = str_replace('[user-name]', $user->display_name, $content);
                $content = str_replace('[user-email]', $user->user_email, $content);
                $content = str_replace('[post-title]', $post->post_title, $content);
                $content = str_replace('[link]', $post_url, $content);
                $content = str_replace('[date]', fsdate('Y-m-d H:i', current_time('timestamp', 1)), $content);
                $content = str_replace('[ip]', get_current_ip(), $content);
                FS_Mail::init()
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
                        'info' => cs_get_option('email-desc'),
                        'copyright' => cs_get_option('email-copyright'),
                    ])
                    ->send();
            }
        }
    }

    public function ajax_auth_init()
    {

        add_action('wp_ajax_nopriv_ajaxregister', array($this, 'ajax_register'));
        add_action('wp_ajax_nopriv_ajaxlogin', array($this, 'ajax_login'));
        add_action('wp_ajax_nopriv_ajaxforgotpassword', array($this, 'ajax_forgotPassword'));
        add_action('wp_ajax_nopriv_newpassset', array($this, 'ajax_newpassset'));
    }

    public function ajax_newpassset()
    {
        check_ajax_referer('ajax-set-password', 'security');
        $pass = $_POST['password'];
        $pass2 = $_POST['password2'];
        $unique = $_POST['unique'];
        $userid = $_POST['userid'];
        $q = get_user_meta($userid, 'reset_password',true);
        if (!isset($pass)) {
            echo json_encode(array('newpass' => false, 'message' => __('رمز عبور جدید را وارد کنید')));
        }elseif(!isset($pass2)) {
            echo json_encode(array('newpass' => false, 'message' => __('تایید رمز عبور جدید را وارد کنید')));
        }elseif($pass != $pass2) {
            echo json_encode(array('newpass' => false, 'message' => __('تایید رمز عبور جدید یکسان نمی باشد')));
        }elseif(!isset($q)) {
            echo json_encode(array('newpass' => false, 'message' => __('کد امنیتی نا معتبر می باشد')));
        }elseif($q != $unique) {
            echo json_encode(array('newpass' => false, 'message' => __('خطا امنیتی رخ داده است')));
        }else{
            wp_set_password($pass, $userid);
            update_user_meta($userid, 'reset_password', '');
            echo json_encode(array('newpass' => true, 'message' => __('رمز عبور با موفقیت تغییر یافت'),'goto' => home_url()));
        }
        die();
    }

    public function ajax_login()
    {
        check_ajax_referer('ajax-login-nonce', 'security');
        $this->auth_user_login($_POST['username'], $_POST['password'], 'Login', $_POST['captcha']);
        die();
    }

    public function auth_user_login($user_login, $password, $login, $captcha = '')
    {
        global $error;
        $info = array();
        $info['user_login'] = $user_login;
        $info['user_password'] = $password;
        $info['remember'] = true;
        if (cs_get_option('is_google_captcha') && !empty(cs_get_option('google_captcha_sitekey')) && !empty(cs_get_option('google_captcha_secretkey')) && $login == 'Login') {
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
                    if (get_transient($this->transient_name)) {
                        $datas = get_transient($this->transient_name);

                        if ($datas['tried'] >= $this->failed_login_limit) {
                            $until = get_option('_transient_timeout_' . $this->transient_name);
                            $time = $this->when($until);
                            echo json_encode(array('loggedin' => false, 'message' => sprintf(__('خطا: شما به حد مجاز احراز هویت دسترسی پیدا کرده اید،%1$s دیگر دوباره امتحان کنید'), $time)));
                            return;
                        }
                    }
                    $user_signon = wp_signon($info, '');
                    if (is_wp_error($user_signon)) {
                        if($user_signon->get_error_code() == 465){
                            if ($login == 'Login'){
                                    echo json_encode(array('loggedin' => false,'notactive' => true, 'message' => __('ایمیل خود را تایید نکرده اید، درصورتی که ایمیل تاییده را دریافت نکرده اید ایمیل خود را وارد کنید')));
                            }else{
                                echo json_encode(array('loggedin' => false, 'message' => __('ثبت نام شما انجام شد، برای تایید حساب کاربری یک ایمیل برای شما ارسال شد.')));
                            }
                        }else{
                            $this->login_failed($user_login);
                            echo json_encode(array('loggedin' => false, 'message' => __('نام کاربری یا رمز عبور اشتباه می باشد')));
                        }

                    } else {
                        wp_set_current_user($user_signon->ID);
                        echo json_encode(array('loggedin' => true, 'message' => __(' با موفقیت وارد شدید، در حال انتقال ...')));
                    }
                } else {
                    echo json_encode(array('loggedin' => false, 'message' => __('مقدار اعتبار سنجی را وارد کنید')));
                }
            } else {
                echo json_encode(array('loggedin' => false, 'message' => __('مقدار اعتبار سنجی را وارد کنید')));
            }
        } else {
            if (get_transient($this->transient_name)) {
                $datas = get_transient($this->transient_name);

                if ($datas['tried'] >= $this->failed_login_limit) {
                    $until = get_option('_transient_timeout_' . $this->transient_name);
                    $time = $this->when($until);
                    echo json_encode(array('loggedin' => false, 'message' => sprintf(__('خطا: شما به حد مجاز احراز هویت دسترسی پیدا کرده اید،%1$s دیگر دوباره امتحان کنید'), $time)));
                    return;
                }
            }
            $user_signon = wp_signon($info, ''); // From false to '' since v4.9
            if (is_wp_error($user_signon)) {
                if($user_signon->get_error_code() == 465){
                    if ($login == 'Login'){
                        echo json_encode(array('loggedin' => false,'notactive' => true, 'message' => __('ایمیل خود را تایید نکرده اید، درصورتی که ایمیل تاییده را دریافت نکرده اید ایمیل خود را وارد کنید')));
                    }else{
                        echo json_encode(array('loggedin' => false, 'message' => __('ثبت نام شما انجام شد، برای تایید حساب کاربری یک ایمیل برای شما ارسال شد.')));
                    }
                }else{
                    $this->login_failed($user_login);
                    echo json_encode(array('loggedin' => false, 'message' => __('نام کاربری یا رمز عبور اشتباه می باشد')));
                }

            } else {
                wp_set_current_user($user_signon->ID);
                echo json_encode(array('loggedin' => true, 'message' => __(' با موفقیت وارد شدید، در حال انتقال ...')));
            }
        }
        die();
    }

    /**
     * Add transient
     */
    public function login_failed($username)
    {
        if (get_transient($this->transient_name)) {
            $datas = get_transient($this->transient_name);
            $datas['tried']++;

            if ($datas['tried'] <= $this->failed_login_limit)
                set_transient($this->transient_name, $datas, $this->lockout_duration);
        } else {
            $datas = array(
                'tried' => 1
            );
            set_transient($this->transient_name, $datas, $this->lockout_duration);
        }
    }

    public function ajax_register()
    {
        check_ajax_referer('ajax-register-nonce', 'security');
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
                    $info = array();
                    $info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']);
                    $info['user_pass'] = sanitize_text_field($_POST['password']);
                    $info['user_email'] = sanitize_email($_POST['email']);
                    $user_register = wp_insert_user($info);
                    if (is_wp_error($user_register)) {
                        $error = $user_register->get_error_codes();
                        if (in_array('empty_user_login', $error))
                            echo json_encode(array('loggedin' => false, 'message' => __($user_register->get_error_message('empty_user_login'))));
                        elseif (in_array('existing_user_login', $error))
                            echo json_encode(array('loggedin' => false, 'message' => __('این نام کاربری قبلا ثبت شده است.')));
                        elseif (in_array('existing_user_email', $error))
                            echo json_encode(array('loggedin' => false, 'message' => __('این ایمیل قبلا ثبت شده است.')));
                    } else {
                        $this->auth_user_login($info['nickname'], $info['user_pass'], 'Registration', $captcha);

                    }
                } else {
                    echo json_encode(array('loggedin' => false, 'message' => __('یک مقدار اعتبار سنجی وارد کنید')));
                }
            }else {
                echo json_encode(array('loggedin' => false, 'message' => __('یک مقدار اعتبار سنجی وارد کنید')));
            }
        } else {
            $info = array();
            $info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']);
            $info['user_pass'] = sanitize_text_field($_POST['password']);
            $info['user_email'] = sanitize_email($_POST['email']);
            $user_register = wp_insert_user($info);
            if (is_wp_error($user_register)) {
                $error = $user_register->get_error_codes();
                if (in_array('empty_user_login', $error))
                    echo json_encode(array('loggedin' => false, 'message' => __($user_register->get_error_message('empty_user_login'))));
                elseif (in_array('existing_user_login', $error))
                    echo json_encode(array('loggedin' => false, 'message' => __('این نام کاربری قبلا ثبت شده.')));
                elseif (in_array('existing_user_email', $error))
                    echo json_encode(array('loggedin' => false, 'message' => __('این ایمیل قبلا ثبت شده.')));
            } else {
                $this->auth_user_login($info['nickname'], $info['user_pass'], 'Registration');

            }
        }

        die();
    }

    public function new_user_registered_notification($user_id)
    {
        if (cs_get_option('email-admin-user-registered-is')) {
            $user = get_userdata($user_id);
            $admin = get_user_by('email', get_option('admin_email'));
            $subject = cs_get_option('email-admin-user-registered-sub');
            $content = cs_get_option('email-admin-user-registered-content');
            $from = cs_get_option('email-sender');
            $title = cs_get_option('email-name');
            $content = str_replace('[admin-name]', $admin->display_name, $content);
            $content = str_replace('[user-name]', $user->display_name, $content);
            $content = str_replace('[user-email]', $user->user_email, $content);
            $mail = FS_Mail::init()
                ->to(get_option('admin_email'))
                ->from("$title < $from >")
                ->subject($subject)
                ->template(get_theme_file_path() . '/template/email/global.php', [
                    'title' => $subject,
                    'logo' => cs_get_option('email-logo', WF_URI . '/assets/img/logo.png'),
                    'site' => home_url(),
                    'image' => WF_URI . '/assets/img/admin-manage.gif',
                    'subject' => $subject,
                    'content' => $content,
                    'info' => cs_get_option('email-desc'),
                    'copyright' => cs_get_option('email-copyright'),
                ])
                ->send();
        }
        if (cs_get_option('email-user-signup-is')) {
            $user = get_userdata($user_id);
            $subject = cs_get_option('email-user-signup-sub');
            $content = cs_get_option('email-user-signup-content');
            $from = cs_get_option('email-sender');
            $title = cs_get_option('email-name');
            $content = str_replace('[user-name]', $user->display_name, $content);
            $content = str_replace('[user-email]', $user->user_email, $content);
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
                    'info' => cs_get_option('email-desc'),
                    'copyright' => cs_get_option('email-copyright'),
                ])
                ->send();
        }


    }

    public function ajax_forgotPassword()
    {
        check_ajax_referer('ajax-forgot-nonce', 'security');
        global $wpdb;

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
                        update_user_meta($user->ID, 'reset_password', $unique);
                        $unique_url = site_url() . '/confirm-password/' . $user->ID . '/?unique=' . $unique;
                        $subject = cs_get_option('email-user-forgetpass-sub');
                        $content = cs_get_option('email-user-forgetpass-content');
                        $from = cs_get_option('email-sender');
                        $title = cs_get_option('email-name');
                        $content = str_replace('[user-name]', $user->display_name, $content);
                        $content = str_replace('[user-email]', $user->user_email, $content);
                        $content = str_replace('[time]', fsdate('Y-m-d H:i', current_time('timestamp', 1)), $content);
                        $content = str_replace('[ip]', get_current_ip(), $content);
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
                                'button' => $this->get_button_email($unique_url, 'ثبت رمز عبور جدید'),
                                'info' => cs_get_option('email-desc'),
                                'copyright' => cs_get_option('email-copyright'),
                            ])
                            ->send();
                    }
                    if ($mail)
                        $success = 'ایمیل خود را برای تغییر رمز عبور بررسی کنید.';
                    else
                        $error = 'سیستم قادر به ارسال ایمیل  به شما نیست.';

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
                update_user_meta($user->ID, 'reset_password', $unique);
                $unique_url = site_url() . '/confirm-password/' . $user->ID . '/?unique=' . $unique;
                $subject = cs_get_option('email-user-forgetpass-sub');
                $content = cs_get_option('email-user-forgetpass-content');
                $from = cs_get_option('email-sender');
                $title = cs_get_option('email-name');
                $content = str_replace('[user-name]', $user->display_name, $content);
                $content = str_replace('[user-email]', $user->user_email, $content);
                $content = str_replace('[time]', fsdate('Y-m-d H:i', current_time('timestamp', 1)), $content);
                $content = str_replace('[ip]', get_current_ip(), $content);
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
                        'button' => $this->get_button_email($unique_url, 'ثبت رمز عبور جدید'),
                        'info' => cs_get_option('email-desc'),
                        'copyright' => cs_get_option('email-copyright'),
                    ])
                    ->send();
            }
            if ($mail)
                $success = 'ایمیل خود را برای تغییر رمز عبور بررسی کنید.';
            else
                $error = 'سیستم قادر به ارسال ایمیل  رمز عبور جدید شما نیست.';

            if (!empty($error))
                echo json_encode(array('loggedin' => false, 'message' => __($error)));

            if (!empty($success))
                echo json_encode(array('loggedin' => false, 'message' => __($success)));
        }
        die();
    }

    public function get_button_email($link, $name)
    {
        if ($link && $name) {
            return '<a class="mcnButton" href="' . $link . '" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; display: block; color: #007bff; font-weight: normal; text-decoration: none; font-weight: normal; letter-spacing: 1px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF; direction: rtl;text-transform:uppercase;" target="_blank" title="' . $name . '">' . $name . '</a>';
        }
    }

    public function new_comment_created_notification($comment_ID, $comment_approved)
    {
        if (1 === $comment_approved) {
            if (cs_get_option('email-admin-comment-post-is')) {
                $admin = get_user_by('email', get_option('admin_email'));
                $comment = get_comment($comment_ID);
                $post = get_post($comment->comment_post_ID);
                $subject = cs_get_option('email-admin-comment-post-sub');
                $content = cs_get_option('email-admin-comment-post-content');
                $content = str_replace('[admin-name]', $admin->display_name, $content);
                $content = str_replace('[post-title]', $post->post_title, $content);
                $content = str_replace('[ip]', $comment->comment_author_IP, $content);
                $content = str_replace('[email]', $comment->comment_author_email, $content);
                $content = str_replace('[comment]', $comment->comment_content, $content);
                $content = str_replace('[date]', $comment->comment_date, $content);
                $from = cs_get_option('email-sender');
                $title = cs_get_option('email-name');
                FS_Mail::init()
                    ->to(get_option('admin_email'))
                    ->from("$title < $from >")
                    ->subject($subject)
                    ->template(get_theme_file_path() . '/template/email/global.php', [
                        'title' => $subject,
                        'logo' => cs_get_option('email-logo', WF_URI . '/assets/img/logo.png'),
                        'site' => home_url(),
                        'image' => WF_URI . '/assets/img/admin-manage.gif',
                        'subject' => $subject,
                        'content' => $content,
                        'info' => cs_get_option('email-desc'),
                        'copyright' => cs_get_option('email-copyright'),
                    ])
                    ->send();
            }
            if (cs_get_option('email-user-comment-is')) {
                $admin = get_user_by('email', get_option('admin_email'));
                $comment = get_comment($comment_ID);
                $post = get_post($comment->comment_post_ID);
                $subject = cs_get_option('email-user-comment-sub');
                $content = cs_get_option('email-user-comment-content');
                $content = str_replace('[post-title]', $post->post_title, $content);
                $content = str_replace('[ip]', $comment->comment_author_IP, $content);
                $content = str_replace('[email]', $comment->comment_author_email, $content);
                $content = str_replace('[comment]', $comment->comment_content, $content);
                $content = str_replace('[date]', $comment->comment_date, $content);
                $from = cs_get_option('email-sender');
                $title = cs_get_option('email-name');
                FS_Mail::init()
                    ->to($comment->comment_author_email)
                    ->from("$title < $from >")
                    ->subject($subject)
                    ->template(get_theme_file_path() . '/template/email/global.php', [
                        'title' => $subject,
                        'logo' => cs_get_option('email-logo', WF_URI . '/assets/img/logo.png'),
                        'site' => home_url(),
                        'image' => WF_URI . '/assets/img/user-manage.gif',
                        'subject' => $subject,
                        'content' => $content,
                        'info' => cs_get_option('email-desc'),
                        'copyright' => cs_get_option('email-copyright'),
                    ])
                    ->send();
            }
        }


    }


}