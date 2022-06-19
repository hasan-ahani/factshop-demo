<?php

if (is_user_logged_in()) {
    wp_redirect(home_url());
    exit;

}
get_header(); ?>
    <section id="main" class="my-4">
        <div class="container">
            <div class="row">
                <div id="login-modal" class="col-md-6 p-5 offset-md-3">
                        <form id="set_new_password" method="post">
                            <h3 class="text-primary">بازیابی رمز عبور</h3>
                            <p class="pass_state mt-2"></p>
                            <p class="status"></p>
                            <div class="form-group">
                                <label for="newpassword"> رمز عبور جدید</label>
                                <input type="password" class="form-control" id="newpassword"
                                       name="newpassword" required>
                            </div>
                            <div class="form-group">
                                <label for="newpasswordconfirm">تایید رمز عبور جدید</label>
                                <input type="password" class="form-control" id="newpasswordconfirm"
                                       name="newpasswordconfirm"
                                       required>
                            </div>
                            <div class="form-row">
                                <span>قدرت رمزعبور: </span>
                                <span id="result_pass"></span>
                            </div>
                            <?php wp_nonce_field('ajax-set-password', 'set_password_secure'); ?>
                            <input type="hidden" id="unique" name="unique" value="<?php echo $_GET['unique']; ?>"/>
                            <input type="hidden" id="userid" name="userid" value="<?php echo $confirm_password; ?>"/>
                            <button type="submit" class="btn btn-primary mb-2" value="password_confirm" disabled>
                                ثبت رمز عبور جدید
                                <span id="subloader" class="spinner-border spinner-border-sm d-none"
                                      role="status" aria-hidden="true"></span>
                            </button>
                        </form>
                </div>
            </div>
        </div>
    </section>
<?php get_footer();