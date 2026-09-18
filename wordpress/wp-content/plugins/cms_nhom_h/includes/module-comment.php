<?php
/**
 * Module Comment
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!comments_open()) {
    return;
}
?>

<section class="cms-comment">

    <div class="cms-comment__header">
        <h2>Leave a comment</h2>
    </div>

    <div class="cms-comment__body">

        <?php
        comment_form(
            array(
                'title_reply' => '',

                'label_submit' => 'Post Comment',

                'comment_field' =>
                    '<label class="cms-comment__label" for="comment">
                        Comment <span class="required">*</span>
                    </label>

                    <textarea
                        id="comment"
                        name="comment"
                        class="cms-comment__textarea"
                        rows="8"
                        required
                    ></textarea>',

                'comment_notes_before' =>
                    '<p class="cms-comment__note">
                        Required fields are marked <span class="required">*</span>
                    </p>',

                'comment_notes_after' => '',

                'logged_in_as' =>
                    '<p class="cms-comment__logged-in">
                        Logged in as '
                        . esc_html(wp_get_current_user()->display_name) .
                        '.
                        <a href="' . esc_url(get_edit_user_link()) . '">
                            Edit your profile
                        </a>
                        <a href="' . esc_url(wp_logout_url(get_permalink())) . '">
                            Log out?
                        </a>
                    </p>',
            )
        );
        ?>

    </div>

</section>