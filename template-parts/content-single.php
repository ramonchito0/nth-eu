<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content' ); ?>>

	<div class="nds-post-body pt-[4.125rem] pb-[4.375rem]">
		<div class="container">

			<header class="nds-entry-header">
				<h1 class="nds-entry-title"><?php the_title(); ?></h1>
			</header>

			<div class="nds-post-content mt-8">
				<?php the_content(); ?>
			</div>
			
		</div>
	</div>

</article>
