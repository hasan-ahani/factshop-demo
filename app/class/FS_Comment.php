<?php
if ( ! defined( 'ABSPATH' ) )
    die( 'Fizzle' );

class FS_Comment {

    private $public_key, $private_key;

    private static $captcha_error;

    public function __construct() {
        $this->public_key  = cs_get_option('google_captcha_sitekey');
        $this->private_key = cs_get_option('google_captcha_secretkey');
        // adds the captcha to the comment form
        add_action( 'comment_form', array( $this, 'captcha_display' ) );
        // delete comment that fail the captcha challenge
        add_action( 'wp_head', array( $this, 'delete_failed_captcha_comment' ) );
        // authenticate the captcha answer
        add_filter( 'preprocess_comment', array( $this, 'validate_captcha_field' ) );
        // redirect location for comment
        add_filter( 'comment_post_redirect', array( $this, 'redirect_fail_captcha_comment' ), 10, 2 );
    }

    public function captcha_display() {
        if ( isset( $_GET['captcha'] ) && $_GET['captcha'] == 'empty' ) {
            echo '<strong>خطا</strong>: مقدار اعتبارسنجی نباید خالی باشد';
        } elseif ( isset( $_GET['captcha'] ) && $_GET['captcha'] == 'failed' ) {
            echo '<strong>خطا</strong>: پاسخ اعتبار سنجی اشتباه بود';
        }
        echo <<<CAPTCHA_FORM
		<style type='text/css'>#submit {
				display: none;
			}</style>
		<script type="text/javascript"
		        src="http://www.google.com/recaptcha/api/challenge?k=$this->public_key">
		</script>
		<noscript>
			<iframe src="http://www.google.com/recaptcha/api/noscript?k=$this->public_key"
			        height="300" width="300" frameborder="0"></iframe>
			<br>
			<textarea name="recaptcha_challenge_field" rows="3" cols="40">
			</textarea>
			<input type="hidden" name="recaptcha_response_field"
			       value="manual_challenge">
		</noscript>
		<input name="submit" type="submit" class="btn btn-primary mb-2" id="submit-alt" tabindex="6" value="ارسال دیدگاه"/>
CAPTCHA_FORM;
    }
    /**
     * Add query string to the comment redirect location
     *
     * @param $location string location to redirect to after comment
     * @param $comment object comment object
     *
     * @return string
     */
    function redirect_fail_captcha_comment( $location, $comment ) {
        if ( ! empty( self::$captcha_error ) ) {
            // replace #comment- at the end of $location with #commentform
            $args = array( 'comment-id' => $comment->comment_ID );
            if ( self::$captcha_error == 'captcha_empty' ) {
                $args['captcha'] = 'empty';
            } elseif ( self::$captcha_error == 'challenge_failed' ) {
                $args['captcha'] = 'failed';
            }
            $location = add_query_arg( $args, $location );
        }
        return $location;
    }
    /** Delete comment that fail the captcha test. */
    function delete_failed_captcha_comment() {
        if ( isset( $_GET['comment-id'] ) && ! empty( $_GET['comment-id'] ) ) {
            wp_delete_comment( absint( $_GET['comment-id'] ) );
        }
    }
    /**
     * Verify the captcha answer
     *
     * @param $commentdata object comment object
     *
     * @return object
     */
    public function validate_captcha_field( $commentdata ) {
        // if captcha is left empty, set the self::$captcha_error property to indicate so.
        if ( empty( $_POST['recaptcha_response_field'] ) ) {
            self::$captcha_error = 'captcha_empty';
        } // if captcha verification fail, set self::$captcha_error to indicate so
        elseif ( $this->recaptcha_response() == 'false' ) {
            self::$captcha_error = 'challenge_failed';
        }
        return $commentdata;
    }
    /**
     * Get the reCAPTCHA API response.
     *
     * @return string
     */
    public function recaptcha_response() {
        // reCAPTCHA challenge post data
        $challenge = isset( $_POST['recaptcha_challenge_field'] ) ? esc_attr( $_POST['recaptcha_challenge_field'] ) : '';
        // reCAPTCHA response post data
        $response = isset( $_POST['recaptcha_response_field'] ) ? esc_attr( $_POST['recaptcha_response_field'] ) : '';
        $remote_ip = $_SERVER["REMOTE_ADDR"];
        $post_body = array(
            'privatekey' => $this->private_key,
            'remoteip'   => $remote_ip,
            'challenge'  => $challenge,
            'response'   => $response
        );
        return $this->recaptcha_post_request( $post_body );
    }
    /**
     * Send HTTP POST request and return the response.
     *
     * @param $post_body array HTTP POST body
     *
     * @return bool
     */
    public function recaptcha_post_request( $post_body ) {
        $args = array( 'body' => $post_body );
        // make a POST request to the Google reCaptcha Server
        $request = wp_remote_post( 'https://www.google.com/recaptcha/api/verify', $args );
        // get the request response body
        $response_body = wp_remote_retrieve_body( $request );
        /**
         * explode the response body and use the request_status
         * @see https://developers.google.com/recaptcha/docs/verify
         */
        $answers = explode( "\n", $response_body );
        $request_status = trim( $answers[0] );
        return $request_status;
    }
}
