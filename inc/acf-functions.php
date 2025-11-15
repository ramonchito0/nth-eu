<?php
/**
 * Site Settings → Advanced → Custom HTML → Head
 */
add_action( 'wp_head', 'nds_custom_html_head' );
function nds_custom_html_head() {
    $acf_general_settings = get_field( 'acf_advanced_custom_html', 'option' );

    if ( $acf_general_settings ) {
        $custom_html_head = !empty( $acf_general_settings['head'] ) ? $acf_general_settings['head'] : '';

        if ( $custom_html_head ) {
            echo htmlspecialchars_decode( $custom_html_head ) . "\n";
        }
    }
}


/**
 * Site Settings → Advanced → Custom HTML → Head (Admin)
 */
add_action( 'admin_head', 'nds_custom_html_head_admin' );
function nds_custom_html_head_admin() {
    $acf_general_settings = get_field( 'acf_advanced_custom_html', 'option' );

    if ( $acf_general_settings ) {
        $custom_html_head = !empty( $acf_general_settings['head_admin'] ) ? $acf_general_settings['head_admin'] : '';

        if ( $custom_html_head ) {
            echo htmlspecialchars_decode( $custom_html_head ) . "\n";
        }
    }
}


/**
 * Site Settings → Advanced → Custom HTML → Body
 */
add_action( 'nds_header', 'nds_custom_html_body_top' );
function nds_custom_html_body_top() {
    $acf_general_settings = get_field( 'acf_advanced_custom_html', 'option' );

    if ( $acf_general_settings ) {
        $custom_html_body_top = !empty( $acf_general_settings['body_top'] ) ? $acf_general_settings['body_top'] : '';

        if ( $custom_html_body_top ) {
            echo htmlspecialchars_decode( $custom_html_body_top ) . "\n";
        }
    }
}


/**
 * Site Settings → Advanced → Custom HTML → Body (Footer)
 */
add_action( 'wp_footer', 'nds_custom_html_body_footer' );
function nds_custom_html_body_footer() {
    $acf_general_settings = get_field( 'acf_advanced_custom_html', 'option' );

    if ( $acf_general_settings ) {
        $custom_html_body_footer = !empty( $acf_general_settings['body_footer'] ) ? $acf_general_settings['body_footer'] : '';

        if ( $custom_html_body_footer ) {
            echo htmlspecialchars_decode( $custom_html_body_footer ) . "\n";
        }
    }
}


/**
 * Define screen sizes for CSS media queries
 */
define( 'SCREEN_TABLET', '1023px' );
define( 'SCREEN_MOBILE', '781px' );


/**
 * Theme Styles from Site Settings
 */
function nds_build_design_css_raw() {
    return '';
}

/**
 * Inject CSS into the editor *iframe* via block editor settings.
 */
add_filter( 'block_editor_settings_all', function( $settings, $context ) {
    // Limit to certain post types 
    $acf_advanced = get_field( 'acf_advanced_gutenberg_settings', 'option' );
    $allowed = ['post','page'];
    if ( isset($acf_advanced['allowed_post_types']) && is_array($acf_advanced['allowed_post_types']) ) {
        foreach ( $acf_advanced['allowed_post_types'] as $pt ) {
            if ( ! empty( $pt['post_type_slug'] ) ) {
                $allowed[] = $pt['post_type_slug'];
            }
        }
    }

    if ( isset($context->post) && $context->post ) {
        $pt = is_object($context->post) ? get_post_type($context->post) : get_post_type((int)$context->post);
        if ( $pt && ! in_array( $pt, $allowed, true ) ) {
            return $settings;
        }
    }

    // Append CSS to the iframe styles array
    $css = nds_build_design_css_raw();
    if ( ! isset( $settings['styles'] ) || ! is_array( $settings['styles'] ) ) {
        $settings['styles'] = [];
    }
    $settings['styles'][] = [ 'css' => $css ];
    return $settings;
}, 10, 2 );


/**
 * Add CSS to the frontend and backend
 */
