<?php

if (!defined('ABSPATH')) {
    exit;
}

class Widget_Test_4 extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'widget_test_4',
            'Widget Test 4',
            array(
                'description' => 'Widget hiển thị bài viết nổi bật.'
            )
        );
    }

    /**
     * Lấy ảnh đầu tiên trong bài viết
     */
    private function get_first_image()
    {
        // 1. Nếu có Featured Image thì ưu tiên sử dụng
        if (has_post_thumbnail()) {
            return get_the_post_thumbnail_url(
                get_the_ID(),
                'large'
            );
        }

        // 2. Nếu không có Featured Image,
        // tìm ảnh đầu tiên trong nội dung bài viết
        $content = get_the_content();

        preg_match(
            '/<img[^>]+src=["\']([^"\']+)["\']/i',
            $content,
            $matches
        );

        // Có tìm thấy ảnh
        if (!empty($matches[1])) {
            return $matches[1];
        }

        // Không có ảnh
        return '';
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        $query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 5,
            'post_status'    => 'publish'
        ));

        if ($query->have_posts()) {

            $count = 0;

            while ($query->have_posts()) {

                $query->the_post();

                /*
                 * BÀI VIẾT ĐẦU TIÊN
                 */
                if ($count === 0) {

                    $image_url = $this->get_first_image();
?>

                    <div class="widget-test-4-featured">

                        <?php if ($image_url) : ?>

                            <div class="widget-test-4-image">

                                <a href="<?php the_permalink(); ?>">

                                    <img
                                        src="<?php echo esc_url($image_url); ?>"
                                        alt="<?php echo esc_attr(get_the_title()); ?>">

                                </a>

                            </div>

                        <?php endif; ?>

                        <h3>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                    </div>

                <?php
                }

                /*
                 * CÁC BÀI VIẾT CÒN LẠI
                 */ else {
                ?>

                    <div class="widget-test-4-item">

                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>

                        <span class="widget-test-4-count">
                            <?php echo esc_html($count); ?>
                        </span>

                    </div>

<?php
                }

                $count++;
            }

            wp_reset_postdata();
        }

        echo $args['after_widget'];
    }
}
