<?php
// includes/module-archive.php
if (!defined('ABSPATH')) exit;

function cms_render_archive($number = 8) {
    $query = new WP_Query(array(
        'post_type'      => 'post',
        'posts_per_page' => $number,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    ));

    if (!$query->have_posts()) {
        return;
    }

    $col_size = (int) ceil($number / 2); // chia đôi: 1-4 cột trái, 5-8 cột phải
    $i = 0;
    ?>
    <div class="cms-archive">
        <h3 class="cms-archive__title">Bài viết mới nhất</h3>

        <div class="cms-archive__columns">
            <?php while ($query->have_posts()) : $query->the_post();
                $i++;
                if ($i === 1 || $i === $col_size + 1) {
                    if ($i > 1) echo '</ul>';
                    echo '<ul class="cms-archive__col">';
                }
            ?>
                <li class="cms-archive__item">
                    <span class="cms-archive__number"><?php echo $i; ?></span>
                    <a class="cms-archive__link" href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </li>
            <?php endwhile; ?>
            </ul>
        </div>
    </div>
    <?php
    wp_reset_postdata();
}