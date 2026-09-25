<?php

/**
 * Plugin Name: CMS NHOM H
 * Description: Plugin bán shop thời trang
 * Version: 1.0
 * Author: CMS NHOM H
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

// Đường dẫn plugin
define('CMS_NHOM_H_PATH', plugin_dir_path(__FILE__));
define('CMS_NHOM_H_URL', plugin_dir_url(__FILE__));

// Load database & các module
require_once CMS_NHOM_H_PATH . 'database.php';
require_once CMS_NHOM_H_PATH . 'includes/module-content.php';
require_once CMS_NHOM_H_PATH . 'includes/module-prev-next.php';
require_once CMS_NHOM_H_PATH . 'includes/module-recent-post.php';
require_once CMS_NHOM_H_PATH . 'includes/widget_test_4.php';

require_once CMS_NHOM_H_PATH . 'includes/module-header.php';
require_once CMS_NHOM_H_PATH . 'includes/module-search.php';
require_once CMS_NHOM_H_PATH . 'includes/module-archive.php';
require_once CMS_NHOM_H_PATH . 'includes/module-comment.php';

function cms_nhom_h_register_widget()
{
    register_widget('Widget_Test_4');
}

add_action('widgets_init', 'cms_nhom_h_register_widget');
function cms_nhom_h_register_footer_widget()
{
    register_sidebar(array(
        'name'          => 'Widget trước Footer',
        'id'            => 'cms-before-footer',
        'description'   => 'Widget hiển thị ngay phía trên Footer',
        'before_widget' => '<div id="%1$s" class="cms-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}

add_action('widgets_init', 'cms_nhom_h_register_footer_widget');
add_action('wp_footer', 'cms_nhom_h_render_archive_section');

function cms_nhom_h_render_archive_section()
{
    if (function_exists('cms_render_archive')) {
        cms_render_archive(8);
    }
}

/* ==========================================================================
   1. ĐĂNG KÝ VỊ TRÍ MENU TRONG ADMIN (Để quản lý menu kéo-thả)
   ========================================================================== */
add_action('after_setup_theme', 'cms_nhom_h_register_menus');
// cms_nhom_h.php
add_action('init', 'cms_nhom_h_register_menus');
function cms_nhom_h_register_menus()
{
    register_nav_menus(array(
        'cms_header_menu' => 'Menu Chính Trên Header (Hiển thị ngang)',
        'cms_sidebar_menu' => 'Menu Mở Rộng (... Menu Drawer)',
    ));
}
add_action('wp_footer', 'cms_nhom_h_display_recent_posts');
function cms_nhom_h_display_recent_posts()
{
    if (!is_home() && !is_front_page() && !is_archive()) {
        return;
    }

    cms_nhom_h_render_recent_posts(3);
}
/* ==========================================================================
   2. RENDER HEADER & FOOTER
   ========================================================================== */
// Tự động gắn Header vào ngay sau thẻ <body> mở
add_action('wp_body_open', 'cms_nhom_h_render_header');
function cms_nhom_h_render_header()
{
    // Hàm này sẽ nằm trong file includes/module-header.php
    if (function_exists('cms_render_module_header')) {
        cms_render_module_header();
    }
}

// Gắn Footer
add_action('wp_footer', 'cms_nhom_h_render_footer');

function cms_nhom_h_render_footer()
{
    // Widget trước footer
    if (is_active_sidebar('cms-before-footer')) {
?>

        <section class="cms-before-footer">
            <?php dynamic_sidebar('cms-before-footer'); ?>
        </section>

    <?php
    }

    // Footer
    require CMS_NHOM_H_PATH . 'includes/module-footer.php';
}
/* ==========================================================================
   3. XỬ LÝ NỘI DUNG BÀI VIẾT & COMMENT
   ========================================================================== */




add_filter('the_content', 'cms_nhom_h_render_detail');
function cms_nhom_h_render_detail($content)
{
    if (is_single() && in_the_loop() && is_main_query()) {
        $cms_post_content = $content;
        ob_start();
        require CMS_NHOM_H_PATH . 'includes/module-detail.php';
        return ob_get_clean();
    }
    return $content;
}
add_filter('comments_template', 'cms_nhom_h_override_comments_template');
function cms_nhom_h_override_comments_template($theme_template)
{
    if (is_singular()) {
        return CMS_NHOM_H_PATH . 'includes/comments-template.php';   // ← đổi file ở đây
    }
    return $theme_template;
}

/* ==========================================================================
   4. TẠO DATABASE KHI KÍCH HOẠT
   ========================================================================== */
register_activation_hook(__FILE__, 'cms_nhom_h_create_tables');

