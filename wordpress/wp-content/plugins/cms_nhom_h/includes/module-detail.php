<?php

if (!defined('ABSPATH')) {
    exit;
}

$post_id = get_the_ID();

$title = get_the_title($post_id);

$day = get_the_date('d', $post_id);
$month = get_the_date('m', $post_id);
$year = get_the_date('y', $post_id);

$author = get_the_author_meta(
    'display_name',
    get_post_field('post_author', $post_id)
);

?>

<article class="cms-detail">

    <!-- HEADER -->
    <div class="cms-detail-header">

        <h1 class="cms-detail-title">
            <?php echo esc_html($title); ?>
        </h1>

        <!-- DATE -->
        <div class="cms-detail-date">

            <div class="cms-date-left">
                <span class="cms-detail-day">
                    <?php echo esc_html($day); ?>
                </span>

                <span class="cms-detail-month">
                    <?php echo esc_html($month); ?>
                </span>
            </div>

            <div class="cms-date-divider"></div>

            <div class="cms-date-right">
                <span class="cms-detail-year">
                    20<?php echo esc_html($year); ?>
                </span>
            </div>

        </div>

    </div>


    <!-- LINE -->
    <div class="cms-detail-line"></div>


    <!-- POST CONTENT -->
    <div class="cms-detail-content">

        <?php echo $cms_post_content; ?>

    </div>


    <!-- AUTHOR -->
    <div class="cms-detail-author">

        (Theo <?php echo esc_html($author); ?>)

    </div>

</article>