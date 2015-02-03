<?php
/**
 * The template for displaying Comments.
 *
 * @package Makron
 * @since 1.0.0
 */
if( post_password_required() || ( !have_comments() && !comments_open() && !pings_open() ) )
    return; ?>

<div id="commentsbox" class="mak-comments-box">
    <div id="comments" class="comments-area mak-cf">

        <?php if( have_comments() ) : ?>
            <h3 class="comments-title"><span><?php printf( _n( '1 comment', '%1$s comments', get_comments_number(), 'makron' ), number_format_i18n( get_comments_number() ) ); ?></span></h3>

            <?php if( get_comment_pages_count( null ) > 1 && get_option( 'page_comments' ) ) : ?>
            <nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
                <h1 class="assistive-text"><?php echo __( 'Comment Navigation', 'makron' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( '&larr;'. __( 'Older Comments','makron' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments','makron' ) .'&rarr;', 0 ); ?></div>
            </nav>
            <?php endif; ?>

            <ol class="commentlist">
                <?php wp_list_comments( array( 'callback' => 'mak_comment' ) ); ?>
            </ol>

            <?php if( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
                <h1 class="assistive-text"><?php echo __('Comment Navigation','makron'); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( '&larr;'. __( 'Older Comments','makron') ); ?></div>
                <div class="nav-next"><?php next_comments_link( __('Newer Comments', 'makron' ) .'&rarr;', 0); ?></div>
            </nav>
            <?php endif; ?>

        <?php endif; ?>

        <?php if(!comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

        <?php endif; ?>

        <?php
        $commenter = wp_get_current_commenter();
        $req       = get_option( 'require_name_email' );
        $aria_req  = ( $req ? " aria-required='true'" : '' );

        $fields =  array(
            'author' => '<p class="comment-form-author">' . '<label for="author">'. __('Name/Pseudo','makron') .' ' . ( $req ? '<span class="required">*</span></label>' : '' ) . '<input placeholder="'. __('Your name/nickname...','makron') .'" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">'. __('Email','makron') .' ' . ( $req ? '<span class="required">*</span></label>' : '' ) . '<input placeholder="'. __('Your email address...','makron') .'" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
            'url'    => '<p class="comment-form-url"><label for="url">'. __('Website/blog','makron') .'</label>' . '<input placeholder="'. __('Your website/blog URL...','makron') .'" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
        );

        $comments_args = array(
            'fields'               => $fields,
            'title_reply'          => '<span>' . __( 'Leave a comment', 'makron' ) .'</span>',
            'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true" rows="10"></textarea></p>',
            'must_log_in'          => '<p class="must-log-in"><a href="' . wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">'. __('Log In To Comment','makron') .'</a></p>',
            'comment_form_top'     => '',
            'comment_notes_after'  => '',
            'comment_notes_before' => '',
            'cancel_reply_link'    => __( 'Cancel', 'makron' ) ,
            'label_submit'         => __( 'Send','makron' )
        );

        comment_form( $comments_args ); ?>

    </div>
</div>
