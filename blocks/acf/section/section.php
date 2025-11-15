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

$class_name = 'section flex flex-col';

if ( !empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

$supports               = $block['supports'] ?? [];
$style                  = $block['style'] ?? null;
$settings_arr['supports']         = $supports;
$settings_arr['supports']['style'] = $style;

$background = get_field('background') ?: [];
$bg         = is_array($background) ? ($background['background'] ?? []) : [];
$background_overlay = $bg['bg_overlay'] ?? '';

$settings_arr['background'] = $background;

$spacing       = get_field('spacing') ?: [];
$spacing_class = nds_acf_section_block_spacing($spacing) ?: ''; 
$settings_arr['spacing'] = $spacing;

$hide_frontend = (bool) get_field( 'hide_on_frontend' );
if ( ! is_admin() && $hide_frontend ) {
    echo "<!-- Section {$block_id} hidden on frontend -->";
    return;
}
if ( is_admin() && $hide_frontend ) {
    $class_name .= ' nds-hidden-frontend';
}

$is_hero_section = (bool) get_field( 'is_hero_section' );
if ( $is_hero_section ){
    $class_name .= ' nds-is-hero-section';
}

$custom_css = get_field( 'custom_css' );

$settings_arr['custom_css'] = $custom_css;

$vertical_aligment = !empty( get_field( 'alignment' ) ) ? get_field( 'alignment' ) : 'start' ;

$class_name .= ' justify-' . strtolower( $vertical_aligment );
$class_name .= ' relative ' . $spacing_class;

$bg_enable_video_background = $background['background']['bg_enable_video_background'] ?? false;
$video = $background['background']['bg_video'] ?? '';
?>

<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>" data-block-id="<?php echo $block_id; ?>">

    <?php
    if ( is_admin() && $hide_frontend ) {
        echo '<span class="nds-admin-badge">Hidden on frontend</span>';
    }
    ?>

    <?php echo nds_section_container_block_video_bg( $bg_enable_video_background, $video ); ?>

    <?php if ( $background_overlay ) echo '<div class="bg-overlay absolute w-full h-full top-0 left-0" style="background-color: '. $background_overlay .'"></div>'; ?>

    <?php echo '<InnerBlocks class="container-inner w-full" />'; ?>

    <?php echo nds_css_section_container_backend( $settings_arr ); ?>

</div>