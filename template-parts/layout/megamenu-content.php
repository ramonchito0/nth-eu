<?php
$acf_header_settings = get_field( 'acf_header_settings', 'option' );
$megamenu = $acf_header_settings['megamenu'] ?? null;

if ( $megamenu ) :

    $megamenu_items = $megamenu['megamenu_item'] ?? null;
?>

    <div class="nds-megamenu bg-secondary w-[calc(100%-2.5rem)] min-h-[27.5rem] pt-[5.5625rem] pb-[4.3125rem] pl-[clamp(1.875rem,5vw,4.875rem)] pr-[clamp(1.875rem,5vw,5.875rem)] rounded-b-[1.75rem] absolute opacity-0 invisible transition-all duration-300 z-30 transform-gpu max-lg:hidden">

        <?php 
        if ( $megamenu_items ) { 
            foreach ( $megamenu_items as $item ) : 
                $identifider = $item['identifier'] ?? null;
                $title = $item['title'] ?? null;
                $link = $item['link'] ?? null;
                $link_array = array();
                $links = $item['links'] ?? null;
                $links_number = $links ? count( $links ) : 0;

                $links_classes = '';
                if ( $links_number > 4 ) {
                    $links_classes = 'grid grid-cols-2';
                } else {
                    $links_classes = 'flex flex-col';
                }
        ?>
            <div id="<?php echo esc_attr( $identifider ); ?>" class="nds-megamenu-item w-full flex gap-[clamp(1.5rem,4vw,4.125rem)] opacity-0 transform translate-y-5 transition-all duration-300" data-identifier="<?php echo esc_attr( $identifider ); ?>">
                <div class="nds-megamenu-content w-[36.2%] flex flex-col gap-[3.75rem]">
                    <?php if ( $title ) { ?>
                        <div class="nds-megamenu-title text-2xl leading-[1.1]"><?php echo $title; ?></div>
                    <?php } ?>
                    <?php 
                    if ( $link ) { 
                        $link_array['link'] = $link;
                        $link_array['style'] = 'plain';

                        echo nds_button_single_render(  $link_array );
                    } 
                    ?>
                </div>
                <div class="nds-megamenu-links flex-1 <?php echo $links_classes; ?> gap-y-7.5 gap-x-[clamp(1.25rem,1vw,2.9375rem)] pt-[1.5625rem]">
                    <?php 
                    if ( $links ) { 
                        $links_ctr = 0;
                        foreach ( $links as $link_item ) {
                            $links_ctr++;
                            $link_item_icon = $link_item['icon'] ?? null;
                            $link_item_link = $link_item['link'] ?? null;

                            if ( $link_item_link && $link_item_link['url'] && $link_item_link['title'] ) {
                    ?>
                                <div class="nds-megamenu-links-item w-full<?php if ( $links_ctr == 1 && !$link_item_icon ) echo ' -mt-2.5'; ?>">
                                    <a href="<?php echo esc_url( $link_item_link['url'] ); ?>" target="<?php if ( $link_item_link['target'] ) { echo $link_item_link['target']; } else { echo '_self'; } ?>" title="<?php echo esc_html( $link_item_link['title'] ); ?>" class="flex gap-[1.8125rem] !no-underline">
                                        <?php if ( $link_item_icon ) { ?>
                                            <img src="<?php echo esc_url( $link_item_icon['url'] ); ?>" alt="<?php echo esc_html( $link_item_icon['alt'] ); ?>" class="w-[2.5625rem] h-[2.5625rem] object-contain flex-shrink-0">
                                        <?php } ?>
                                        <span class="text-md-2 flex gap-5<?php if ( $link_item_icon ) echo ' pt-[.3125rem]'; ?> relative">
                                            <?php echo esc_html( $link_item_link['title'] ); ?>
                                        </span>
                                    </a>
                                </div>
                    <?php 
                           }
                        }
                    } 
                    ?>
                </div>
            </div>
        <?php 
            endforeach;
        } 
        ?>

    </div>

<?php
endif;