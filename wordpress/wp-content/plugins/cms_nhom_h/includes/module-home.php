<?php
// includes/module-home.php
if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="cms-home-container">
    <!-- CỘT TRÁI (Widget Area) -->
    <aside class="cms-home-archive">
        <?php 
        if (is_active_sidebar('cms-home-left')) {
            dynamic_sidebar('cms-home-left');
        } else {
            echo '<p>Vào wp-admin > Appearance > Widgets để kéo Widget vào Cột Trái.</p>';
        }
        ?>
    </aside>

    <!-- CỘT GIỮA (Widget Area) -->
    <main class="cms-home-content">
        <?php
        if (is_active_sidebar('cms-home-center')) {
            dynamic_sidebar('cms-home-center');
        } else {
            echo '<p>Vào wp-admin > Appearance > Widgets để kéo Widget "CMS - Content" vào Cột Giữa.</p>';
        }
        ?>
    </main>

    <!-- CỘT PHẢI (Widget Area) -->
    <aside class="cms-home-comments">
        <?php
        if (is_active_sidebar('cms-home-right')) {
            dynamic_sidebar('cms-home-right');
        } else {
            echo '<p>Vào wp-admin > Appearance > Widgets để kéo Widget vào Cột Phải.</p>';
        }
        ?>
    </aside>
</div>

<style>
/* CSS cơ bản tạo layout 3 cột */
.cms-home-container {
    display: flex;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 40px auto;
    gap: 3%;
    padding: 0 15px;
    align-items: flex-start;
}
.cms-home-archive { width: 22%; }
.cms-home-content { width: 48%; }
.cms-home-comments { width: 24%; }

.cms-home-comments-wrapper {
    background: #fdfdfd;
    padding: 20px;
    border: 1px solid #eee;
}
.cms-home-comments-title {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    margin-top: 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

@media (max-width: 991px) {
    .cms-home-container { gap: 20px; }
    .cms-home-archive, .cms-home-content, .cms-home-comments { width: 100%; }
}
</style>

<?php wp_footer(); ?>
</body>
</html>