add_action( 'wp_enqueue_scripts', function () {
    $css = nds_build_design_css_raw();
    wp_register_style( 'nds-frontend-inline', false, [], null );
    wp_enqueue_style( 'nds-frontend-inline' );
    wp_add_inline_style( 'nds-frontend-inline', $css );
});


/**
 * Add custom category for blocks and place it at the top
 */
add_filter( 'block_categories_all', function( $categories ) {

    // Prepend the custom category
    array_unshift( $categories, array(
        'slug'  => 'nds-blocks',
        'title' => 'NDS'
    ));

    return $categories;

});


/**
 * Dynamically register ACF blocks from /blocks/acf/
 */
add_action( 'init', 'nds_register_acf_blocks' );
function nds_register_acf_blocks() {

    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }

    $blocks_dir = get_template_directory() . '/blocks/acf/';
    
    if ( ! is_dir( $blocks_dir ) ) {
        return;
    }

    // Scan for directories inside /blocks/acf/
    $block_folders = array_filter( glob( $blocks_dir . '*', GLOB_ONLYDIR ) );

    foreach ( $block_folders as $folder_path ) {
        register_block_type( $folder_path );
    }
}


/**
 * Remove ACF inner block
 */
add_filter( 'acf/blocks/wrap_frontend_innerblocks', 'nds_acf_should_wrap_innerblocks', 10, 2 );
function nds_acf_should_wrap_innerblocks( $wrap, $name ) {

    if ( $name == 'acf/container' ) {
        return true;
    }

    return false;
    
}


/**
 * Render section css
 */
