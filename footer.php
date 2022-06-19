<footer class="bg-white shadow-sm">
    <?php if(cs_get_option('show-footer-widgets')):?>
    <div class="footer-widgets py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-widget mt-4">
                        <div class="fw-title"><i class="icon-rss"></i><?php echo cs_get_option('translate-blog','بلاگ'); ?></div>
                        <div class="fw-body">
                            <ul class="last-post list-unstyled">
                                <?php $cat = (cs_get_option('footer-category-post') != null) ? '&cat='.cs_get_option('footer-category-post') : '';?>
                                <?php query_posts("&showposts=5".$cat); ?>
                                <?php while (have_posts()) : the_post(); ?>
                                <li><a href="<?php the_permalink() ?>" ><i class="icon-chevron-left"></i><?php the_title(); ?></a></li>
                                <?php endwhile; ?>
                                <?php wp_reset_query(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="footer-widget mt-4">
                        <div class="fw-title"><i class="icon-cart"></i><?php echo cs_get_option('translate-socialmedia','شبکه های اجتماعی'); ?></div>
                        <div class="fw-body">
                            <?php if(cs_get_option("show-social-in-footer")): ?>
                                <ul class="social-menu list-unstyled text-center list-inline m-0 <?php echo (cs_get_option("show-social-colored")) ? 'colored' : NULL; ?>">
                                        <?php if(cs_get_option("social-telegram")): ?>
                                            <li><a class="social-telegram" href="<?php echo 'https://t.me/'.cs_get_option("social-telegram"); ?>"><i class="fab fa-telegram"></i></a></li>
                                        <?php endif; ?>
                                        <?php if(cs_get_option("social-instagram")): ?>
                                            <li><a class="social-instagram" href="<?php echo 'https://instagram.com/'.cs_get_option("social-instagram"); ?>"><i class="fab fa-instagram"></i></a></li>
                                        <?php endif; ?>
                                        <?php if(cs_get_option("social-aparat")): ?>
                                        <li><a class="social-aparat" href="<?php echo 'https://www.aparat.com/'.cs_get_option("social-aparat"); ?>"><svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" stroke="none">
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
                                        <?php if(cs_get_option("social-facebook")): ?>
                                            <li><a class="social-facebook" href="<?php echo 'https://facebook.com/'.cs_get_option("social-facebook"); ?>"><i class="fab fa-facebook-square"></i></a></li>
                                        <?php endif; ?>
                                        <?php if(cs_get_option("social-google")): ?>
                                            <li><a class="social-google" href="<?php echo 'https://plus.google.com/'.cs_get_option("social-google"); ?>"><i class="fab fa-google-plus-square"></i></a></li>
                                        <?php endif; ?>
                                        <?php if(cs_get_option("social-twitter")): ?>
                                            <li><a class="social-twitter" href="<?php echo 'https://twitter.com/'.cs_get_option("social-twitter"); ?>"><i class="fab fa-twitter-square"></i></a></li>
                                        <?php endif; ?>
                                        <?php if(cs_get_option("social-pintrest")): ?>
                                            <li><a class="social-pintrest" href="<?php echo 'https://www.pintrest.com/'.cs_get_option("social-pintrest"); ?>"><i class="fab fa-pinterest"></i></a></li>
                                        <?php endif; ?>
                                    </ul>
                            <?php endif; ?>
                            <?php
                            if(cs_get_option("footer-mailchimp")){
                                if(do_shortcode(cs_get_option("footer-mailchimp"))){
                                    echo '<p class="mail-text">'.cs_get_option('translate-shoar','به جمع صد‌ها هزار نفری همراهان وردپرس بپیوندید.').'</p>';
                                    echo do_shortcode(cs_get_option("footer-mailchimp"));
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="footer-widget mt-4">
                        <div class="fw-title"><i class="icon-namad"></i><?php echo cs_get_option('translate-namad','نماد اعتماد'); ?></div>
                        <div class="fw-body text-center">
                            <?php echo cs_get_option('footer-namad1');?>
                            <?php echo cs_get_option('footer-namad2');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
    <div class="copyright bg-white border-top border-light">
        <div class="container">
            <div class="row text-sm-center">
                <div class="col-md-6 copyright-text text-md-left text-lg-left text-xl-left <?php echo (cs_get_option('show-footer-widgets')) ? null : 'pt-2'; ?> text-center"><p><?php echo cs_get_option('footer-copyright','@تمامی حقوق این قالب برای فکت وردپرس محفوظ می باشد.');?></p></div>
                <?php if(cs_get_option('show-footer-widgets')):?>
                <div class="col-md-6 text-md-right text-lg-right text-xl-right text-center pb-sm-3 designed"><?php echo cs_get_option('footer-designer', 'طراحی و اجرا با <i class="icon-heart"></i> توسط <a href="www.wpfact.ir">فکت وردپرس</a>');?></div>
                <?php else:?>
                    <?php if(cs_get_option("show-social-in-footer")): ?>
                        <div class="col-md-6 text-md-right text-lg-right text-xl-right text-center pb-sm-3 designed">
                            <ul class="social-menu list-unstyled text-center list-inline m-0 float-md-right float-lg-right float-xl-right float-none <?php echo (cs_get_option("show-social-colored")) ? 'colored' : NULL; ?>">
                                <?php if(cs_get_option("social-telegram")): ?>
                                    <li><a class="social-telegram" href="<?php echo 'https://t.me/'.cs_get_option("social-telegram"); ?>"><i class="fab fa-telegram"></i></a></li>
                                <?php endif; ?>
                                <?php if(cs_get_option("social-instagram")): ?>
                                    <li><a class="social-instagram" href="<?php echo 'https://instagram.com/'.cs_get_option("social-instagram"); ?>"><i class="fab fa-instagram"></i></a></li>
                                <?php endif; ?>
                                <?php if(cs_get_option("social-aparat")): ?>
                                    <li><a class="social-aparat" href="<?php echo 'https://www.aparat.com/'.cs_get_option("social-aparat"); ?>"><svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" stroke="none">
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
                                <?php if(cs_get_option("social-facebook")): ?>
                                    <li><a class="social-facebook" href="<?php echo 'https://facebook.com/'.cs_get_option("social-facebook"); ?>"><i class="fab fa-facebook-square"></i></a></li>
                                <?php endif; ?>
                                <?php if(cs_get_option("social-google")): ?>
                                    <li><a class="social-google" href="<?php echo 'https://plus.google.com/'.cs_get_option("social-google"); ?>"><i class="fab fa-google-plus-square"></i></a></li>
                                <?php endif; ?>
                                <?php if(cs_get_option("social-twitter")): ?>
                                    <li><a class="social-twitter" href="<?php echo 'https://twitter.com/'.cs_get_option("social-twitter"); ?>"><i class="fab fa-twitter-square"></i></a></li>
                                <?php endif; ?>
                                <?php if(cs_get_option("social-pintrest")): ?>
                                    <li><a class="social-pintrest" href="<?php echo 'https://www.pintrest.com/'.cs_get_option("social-pintrest"); ?>"><i class="fab fa-pinterest"></i></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php endif;?>
            </div>
        </div>
    </div>
</footer>
<?php if(cs_get_option('is_show_go_top')):?>
<button class="btn btn-primary scroll-top" data-scroll="up" type="button">
    <i class="icon-chevron-left "></i>
</button>
<?php endif;?>
<?php wp_footer();?>
<?php if(cs_get_option('is_google_captcha')):?>
<script src='https://www.google.com/recaptcha/api.js' async defer ></script>
<?php endif;?>
</body>

</html>