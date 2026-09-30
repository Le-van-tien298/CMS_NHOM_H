<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Latest Posts Timeline (Module Latest Post)
 *
 * @param int $limit Số lượng bài viết hiển thị (mặc định: 3)
 * @param string $title Tiêu đề khối (mặc định: 'Latest News')
 */
function cms_nhom_h_render_latest_posts($limit = 3, $title = 'Latest News')
{
    $query = new WP_Query(array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    if (!$query->have_posts()) {
        return;
    }
    ?>

    <section class="cms-latest-news-section">
        <?php if (!empty($title)): ?>
            <h3 class="cms-latest-news-title"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>

        <div class="cms-timeline-list">
            <?php while ($query->have_posts()): $query->the_post(); ?>
                <article class="cms-timeline-item">
                    <!-- Nút tròn rỗng viền xanh (Node) -->
                    <span class="cms-timeline-node"></span>

                    <!-- Dòng tiêu đề bài viết và ngày tháng -->
                    <div class="cms-timeline-header">
                        <h4 class="cms-timeline-post-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h4>

                        <span class="cms-timeline-date">
                            <?php echo get_the_date('j F, Y'); ?>
                        </span>
                    </div>

                    <!-- Mô tả ngắn / trích dẫn -->
                    <p class="cms-timeline-excerpt">
                        <?php
                        $post_id = get_the_ID();
                        $raw_excerpt = get_post_field('post_excerpt', $post_id);
                        if (!empty($raw_excerpt)) {
                            $clean_excerpt = wp_strip_all_tags($raw_excerpt);
                        } else {
                            $raw_content = get_post_field('post_content', $post_id);
                            $clean_excerpt = wp_strip_all_tags(strip_shortcodes($raw_content));
                        }
                        echo esc_html(wp_trim_words($clean_excerpt, 28, '...'));
                        ?>
                    </p>
                </article>
            <?php endwhile; ?>
        </div>
    </section>

    <?php
    wp_reset_postdata();
}

/**
 * Shortcode [cms_latest_posts] / [cms_latest_news]
 */
function cms_nhom_h_latest_posts_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'limit' => 3,
        'title' => 'Latest News',
    ), $atts, 'cms_latest_posts');

    ob_start();
    cms_nhom_h_render_latest_posts((int) $atts['limit'], $atts['title']);
    return ob_get_clean();
}
add_shortcode('cms_latest_posts', 'cms_nhom_h_latest_posts_shortcode');
add_shortcode('cms_latest_news', 'cms_nhom_h_latest_posts_shortcode');
