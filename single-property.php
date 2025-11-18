<?php get_header(); ?>
    <main role="main">

        <div class="breadcrumbs bg-[var(--color-accent)]">
            <div class="container">
                <div class="flex items-center gap-2 text-xs py-2 mb-8">
                    <a href="<?php echo get_home_url(); ?>" class="!no-underline">Home</a>

                    <svg width="4" height="7" viewBox="0 0 4 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.374399 5.875L3.33594 3.125L0.374399 0.375" stroke="#1C1C1C" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <!-- Property Category -->
                    <?php 
                    $terms = get_the_terms( get_the_ID(), 'property-category' );
                    if ( $terms && ! is_wp_error( $terms ) ) :
                        $term = $terms[0];
                    ?>
                        <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="!no-underline">
                            <?php echo esc_html( $term->name ); ?>
                        </a>
                    <?php endif; ?>

                    <svg width="4" height="7" viewBox="0 0 4 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.374399 5.875L3.33594 3.125L0.374399 0.375" stroke="#1C1C1C" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <span class="font-semibold"><?php the_title(); ?></span>
                </div>
            </div>
        </div>
      
        <div class="container">
            <?php get_template_part( 'template-parts/property-single-gallery' ); ?>
            <div class="h-[30px] lg:h-[50px]"></div>

            <?php get_template_part( 'template-parts/property-single-header' ); ?>

            <?php get_template_part( 'template-parts/property-single-offers' ); ?>

            <?php get_template_part( 'template-parts/property-single-feature-destination' ); ?>
            
            <?php get_template_part( 'template-parts/property-why' ); ?>

        </div>

        <?php get_template_part( 'template-parts/property-single-map' ); ?>
    </main>
<?php get_footer(); ?>
