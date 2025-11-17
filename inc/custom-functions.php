<?php
/**
 * Slug
 */
function nds_create_slug( $string ){

    $string = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

    return strtolower( $string );

}

add_action('init', function() {

    register_block_style(
        'core/button',
        [
            'name'  => 'btn-secondary',
            'label' => 'Secondary'
        ]
    );

    register_block_style(
        'core/button',
        [
            'name'  => 'btn-ghost',
            'label' => 'Ghost'
        ]
    );

});