<?php
/**
 * Section and Container block video background
 */
function nds_section_container_block_video_bg( $bg_enable_video_background, $video ){

    ob_start();

    if ( $bg_enable_video_background ) : 
        $video_src = $video['bg_video_source'] ?? false;
        $video_local_file = $video['bg_video_local'] ?? '';
        $video_youtube = $video['bg_youtube_url'] ?? '';

        $youtube_video_id = '';
        $youtube_valid = false;

        if ( $video_src && $video_youtube ) {
            // Match YouTube standard format
            if ( preg_match( '/^https:\/\/www\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})$/', $video_youtube, $matches ) ) {
                $youtube_video_id = $matches[1];
                $youtube_valid = true;
            }
        }
?>

        <div class="absolute inset-0 w-full h-full top-0 left-0 pointer-events-none overflow-hidden">

            <?php if ( $video_src && $youtube_valid  ) { ?>

                <div class="youtube-wrapper absolute top-1/2 left-1/2 w-[177.78vh] h-[100vh] -translate-x-1/2 -translate-y-1/2 min-lg:w-full">
                    <iframe
                        class="nds-lazyvideo absolute top-0 left-0 w-full h-full object-cover"
                        title="YouTube video"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        data-src="https://www.youtube.com/embed/<?php echo esc_attr( $youtube_video_id ); ?>?enablejsapi=1&autoplay=1&mute=1&controls=0&rel=0&playsinline=1&modestbranding=1&showinfo=0&loop=1&playlist=<?php echo esc_attr( $youtube_video_id ); ?>"


                    ></iframe>
                </div>

            <?php } elseif ( $video_src && !$youtube_valid ) { ?>

                <div class="text-red-600 bg-white p-4 font-semibold">
                    Invalid YouTube URL format. Please use: <br>
                    <code>https://www.youtube.com/watch?v=VIDEO_ID</code>
                </div>

            <?php } elseif ( !$video_src && $video_local_file ) { ?>

                <video
                    class="nds-lazyvideo w-full h-full object-cover"
                    autoplay
                    muted
                    loop
                    playsinline
                    preload="none"
                    data-src="<?php echo esc_url( $video_local_file['url'] ); ?>"
                    data-type="<?php echo $video_local_file['mime_type']; ?>"
                ></video>

            <?php } ?>

        </div>

<?php
    endif;

    return ob_get_clean();
}


/**
 * Buttons render
 */
function nds_button_render( $buttons, $buttons_arr ){

    ob_start();

    if ( !empty( $buttons ) ) :

        $anchor = '';

        if ( isset( $buttons['anchor'] ) && ! empty( $buttons['anchor'] ) ) {
            $anchor = 'id="' . esc_attr( $buttons['anchor'] ) . '" ';
        }

        $buttons_wrapper_classes = $buttons['className'] ?? '';
        $alignment = $buttons['align'] ? $buttons['align'] : 'start';
        $direction = $buttons_arr['direction'] ? 'col' : 'row';
        $gap = $buttons_arr['gap'] ?? 'gap-5';
        $buttons_items = $buttons_arr['buttons_items'] ?? '';

        if ( $gap == '0' ) {
            $gap = 'gap-0';
        } elseif ( $gap == 'sm' ) {
            $gap = 'gap-2.5';
        } elseif ( $gap == 'lg' ) {
            $gap = 'gap-[1.875rem]';
        } else {
            $gap = 'gap-5';
        }

        $margin_top = $buttons['style']['spacing']['margin']['top'] ?? '0';
        $margin_top = str_replace('var:preset|spacing|', '', $margin_top);
        $margin_bottom = $buttons['style']['spacing']['margin']['bottom'] ?? '0';
        $margin_bottom = str_replace('var:preset|spacing|', '', $margin_bottom);

        $class_name = ' block-mt-' . $margin_top . ' block-mb-' . $margin_bottom; 
?>

        <div <?php echo $anchor; ?> class="nds-buttons-wrapper flex flex-<?php echo $direction; ?> <?php echo $gap; ?> <?php if ( $direction == 'row' ) { ?>justify-<?php echo $alignment; ?><?php } else { ?>items-<?php echo $alignment; ?><?php } ?><?php if( $buttons_wrapper_classes ) echo ' ' . $buttons_wrapper_classes; ?> relative<?php echo $class_name; ?>" data-block-id="<?php echo $buttons_arr['block_data']['block_id']; ?>">

            <?php 
            if ( $buttons_items ) {
                foreach ( $buttons_items as $button ){
                    $link = $button['link'] ?? '';
                    $link_target = $link['target'] ?? '';
                    $link_target = $link_target ? ' target="_blank"' : '';
                    $style = $button['style'] ? $button['style'] : 'primary';
                    // $size = $button['size'] ? $button['size'] : '';
                    $btn_class = $style == 'plain' ? 'nds-btn-plain' : ($style == 'plain-light' ? 'nds-btn-plain-light' : 'nds-btn');
                    $custom_class = $button['custom_class'] ?? '';

                    if( $link['title'] && $link['url'] ) {
            ?>
                        <a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo $link_target; ?> class="<?php echo $btn_class;?> nds-btn-<?php echo $style; ?> w-fit<?php if( $custom_class ) echo ' ' . $custom_class; ?>">
                            <?php echo esc_html( $link['title'] ); ?>
                        </a>
            <?php 
                    }
                }
            } 
            ?>

        </div>

<?php

    endif;

    return ob_get_clean();
}


/**
 * Single button render 
 */
function nds_button_single_render( $button_arr ){

    ob_start();

    if ( $button_arr ) {
    ?>
        <div class="nds-buttons-wrapper flex">
            <?php
            $link = $button_arr['link'] ?? '';
            $link_target = $link['target'] ?? '';
            $link_target = $link_target ? ' target="_blank"' : '';
            $style = $button_arr['style'] ? $button_arr['style'] : 'primary';
            $btn_style = ( $style == 'plain' ) ? 'nds-btn-plain' : 'nds nds-btn-primary';
            //echo '<pre>' . print_r( $button_arr, 1 ) . '</pre>';
            ?>
            <a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo $link_target; ?> class="<?php echo $btn_style; ?>">
                <?php echo esc_html( $link['title'] ); ?>
            </a>
        </div>
    <?php
    }

    return ob_get_clean();
}


/**
 * Small title render 
 */
function nds_small_title_render( $title, $title_tag = 'p', $additional_classes = '' ) {

    ob_start();

    if ( $title ) {
    ?>
        <<?php echo esc_html( $title_tag ); ?> class="!text-sm uppercase border-b border-solid border-primary !mb-9 pb-5 tracking-[0.2em] <?php echo esc_html( $additional_classes ); ?>">
            <?php echo esc_html( $title ); ?>
        </<?php echo esc_html( $title_tag ); ?>>
    <?php
    }

    return ob_get_clean();
}