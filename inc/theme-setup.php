<?php
/**
 * Theme setup for nthdegreesearch
 */

function nthdegreesearch_setup() {
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'custom-logo', array(
		'height'      => 42,      
		'width'       => 257,    
		'flex-height' => true,      
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );    

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'nthdegreesearch' ),
	) );
}
add_action( 'after_setup_theme', 'nthdegreesearch_setup' );

/**
 * Allow safe SVG uploads
 */

// Enable SVG file type for uploads
function nthdegreesearch_enable_svg_uploads( $mime_types ) {
	$mime_types['svg'] = 'image/svg+xml';
	return $mime_types;
}
add_filter( 'upload_mimes', 'nthdegreesearch_enable_svg_uploads' );

// Show SVG previews in media library
function nthdegreesearch_fix_svg_display() {
	echo '<style>
		.attachment-266x266, .thumbnail img[src$=".svg"] {
			width: 100% !important;
			height: auto !important;
		}
	</style>';
}
add_action( 'admin_head', 'nthdegreesearch_fix_svg_display' );
