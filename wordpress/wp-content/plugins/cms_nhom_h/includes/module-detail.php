<?php

if (!defined('ABSPATH')) {
    exit;
}

$post_id = get_the_ID();

$title = get_the_title($post_id);

$day = get_the_date('d', $post_id);
$month = get_the_date('m', $post_id);
$year = get_the_date('y', $post_id);

$author = get_the_author_meta(
    'display_name',
    get_post_field('post_author', $post_id)
);

// Nạp module categories nếu chưa có
if (!function_exists('cms_nhom_h_render_categories_box')) {
    $cat_file = dirname(__FILE__) . '/module-categories.php';
    if (file_exists($cat_file)) {
        require_once $cat_file;
    }
}

// Nạp module recent post nếu chưa có
if (!function_exists('cms_nhom_h_render_recent_posts')) {
    $recent_file = dirname(__FILE__) . '/module-recent-post.php';
    if (file_exists($recent_file)) {
        require_once $recent_file;
    }
}

// Nạp module prev next nếu chưa có
if (!function_exists('cms_prev_next_posts')) {
    $prev_next_file = dirname(__FILE__) . '/module-prev-next.php';
    if (file_exists($prev_next_file)) {
        require_once $prev_next_file;
    }
}
?>

<div class="cms-detail-layout">

    <!-- CỘT TRÁI: CATEGORIES (9) -->
    <aside class="cms-detail-categories">
        <?php
        if (function_exists('cms_nhom_h_render_categories_box')) {
            cms_nhom_h_render_categories_box();
        } else {
            echo '<div class="cms-category-widget"><h3 class="widget-title">Categories</h3><p>Chưa có chuyên mục</p></div>';
        }
        ?>
    </aside>

    <!-- CỘT GIỮA: DETAIL (6) -->
    <article class="cms-detail">

        <!-- HEADER -->
        <div class="cms-detail-header">

            <h1 class="cms-detail-title">
                <?php echo esc_html($title); ?>
            </h1>

            <!-- DATE -->
            <div class="cms-detail-date">

                <div class="cms-date-left">
                    <span class="cms-detail-day">
                        <?php echo esc_html($day); ?>
                    </span>

                    <span class="cms-detail-month">
                        THÁNG <?php echo esc_html($month); ?>
                    </span>
                </div>

                <div class="cms-date-divider"></div>

                <div class="cms-date-right">
                    <span class="cms-detail-year">
                        20<?php echo esc_html($year); ?>
                    </span>
                </div>

            </div>

        </div>

        <!-- LINE -->
        <div class="cms-detail-line"></div>

        <!-- POST CONTENT -->
        <div class="cms-detail-content">

            <?php
            if (isset($cms_post_content) && !empty($cms_post_content)) {
                echo $cms_post_content;
            } else {
                the_content();
            }
            ?>

        </div>

        <!-- AUTHOR -->
        <div class="cms-detail-author">

            (Theo <?php echo esc_html($author ? $author : get_bloginfo('name')); ?>)

        </div>

        <!-- PREV / NEXT POSTS -->
        <div class="cms-detail-navigation">
            <?php
            if (function_exists('cms_prev_next_posts')) {
                cms_prev_next_posts();
            }
            ?>
        </div>

    </article>

    <!-- CỘT PHẢI: RECENT POST (10) -->
    <aside class="cms-detail-sidebar">

        <?php
        if (function_exists('cms_nhom_h_render_recent_posts')) {
            cms_nhom_h_render_recent_posts(3);
        }
        ?>

    </aside>

</div>