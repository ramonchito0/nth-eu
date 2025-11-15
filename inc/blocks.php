<?php
/**
 * Get standard ACF block data array
 *
 * @param array $block Block array from ACF
 * @return array Standardized block data
 */
function nds_get_block_data( $block ) {
    $block_name = str_replace( '.php', '', $block['render_template'] );
    $anchor = '';

    if ( isset( $block['anchor'] ) && ! empty( $block['anchor'] ) ) {
        $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
    }

    if ( is_admin() ) {
        $block_id = $block['id'];
    } else {
        $block_id = isset( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : str_replace( 'block_', '', $block['id'] );
    }

    $class_name = 'nds-block nds-' . $block_name;

    if ( !empty( $block['className'] ) ) {
        $class_name .= ' ' . $block['className'];
    }

    return [
        'block_name' => $block_name,
        'anchor' => $anchor,
        'block_id' => $block_id,
        'class_name' => $class_name,
    ];
}