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

// Load module

require_once CMS_NHOM_H_PATH . 'includes/module-content.php';
require_once CMS_NHOM_H_PATH . 'includes/module-header.php';
require_once CMS_NHOM_H_PATH . 'includes/module-search.php';
require_once CMS_NHOM_H_PATH . 'database.php';
add_action('wp_footer', 'cms_nhom_h_render_footer');

function cms_nhom_h_render_footer()
{
    require CMS_NHOM_H_PATH . 'includes/module-footer.php';
}
// Comment
add_filter('the_content', 'cms_nhom_h_add_comment_module');

function cms_nhom_h_add_comment_module($content)
{
    if (!is_singular()) {
        return $content;
    }

    if (!comments_open()) {
        return $content;
    }

    ob_start();

    require CMS_NHOM_H_PATH . 'includes/module-comment.php';

    $comment_module = ob_get_clean();

    return $content . $comment_module;
}

// Tạo database khi kích hoạt plugin
register_activation_hook(
    __FILE__,
    'cms_nhom_h_create_tables'
);

// Tạo menu trong Admin
add_action(
    'admin_menu',
    'cms_nhom_h_add_menu'
);

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

// Trang quản trị plugin
function cms_nhom_h_admin_page()
{
?>
    <div class="wrap">
        <h1>CMS NHOM H - Shop thời trang</h1>

        <p>
            Chào mừng bạn đến trang quản lý shop thời trang.
        </p>
    </div>
<?php
}

// Nạp CSS frontend
function cms_nhom_h_enqueue_assets()
{
    // Font Awesome 6 CDN
    wp_enqueue_style(
        'font-awesome-6',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    // CSS chung
    wp_enqueue_style(
        'cms-nhom-h-style',
        CMS_NHOM_H_URL . 'assets/css/style.css',
        array(),
        '1.0.5'
    );

    // CSS header
    wp_enqueue_style(
        'cms-nhom-h-header',
        CMS_NHOM_H_URL . 'assets/css/header.css',
        array('cms-nhom-h-style'),
        '1.3.0'
    );

    // CSS search
    wp_enqueue_style(
        'cms-nhom-h-search',
        CMS_NHOM_H_URL . 'assets/css/search.css',
        array('cms-nhom-h-header'),
        '1.3.0'
    );

    // CSS footer
    wp_enqueue_style(
        'cms-nhom-h-footer',
        CMS_NHOM_H_URL . 'assets/css/footer.css',
        array('cms-nhom-h-header'),
        '1.3.0'
    );
    // CSS comment
    wp_enqueue_style(
        'cms-nhom-h-comment',
        CMS_NHOM_H_URL . 'assets/css/comment.css',
        array('cms-nhom-h-style'),
        '1.0.0'
    );
  

    // JavaScript search
    wp_enqueue_script(
        'cms-nhom-h-search',
        CMS_NHOM_H_URL . 'assets/js/search.js',
        array(),
        '1.3.0',
        true
    );
}

add_action(
    'wp_enqueue_scripts',
    'cms_nhom_h_enqueue_assets'
);
