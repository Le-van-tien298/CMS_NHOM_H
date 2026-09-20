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

// CHẶN GIAO DIỆN THỪA CỦA THEME & RENDER KẾT QUẢ ĐỒNG BỘ TRANG CHỦ
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
                        /* KHUNG CARD CHUẨN TDC NHƯ ẢNH MẪU */
                        .cms-tdc-card {
                            background: #ffffff;
                            border: 1px solid #e5e7eb;
                            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
                            display: flex;
                            align-items: center;
                            padding: 24px 30px;
                            box-sizing: border-box;
                            transition: all 0.2s ease;
                        }
                        .cms-tdc-card:hover {
                            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                            transform: translateY(-2px);
                        }
                        /* Cột ngày tháng to bên trái */
                        .cms-tdc-date {
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            min-width: 90px;
                            text-align: center;
                        }
                        .cms-tdc-date .day-number {
                            font-size: 46px;
                            font-weight: 700;
                            line-height: 1;
                            color: #111827;
                            font-family: Georgia, "Times New Roman", serif;
                        }
                        .cms-tdc-date .month-text {
                            font-size: 13px;
                            font-weight: 600;
                            color: #6b7280;
                            margin-top: 6px;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        }
                        /* Vạch đứng ngăn cách */
                        .cms-tdc-divider {
                            width: 1px;
                            height: 65px;
                            background-color: #d1d5db;
                            margin: 0 30px;
                            flex-shrink: 0;
                        }
                        /* Nội dung tiêu đề & mô tả bên phải */
                        .cms-tdc-info {
                            flex: 1;
                        }
                        .cms-tdc-title {
                            margin: 0 0 6px 0;
                            font-size: 20px;
                            font-weight: 700;
                        }
                        .cms-tdc-title a {
                            color: #0284c7;
                            text-decoration: none;
                        }
                        .cms-tdc-title a:hover {
                            text-decoration: underline;
                        }
                        .cms-tdc-desc {
                            font-size: 14px;
                            color: #6b7280;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            margin: 0;
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
                                        $search_query->the_post(); ?>
                                            <div class="cms-tdc-card">
                                                <!-- Khối ngày tháng số to -->
                                                <div class="cms-tdc-date">
                                                    <span class="day-number"><?php echo get_the_date('d'); ?></span>
                                                    <span class="month-text">THÁNG <?php echo get_the_date('m'); ?></span>
                                                </div>

                                                <!-- Vạch ngăn cách đứng -->
                                                <div class="cms-tdc-divider"></div>

                                                <!-- Tiêu đề xanh & chữ mô tả xám in hoa -->
                                                <div class="cms-tdc-info">
                                                    <h3 class="cms-tdc-title">
                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                    </h3>
                                                    <p class="cms-tdc-desc">
                                                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '...')); ?>
                                                    </p>
                                                </div>
                                            </div>
                                    <?php endwhile;
                                    wp_reset_postdata(); ?>
                            <?php else: ?>
                                    <div class="no-result-box">
                                        <p>Không tìm thấy bài viết nào phù hợp với từ khóa "<?php echo esc_html($keyword); ?>"!</p>
                                    </div>
                            <?php endif; ?>
                        </div>
                    </main>

                    <?php
                    if (function_exists('cms_nhom_h_render_footer')) {
                        cms_nhom_h_render_footer();
                    }
                    wp_footer();
                    ?>
                </body>
                </html>
                <?php
                exit;
    }
}