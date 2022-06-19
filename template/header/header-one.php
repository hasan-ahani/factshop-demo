<header class="site-header">
    <?php get_template_part('template/header/notification'); ?>
    <?php if (cs_get_option('show-topbar')): ?>
        <div id="topbar" class="bg-white border-bottom border-light ">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 d-none d-lg-block d-xl-block">
                        <?php
                        if (has_nav_menu('top-bar')) {
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'top-bar',
                                    'menu_class' => 'list-inline font-weight-light topbar-menu py-1 m-0',
                                    'container' => '',
                                )
                            );
                        } ?>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center text-sm-center text-md-right text-lg-right text-xl-right">
                        <?php if (cs_get_option("phone-number")): ?>
                            <a class="top-contact" href="#"><i
                                    class="fas fa-phone-square"></i> <?php echo cs_get_option("phone-number"); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (cs_get_option("email-address")): ?>
                            <a class="top-contact" href="#"><i
                                    class="fas fa-envelope"></i><?php echo cs_get_option("email-address"); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div id="mainhead" class="bg-white border-bottom border-light">
        <div class="container">
            <div class="row">
                <div class="col-8 col-md-6 col-sm-8 col-lg-4 col-xl-3 logo ">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php if (cs_get_option('logo')): ?>
                            <img class="my-2" src="<?php echo wp_get_attachment_url(cs_get_option('logo')); ?>"
                                 alt="<?php echo cs_get_option('logo'); ?>"/>
                        <?php else: ?>
                            <img class="my-2" src="<?php echo WF_URI . '/assets/img/logo.png'; ?>" alt="<?php echo cs_get_option('logo'); ?>"/>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="col-4 col-sm-4 d-lg-none d-xl-none d-md-none">
                    <?php if (cs_get_option('show-mycart-mobile')): ?>
                        <a class="my-cart in-mob my-4 pt-1 float-left" href="<?php echo wc_get_cart_url(); ?>"
                           title="سبد خرید شما">
                            <small class="badge badge-primary"><?php echo WC()->cart->get_cart_contents_count(); ?></small>
                            <i class="icon-shop"></i></a>
                    <?php endif; ?>
                    <div class="burger-container  d-xl-none d-md-none d-lg-none">
                        <div id="burger">
                            <div class="bar topBar"></div>
                            <div class="bar btmBar"></div>
                        </div>
                    </div>
                    <?php if (cs_get_option('show-menu-text-responsive') && !cs_get_option('show-mycart-mobile')): ?>
                        <span class="responsive-menu-text"><?php echo cs_get_option('menu-text-responsive'); ?></span>
                    <?php endif; ?>
                </div>
                <div class="mobilenav">
                    <?php if (cs_get_option('show-profile')): ?>
                        <?php if (is_user_logged_in()): ?>
                            <?php global $current_user;
                            _wp_get_current_user(); ?>
                            <div class="panel-user">
                                <header>
                                    <?php echo get_avatar($current_user->ID, '100', '', '', array('class' => 'panel-user-img')); ?>
                                    <b><?php echo $current_user->display_name; ?></b>
                                    <small><?php echo cs_get_option('translate-welcome','خوش آمدید'); ?></small>
                                    <a href="javascript:;" class="btnmenuprofile"></a>
                                </header>
                            </div>
                            <div class="panel-menu">
                                <ul class="my-acount-menus list-unstyled">
                                    <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
                                        <li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                                            <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php else: ?>
                            <div class="panel-user">
                                <header class="text-center">
                                    <a href="<?php echo (cs_get_option('login_page')) ? get_page_link(cs_get_option('login_page')) : home_url(); ?>" class="btn btn-warning px-4">ورود به پنل کاربری</a>
                                </header>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="input-group">
                            <input type="search" class="form-control search-input" placeholder="<?php echo cs_get_option('translate-whatsearch','دنبال چی می گردی؟'); ?>" value="<?php echo get_search_query(); ?>" name="s">
                            <div class="input-group-btn">
                                <button class="search-btn" type="submit">
                                    <i class="icon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php
                    if (has_nav_menu('main-menu')) {
                        wp_nav_menu(
                            array(
                                'theme_location' => 'main-menu',
                                'menu_class' => 'list-unstyled mobile-menu',
                                'container' => '',
                            )
                        );
                    } ?>
                </div>
                <div class="col-lg-4 col-xl-6 my-4 d-none d-lg-block d-xl-block">
                    <?php if (cs_get_option('show-search')): ?>
                        <form class="form-search-header" role="search" method="get"
                              action="<?php echo esc_url(home_url('/')); ?>">
                            <div class="input-group">
                                <input type="search"
                                       class="form-control search-input <?php echo (cs_get_option('is_ajax_search_header')) ? 'ajax-search' : NULL; ?>"
                                       autocomplete="off" placeholder="<?php echo cs_get_option('translate-whatsearch','دنبال چی می گردی؟'); ?>"
                                       value="<?php echo get_search_query(); ?>" name="s" required>
                                <?php if(cs_get_option('is_ajax_search_header')): ?>
                                    <span id="s-loader" class="search-ajax-loader"><div class="sloader">Loading...</div></span>
                                <?php endif; ?>
                                <div class="input-group-btn">
                                    <button class="search-btn" type="submit">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                            </div>
                            <?php if(cs_get_option('is_ajax_search_header')): ?>
                                <div class="ajax-results" style="display: none;"></div>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 d-none d-md-block d-lg-block d-xl-block">
                    <?php if (cs_get_option('show-profile')): ?>
                        <div class="profile ml-3 my-2 float-left">
                            <?php if (is_user_logged_in()):
                                $user = wp_get_current_user(); ?>
                                <?php echo get_avatar($user->ID); ?>
                                <div class="info-profile ml-2">
                                    <b class="name-profile text-primary"><?php echo $user->display_name; ?></b>
                                    <small class="money-profile text-success"><?php if (class_exists('WooWallet')) {
                                            echo 'موجودی: ' . strip_tags(woo_wallet()->wallet->get_wallet_balance(get_current_user_id()));
                                        } else {
                                            echo cs_get_option('translate-welcome','خوش آمدید');
                                        } ?></small>
                                </div>
                                <ul class="list-unstyled profile-menu">
                                    <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
                                        <li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                                            <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <div class="btn-group my-3" role="group">
                                    <button type="button" id="loginbtn-modal" class="btn btn-primary px-3"
                                            data-toggle="modal" data-target="#login-modal"><?php echo cs_get_option('translate-login','ورود'); ?>
                                    </button>
                                    <button type="button" id="registerbtn-modal" class="btn btn-primary"
                                            data-toggle="modal" data-target="#login-modal"><?php echo cs_get_option('translate-signup','ثبت نام'); ?>
                                    </button>
                                </div>
                                <div class="modal fade" id="login-modal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>

                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 p-5">
                                                        <div class="tab-content" id="pills-tabContent">
                                                            <div class="tab-pane fade show active" id="login-tab"
                                                                 role="tabpanel" aria-labelledby="pills-login-tab">
                                                                <form id="login" class="ajax-auth" action="login"
                                                                      method="post">
                                                                    <h3 class="text-primary">ورود</h3>
                                                                    <p class="status"></p>
                                                                    <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
                                                                    <div class="form-group">
                                                                        <label for="username">نام کاربری یا
                                                                            ایمیل</label>
                                                                        <input type="text" class="form-control"
                                                                               id="username" name="username" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="password">رمز عبور</label>
                                                                        <input type="password" class="form-control"
                                                                               id="password" name="password" required>
                                                                    </div>
                                                                    <!-- Default unchecked -->
                                                                    <div class="custom-control custom-checkbox mb-3">
                                                                        <input type="checkbox"
                                                                               class="custom-control-input"
                                                                               id="defaultUnchecked">
                                                                        <label class="custom-control-label"
                                                                               for="defaultUnchecked">مرا به خاطر
                                                                            بسپار</label>
                                                                    </div>
                                                                    <?php if (cs_get_option('is_google_captcha') && cs_get_option('google_captcha_sitekey') != ''): ?>
                                                                        <div class="form-group">
                                                                            <div class="g-recaptcha"
                                                                                 data-sitekey="<?php echo cs_get_option('google_captcha_sitekey'); ?>"></div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <button id="btnlogin" type="submit"
                                                                            class="btn btn-primary mb-2" value="LOGIN">
                                                                        ورود
                                                                        <span id="subloader"
                                                                              class="spinner-border spinner-border-sm d-none"
                                                                              role="status" aria-hidden="true"></span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            <div class="tab-pane fade" id="register-tab" role="tabpanel"
                                                                 aria-labelledby="pills-register-tab">
                                                                <form id="register" class="ajax-auth" action="register"
                                                                      method="post">
                                                                    <h3 class="text-primary">ثبت نام</h3>
                                                                    <p class="status"></p>
                                                                    <?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>
                                                                    <div class="form-group">
                                                                        <label for="signonname">نام کاربری</label>
                                                                        <input type="text" class="form-control"
                                                                               id="signonname" name="signonname"
                                                                               required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="email">ایمیل</label>
                                                                        <input type="email" class="form-control"
                                                                               id="email" name="email" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="signonpassword">رمز عبور</label>
                                                                        <input type="password" class="form-control"
                                                                               id="signonpassword" name="signonpassword"
                                                                               required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="password2">تایید رمز عبور</label>
                                                                        <input type="password" class="form-control"
                                                                               id="password2" name="password2" required>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <span>قدرت رمزعبور: </span>
                                                                        <span id="result_pass"></span>
                                                                    </div>
                                                                    <?php if (cs_get_option('is_google_captcha') && cs_get_option('google_captcha_sitekey') != ''): ?>
                                                                        <div class="form-group">
                                                                            <div class="g-recaptcha"
                                                                                 data-sitekey="<?php echo cs_get_option('google_captcha_sitekey'); ?>"></div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <button id="btnregister" type="submit"
                                                                            class="btn btn-primary mb-2" value="SIGNUP">
                                                                        ثبت نام
                                                                        <span id="subloader"
                                                                              class="spinner-border spinner-border-sm d-none"
                                                                              role="status" aria-hidden="true"></span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            <div class="tab-pane fade" id="password-tab" role="tabpanel"
                                                                 aria-labelledby="pills-password-tab">
                                                                <form id="forgot_password" class="ajax-auth"
                                                                      action="forgot_password" method="post">
                                                                    <h3 class="text-primary">بازیابی رمز عبور</h3>
                                                                    <p class="status"></p>
                                                                    <?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>
                                                                    <div class="form-group">
                                                                        <label for="user_login">ایمیل</label>
                                                                        <input type="email" class="form-control"
                                                                               id="user_login" class="required"
                                                                               name="user_login" required>
                                                                    </div>
                                                                    <?php if (cs_get_option('is_google_captcha') && cs_get_option('google_captcha_sitekey') != ''): ?>
                                                                        <div class="form-group">
                                                                            <div class="g-recaptcha"
                                                                                 data-sitekey="<?php echo cs_get_option('google_captcha_sitekey'); ?>"></div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <button id="btnforget" type="submit"
                                                                            class="btn btn-primary mb-2" value="SUBMIT">
                                                                        بازیابی
                                                                        <span id="subloader"
                                                                              class="spinner-border spinner-border-sm d-none"
                                                                              role="status" aria-hidden="true"></span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            <div class="tab-pane fade" id="active-tab" role="tabpanel"
                                                                 aria-labelledby="pills-active-tab">
                                                                <form id="active_user" class="ajax-auth"
                                                                      action="active_user" method="post">
                                                                    <h3 class="text-primary">تایید حساب کاربری</h3>
                                                                    <p class="status"></p>
                                                                    <?php wp_nonce_field('ajax-active-user-nonce', 'active_user_security'); ?>
                                                                    <div class="form-group">
                                                                        <label for="user_login">ایمیل</label>
                                                                        <input type="email" class="form-control"
                                                                               id="user_login_active" class="required"
                                                                               name="user_login_active" required>
                                                                    </div>
                                                                    <?php if (cs_get_option('is_google_captcha') && cs_get_option('google_captcha_sitekey') != ''): ?>
                                                                        <div class="form-group">
                                                                            <div class="g-recaptcha"
                                                                                 data-sitekey="<?php echo cs_get_option('google_captcha_sitekey'); ?>"></div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <button id="btnactive" type="submit"
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
                                                                <a class="nav-link active" id="pills-login-tab"
                                                                   data-toggle="pill" href="#login-tab" role="tab"
                                                                   aria-controls="login-tab"
                                                                   aria-selected="true">ورود</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="pills-register-tab"
                                                                   data-toggle="pill" href="#register-tab" role="tab"
                                                                   aria-controls="register-tab" aria-selected="false">عضو
                                                                    نیستید؟ ثبت نام کنید</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="pills-password-tab"
                                                                   data-toggle="pill" href="#password-tab" role="tab"
                                                                   aria-controls="password-tab" aria-selected="false">رمز
                                                                    عبور خود را فراموش کرده اید؟</a>
                                                            </li>
                                                            <li class="nav-item d-none">
                                                                <a class="nav-link" id="pills-active-tab"
                                                                   data-toggle="pill" href="#active-tab" role="tab"
                                                                   aria-controls="active-tab" aria-selected="false">تایید حساب کاربری</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6 loginbg">
                                                        <?php if (cs_get_option('login_pic')): ?>
                                                            <img src="<?php echo wp_get_attachment_url(cs_get_option('login_pic')); ?>" alt="ورور به سایت"/>
                                                        <?php else: ?>
                                                            <img src="<?php echo WF_URI . '/assets/img/loginbg.jpg'; ?>" alt="ورور به سایت"/>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (cs_get_option('show-mycart')): ?>
                        <a class="my-cart my-4 pt-1 float-left" href="<?php echo wc_get_cart_url(); ?>"
                           title="سبد خرید شما">
                            <small class="badge badge-primary"><?php echo WC()->cart->get_cart_contents_count(); ?></small>
                            <i class="icon-shop"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div id="main-menu" class="shadow-sm bg-white d-none d-md-block d-lg-block d-xl-block <?php echo (cs_get_option('show-sticky-header')) ? 'is_sticky' : null; ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-9 col-xl-9 ">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php if (cs_get_option('logo')): ?>
                            <img class="my-2 menu-logo"
                                 src="<?php echo wp_get_attachment_url(cs_get_option('logo')); ?>"
                                 alt="<?php echo cs_get_option('logo'); ?>"/>
                        <?php else: ?>
                            <img class="my-2 menu-logo" src="<?php echo WF_URI . '/assets/img/logo.png'; ?>"
                                 alt="<?php echo cs_get_option('logo'); ?>"/>
                        <?php endif; ?>
                    </a>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'main-menu',
                            'menu_class' => 'main-nav list-inline m-0',
                            'container' => '',
                        )
                    );
                    ?>
                </div>
                <?php if (cs_get_option("show-social-in-header")): ?>
                    <div class="col-md-3 d-none d-lg-block d-xl-block">
                        <ul class="social-menu list-unstyled list-inline m-0 <?php echo (cs_get_option("show-social-colored")) ? 'colored' : NULL; ?>">
                            <?php if (cs_get_option("social-telegram")): ?>
                                <li><a class="social-telegram"
                                       href="<?php echo 'https://t.me/' . cs_get_option("social-telegram"); ?>"><i
                                            class="fab fa-telegram"></i></a></li>
                            <?php endif; ?>
                            <?php if (cs_get_option("social-instagram")): ?>
                                <li><a class="social-instagram"
                                       href="<?php echo 'https://instagram.com/' . cs_get_option("social-instagram"); ?>"><i
                                            class="fab fa-instagram"></i></a></li>
                            <?php endif; ?>
                            <?php if (cs_get_option("social-aparat")): ?>
                                <li><a class="social-aparat"
                                       href="<?php echo 'https://www.aparat.com/' . cs_get_option("social-aparat"); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt"
                                             height="512.000000pt" viewBox="0 0 512.000000 512.000000"
                                             preserveAspectRatio="xMidYMid meet">
                                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                               stroke="none">
                                                <path d="M1570 4615 c-30 -8 -93 -34 -140 -57 -115 -56 -230 -169 -283 -278 -30 -60 -95 -276 -140 -461 -5 -19 32 13 136 116 206 206 402 337 655 440 113 46 334 108 430 121 29 4 51 9 48 11 -2 2 -96 29 -208 60 -182 49 -216 55 -323 59 -86 3 -136 0 -175 -11z"/>
                                                <path d="M2388 4349 c-208 -20 -413 -78 -608 -170 -550 -262 -925 -766 -1015 -1365 -19 -128 -19 -390 0 -518 90 -599 465 -1103 1015 -1365 585 -278 1266 -228 1805 134 406 272 672 676 772 1170 26 129 26 511 0 640 -100 494 -366 898 -772 1170 -353 237 -777 344 -1197 304z m-236 -490 c281 -58 464 -349 393 -624 -100 -384 -583 -515 -864 -234 -202 202 -201 511 3 715 129 128 295 179 468 143z m1321 -254 c232 -60 387 -256 387 -489 0 -151 -43 -259 -145 -361 -70 -70 -155 -118 -246 -140 -126 -29 -232 -16 -355 45 -200 98 -315 328 -271 541 23 112 61 183 142 265 105 105 213 151 360 153 39 1 97 -6 128 -14z m-816 -864 c76 -39 123 -112 123 -192 0 -173 -168 -279 -325 -205 -59 27 -77 46 -104 106 -88 193 118 388 306 291z m-776 -241 c30 -5 91 -28 135 -50 200 -98 315 -328 271 -541 -23 -112 -61 -183 -142 -265 -164 -165 -393 -201 -603 -95 -269 136 -358 489 -186 739 115 165 322 249 525 212z m1333 -256 c263 -68 430 -333 375 -596 -29 -137 -148 -293 -269 -351 -207 -100 -442 -63 -597 92 -203 202 -204 520 -3 721 128 127 319 179 494 134z"/>
                                                <path d="M3770 4112 c0 -4 20 -22 45 -40 114 -86 289 -279 395 -438 145 -215 259 -502 300 -762 7 -40 14 -71 17 -69 2 3 33 114 69 248 56 214 64 255 64 334 0 177 -65 332 -190 456 -101 99 -191 144 -405 199 -88 23 -190 50 -227 60 -38 10 -68 16 -68 12z"/>
                                                <path d="M580 2237 c0 -4 -25 -100 -55 -214 -47 -179 -55 -220 -55 -298 0 -177 65 -332 189 -455 107 -105 179 -140 443 -210 117 -31 215 -55 217 -54 2 2 -9 14 -25 26 -56 43 -237 224 -297 298 -183 225 -325 523 -387 806 -18 85 -30 124 -30 101z"/>
                                                <path d="M4095 1319 c-22 -29 -81 -94 -131 -145 -272 -273 -629 -467 -1004 -544 -57 -11 -106 -23 -108 -25 -4 -4 -5 -4 228 -66 307 -82 431 -80 618 12 138 68 261 199 311 335 26 67 133 464 129 476 -2 5 -21 -15 -43 -43z"/>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (cs_get_option("social-facebook")): ?>
                                <li><a class="social-facebook"
                                       href="<?php echo 'https://facebook.com/' . cs_get_option("social-facebook"); ?>"><i
                                            class="fab fa-facebook-square"></i></a></li>
                            <?php endif; ?>
                            <?php if (cs_get_option("social-google")): ?>
                                <li><a class="social-google"
                                       href="<?php echo 'https://plus.google.com/' . cs_get_option("social-google"); ?>"><i
                                            class="fab fa-google-plus-square"></i></a></li>
                            <?php endif; ?>
                            <?php if (cs_get_option("social-twitter")): ?>
                                <li><a class="social-twitter"
                                       href="<?php echo 'https://twitter.com/' . cs_get_option("social-twitter"); ?>"><i
                                            class="fab fa-twitter-square"></i></a></li>
                            <?php endif; ?>
                            <?php if (cs_get_option("social-pintrest")): ?>
                                <li><a class="social-pintrest"
                                       href="<?php echo 'https://www.pintrest.com/' . cs_get_option("social-pintrest"); ?>"><i
                                            class="fab fa-pinterest"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</header>
<div class="screen_mobile_show"></div>