<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hiển thị module tìm kiếm
 */
function cms_nhom_h_search_shortcode()
{
    ob_start();
    ?>

    <section id="cms-search-box" class="cms-search-box">

        <form class="cms-search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">

            <span class="cms-search-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>

            <input type="search" name="s" placeholder="Search topics or keywords" aria-label="Search topics or keywords">

            <button type="submit">
                Search
            </button>

        </form>

    </section>

    <?php
    return ob_get_clean();
}

add_shortcode(
    'cms_search',
    'cms_nhom_h_search_shortcode'
);