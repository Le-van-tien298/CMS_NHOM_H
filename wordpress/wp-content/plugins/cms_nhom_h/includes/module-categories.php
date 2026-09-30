<?php
// includes/module-categories.php (hoặc đặt trong plugin cms_nhom_h)

function cms_nhom_h_render_categories_box()
{
    // Lấy toàn bộ category có bài viết (hoặc bỏ 'hide_empty' => 0 nếu muốn hiện cả mục chưa có bài)
    $categories = get_categories(array(
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => 0, // 0: Hiện cả danh mục chưa có bài; 1: Chỉ hiện mục đã có bài
    ));
    ?>
    <div class="cms-category-widget">
        <h3 class="widget-title">Categories</h3>
        <div class="widget-divider-pattern"></div>

        <ul class="category-list">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat):
                    // Bỏ qua category mặc định "Uncategorized" nếu không thích
                    if ($cat->slug === 'uncategorized')
                        continue;

                    // Lấy link dẫn tới trang lọc bài viết của category này
                    $category_link = get_category_link($cat->term_id);
                    ?>
                    <li class="category-item">
                        <span class="bullet-dot"></span>
                        <a href="<?php echo esc_url($category_link); ?>">
                            <?php echo esc_html($cat->name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Chưa có chuyên mục nào.</li>
            <?php endif; ?>
        </ul>
    </div>
    <?php
}

// Đăng ký Shortcode [cms_categories] để Pro thích chèn vào đâu (Sidebar, Footer, Page) cũng được
add_shortcode('cms_categories', 'cms_nhom_h_render_categories_box');