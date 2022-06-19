<?php

if ( post_password_required() ) {
    return;
}
?>
<div id="comments" class="card comments-layout mb-4">
    <?php if ( have_comments() ) : ?>
    <h4>
        <?php
        $comments_number = get_comments_number();
        if ( '1' === $comments_number ) {
                printf( _x( '1 دیدگاه در  &ldquo;%s&rdquo;', 'دیدگاه ها'), get_the_title() );
            } else {
                printf(
                _nx(
                '%1$s دیدگاه در &ldquo;%2$s&rdquo;',
                '%1$s دیدگاه در &ldquo;%2$s&rdquo;',
                $comments_number,
                'دیدگاه ها'
                ),
                number_format_i18n( $comments_number ),
                get_the_title()
                );
        }
        ?>
    </h4>
    <ul class="comments-list list-unstyled p-3">
        <?php wp_list_comments( array (
                'callback' => 'wf_comments' ,
        ) ); ?>
    </ul>
        <nav class="col-md-12">
            <?php
             paginate_comments_links( array(
                'prev_text' => '&rarr;',
                'next_text' => '&larr;',
                'type' => 'list',
                'end_size' => 3,
                'mid_size' => 3,
            ));
            ?>
        </nav>
    <?php

    elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p>
            <?php echo __('Comments are closed')?>
        </p>

    <?php endif;

    ob_start();
    $commenter = wp_get_current_commenter();
    $comment_author = $commenter['comment_author'];
    $comment_author_email = $commenter['comment_author_email'];
    $req = true;
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $comments_arg = array(
        'form'	=> array(
            'class' => 'form-horizontal',
            'id' => 'submit-comments'
        ),
        'fields' => apply_filters( 'comment_form_default_fields', array(
            'author' 				=> '<div class="form-row"><div class="form-group col-md-6">' .
                '<input id="author" name="author" class="form-control mb-2 mr-sm-2" type="text" value="'.$comment_author.'" placeholder="نام" size="30"' . $aria_req . ' />'.
                '<p id="d1" class="text-danger"></p>' . '</div>',
            'email'					=> '<div class="form-group col-md-6">' .
                '<input id="email" name="email" class="form-control mb-2 mr-sm-2" type="text" value="'.$comment_author_email.'" placeholder="ایمیل" size="30"' . $aria_req . ' />'.
                '<p id="d2" class="text-danger"></p>' . '</div></div>',
            'url'					=> '')),
        'comment_field'			=> '<div class="form-group">' .
            '<textarea id="comment" class="form-control mb-2 mr-sm-2" name="comment" rows="7" aria-required="true" placeholder="دیدگاه"></textarea><p id="d3" class="text-danger"></p>' . '</div>',
        'comment_notes_after' 	=> '',
        'class_submit'			=> 'btn btn-primary mb-2'
    );

    comment_form($comments_arg);
    echo str_replace('class="comment-form"','class="comment-form" name="commentForm" onsubmit="return validateForm();"',ob_get_clean());
    ?>

</div>