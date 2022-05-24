<?php
/**
 * Comment template
 *
 * @package sanjose
 * @since 1.0.0
 *
 */

if ( post_password_required() ) { return; } ?>

<div class="row">
    <div class="col-md-12">
            <h2 class="title-comment"><?php comments_number(esc_html__('No Comments', 'sanjose'), esc_html__('1 Comment', 'sanjose'),esc_html__('% Comments', 'sanjose') ); ?></h2>
            <div class="sanjose-comments-list" id="comments">
                <ul><?php wp_list_comments( array( 'callback' => 'sanjose_comment' ) ); ?></ul>

                <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                    <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                        <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'sanjose' ) ); ?></div>
                        <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'sanjose' ) ); ?></div>
                    </nav>
                <?php endif; ?>
            </div>

        <div class="comment-post-form">
            <?php comment_form(
                array(
                    'id_form'              => 'sanjose-comment-form',
                    'fields'               => array(
                        'author'            => '<div class="row"><div class="col-md-6"><label>'. esc_html__( 'Your name', 'sanjose' ) . '</label><input name="author"  type="text"  placeholder="'. esc_html__( 'Your name', 'sanjose') .'" required /></div>',
                        'email'             => '<div class="col-md-6"><label>'. esc_html__( 'Your E-mail', 'sanjose' ) . '</label><input name="email"   type="email" placeholder="'. esc_html__( 'Your email', 'sanjose') .'" required /></div></div>',
                    ),
                    'comment_field'        => '<div class="row"><div class="col-md-12"><textarea cols="30"  name="comment" rows="10" placeholder="'. esc_html__( 'Your comment here', 'sanjose') .'" required></textarea>',
                    'must_log_in'          => '',
                    'logged_in_as'         => '',
                    'comment_notes_before' => '',
                    'comment_notes_after'  => '',
                    'title_reply'          => 'Leave A Comment',
                    'title_reply_to'       => esc_html__('Leave a Reply to %s', 'sanjose' ),
                    'cancel_reply_link'    => esc_html__('Cancel', 'sanjose' ),
                    'label_submit'         => esc_html__('Send Comment', 'sanjose' ),
                    'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="send-button" value="' . esc_html__('SEND Comment','sanjose') . '" /></div></div>',
                    'submit_field'         => '%1$s %2$s',
                )
            ); ?>
        </div>

    </div>
</div>
