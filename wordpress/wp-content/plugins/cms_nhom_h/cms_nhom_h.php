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
require_once CMS_NHOM_H_PATH . 'database.php';

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
    // CSS chung
    wp_enqueue_style(
        'cms-nhom-h-style',
        CMS_NHOM_H_URL . 'assets/css/style.css',
        array(),
        '1.0.5'
    );

    // CSS riêng cho header
    wp_enqueue_style(
        'cms-nhom-h-header',
        CMS_NHOM_H_URL . 'assets/css/header.css',
        array('cms-nhom-h-style'),
        '1.0.0'
    );
}

add_action(
    'wp_enqueue_scripts',
    'cms_nhom_h_enqueue_assets'
);