function nds_css_section_container( $settings_arr ){

    ob_start();
    
    $block_data = $settings_arr['block_data'];
    $block_id = $block_data['block_id'];
    $block_name = $block_data['block_name'];
    $supports = $settings_arr['supports'];
    $style = isset( $supports['style'])  ? $supports['style'] : null;

    if ( $supports['dimensions']['minHeight'] == 1 && !empty( $style['dimensions']['minHeight'] ) ){
        $min_height = $style['dimensions']['minHeight'];
    }

    $background = $settings_arr['background'];
    $background_value = $background['background'] ?? '';

    $custom_css = !empty( $settings_arr['custom_css'] ) ? $settings_arr['custom_css'] : '';

    if ( $custom_css ) $custom_css = str_replace( 'selector', '.section[data-block-id="' . $block_id . '"]', $custom_css );

    $container = $settings_arr['container'] ?? '';
    $container_custom = $settings_arr['container_custom'] ?? '';
    $columns_gap = $settings_arr['columns_gap'] ?? '';

    $css = '';
    $desktop_css = '';
    $tablet_css = '';
    $mobile_css= '';
    $container_css = '';

    if ( ( $background && ( $background_value['bg_image'] || $background_value['bg_image_tablet'] || $background_value['bg_image_mobile'] || $background_value['bg_color'] ) ) || ( $supports['dimensions']['minHeight'] && !empty( $min_height ) ) || ( $container == 'Custom' && $container_custom ) || !empty( $custom_css ) ) :

        if ( $container == 'Custom' && $container_custom ) {
            $container_css .= 'max-width: ' . $container_custom . ';';
        }

        if ( !empty( $background_value['bg_color'] ) ) {
            $css .= 'background-color: ' . $background_value['bg_color'] . ';';
        }

        if ( !empty( $background_value['bg_image'] ) ) {
            $css .= 'background-image: url("' . $background_value['bg_image']['url'] . '");';
        }   

        if ( !empty( $background_value['bg_image'] ) && !empty( $background_value['bg_size'] ) && $background_value['bg_size'] != 'Custom' ) {
            $css .= 'background-size: ' . strtolower( $background_value['bg_size'] ) . ';';
        } elseif ( !empty( $background_value['bg_image'] ) && $background_value['bg_size'] == 'Custom' && !empty( $background_value['bg_custom_size'] ) ) {
            $css .= 'background-size: ' . strtolower( $background_value['bg_custom_size'] ) . ';';
        }

        if ( !empty( $background_value['bg_image'] ) && !empty( $background_value['bg_repeat'] ) ) {
            $css .= 'background-repeat: ' . str_replace( ' ', '-', strtolower( $background_value['bg_repeat'] ) ) . '; ';
        }

        if ( !empty( $background_value['bg_image'] ) && !empty( $background_value['bg_position'] ) && $background_value['bg_position'] != 'Custom' ) {
            $css .= 'background-position: ' . strtolower( $background_value['bg_position'] ) . ';';
        } elseif ( !empty( $background_value['bg_image'] ) && !empty( $background_value['bg_position'] ) && $background_value['bg_position'] == 'Custom' ){
            $css .= 'background-position: ' . strtolower( $background_value['bg_custom_position'] ) . ';';
        }

        if ( $supports['dimensions']['minHeight'] && !empty( $style['dimensions']['minHeight'] ) ) {
            $css .= 'min-height: ' . $min_height . '; ';
        }

        if ( !empty( $background_value['bg_image_tablet'] ) ){

            $tablet_css = '@media only screen and (max-width: ' . SCREEN_TABLET . '){ .div[data-block-id="' . $block_id . '"]{';

                if ( !empty( $background_value['bg_image_tablet'] ) ) $tablet_css .= 'background-image: url("' . $background_value['bg_image_tablet']['url'] . '");';

            $tablet_css .= '} }';

        }

        if ( !empty( $background_value['bg_image_mobile'] ) ){

            $mobile_css = '@media only screen and (max-width: ' . SCREEN_MOBILE . '){ .div[data-block-id="' . $block_id . '"]{';

                if ( !empty( $background_value['bg_image_mobile'] ) ) $mobile_css .= 'background-image: url("' . $background_value['bg_image_mobile']['url'] . '");';

            $mobile_css .= '} }';

        }
        
        if ( !empty( $container_css ) || !empty( $columns_gap ) || !empty( $desktop_css ) || !empty( $css ) || !empty( $tablet_css ) || !empty( $mobile_css ) || !empty( $custom_css ) ) {
?>

<style>
    <?php if ( $container_css || $columns_gap || $desktop_css ){ ?>@media only screen and (min-width: 1024px){ <?php if ( $container_css ){ ?>div[data-block-id="<?php echo $block_id; ?>"]{ <?php echo $container_css;?> }<?php } ?> <?php if ( $desktop_css  ){ ?>div[data-block-id="<?php echo $block_id; ?>"]{<?php echo $desktop_css; ?>}<?php } ?> <?php if ( $columns_gap ){ ?>div[data-block-id="<?php echo $block_id; ?>"] .wp-block-columns{ column-gap: <?php echo $columns_gap;?> }<?php } ?> }<?php } ?><?php if ( $css  ){ ?>div[data-block-id="<?php echo $block_id; ?>"]{<?php echo $css; ?>}<?php } ?><?php if ( $tablet_css ) echo $tablet_css; ?><?php if ( $mobile_css ) echo $mobile_css; ?><?php if ( $custom_css ) echo $custom_css; ?>
</style>

<?php
        }

    endif;

    return ob_get_clean();

}


/**
 * Section block CSS (Backend)
 */
function nds_css_section_container_backend( $settings_arr ){

    if ( is_admin() ) :

        ob_start();

        echo nds_css_section_container( $settings_arr );

        $minified_css = ob_get_clean();
        $minified_css = preg_replace( '/\s+/', ' ', $minified_css );   

        echo $minified_css;

    endif;

}


/**
 * Blocks CSS (Frontend)
 */
