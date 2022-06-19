<?php /*
* Template Name: ورود و ثبت نام
*/
if (is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}
?>
<?php get_header(); ?>
    <section id="main" class="my-4">
        <div class="container">
            <div class="card">
            <div class="row">
                <div id="login-modal" class="col-md-6 p-5">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="login-tab-page" role="tabpanel"
                                 aria-labelledby="pills-login-tab">
                                <form id="llogin" class="ajax-auth" action="login" method="post">
                                    <h3 class="text-primary">ورود</h3>
                                    <p class="status"></p>
                                    <?php wp_nonce_field('ajax-login-nonce', 'lsecurity'); ?>
                                    <div class="form-group">
                                        <label for="username">نام کاربری یا ایمیل</label>
                                        <input type="text" class="form-control" id="lusername" name="lusername" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">رمز عبور</label>
                                        <input type="password" class="form-control" id="lpassword" name="password"
                                               required>
                                    </div>
                                    <?php if (cs_get_option('is_google_captcha') && cs_get_option('google_captcha_sitekey') != ''): ?>
                                        <div class="form-group">
                                            <div class="g-recaptcha"
                                                 data-sitekey="<?php echo cs_get_option('google_captcha_sitekey'); ?>"></div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remember">
                                        <label class="custom-control-label" for="defaultUnchecked">مرا به خاطر
                                            بسپار</label>
                                    </div>
                                    <button id="lbtnlogin" type="submit" class="btn btn-primary mb-2" value="LOGIN">ورود
                                        <span id="subloader" class="spinner-border spinner-border-sm d-none"
                                              role="status" aria-hidden="true"></span>
                                    </button>
                                </form>

                            </div>
                            <div class="tab-pane fade" id="register-tab-page" role="tabpanel"
                                 aria-labelledby="pills-register-tab">
                                <form id="lregister" class="ajax-auth" action="register" method="post">
                                    <h3 class="text-primary">ثبت نام</h3>
                                    <p class="status"></p>
                                    <?php wp_nonce_field('ajax-register-nonce', 'lsignonsecurity'); ?>
                                    <div class="form-group">
                                        <label for="signonname">نام کاربری</label>
                                        <input type="text" class="form-control" id="lsignonname" name="signonname"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">ایمیل</label>
                                        <input type="email" class="form-control" id="lemail" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="signonpassword"> رمز عبور</label>
                                        <input type="password" class="form-control" id="lsignonpassword"
                                               name="signonpassword" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password2">تایید رمز عبور</label>
                                        <input type="password" class="form-control" id="lpassword2" name="password2"
                                               required>
                                    </div>
                                    <div class="form-row">
                                        <span>قدرت رمزعبور: </span>
                                        <span id="result_passs"></span>
                                    </div>
                                    <?php if (cs_get_option('is_google_captcha') && cs_get_option('google_captcha_sitekey') != ''): ?>
                                        <div class="form-group">
                                            <div class="g-recaptcha"
                                                 data-sitekey="<?php echo cs_get_option('google_captcha_sitekey'); ?>"></div>
                                        </div>
                                    <?php endif; ?>
                                    <button id="lbtnregister" type="submit" class="btn btn-primary mb-2" value="SIGNUP">
                                        ثبت نام
                                        <span id="subloader" class="spinner-border spinner-border-sm d-none"
                                              role="status" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="password-tab-page" role="tabpanel"
                                 aria-labelledby="pills-password-tab">
                                <form id="lforgot_password" class="ajax-auth" action="forgot_password" method="post">
                                    <h3 class="text-primary">بازیابی رمز عبور</h3>
                                    <p class="status"></p>
                                    <?php wp_nonce_field('ajax-forgot-nonce', 'lforgotsecurity'); ?>
                                    <div class="form-group">
                                        <label for="user_login">ایمیل</label>
                                        <input type="text" class="form-control" id="luser_login" class="required"
                                               name="user_login" required>
                                    </div>
                                    <?php if (cs_get_option('is_google_captcha') && cs_get_option('google_captcha_sitekey') != ''): ?>
                                        <div class="form-group">
                                            <div class="g-recaptcha"
                                                 data-sitekey="<?php echo cs_get_option('google_captcha_sitekey'); ?>"></div>
                                        </div>
                                    <?php endif; ?>
                                    <button id="lbtnforget-page" type="submit" class="btn btn-primary mb-2" value="SUBMIT">
                                        بازیابی
                                        <span id="subloader" class="spinner-border spinner-border-sm d-none"
                                              role="status" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="active-tab-page" role="tabpanel"
                                 aria-labelledby="pills-active-tab">
                                <form id=active_user_page" class="ajax-auth" method="post">
                                    <h3 class="text-primary">تایید حساب کاربری</h3>
                                    <p class="status"></p>
                                    <?php wp_nonce_field('ajax-active-user-nonce', 'lactive_user_security'); ?>
                                    <div class="form-group">
                                        <label for="user_login">ایمیل</label>
                                        <input type="email" class="form-control"
                                               id="luser_login_active" class="required"
                                               name="user_login_active" required>
                                    </div>
                                    <?php if (cs_get_option('is_google_captcha') && cs_get_option('google_captcha_sitekey') != ''): ?>
                                        <div class="form-group">
                                            <div class="g-recaptcha" data-sitekey="<?php echo cs_get_option('google_captcha_sitekey'); ?>"></div>
                                        </div>
                                    <?php endif; ?>
                                    <button id="lbtnactive" type="submit"
                                            class="btn btn-primary mb-2" value="SUBMIT">
                                        ارسال ایمیل فعالسازی
                                        <span id="subloader"
                                              class="spinner-border spinner-border-sm d-none"
                                              role="status" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </div>

                        </div>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-login-tab" data-toggle="pill" href="#login-tab-page"
                                   role="tab" aria-controls="login-tab-page" aria-selected="true">ورود</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-register-tab" data-toggle="pill" href="#register-tab-page"
                                   role="tab" aria-controls="register-tab-page" aria-selected="false">عضو نیستید؟ ثبت نام
                                    کنید</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-password-tab" data-toggle="pill" href="#password-tab-page"
                                   role="tab" aria-controls="password-tab-page" aria-selected="false">رمز عبور خود را فراموش
                                    کرده اید؟</a>
                            </li>
                            <li class="nav-item d-none">
                                <a class="nav-link" id="pills-active-tab"
                                   data-toggle="pill" href="#active-tab-page" role="tab"
                                   aria-controls="active-tab-page" aria-selected="false">تایید حساب کاربری</a>
                            </li>
                        </ul>
                    </div>


                <div class="col-md-6 loginbg d-none d-sm-none d-md-block d-lg-block d-xl-block">
                    <img src="<?php echo WF_URI . '/assets/img/loginbg.jpg'; ?>" alt=""/>
                </div>
                </div>
            </div>


        </div>
    </section>
<?php get_footer(); ?>