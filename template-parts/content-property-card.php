<?php 
global $post;
?>
<article class="flex flex-col gap-5 md:gap-8">

    <!-- Featured Image -->
    <?php if (has_post_thumbnail()) : ?>
        <div class="rounded-[12px] overflow-hidden">
            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
                <?php the_post_thumbnail('large', [
                    'class' => 'w-full h-full object-cover'
                ]); ?>
            </a>
        </div>
    <?php endif; ?>

    <!-- Text Content -->
    <div class="flex flex-col gap-4 text-left w-full">
    <h3 class="text-20 font-display"><a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="!no-underline"><?php echo esc_html(get_the_title($post->ID)); ?></a></h3>

        <div class="flex flex-col gap-3 text-sm text-neutral-700">

            <!-- Location -->
            <?php if ($location = get_field('location', $post->ID)) : ?>
                <div class="flex items-center gap-2">
                    <!-- Location Icon -->
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_location)">
                            <path d="M15.9827 7.88266C15.9827 12.3516 8.99997 17.0999 8.99997 17.0999C8.99997 17.0999 2.01721 12.3516 2.01721 7.88266C2.01721 3.97232 5.29776 0.899902 8.99997 0.899902C12.7022 0.899902 15.9827 3.97232 15.9827 7.88266Z" stroke="#5F5F5F" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M9 10.3965C10.3883 10.3965 11.5138 9.27102 11.5138 7.88269C11.5138 6.49436 10.3883 5.3689 9 5.3689C7.61167 5.3689 6.48621 6.49436 6.48621 7.88269C6.48621 9.27102 7.61167 10.3965 9 10.3965Z" stroke="#5F5F5F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_location">
                                <rect width="18" height="18" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>

                    <span><?php echo esc_html($location); ?></span>
                </div>
            <?php endif; ?>

            <!-- Guest Range -->
            <?php if ($guests = get_field('guest_range', $post->ID)) : ?>
                <div class="flex items-center gap-2">
                    <!-- Guest Icon -->
<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_1006_20728)">
<path d="M1.51135 16.534L11.4556 16.6501C11.4556 16.6501 11.4326 16.0436 11.3148 15.4643C10.9897 13.865 9.92752 11.0364 6.48266 11.0364C3.03781 11.0364 1.97571 13.865 1.65051 15.4643C1.53271 16.0436 1.51135 16.534 1.51135 16.534Z" stroke="#5F5F5F" stroke-width="1.5" stroke-linecap="square"></path>
<path d="M13.0277 11.0364C15.2046 11.0364 16.0961 13.2856 16.456 14.9067C16.6504 15.7821 15.9423 16.534 15.0455 16.534H14.0749" stroke="#5F5F5F" stroke-width="1.5" stroke-linecap="square"></path>
<path d="M6.48285 7.10951C8.07327 7.10951 9.36256 5.82022 9.36256 4.2298C9.36256 2.63939 8.07327 1.3501 6.48285 1.3501C4.89244 1.3501 3.60315 2.63939 3.60315 4.2298C3.60315 5.82022 4.89244 7.10951 6.48285 7.10951Z" stroke="#5F5F5F" stroke-width="1.5" stroke-linecap="square"></path>
<path d="M11.98 7.10951C13.5704 7.10951 14.5979 5.82022 14.5979 4.2298C14.5979 2.63939 13.5704 1.3501 11.98 1.3501" stroke="#5F5F5F" stroke-width="1.5" stroke-linecap="square"></path>
</g>
<defs>
<clipPath id="clip0_1006_20728">
<rect width="18" height="18" fill="white"></rect>
</clipPath>
</defs>
</svg>

                    <span><?php echo esc_html($guests); ?></span>
                </div>
            <?php endif; ?>

        </div>
    </div>

</article>
