<?php
$args = [
    'post_type'      => 'property',
    'posts_per_page' => 9,
    'orderby'        => 'date',
    'order'          => 'DESC',
];

$query = new WP_Query($args);
?>

<?php if ($query->have_posts()) : ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">

        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php get_template_part('template-parts/content-property-card'); ?>
        <?php endwhile; ?>

    </div>
<?php endif; ?>

<?php wp_reset_postdata(); ?>
