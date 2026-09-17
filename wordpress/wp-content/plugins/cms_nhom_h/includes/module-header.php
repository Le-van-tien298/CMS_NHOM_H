<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hiển thị Header
 */
function cms_nhom_h_render_header()
{
    include plugin_dir_path(dirname(__FILE__))
        . 'templates/header.php';
}

/**
 * Tự động hiển thị Header
 */
function cms_nhom_h_auto_header()
{
    cms_nhom_h_render_header();
}

add_action(
    'wp_body_open',
    'cms_nhom_h_auto_header'
);