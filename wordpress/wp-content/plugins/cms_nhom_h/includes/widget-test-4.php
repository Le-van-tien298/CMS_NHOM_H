<?php

if (! defined('ABSPATH')) {
    exit;
}


/**
 * =========================================================
 * Widget Test 4
 * =========================================================
 */
class Widget_Test_4 extends WP_Widget
{


    public function __construct()
    {

        parent::__construct(
            'widget_test_4',
            'Widget Test 4',
            array(
                'description' => 'Hiển thị các bài viết mới nhất phía trên Footer.',
            )
        );
    }


    /**
     * =====================================================
     * FRONTEND
     * =====================================================
     */
    public function widget($args, $instance)
    {

        echo $args['before_widget'];


        /*
         * -------------------------------------------------
         * Lấy 3 bài viết mới nhất
         * -------------------------------------------------
         */

        $query = new WP_Query(
            array(
                'post_type'           => 'post',
                'post_status'         => 'publish',
                'posts_per_page'      => 3,
                'ignore_sticky_posts' => false,
                'orderby'             => 'date',
                'order'               => 'DESC',
            )
        );


        if (! $query->have_posts()) {

            echo $args['after_widget'];

            return;
        }


        /*
         * -------------------------------------------------
         * Lấy dữ liệu bài viết
         * -------------------------------------------------
         */

        $posts = $query->posts;


        /*
         * Bài gần nhất = bài nổi bật
         */
        $main_post = $posts[0];


        /*
         * 2 bài tiếp theo
         */
        $side_posts = array_slice($posts, 1);


        /*
         * =================================================
         * ẢNH BÀI CHÍNH
         * =================================================
         */

        $main_image = get_the_post_thumbnail_url(
            $main_post->ID,
            'large'
        );



        /*
         * =================================================
         * HTML
         * =================================================
         */

?>

        <section class="widget-test-4">


            <div class="widget-test-4-grid">


                <!-- =====================================
                     BÀI NỔI BẬT
                     ===================================== -->

                <article class="widget-test-4-feature">


                    <?php if ($main_image) : ?>

                        <a
                            class="widget-test-4-feature-image"
                            href="<?php echo esc_url(
                                        get_permalink($main_post->ID)
                                    ); ?>">

                            <img
                                src="<?php echo esc_url($main_image); ?>"
                                alt="<?php echo esc_attr(
                                            get_the_title($main_post->ID)
                                        ); ?>"
                                loading="lazy">

                        </a>

                    <?php endif; ?>


                    <div class="widget-test-4-feature-content">


                        <h2>

                            <a
                                href="<?php echo esc_url(
                                            get_permalink($main_post->ID)
                                        ); ?>">

                                <?php
                                echo esc_html(
                                    get_the_title($main_post->ID)
                                );
                                ?>

                            </a>

                        </h2>


                        <p>

                            <?php

                            echo esc_html(
                                $this->get_post_excerpt(
                                    $main_post->ID
                                )
                            );

                            ?>

                        </p>


                    </div>


                </article>



                <!-- =====================================
                     2 BÀI PHỤ
                     ===================================== -->

                <div class="widget-test-4-list">


                    <?php foreach ($side_posts as $side_post) : ?>


                        <?php

                        $side_image = get_the_post_thumbnail_url(
                            $side_post->ID,
                            'large'
                        );

                        ?>


                        <article class="widget-test-4-card">


                            <?php if ($side_image) : ?>

                                <a
                                    class="widget-test-4-card-image"
                                    href="<?php echo esc_url(
                                                get_permalink(
                                                    $side_post->ID
                                                )
                                            ); ?>">

                                    <img
                                        src="<?php echo esc_url(
                                                    $side_image
                                                ); ?>"
                                        alt="<?php echo esc_attr(
                                                    get_the_title(
                                                        $side_post->ID
                                                    )
                                                ); ?>"
                                        loading="lazy">

                                </a>

                            <?php endif; ?>


                            <div class="widget-test-4-card-content">


                                <h3>

                                    <a
                                        href="<?php echo esc_url(
                                                    get_permalink(
                                                        $side_post->ID
                                                    )
                                                ); ?>">

                                        <?php

                                        echo esc_html(
                                            get_the_title(
                                                $side_post->ID
                                            )
                                        );

                                        ?>

                                    </a>

                                </h3>


                            </div>


                        </article>


                    <?php endforeach; ?>


                </div>


            </div>


        </section>


    <?php


        wp_reset_postdata();


        echo $args['after_widget'];
    }
   

    private function get_post_excerpt($post_id)
    {


        /*
         * Nếu bài có excerpt thủ công
         */

        $excerpt = get_the_excerpt($post_id);


        if (! empty($excerpt)) {

            return wp_trim_words(
                wp_strip_all_tags($excerpt),
                45,
                '...'
            );
        }


        /*
         * Nếu không có excerpt,
         * lấy content
         */

        $content = get_post_field(
            'post_content',
            $post_id
        );


        $content = wp_strip_all_tags(
            strip_shortcodes($content)
        );


        return wp_trim_words(
            $content,
            45,
            '...'
        );
    }



    /**
     * =====================================================
     * WIDGET ADMIN
     * =====================================================
     *
     * Widget này không cần nhập nội dung.
     * Nội dung tự lấy từ Post.
     *
     */

    public function form($instance)
    {

    ?>

        <p>

            <strong>
                Widget Test 4
            </strong>

        </p>

        <p>

            Widget tự động lấy:

        </p>

        <ul>

            <li>
                Bài viết mới nhất → bài nổi bật
            </li>

            <li>
                2 bài viết kế tiếp → bài phụ
            </li>

            <li>
                Ảnh → get_first_images()
            </li>

            <li>
                Tiêu đề → Post Title
            </li>

            <li>
                Link → Permalink
            </li>

        </ul>

        <p>

            Không cần nhập nội dung thủ công.

        </p>

<?php

    }



    /**
     * =====================================================
     * UPDATE
     * =====================================================
     */

    public function update($new_instance, $old_instance)
    {

        return $old_instance;
    }
}



/**
 * =========================================================
 * REGISTER WIDGET
 * =========================================================
 */

function register_widget_test_4()
{

    register_widget(
        'Widget_Test_4'
    );
}

add_action(
    'widgets_init',
    'register_widget_test_4'
);
