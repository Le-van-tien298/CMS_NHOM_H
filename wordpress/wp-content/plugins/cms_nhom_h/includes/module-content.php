<?php

if (!defined('ABSPATH')) {
    exit;
}

function cms_custom_post_excerpt($excerpt, $post = null)
{
    if (!$post) {
        $post = get_post();
    }

    if (is_home() || is_front_page() || is_archive() || in_the_loop() || is_main_query()) {

        $day = get_the_date('d', $post);
        $month = get_the_date('m', $post);
        $title = get_the_title($post);

        if (empty($excerpt)) {
            $excerpt = wp_trim_words(
                wp_strip_all_tags($post->post_content),
                25,
                '...'
            );
        }

        return '
        <div class="cms-post-card">
            <div class="cms-post-date">
                <span class="cms-day">' . esc_html($day) . '</span>
                <span class="cms-month">THÁNG ' . esc_html($month) . '</span>
            </div>
            <div class="cms-post-divider"></div>
            <div class="cms-post-info">
                <div class="cms-post-title">
                        <a href="' . esc_url(get_permalink($post)) . '">
                            ' . esc_html($title) . '
                        </a>
                    </div>
                <div class="cms-post-excerpt">' . esc_html($excerpt) . '</div>
            </div>
        </div>
        ';
    }

    return $excerpt;
}
add_filter('get_the_excerpt', 'cms_custom_post_excerpt', 10, 2);
