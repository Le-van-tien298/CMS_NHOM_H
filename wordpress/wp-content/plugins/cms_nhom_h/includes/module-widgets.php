<?php
if (!defined('ABSPATH')) {
    exit;
}

// 1. Đăng ký các Vùng Widget (Widget Areas) cho 3 cột
add_action('widgets_init', 'cms_nhom_h_register_sidebars');
function cms_nhom_h_register_sidebars() {
    register_sidebar(array(
        'name'          => 'Home - Cột Trái',
        'id'            => 'cms-home-left',
        'description'   => 'Kéo thả các module vào cột trái của trang Home.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
    ));

    register_sidebar(array(
        'name'          => 'Home - Cột Giữa',
        'id'            => 'cms-home-center',
        'description'   => 'Kéo thả module Content vào cột giữa của trang Home.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
    ));

    register_sidebar(array(
        'name'          => 'Home - Cột Phải',
        'id'            => 'cms-home-right',
        'description'   => 'Kéo thả các module vào cột phải của trang Home.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
    ));
}

// 2. Tạo Widget Archive
class CMS_Archive_Widget extends WP_Widget {
    function __construct() {
        parent::__construct('cms_archive_widget', 'CMS - Archive (Bài viết mới nhất)');
    }
    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (function_exists('cms_render_archive')) {
            cms_render_archive(8);
        }
        echo $args['after_widget'];
    }
}

// 3. Tạo Widget Comments
class CMS_Comments_Widget extends WP_Widget {
    function __construct() {
        parent::__construct('cms_comments_widget', 'CMS - Comments');
    }
    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo '<div class="cms-home-comments-wrapper">';
        echo '<h3 class="cms-home-comments-title">Comments</h3>';
        if (function_exists('cms_nhom_h_render_comments')) {
            cms_nhom_h_render_comments();
        }
        echo '</div>';
        echo $args['after_widget'];
    }
}

// 4. Tạo Widget Content (Danh sách bài viết)
class CMS_Content_Widget extends WP_Widget {
    function __construct() {
        parent::__construct('cms_content_widget', 'CMS - Content (Danh sách bài viết)');
    }
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        // Sử dụng main loop của trang hiện tại
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                // In ra định dạng card bài viết (do module-content.php quy định)
                echo get_the_excerpt();
            }
            
            echo '<div class="cms-home-pagination">';
            the_posts_pagination();
            echo '</div>';
        } else {
            echo '<p>Chưa có bài viết nào.</p>';
        }
        
        echo $args['after_widget'];
    }
}

// 5. Tạo Widget Categories (Để dùng cho cả trang chi tiết nếu thích)
class CMS_Categories_Widget extends WP_Widget {
    function __construct() {
        parent::__construct('cms_categories_widget', 'CMS - Categories');
    }
    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (function_exists('cms_nhom_h_render_categories_box')) {
            cms_nhom_h_render_categories_box();
        }
        echo $args['after_widget'];
    }
}

// Kích hoạt tất cả các Widget trên
add_action('widgets_init', function() {
    register_widget('CMS_Archive_Widget');
    register_widget('CMS_Comments_Widget');
    register_widget('CMS_Content_Widget');
    register_widget('CMS_Categories_Widget');
});
