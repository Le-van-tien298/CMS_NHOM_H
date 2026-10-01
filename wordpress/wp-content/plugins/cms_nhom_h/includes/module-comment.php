<?php
/**
 * module-comments.php  (đã gom module-comment.php cũ vào đây)
 *
 * PHẦN A: xử lý submit "Make a Post" (code có sẵn của nhóm, giữ nguyên).
 *         is_user_logged_in() chỉ gọi BÊN TRONG hàm callback (chạy trễ khi
 *         admin_post hook kích hoạt) nên an toàn để require_once sớm.
 * PHẦN B: hiển thị danh sách comments dạng cây + form bình luận.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ==========================================================================
   PHẦN A - MAKE A POST (giữ nguyên)
   ========================================================================== */
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

/* ==========================================================================
   PHẦN B - COMMENTS (avatar + khung, reply thụt vào)
   ========================================================================== */
// 0. Tự nạp CSS của module (có filemtime để trình duyệt luôn lấy bản mới)
function cms_nhom_h_comments_assets() {
    $css_file = dirname( __DIR__ ) . '/assets/css/comments.css';
    $css_url  = defined( 'CMS_NHOM_H_URL' )
        ? CMS_NHOM_H_URL . 'assets/css/comments.css'
        : plugins_url( 'assets/css/comments.css', dirname( __DIR__ ) . '/cms_nhom_h.php' );

    wp_enqueue_style(
        'cms-comments-module',
        $css_url,
        array(),
        file_exists( $css_file ) ? filemtime( $css_file ) : '1.0'
    );

    if ( get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'cms_nhom_h_comments_assets', 30 );

// 1. Callback vẽ từng comment
function cms_nhom_h_comments_item( $comment, $args, $depth ) {
    ?>
    <div id="comment-<?php comment_ID(); ?>" class="cms-comments-item">
        <div class="cms-comments-item__row">
            <div class="cms-comments-item__avatar">
                <?php echo get_avatar( $comment, 32, 'mm' ); ?>
            </div>
            <div class="cms-comments-item__box">
                <div class="cms-comments-item__header">
                    <span class="cms-comments-item__name"><?php comment_author(); ?></span>
                    <?php
                    comment_reply_link( array_merge( $args, array(
                        'depth'      => $depth,
                        'max_depth'  => $args['max_depth'],
                        'reply_text' => 'Reply',
                        'before'     => '<span class="cms-comments-item__reply">',
                        'after'      => '</span>',
                    ) ) );
                    ?>
                </div>
                <div class="cms-comments-item__body">
                    <?php comment_text(); ?>
                </div>
            </div>
        </div>
    <?php
    // Không đóng </div> ngoài cùng (.cms-comments-item): WordPress tự đóng sau khi in các comment con.
}

// 2. Hàm render module (đặt phía trên Footer)
function cms_nhom_h_render_comments() {
    if ( is_singular() ) {
        $post_id = get_queried_object_id();
    } else {
        $latest  = get_posts( array( 'numberposts' => 1 ) );
        $post_id = $latest ? $latest[0]->ID : 0;
    }
    if ( ! $post_id ) return;

    $comments = get_comments( array(
        'post_id' => $post_id,
        'status'  => 'approve',
        'order'   => 'ASC',
    ) );

    echo '<section class="cms-comments-list">';

    wp_list_comments( array(
        'callback'  => 'cms_nhom_h_comments_item',
        'style'     => 'div',
        'max_depth' => 3,
    ), $comments );

    global $post;
    $post = get_post( $post_id );
    setup_postdata( $post );
    comment_form( array( 'title_reply' => 'Leave a comment' ), $post_id );
    wp_reset_postdata();

    echo '</section>';
}