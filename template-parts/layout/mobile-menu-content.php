<?php
$acf_header_settings = get_field( 'acf_header_settings', 'option' );
$megamenu = $acf_header_settings['megamenu'] ?? null;
?>

<div class="nds-mobile-menu-wrapper fixed bg-secondary top-0 left-0 w-full h-[calc(100%-8.9375rem)] mt-[8.9375rem] opacity-0 invisible overflow-y-auto z-50 transition-all duration-300">
    <?php
    wp_nav_menu(
        array(
            'container_id'    => 'mobile-primary-menu',
            'container_class' => 'nds-mobile-primary-menu border-b border-solid border-primary py-[2.6875rem] pl-[3.3125rem] pr-[4.375rem]',
            'menu_class'      => 'w-full flex flex-col gap-11',
            'theme_location'  => 'primary',
            'li_class'        => 'w-full',
            'fallback_cb'     => false,
        )
    );
    ?>
    <?php
    wp_nav_menu(
        array(
            'container_id'    => 'mobile-top-menu',
            'container_class' => 'nds-mobile-top-menu py-6 pl-[3.3125rem] pr-[4.375rem]',
            'menu_class'      => 'w-full flex flex-col gap-6',
            'menu'            => 2,
            'li_class'        => 'w-full',
            'fallback_cb'     => false,
        )
    );
    ?>
    <?php
    if ( $megamenu ) :

    $megamenu_items = $megamenu['megamenu_item'] ?? null;
    ?>
        <div class="nds-mobile-megamenu bg-secondary w-full h-full absolute top-0 -left-full transition-all duration-300 z-[51] transform-gpu">

            <?php 
            if ( $megamenu_items ) { 
                foreach ( $megamenu_items as $item ) : 
                    $identifider = $item['identifier'] ?? null;
                    $title = $item['title'] ?? null;
                    $title_mobile = $item['title_mobile'] ?? null;
                    $link = $item['link'] ?? null;
                    $link_array = array();
                    $links = $item['links'] ?? null;
                    $links_number = $links ? count( $links ) : 0;
            ?>
                <div class="nds-mobile-megamenu-item w-full h-[calc(100%-1.25rem)] bg-secondary absolute top-0 left-0 pt-[2.6875rem] pb-5 pl-[3.3125rem] pr-[4.375rem] opacity-0 invisible transform translate-y-5 transition-all duration-300 delay-500 overflow-hidden" data-identifier="<?php echo esc_attr( $identifider ); ?>">
                    <div class="nds-mobile-megamenu-content flex flex-col gap-10">
                        <?php if ( $title_mobile ) { ?>
                            <div class="nds-mobile-megamenu-title text-2md font-normal leading-[1.2] flex items-center gap-[1.625rem]">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="18.609" height="18.402" viewBox="0 0 18.609 18.402"><g id="Group_301" data-name="Group 301" transform="translate(-1262.516 2988.3) rotate(-135)"><g id="Group_11" data-name="Group 11" transform="translate(121.935 2.178)"><g id="Group_10" data-name="Group 10" transform="translate(-379.5 4063.68) rotate(-90)"><path id="Path_27" data-name="Path 27" d="M1133.332,1415.765h12.452v-12.251" transform="translate(-79.7 55.107)" fill="none" stroke="#0f2433" stroke-width="1"/><path id="Path_28" data-name="Path 28" d="M1067.381,1472l-12.305-12.305" transform="translate(-1.297 -1.132)" fill="none" stroke="#0f2433" stroke-width="1"/></g></g></g></svg></span>
                                <?php echo $title_mobile; ?>
                            </div>
                        <?php } ?>
                        <?php 
                        if ( $link ) { 
                            $link_array['link'] = $link;
                            $link_array['style'] = 'plain';

                            echo nds_button_single_render(  $link_array );
                        } 
                        ?>
                    </div>
                    <div class="nds-mobile-megamenu-links w-full flex flex-col gap-[2.625rem] mt-11 pb-7.5">
                        <?php 
                        if ( $links ) { 
                            $links_ctr = 0;
                            foreach ( $links as $link_item ) {
                                $links_ctr++;
                                $link_item_icon = $link_item['icon'] ?? null;
                                $link_item_link = $link_item['link'] ?? null;

                                if ( $link_item_link && $link_item_link['url'] && $link_item_link['title'] ) {
                        ?>
                                    <div class="nds-mobile-megamenu-links-item w-full">
                                        <a href="<?php echo esc_url( $link_item_link['url'] ); ?>" target="<?php if ( $link_item_link['target'] ) { echo $link_item_link['target']; } else { echo '_self'; } ?>" title="<?php echo esc_html( $link_item_link['title'] ); ?>" class="flex items-center gap-4 !no-underline">
                                            <?php if ( $link_item_icon ) { ?>
                                                <img src="<?php echo esc_url( $link_item_icon['url'] ); ?>" alt="<?php echo esc_html( $link_item_icon['alt'] ); ?>" class="w-[2.25rem] h-[2.25rem] object-contain flex-shrink-0">
                                            <?php } ?>
                                            <span class="text-md font-normal flex gap-5 relative">
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
    <?php endif; ?>
</div>