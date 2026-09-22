<?php

if (!defined('ABSPATH')) {
    exit;
}

function cms_prev_next_posts() {

    $prev_post = get_previous_post();
    $next_post = get_next_post();

    if (!$prev_post && !$next_post) {
        return;
    }

    ?>

    <div class="cms-prev-next-list">

        <?php if ($prev_post): ?>

            <a
                class="cms-prev-next-row"
                href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>"
            >

                <div class="cms-prev-next-date">

                    <span class="cms-date-day">
                        <?php echo get_the_date('d', $prev_post->ID); ?>
                    </span>

                    <span class="cms-date-month">
                        <?php echo get_the_date('m', $prev_post->ID); ?>
                    </span>

                    <span class="cms-date-year">
                        <?php echo get_the_date('y', $prev_post->ID); ?>
                    </span>

                </div>

                <div class="cms-prev-next-title">
                    <?php echo esc_html(get_the_title($prev_post->ID)); ?>
                </div>

            </a>

        <?php endif; ?>


        <?php if ($next_post): ?>

            <a
                class="cms-prev-next-row"
                href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"
            >

                <div class="cms-prev-next-date">

                    <span class="cms-date-day">
                        <?php echo get_the_date('d', $next_post->ID); ?>
                    </span>

                    <span class="cms-date-month">
                        <?php echo get_the_date('m', $next_post->ID); ?>
                    </span>

                    <span class="cms-date-year">
                        <?php echo get_the_date('y', $next_post->ID); ?>
                    </span>

                </div>

                <div class="cms-prev-next-title">
                    <?php echo esc_html(get_the_title($next_post->ID)); ?>
                </div>

            </a>

        <?php endif; ?>

    </div>

    <?php
}