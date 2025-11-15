<?php
$block_name = $block['name'] ?? (isset($block['render_template']) ? str_replace('.php', '', $block['render_template']) : 'container');
$anchor = ! empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '" ' : '';

$block_id = is_admin()
    ? ($block['id'] ?? uniqid('block_'))
    : (! empty($block['anchor']) ? esc_attr($block['anchor']) : str_replace('block_', '', ($block['id'] ?? uniqid('block_'))));

$settings_arr = [
    'block_data' => [
        'block_id'   => $block_id,
        'block_name' => $block_name,
    ]
];

$container_size = get_field('container_size') ?: ''; // could be null
$class_name = ($container_size === 'Full Width') ? 'container-fluid' : 'container';

$custom_container_max_width = get_field('custom_container_size') ?: '';

$class_name .= ' w-full relative';
if (! empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

$settings_arr['container']        = $container_size;
$settings_arr['container_custom'] = $custom_container_max_width;

$supports               = $block['supports'] ?? [];
$style                  = $block['style'] ?? null;
$settings_arr['supports']         = $supports;
$settings_arr['supports']['style'] = $style;

$background = get_field('background') ?: [];
$bg         = is_array($background) ? ($background['background'] ?? []) : [];
$background_overlay = $bg['bg_overlay'] ?? '';
if ($background_overlay) {
    $class_name .= ' section-bg-overlay';
}
$settings_arr['background'] = $background;

$spacing       = get_field('spacing') ?: [];
$spacing_class = nds_acf_section_block_spacing($spacing) ?: ''; 
$settings_arr['spacing'] = $spacing;

$columns_gap = get_field('columns_gap') ?: '';
$settings_arr['columns_gap'] = $columns_gap;

$alignment_items = get_field('alignment') ?: 'start';
$class_name     .= ' items-' . strtolower($alignment_items);

$justify = get_field('justify') ?: 'normal';
$class_name .= ' justify-' . strtolower($justify);

$class_name .= ' mx-auto ' . $spacing_class;

$bg_enable_video_background = !empty($bg['bg_enable_video_background']);
$video                      = $bg['bg_video'] ?? '';
?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr($class_name); ?>" data-block-id="<?php echo esc_attr($block_id); ?>">

    <?php echo nds_section_container_block_video_bg($bg_enable_video_background, $video); ?>

    <?php if ($background_overlay): ?>
        <div class="bg-overlay absolute w-full h-full top-0 left-0 opacity-60" style="background-color: <?php echo esc_attr($background_overlay); ?>"></div>
    <?php endif; ?>

    <?php echo '<InnerBlocks />'; ?>

    <?php echo nds_css_section_container_backend($settings_arr); ?>
</div>
