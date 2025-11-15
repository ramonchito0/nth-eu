<?php
// ---------------------------
// Blog Listing Shortcode
// [nth_blog type="default" posts="4" pagination="true"]
// [nth_blog type="related" posts="3"]
// ---------------------------

function nth_blog_shortcode($atts)
{
    ob_start();

    // Shortcode attributes
    $atts = shortcode_atts([
        'type'       => 'default', // default|related
        'posts'      => 4,
        'pagination' => 'false',
    ], $atts);

    global $post;

    // Query Arguments
    $args = [
        'post_type'      => 'post',
        'posts_per_page' => intval($atts['posts']),
        'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
    ];

    // Handle "related" blog type
    if ($atts['type'] === 'related' && !empty($post->ID)) {
        $categories = wp_get_post_categories($post->ID);

        if (!empty($categories)) {
            $args['category__in'] = $categories;
            $args['post__not_in'] = [$post->ID];
        }
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) : ?>

        <div class="nth-blog-list">
            <?php while ($query->have_posts()) : $query->the_post(); ?>

                <?php get_template_part('template-parts/content', 'blog-card'); ?>

            <?php endwhile; ?>
        </div>

        <?php if ($atts['pagination'] === 'true') : ?>
            <div class="nth-blog-pagination">
                <?php
                    echo paginate_links([
                        'total'   => $query->max_num_pages,
                        'current' => max(1, get_query_var('paged')),
                    ]);
                ?>
            </div>
        <?php endif; ?>

    <?php endif;

    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode('nth_blog', 'nth_blog_shortcode');
