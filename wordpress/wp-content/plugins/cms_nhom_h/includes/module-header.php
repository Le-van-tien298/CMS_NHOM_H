<?php
// includes/module-header.php

function cms_render_module_header()
{
    $account_link = is_user_logged_in() ? admin_url('profile.php') : wp_login_url();
    ?>
        <header class="site-header-pill">
            <div class="header-card">
                <!-- 1. Logo -->
                <div class="brand-logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php
                        if (has_custom_logo()) {
                            the_custom_logo();
                        } else {
                            echo '<span>' . esc_html(get_bloginfo('name')) . '</span>';
                        }
                    ?>
                </a>
            </div>

            <!-- 2. Ô tìm kiếm Inline -->
            <div class="header-search-inline">
                <?php render_custom_search_inline(); ?>
            </div>
            
            <!-- 3. Menu ngang chính -->
            <nav class="header-navigation">
                <?php
                if (has_nav_menu('cms_header_menu')) {
                    wp_nav_menu([
                        'theme_location' => 'cms_header_menu',
                        'container' => false,
                        'menu_class' => 'header-nav-list',
                    ]);
                } else {
                    echo '<ul class="header-nav-list"><li><a href="' . esc_url(home_url('/')) . '" class="active">Home</a></li></ul>';
                }
                ?>
            </nav>

            <!-- 4. Nhóm Action Icons góc phải -->
            <div class="header-actions">
                <!-- Nút ... Menu để mở Drawer -->
                <button type="button" class="action-btn" id="btn-toggle-menu" title="Menu">
                    <i class="fa-solid fa-ellipsis"></i>
                    <span>Menu</span>
                </button>
                <!-- Nút Search để mở ô tìm kiếm to -->
                <button type="button" class="action-btn" id="btn-toggle-search" title="Search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>Search</span>
                </button>
                <!-- Nút Account -->
                <a href="<?php echo esc_url($account_link); ?>" class="action-btn" title="Account">
                    <i class="fa-solid fa-user"></i>
                    <span>Account</span>
                </a>
            </div>
            </div>
            
            <!-- 5. Popup Search to trượt xuống -->
            <?php render_custom_search_dropdown(); ?>
            
            <!-- 6. KHUNG SIDEBAR DRAWER TRƯỢT TỪ BÊN PHẢI RA -->
            <div id="cms-menu-drawer" class="menu-drawer">
                <div class="drawer-header">
                    <h3>Danh mục mở rộng</h3>
                    <button type="button" id="btn-close-drawer" class="btn-close-drawer" aria-label="Đóng menu">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            
                <div class="drawer-body">
                    <nav class="drawer-navigation">
                        <?php
                        // Ưu tiên load menu 'cms_sidebar_menu', nếu admin chưa tạo thì fallback lấy chung menu header
                        if (has_nav_menu('cms_sidebar_menu')) {
                            wp_nav_menu([
                                'theme_location' => 'cms_sidebar_menu',
                                'container' => false,
                                'menu_class' => 'drawer-nav-list',
                            ]);
                        } elseif (has_nav_menu('cms_header_menu')) {
                            wp_nav_menu([
                                'theme_location' => 'cms_header_menu',
                                'container' => false,
                                'menu_class' => 'drawer-nav-list',
                            ]);
                        }
                    ?>
                </nav>
            </div>
        </div>

        <!-- Lớp phủ mờ nền khi bật menu -->
        <div id="cms-drawer-overlay" class="drawer-overlay"></div>
    </header>
    <?php
}