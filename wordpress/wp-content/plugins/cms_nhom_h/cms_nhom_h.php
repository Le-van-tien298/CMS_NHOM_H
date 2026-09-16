<?php
/*
Plugin Name: CMS NHOM H
Description: Plugin bán shop thời trang
Version: 1.0
Author: CMS NHOM H
*/
require_once plugin_dir_path(__FILE__) . 'database.php';
register_activation_hook(
    __FILE__,
    'cms_nhom_h_create_tables'
);
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
    ?>
                <div class="wrap">
                    <h1>CMS NHOM H - Shop thời trang</h1>
                    <p>Chào mừng bạn đến trang quản lý shop thời trang.</p>
                </div>
                <?php
}