<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hiển thị danh sách bài viết mới nhất
 */
function cms_nhom_h_render_recent_posts($limit = 3)
{
    $recent_posts = new WP_Query([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'orderby'         => 'date',
        'order'           => 'DESC',
    ]);

    if (!$recent_posts->have_posts()) {
        return;
    }
?>

    <section class="cms-recent-posts">

        <div class="cms-recent-posts-list">

            <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>

                <article class="cms-recent-post">

                    <!-- Ngày tháng năm -->
                    <div class="cms-recent-date">

                        <div class="cms-recent-day">
                            <?php echo get_the_date('d'); ?>
                        </div>

                        <div class="cms-recent-month">
                            <?php echo get_the_date('m'); ?>
                        </div>

                        <div class="cms-recent-year">
                            <?php echo get_the_date('y'); ?>
                        </div>

                    </div>

                    <!-- Tiêu đề -->
                    <div class="cms-recent-title">

                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>

                    </div>

                </article>

            <?php endwhile; ?>

        </div>

        <!-- Nút xem tất cả -->
        <div class="cms-recent-footer">

            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
                XEM TẤT CẢ TIN TỨC
            </a>

        </div>

    </section>

<?php

    wp_reset_postdata();
}
