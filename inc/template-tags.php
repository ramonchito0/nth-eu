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

