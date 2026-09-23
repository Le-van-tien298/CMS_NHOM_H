<?php
/**
 * module-comment.php
 * CHỈ chứa hàm xử lý khi submit "Make a Post".
 * File này an toàn để require_once sớm ở đầu cms_nhom_h.php vì
 * is_user_logged_in() chỉ được gọi BÊN TRONG hàm callback (chạy trễ,
 * lúc admin_post hook thực sự kích hoạt), không chạy ngay khi require.
 */

if (!defined('ABSPATH')) exit;

if (!function_exists('cms_nhom_h_handle_submit_post')) {

    add_action('admin_post_cms_nhom_h_submit_post', 'cms_nhom_h_handle_submit_post');

    function cms_nhom_h_handle_submit_post() {

        if (!is_user_logged_in()) {
            wp_die('Bạn cần đăng nhập để đăng bài.');
        }

        if (
            !isset($_POST['cms_nhom_h_post_nonce_field']) ||
            !wp_verify_nonce($_POST['cms_nhom_h_post_nonce_field'], 'cms_nhom_h_post_nonce')
        ) {
            wp_die('Yêu cầu không hợp lệ.');
        }

        $content = isset($_POST['post_content'])
            ? sanitize_textarea_field($_POST['post_content'])
            : '';

        if (!empty($content)) {
            wp_insert_post(array(
                'post_title'   => wp_trim_words($content, 8, '...'),
                'post_content' => $content,
                'post_status'  => 'publish',
                'post_author'  => get_current_user_id(),
                'post_type'    => 'post',
            ));
        }

        $redirect = isset($_POST['cms_redirect']) ? esc_url_raw($_POST['cms_redirect']) : home_url();
        wp_safe_redirect($redirect);
        exit;
    }
}
