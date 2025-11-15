<?php get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<?php if ( get_post_type() === 'post' ) {
				get_template_part( 'template-parts/content', 'single-post' );
			}  elseif ( get_post_type() === 'location' ) {
				get_template_part( 'template-parts/content', 'single-location' );
			} else {
				get_template_part( 'template-parts/content', 'single' );
			} ?>

			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			// if ( comments_open() || get_comments_number() ) :
			// 	comments_template();
			// endif;
			?>

		<?php endwhile; ?>

	<?php endif; ?>

<?php
get_footer();
