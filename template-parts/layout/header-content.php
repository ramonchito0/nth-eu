<?php
/**
 * Header content template
 *
 * @package NDS
 */

 $header_class = ' relative transition-all duration-200';

$acf_general_settings = get_field( 'acf_general_settings', 'option' );
$logo_width  = !empty( $acf_general_settings['logo_width'] ) ? esc_attr( $acf_general_settings['logo_width'] ) : '';
$logo_height = !empty( $acf_general_settings['logo_height'] ) ? esc_attr( $acf_general_settings['logo_height'] ) : '';
$attr = '';
if ( $logo_width ) {
    $attr .= ' width="' . $logo_width . '"';
}
if ( $logo_height ) {
    $attr .= ' height="' . $logo_height . '"';
}
?>
<div class="nds-header-wrapper w-full absolute top-0 left-0 z-50 max-lg:top-10">
    <div class="nds-top-header pt-[1.5625rem] pb-[1.75rem] hidden min-lg:block">
        <div class="container !max-w-[99.5rem]">
            <?php
            wp_nav_menu(
                array(
                    'container_id'    => 'top-menu',
                    'container_class' => 'nds-top-menu',
                    'menu_class'      => 'flex justify-end gap-x-7',
                    'menu'            => 2,
                    'li_class'        => '',
                    'fallback_cb'     => false,
                )
            );
            ?>
        </div>
    </div>
    <header class="nds-site-header<?php echo $header_class; ?>">
        <div class="container !max-w-[99.5rem] relative">
            <div class="nds-main-nav bg-secondary py-[1.3125rem] pl-[1.125rem] pr-[1.8125rem] rounded-[1.75rem] relative z-[60] min-lg:py-0 min-lg:pl-[clamp(1.875rem,5vw,4.875rem)] min-lg:pr-[clamp(1.875rem,5vw,5.875rem)] lg:flex lg:justify-between lg:items-center">
                <div class="w-full flex justify-between items-center gap-x-16">
                    <div class="relative max-w-[6.3125rem] min-lg:max-w-[9.375rem]">
                        <?php if ( has_custom_logo() ) { ?>
                        <?php the_custom_logo(); ?>
                        <?php } else { ?>
                            <a href="<?php echo get_bloginfo( 'url' ); ?>" class="font-extrabold text-lg uppercase">
                                <?php echo get_bloginfo( 'name' ); ?>
                            </a>

                            <p class="text-sm font-light text-gray-600">
                                <?php echo get_bloginfo( 'description' ); ?>
                            </p>

                        <?php } ?>
                    </div>

                    <?php
                    wp_nav_menu(
                        array(
                            'container_id'    => 'primary-menu',
                            'container_class' => 'nds-primary-menu hidden min-lg:block',
                            'menu_class'      => 'flex gap-x-[4.5rem]',
                            'theme_location'  => 'primary',
                            'li_class'        => '',
                            'fallback_cb'     => false,
                        )
                    );
                    ?>

                    <div class="lg:hidden">
                        <a href="#" aria-label="Toggle navigation" id="primary-menu-toggle" class="flex flex-col gap-[.1875rem]">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </a>
                    </div>
                </div>

            </div>

            <?php get_template_part( 'template-parts/layout/megamenu-content' ); ?>
            
            <?php get_template_part( 'template-parts/layout/mobile-menu-content' ); ?>


        </div>
    </header>
</div>