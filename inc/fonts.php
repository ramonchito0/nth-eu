<?php
/**
 * Load Montserrat (Google) + Zodiak (self-hosted) fonts
 */

function nthdegreesearch_enqueue_fonts() {

	// Google Fonts: Montserrat
	wp_enqueue_style(
		'nthdegreesearch-fonts',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// Self-hosted Zodiak (assets/fonts/zodiak/)
	$font_path = get_template_directory_uri() . '/assets/fonts/zodiak/';

	$custom_css = "
	@font-face {
		font-family: 'Zodiak';
		src: url('{$font_path}zodiak-400.woff2') format('woff2'),
		     url('{$font_path}zodiak-400.woff') format('woff');
		font-weight: 400;
		font-style: normal;
		font-display: swap;
	}
	@font-face {
		font-family: 'Zodiak';
		src: url('{$font_path}zodiak-700.woff2') format('woff2'),
		     url('{$font_path}zodiak-700.woff') format('woff');
		font-weight: 700;
		font-style: normal;
		font-display: swap;
	}
	";

	wp_register_style( 'nthdegreesearch-zodiak', false );
	wp_enqueue_style( 'nthdegreesearch-zodiak' );
	wp_add_inline_style( 'nthdegreesearch-zodiak', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'nthdegreesearch_enqueue_fonts' );
add_action( 'enqueue_block_editor_assets', 'nthdegreesearch_enqueue_fonts' );
