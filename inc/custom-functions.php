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


/* Google map api */
function my_acf_google_map_api( $api ){
    $api['key'] = 'AIzaSyAqRyXPKHl_eW8E0jd1qqMuo1gJKKnxF54';
    return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

add_filter('wpcf7_autop_or_not', '__return_false');
