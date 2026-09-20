<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<header class="cms-header">
    <div class="cms-header-container">

        <!-- Logo -->
        <a class="cms-header-logo" href="<?php echo esc_url(home_url('/')); ?>">
            Nhom H
        </a>

        <!-- Home -->
        <a class="cms-header-home" href="<?php echo esc_url(home_url('/')); ?>">
            Home
        </a>

        <!-- Search form -->
        <form class="cms-header-search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">

            <input type="search" name="s" placeholder="Search" value="<?php echo esc_attr(get_search_query()); ?>">

            <button type="submit">
                Submit
            </button>
        </form>

        <!-- Menu chính -->
        <nav class="cms-header-menu">

            <a href="<?php echo esc_url(home_url('/the-thao')); ?>">
                Thể thao
            </a>

            <a href="<?php echo esc_url(home_url('/khoa-hoc')); ?>">
                Khoa học
            </a>

            <a href="<?php echo esc_url(home_url('/tin-tuc')); ?>">
                Tin tức
            </a>

        </nav>

        <!-- Menu icon -->
        <a class="cms-header-menu-icon" href="<?php echo esc_url(home_url('/menu')); ?>">

            <span class="cms-dots"><i class="fa-solid fa-ellipsis"></i></span>
            <small>Menu</small>

        </a>

        <!-- Search icon -->
        <button
            type="button"
            class="cms-header-search-icon cms-header-search-button"
            id="cms-search-toggle"
            aria-label="Mở tìm kiếm"
        >
            <span><i class="fa-solid fa-magnifying-glass"></i></span>
            <small>Search</small>
        </button>

        <!-- Account -->
        <a class="cms-header-account" href="<?php echo esc_url(wp_login_url()); ?>">

            <span class="cms-account-icon"><i class="fa-solid fa-user"></i></span>
            <small>Account</small>

        </a>

    </div>

    <!-- Dropdown search box -->
    <?php if (function_exists('cms_nhom_h_search_shortcode')) {
        echo cms_nhom_h_search_shortcode();
    } ?>
</header>