add_action( 'wp_head', 'nds_css_section_container_head_frontend', 99 );
//add_action( 'admin_head', 'nds_css_head_section' );
function nds_css_section_container_head_frontend() {
    if ( is_admin() ) return;

    $post_id = get_queried_object_id();
    if ( ! $post_id ) return;

    $main_content = get_post_field( 'post_content', $post_id );
    $main_blocks  = $main_content ? parse_blocks( $main_content ) : [];

    $footer_blocks = [];
    if ( $footer = get_page_by_title( 'Site Footer', OBJECT, 'wp_block' ) ) {
        $footer_blocks = parse_blocks( $footer->post_content );
    }

    $css = '';
    foreach ( array_merge( $main_blocks, $footer_blocks ) as $block ) {
        if ( empty( $block['blockName'] ) ) continue;

        if ( $block['blockName'] === 'nds/section' ) {
            ob_start();
            nds_css_section_container_head_frontend_render( $block );
            $css .= ob_get_clean();

            if ( ! empty( $block['innerBlocks'] ) ) {
                foreach ( $block['innerBlocks'] as $inner ) {
                    if ( ! empty( $inner['blockName'] ) && $inner['blockName'] === 'nds/container' ) {
                        ob_start();
                        nds_css_section_container_head_frontend_render( $inner );
                        $css .= ob_get_clean();
                    }
                }
            }
        }
    }

    $css = trim( preg_replace( '/\s+/', ' ', $css ) );
    if ( $css !== '' ) {
        echo '<style id="nds-blocks-inline">', $css, '</style>';
    }
}



/**
 * Blocks render CSS (Frontend)
 */

function nds_css_section_container_head_frontend_render( $block ) {
    
    $css = '';
    $desktop_css = '';
    $tablet_css = '';
    $mobile_css= '';
    $container_css = '';
    $block_id = $block['attrs']['anchor'];
    $data = $block['attrs']['data'];
    $css_class_name = 'div[data-block-id="' . $block_id . '"]';
    $style = $block['attrs']['style'] ?? ''; 

    if ( isset( $data ) || isset( $style ) ) {

        $bg_color = $data['background_background_bg_color'];
        $bg_image_id = $data['background_background_bg_image'];
        $bg_image_url = wp_get_attachment_url( $bg_image_id );
        $bg_image_tablet_id = $data['background_background_bg_image_tablet'];
        $bg_image_tablet_url = wp_get_attachment_url( $bg_image_tablet_id );
        $bg_image_mobile_id = $data['background_background_bg_image_mobile'];
        $bg_image_mobile_url = wp_get_attachment_url( $bg_image_mobile_id );
        $bg_size = strtolower( $data['background_background_bg_size'] );
        $bg_size_custom = !empty( $data['background_background_bg_custom_size'] ) ? $data['background_background_bg_custom_size'] : '';

        if ( $bg_size == 'custom' && $bg_size_custom ) $bg_size = $bg_size_custom;

        $bg_repeat = nds_create_slug( $data['background_background_bg_repeat'] );
        $bg_position = strtolower( $data['background_background_bg_position'] );
        $bg_position_custom = !empty( $data['background_background_bg_custom_position'] ) ? $data['background_background_bg_custom_position'] : '';

        if ( $bg_position == 'custom' && $bg_position_custom ) $bg_position = $bg_position_custom;

        $min_height = '';

        if ( $style && isset( $style['dimensions']['minHeight'] ) ) $min_height = $style['dimensions']['minHeight'];      

        if ( $bg_color ) $css .= 'background-color: ' . $bg_color . ';';

        if ( $bg_image_id ) $css .= 'background-image: url("' . $bg_image_url . '");';

        if ( $bg_image_id && $bg_size ) $css .= 'background-size: ' . $bg_size. ';';

        if ( $bg_image_id && $bg_repeat ) $css .= 'background-repeat: ' . $bg_repeat. ';';

        if ( $bg_image_id && $bg_position ) $css .= 'background-position: ' . $bg_position. ';';

        if ( $min_height ) $css .= 'min-height: ' . $min_height . ';';    

        $container = $data['container_size'] ?? '';
        $container_custom = $data['custom_container_size'] ?? '';

        if ( $container == 'Custom' && $container_custom ) {
            $container_css .= 'max-width: ' . $container_custom . ';';
        }

        $columns_gap = $data['columns_gap'] ?? '';

        if ( $bg_image_tablet_id ) {

            $tablet_css = '@media only screen and (max-width: ' . SCREEN_TABLET . '){ ' . $css_class_name . '{';

            if ( $bg_image_tablet_id ) $tablet_css .= 'background-image: url("' . $bg_image_tablet_url . '");';

            $tablet_css .= '} }';

        }

        if ( $bg_image_mobile_id ) {

            $mobile_css = '@media only screen and (max-width: ' . SCREEN_MOBILE . '){ ' . $css_class_name . '{';

            if ( $bg_image_mobile_id ) $mobile_css .= 'background-image: url("' . $bg_image_mobile_url . '");';

            $mobile_css .= '} }';

        }     

    }

    if ( !empty( $container_css ) || !empty( $columns_gap ) || !empty( $desktop_css ) ) { 

        echo '@media only screen and (min-width: 1024px){';     

        if ( !empty( $container_css ) ) echo 'div[data-block-id="' . $block_id . '"]{ ' . $container_css . ' }';

        if ( !empty( $desktop_css ) ) echo 'div[data-block-id="' . $block_id . '"]{ ' . $desktop_css . ' }';

        if ( !empty( $columns_gap ) ) echo 'div[data-block-id="' . $block_id . '"] .wp-block-columns{ column-gap: ' . $columns_gap . ' }';

        echo '}';

    }

    if ( !empty( $css ) ) {
        $minified_css = preg_replace( '/\s+/', ' ', $css );
        echo $css_class_name . '{' 
            . $minified_css . 
        '}';
    }

    if ( !empty( $tablet_css ) ) {
        $minified_tablet_css = preg_replace( '/\s+/', ' ', $tablet_css );
        echo $minified_tablet_css;

    }

    if ( !empty( $mobile_css ) ) {
        $minified_mobile_css = preg_replace( '/\s+/', ' ', $mobile_css );
        echo $minified_mobile_css;
    }

    $custom_css = $data['custom_css'] ?? '';
    $custom_css = str_replace( 'selector', 'div[data-block-id="' . $block_id . '"]', $custom_css );

    if ( $custom_css ) echo $custom_css;
}


