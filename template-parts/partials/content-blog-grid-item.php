<?php
/**
 * Template part for displaying blog grid items
 */

$post_id = get_the_ID();
$post_link = get_permalink();
?>

<article id="post-<?php echo $post_id; ?>" <?php post_class( 'nds-blog-grid-item border-b border-solid border-primary pb-[3.1875rem]' ); ?>>
    
    
    <div class="nds-post-thumbnail">
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php echo esc_url( $post_link ); ?>" class="block w-full h-[31.9375rem] rounded-[1.375rem] overflow-hidden max-lg:h-[21.1875rem]">
                <?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-full object-cover' ) ); ?>
            </a>
        <?php else : ?>
            <div class="bg-[#E5E5E5] w-full h-[31.9375rem] rounded-[1.375rem] overflow-hidden relative max-lg:h-[21.1875rem]"></div>
        <?php endif; ?>
    </div>
    
    <div class="nds-post-content pt-[1.8125rem] max-lg:pt-[1.1875rem]">
        
        <div class="nds-post-meta flex gap-[2.125rem] text-sm tracking-[0.2em] uppercase mb-[.4375rem] max-lg:mb-0">
            <?php
            // Get categories excluding 'Uncategorized'
            $categories = get_the_category();
            if ( $categories ) :
                $filtered_categories = array();
                foreach ( $categories as $category ) {
                    if ($category->name !== 'Uncategorized' && $category->name !== 'Uncategorised') {
                        $filtered_categories[] = $category;
                    }
                }
                
                if ( !empty( $filtered_categories ) ) :
            ?>
                <div class="nds-post-categories mb-2">
                    <?php foreach ( $filtered_categories as $category ) : ?>
                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" 
                        class="!no-underline">
                            <?php echo esc_html( $category->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php 
                endif;
            endif; 
            ?>
            
            <div class="nds-post-date">
                <time datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo get_the_date('j F Y'); ?>
                </time>
            </div>
        </div>
        
        <h3 class="nds-post-title !text-[1.875rem] !font-light !leading-[1.167em] min-h-[4.75rem] max-lg:!text-[1.625rem] max-lg:!leading-[1.077em] max-lg:min-h-min">
            <a href="<?php echo esc_url( $post_link ); ?>" 
               class="!text-primary !no-underline">
                <?php the_title(); ?>
            </a>
        </h3>

        <?php 
        $link_array = array();
        $link_array['link'] = array(
            'url' => $post_link,
            'title' => 'Read Article',
            'target' => ''
        );
        $link_array['style'] = 'plain';

        echo nds_button_single_render(  $link_array );
        
        ?>
        
    </div>
    
</article>