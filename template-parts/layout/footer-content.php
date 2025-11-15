<?php
/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nth_Degree_Search
 */

$footer_pattern = get_page_by_title( 'Site Footer', OBJECT, 'wp_block' );
?>

<footer id="colophon" class="nds-site-footer" role="contentinfo">
	<?php do_action( 'nds_footer' ); ?>

	<?php
	if ( $footer_pattern ) {
		echo do_blocks( $footer_pattern->post_content );
	}
	?>

</footer>