/**
 * Generate an id on blocks if empty
 */
add_filter(
    'acf/pre_save_block',
    function( $attributes ) {

        if ( empty( $attributes['anchor'] ) ) {
            $attributes['anchor'] = nds_generate_unique_anchor( get_the_ID() );
        }

        return $attributes;

    }
);


function nds_generate_unique_anchor( $post_id ) {
    $base = 'block-' . uniqid();
    $anchors = [];

    // Parse existing anchors
    $blocks = parse_blocks( get_post_field( 'post_content', $post_id ) );
    foreach ( $blocks as $block ) {
        if ( ! empty( $block['attrs']['anchor'] ) ) {
            $anchors[] = $block['attrs']['anchor'];
        }
    }

    // Check and regenerate if needed
    while ( in_array( $base, $anchors ) ) {
        $base = 'block-' . uniqid();
    }

    return $base;
}


/**
 * ACF section block spacing
 */
function nds_acf_section_block_spacing( $spacing ) {

    // Normalize input
    if (is_array($spacing) && isset($spacing['spacing']) && is_array($spacing['spacing'])) {
        $spacing = $spacing['spacing']; 
    }
    if (!is_array($spacing)) {
        $spacing = [];
    }

    $defaults = [
        // Margins
        'dt_margin_top'    => 'none',
        'dt_margin_bottom' => 'none',
        'tb_margin_top'    => 'inherit',
        'tb_margin_bottom' => 'inherit',
        'mb_margin_top'    => 'inherit',
        'mb_margin_bottom' => 'inherit',

        // Padding
        'dt_padding_top'    => null,
        'dt_padding_bottom' => null,
        'tb_padding_top'    => 'inherit',
        'tb_padding_bottom' => 'inherit',
        'mb_padding_top'    => 'inherit',
        'mb_padding_bottom' => 'inherit',
    ];

    foreach ($defaults as $k => $v) {
        if (!array_key_exists($k, $spacing) || $spacing[$k] === '') {
            $spacing[$k] = $v;
        }
    }

    $clean = static function($val) {
        if ($val === null) return null;
        if (function_exists('sanitize_html_class')) {
            return sanitize_html_class($val);
        }
        return preg_replace('/[^a-z0-9\-]/i', '', (string)$val);
    };

    $c = [];

    // Desktop (Margin)
    $dt_mt = $spacing['dt_margin_top'];
    $dt_mb = $spacing['dt_margin_bottom'];
    $c[] = ($dt_mt === 'none') ? 'mt-0' : 'mt-' . $clean($dt_mt);
    $c[] = ($dt_mb === 'none') ? 'mb-0' : 'mb-' . $clean($dt_mb);

    // Tablet (Margin)
    $tb_mt = $spacing['tb_margin_top'];
    if ($tb_mt !== 'inherit') {
        $c[] = ($tb_mt === 'none') ? 'mt-t-0' : 'mt-t-' . $clean($tb_mt);
    }
    $tb_mb = $spacing['tb_margin_bottom'];
    if ($tb_mb !== 'inherit') {
        $c[] = ($tb_mb === 'none') ? 'mb-t-0' : 'mb-t-' . $clean($tb_mb);
    }

    // Mobile (Margin)
    $mb_mt = $spacing['mb_margin_top'];
    if ($mb_mt !== 'inherit') {
        $c[] = ($mb_mt === 'none') ? 'mt-m-0' : 'mt-m-' . $clean($mb_mt);
    }
    $mb_mb = $spacing['mb_margin_bottom'];
    if ($mb_mb !== 'inherit') {
        $c[] = ($mb_mb === 'none') ? 'mb-m-0' : 'mb-m-' . $clean($mb_mb);
    }

    // Desktop (Padding)
    $dt_pt = $spacing['dt_padding_top'];
    if (!$dt_pt) {
        $c[] = 'pt-md';
    } elseif ($dt_pt === 'none') {
        $c[] = 'pt-0';
    } else {
        $c[] = 'pt-' . $clean($dt_pt);
    }

    $dt_pb = $spacing['dt_padding_bottom'];
    if (!$dt_pb) {
        $c[] = 'pb-md';
    } elseif ($dt_pb === 'none') {
        $c[] = 'pb-0';
    } else {
        $c[] = 'pb-' . $clean($dt_pb);
    }

    // Tablet (Padding)
    $tb_pt = $spacing['tb_padding_top'];
    if ($tb_pt !== 'inherit') {
        $c[] = ($tb_pt === 'none') ? 'pt-t-0' : 'pt-t-' . $clean($tb_pt);
    }
    $tb_pb = $spacing['tb_padding_bottom'];
    if ($tb_pb !== 'inherit') {
        $c[] = ($tb_pb === 'none') ? 'pb-t-0' : 'pb-t-' . $clean($tb_pb);
    }

    // Mobile (Padding)
    $mb_pt = $spacing['mb_padding_top'];
    if ($mb_pt !== 'inherit') {
        $c[] = ($mb_pt === 'none') ? 'pt-m-0' : 'pt-m-' . $clean($mb_pt);
    }
    $mb_pb = $spacing['mb_padding_bottom'];
    if ($mb_pb !== 'inherit') {
        $c[] = ($mb_pb === 'none') ? 'pb-m-0' : 'pb-m-' . $clean($mb_pb);
    }

    return implode(' ', array_values(array_unique(array_filter($c))));
}



/**
 * ACF JSON Save Point
 */
add_filter( 'acf/settings/save_json', 'nds_acf_json_save_point' );
function nds_acf_json_save_point( $path ) {
    return get_stylesheet_directory() . '/acf-json';
}

/**
 * ACF JSON Load Point
 */
add_filter( 'acf/settings/load_json', 'nds_acf_json_load_point' );
function nds_acf_json_load_point( $paths ) {

    unset($paths[0]);

    $paths[] = get_stylesheet_directory() . '/acf-json';

    return $paths;    
}