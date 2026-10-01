<?php
// includes/module-search.php

// 1. Form tìm kiếm nhỏ inline trên Header (giữ nguyên)
function render_custom_search_inline()
{
    $placeholder = get_option('cms_search_placeholder', 'Search');
    ?>
            <form role="search" method="get" class="search-form-inline" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="search-input-pill" placeholder="<?php echo esc_attr($placeholder); ?>"
                    value="<?php echo esc_attr(get_search_query()); ?>" name="s" />
                <button type="submit" class="search-btn-pill">Submit</button>
            </form>
            <?php
}

// 2. Khung tìm kiếm popup to (giữ nguyên)
function render_custom_search_dropdown()
{
    $placeholder = get_option('cms_search_placeholder_dropdown', 'Search topics or keywords');
    ?>
            <div id="header-search-popup" class="search-popup-panel">
                <div class="search-popup-container">
                    <form role="search" method="get" class="search-form-large" action="<?php echo esc_url(home_url('/')); ?>">
                    <i class="fa-solid fa-magnifying-glass search-large-icon"></i>
                    <input type="search" class="search-large-input" placeholder="<?php echo esc_attr($placeholder); ?>"
                        value="<?php echo esc_attr(get_search_query()); ?>" name="s" />
                    <button type="submit" class="search-large-btn">Search</button>
                </form>
            </div>
        </div>
        <?php
}

// 3. CHẶN GIAO DIỆN THỪA CỦA THEME & CHỈ RENDER KẾT QUẢ CỦA PLUGIN
add_action('template_redirect', 'cms_handle_search_render_clean');

function cms_handle_search_render_clean()
{
    if (isset($_GET['s']) && !empty(trim($_GET['s'])) && !is_admin()) {
        $keyword = sanitize_text_field($_GET['s']);

        $search_query = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            's' => $keyword,
            'posts_per_page' => 12,
        ));
        ?>
                <!DOCTYPE html>
                <html <?php language_attributes(); ?>>
                <head>
                    <meta charset="<?php bloginfo('charset'); ?>">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Tìm kiếm: <?php echo esc_html($keyword); ?></title>
                    <?php wp_head(); ?>
                    <link rel="stylesheet" href="<?php echo CMS_NHOM_H_URL . 'assets/css/latest-post.css?ver=1.0.0'; ?>">
                    <style>
                        /* ÉP CSS TRỰC TIẾP ĐỂ KHÔNG BỊ MẤT STYLE */
                        body {
                            background-color: #f8fafc;
                            margin: 0;
                            padding: 0;
                            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                        }
                        .cms-search-container {
                            max-width: 1200px;
                            margin: 30px auto;
                            padding: 0 20px;
                        }
                        .cms-search-header {
                            margin-bottom: 25px;
                        }
                        .cms-search-header h2 {
                            font-size: 26px;
                            color: #0f172a;
                            margin: 0 0 8px 0;
                        }
                        .cms-search-header h2 span {
                            color: #0284c7;
                        }
                        .cms-search-header p {
                            color: #64748b;
                            margin: 0;
                            font-size: 14px;
                        }
                        .cms-card-wrapper {
                            display: flex;
                            flex-direction: column;
                            gap: 16px;
                        }

                        .no-result-box {
                            background: #fff;
                            padding: 40px;
                            text-align: center;
                            color: #64748b;
                            border: 1px solid #e5e7eb;
                        }
                    </style>
                </head>
                <body <?php body_class(); ?>>
                    <?php
                    // Header card bo tròn có tìm kiếm
                    if (function_exists('cms_render_module_header')) {
                        cms_render_module_header();
                    }
                    ?>

                    <main class="cms-search-container">
                        <div class="cms-search-header">
                            <h2>Kết quả tìm kiếm cho: <span>"<?php echo esc_html($keyword); ?>"</span></h2>
                            <p>Tìm thấy <?php echo (int) $search_query->found_posts; ?> bài viết liên quan.</p>
                        </div>

                        <div class="cms-card-wrapper">
                            <?php if ($search_query->have_posts()): ?>
                                    <?php while ($search_query->have_posts()):
                                        $search_query->the_post(); 
                                        // Gọi module-content thông qua the_excerpt() đã được filter
                                        echo get_the_excerpt();
                                    endwhile;
                                    wp_reset_postdata(); ?>
                            <?php else: ?>
                                    <div class="no-result-box">
                                        <p>Không tìm thấy bài viết nào phù hợp với từ khóa "<?php echo esc_html($keyword); ?>"!</p>
                                    </div>
                            <?php endif; ?>
                        </div>

                        <!-- KHỐI LATEST POSTS / LATEST NEWS DƯỚI KẾT QUẢ TÌM KIẾM -->
                        <?php
                        if (!function_exists('cms_nhom_h_render_latest_posts')) {
                            $latest_file = dirname(__FILE__) . '/module-latest-post.php';
                            if (file_exists($latest_file)) {
                                require_once $latest_file;
                            }
                        }

                        if (function_exists('cms_nhom_h_render_latest_posts')) {
                            cms_nhom_h_render_latest_posts(3, 'Latest News');
                        }
                        ?>
                    </main>

                    <?php
                    wp_footer();
                    ?>
                </body>
                </html>
                <?php
                exit;
    }
}