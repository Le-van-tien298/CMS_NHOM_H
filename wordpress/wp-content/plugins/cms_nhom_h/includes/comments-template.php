<?php
/**
 * comments-template.php
 * CHỈ chứa phần HTML "Make a Post". File này KHÔNG được require_once
 * ở đâu khác ngoài filter 'comments_template' — WordPress tự require
 * nó lúc render trang, khi đó pluggable.php (is_user_logged_in...) đã load xong.
 */

if (!defined('ABSPATH')) exit;
?>

<div class="cms-post-wrapper">

    <?php if (is_user_logged_in()) : ?>

        <div class="cms-post">
            <div class="cms-post__tab">Make a Post</div>

            <form class="cms-post__form" method="post"
                  action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

                <input type="hidden" name="action" value="cms_nhom_h_submit_post">
                <input type="hidden" name="cms_redirect" value="<?php echo esc_url(get_permalink()); ?>">
                <?php wp_nonce_field('cms_nhom_h_post_nonce', 'cms_nhom_h_post_nonce_field'); ?>

                <textarea class="cms-post__textarea" name="post_content"
                          placeholder="What are you thinking..." required></textarea>

                <div class="cms-post__actions">
                    <button type="submit" class="cms-post__submit">share</button>
                </div>
            </form>
        </div>

    <?php else : ?>

        <div class="cms-post cms-post--locked">
            <p class="cms-post__login-note">
                Vui lòng <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>">đăng nhập</a>
                để đăng bài viết.
            </p>
        </div>

    <?php endif; ?>

</div>
 <?php
    // ---------- Danh sách comment đã có ----------
    $cms_comments = get_comments(array(
        'post_id' => get_the_ID(),
        'status'  => 'approve',
        'order'   => 'DESC',
    ));
    ?>
 
    <div class="cms-comments-list">
        <h3 class="cms-comments-list__title">Comments</h3>
 
        <?php if (!empty($cms_comments)) : ?>
            <ul class="cms-comments-list__items">
                <?php foreach ($cms_comments as $cms_comment) : ?>
                    <li class="cms-comments-list__item">
                        <?php echo esc_html($cms_comment->comment_content); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="cms-comments-list__empty">Chưa có bình luận nào.</p>
        <?php endif; ?>
    </div>
 
</div>