/* ==========================================================================
   5. TRANG QUẢN TRỊ ADMIN - CẤU HÌNH HEADER & TÌM KIẾM
   (Sửa ở đây là ngoài web tự đổi, không cần đụng tới HTML/Code nữa!)
   ========================================================================== */
add_action('admin_menu', 'cms_nhom_h_add_menu');
function cms_nhom_h_add_menu()
{
    add_menu_page(
        'CMS NHOM H',
        'CMS NHOM H',
        'manage_options',
        'cms-nhom-h',
        'cms_nhom_h_admin_page',
        'dashicons-store',
        25
    );
}

function cms_nhom_h_admin_page()
{
    // Xử lý lưu dữ liệu khi nhấn Lưu
    if (isset($_POST['cms_save_settings']) && check_admin_referer('cms_settings_verify')) {
        update_option('cms_header_hotline', sanitize_text_field($_POST['cms_header_hotline']));
        update_option('cms_header_notice', sanitize_text_field($_POST['cms_header_notice']));
        update_option('cms_search_placeholder', sanitize_text_field($_POST['cms_search_placeholder']));
        echo '<div class="notice notice-success is-dismissible"><p><strong>Đã lưu cài đặt thành công!</strong></p></div>';
    }

    // Lấy dữ liệu từ Database ra form
    $hotline = get_option('cms_header_hotline', '0901 234 567');
    $notice = get_option('cms_header_notice', 'Miễn phí giao hàng cho đơn từ 500k!');
    $placeholder = get_option('cms_search_placeholder', 'Tìm kiếm quần áo, phụ kiện thời trang...');
    ?>
    <div class="wrap">
        <h1>Quản lý Cấu hình Shop Thời Trang</h1>
        <p>Tùy chỉnh nội dung Header & Tìm kiếm mà không cần can thiệp mã nguồn.</p>

        <form method="post" action="">
            <?php wp_nonce_field('cms_settings_verify'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="cms_header_notice">Thông báo đầu trang (Top Bar)</label></th>
                    <td>
                        <input name="cms_header_notice" type="text" id="cms_header_notice"
                            value="<?php echo esc_attr($notice); ?>" class="large-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cms_header_hotline">Số điện thoại Hotline</label></th>
                    <td>
                        <input name="cms_header_hotline" type="text" id="cms_header_hotline"
                            value="<?php echo esc_attr($hotline); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cms_search_placeholder">Placeholder ô tìm kiếm</label></th>
                    <td>
                        <input name="cms_search_placeholder" type="text" id="cms_search_placeholder"
                            value="<?php echo esc_attr($placeholder); ?>" class="large-text">
                        <p class="description">Đoạn chữ hiển thị mờ trong ô search trước khi khách gõ chữ.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button('Lưu cài đặt', 'primary', 'cms_save_settings'); ?>
        </form>
    </div>
<?php
}

/* ==========================================================================
   6. NẠP ASSETS (CSS & JS)
   ========================================================================== */
add_action('wp_enqueue_scripts', 'cms_nhom_h_enqueue_assets');
function cms_nhom_h_enqueue_assets()
{
    wp_enqueue_style('font-awesome-6', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    wp_enqueue_style('cms-nhom-h-style', CMS_NHOM_H_URL . 'assets/css/style.css', array(), '1.0.5');
    wp_enqueue_style('cms-nhom-h-header', CMS_NHOM_H_URL . 'assets/css/header.css', array('cms-nhom-h-style'), '1.3.0');
    wp_enqueue_style('cms-nhom-h-search', CMS_NHOM_H_URL . 'assets/css/search.css', array('cms-nhom-h-header'), '1.3.0');
    wp_enqueue_style('cms-nhom-h-footer', CMS_NHOM_H_URL . 'assets/css/footer.css', array('cms-nhom-h-header'), '1.3.0');
    wp_enqueue_style('cms-nhom-h-comment', CMS_NHOM_H_URL . 'assets/css/comment.css', array('cms-nhom-h-style'), '1.0.0');
    wp_enqueue_style('cms-nhom-h-archive', CMS_NHOM_H_URL . 'assets/css/archive.css', array('cms-nhom-h-style'), '1.0.0');
    wp_enqueue_style('cms-prev-next', CMS_NHOM_H_URL . 'assets/css/prev-next.css', array(), '1.0');
    wp_enqueue_style('cms-recent-post', CMS_NHOM_H_URL . 'assets/css/recent-post.css', [], '1.0');
    wp_enqueue_style('widget_test_4', CMS_NHOM_H_URL . 'assets/css/widget.css', array(), '1.0');
    wp_enqueue_script('cms-nhom-h-search', CMS_NHOM_H_URL . 'assets/js/search.js', array(), '1.3.0', true);
}
