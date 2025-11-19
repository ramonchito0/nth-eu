
<?php
$posts_per_page    = get_field('posts_per_page') ?: 12;
$selected_terms    = get_field('property_terms');
$orderby           = get_field('orderby') ?: 'date';
$order             = get_field('order') ?: 'DESC';
$enable_pagination = get_field('enable_pagination');

$paged = 1;

if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} elseif (get_query_var('page')) {
    $paged = get_query_var('page');
} elseif (isset($_GET['paged'])) {
    $paged = intval($_GET['paged']);
} elseif (isset($_GET['page'])) {
    $paged = intval($_GET['page']);
}


$args = [
    'post_type'      => 'property',
    'posts_per_page' => $posts_per_page,
    'orderby'        => $orderby,
    'order'          => $order,
];

if ($enable_pagination) {
    $args['paged'] = $paged;
}

if (!empty($selected_terms)) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'property-category',
            'field'    => 'term_id',
            'terms'    => $selected_terms,
        ]
    ];
}

$query = new WP_Query($args);
?>


<?php $block_id = $block['id']; ?>
<?php if ($query->have_posts()) : ?>
<div id="<?php echo esc_attr($block_id)?>" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
    <?php while ($query->have_posts()) : $query->the_post(); ?>
        <?php get_template_part('template-parts/content-property-card'); ?>
    <?php endwhile; ?>
</div>

<?php if ($enable_pagination) : ?>
    <div class="mt-12 flex justify-center">
        <?php
        echo paginate_links([
            'total'      => $query->max_num_pages,
            'current'    => $paged,
            'format'     => '?paged=%#%#'.$block_id,
            'type'       => 'list',
            'prev_text'  => '<svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.67308 0.75L0.75 6.25L6.67308 11.75" stroke="#1C1C1C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
',
            'next_text'  => '<svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.749774 11.75L6.67285 6.25L0.749775 0.75" stroke="#1C1C1C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        ]);
        ?>
    </div>
<?php endif; ?>

<?php endif; ?>
<?php wp_reset_postdata(); ?>
