<?php
if (!defined('ABSPATH')) {
    exit;
}

$cms_footer_posts = get_posts(array(
    'numberposts' => 5,
    'post_status' => 'publish',
));

$cms_footer_cats = get_categories(array(
    'hide_empty' => true,
    'number'     => 5,
));

$cms_footer_comments = get_comments(array(
    'number' => 5,
    'status' => 'approve',
));

$cms_footer_hotline = get_option('cms_header_hotline', '0901 234 567');
?>
<footer class="module-footer">
    <div class="module-footer__container">

        <div class="module-footer__col">
            <h3 class="module-footer__title">Recent Posts</h3>
            <ul class="module-footer__list">
                <?php if ($cms_footer_posts) : foreach ($cms_footer_posts as $p) : ?>
                    <li><a href="<?php echo esc_url(get_permalink($p->ID)); ?>">
                        <?php echo esc_html(get_the_title($p->ID)); ?>
                    </a></li>
                <?php endforeach; else : ?>
                    <li>Chưa có bài viết</li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="module-footer__col">
            <h3 class="module-footer__title">Categories</h3>
            <ul class="module-footer__list">
                <?php if ($cms_footer_cats) : foreach ($cms_footer_cats as $cat) : ?>
                    <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
                        <?php echo esc_html($cat->name); ?> (<?php echo (int) $cat->count; ?>)
                    </a></li>
                <?php endforeach; else : ?>
                    <li>Chưa có danh mục</li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="module-footer__col">
            <h3 class="module-footer__title">Recent Comments</h3>
            <ul class="module-footer__list">
                <?php if ($cms_footer_comments) : foreach ($cms_footer_comments as $c) : ?>
                    <li><a href="<?php echo esc_url(get_comment_link($c)); ?>">
                        <?php echo esc_html($c->comment_author); ?> on
                        <?php echo esc_html(get_the_title($c->comment_post_ID)); ?>
                    </a></li>
                <?php endforeach; else : ?>
                    <li>Chưa có bình luận</li>
                <?php endif; ?>
            </ul>
        </div>

    </div>

    <div class="module-footer__social">
        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
        <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
        <a href="#" aria-label="Google"><i class="fa-brands fa-google-plus-g"></i></a>
        <a href="mailto:<?php echo esc_attr(get_option('admin_email')); ?>" aria-label="Email"><i class="fa-solid fa-envelope"></i></a>
    </div>

    <p class="module-footer__info">
        <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
        – Hotline: <?php echo esc_html($cms_footer_hotline); ?>
    </p>
    <p class="module-footer__copy">
        &copy; <?php echo esc_html(date('Y')); ?> All right Reversed. <?php bloginfo('name'); ?>
    </p>
</footer>