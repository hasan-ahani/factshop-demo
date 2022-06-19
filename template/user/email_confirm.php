<?php
$email_confirm = get_query_var('email_confirm');
if (is_user_logged_in() && !isset($email_confirm) && !isset($_GET['unique_email'])) {
    wp_redirect(home_url());
    exit;

}else{
    $q = get_user_meta($email_confirm, 'fs_mail_confrim_code',true);
    if ($q === $_GET['unique_email']) {
        update_user_meta( $email_confirm, 'mail_confirm', true );
        update_user_meta( $email_confirm, 'fs_mail_confrim_code', null );
    }else{
        wp_redirect(home_url());
        exit;
    }
}
get_header(); ?>
    <section id="main" class="my-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img class="mt-5" src="<?php echo WF_URI.'/assets/img/confirm-email.png'; ?>">
                    <h3 class="text-primary my-4">حساب کاربری شما فعال شد</h3>
                    <p class="mb-5">با تشکر از شما حساب کاربری شما فعال شد، می توانید به حساب کاربری خود وارد شوید</p>
                </div>
            </div>
        </div>
    </section>
<?php get_footer();