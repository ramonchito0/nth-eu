<?php
$slides = get_field('slides');
if (!$slides) return;
?>

<div class="nds-hero-carousel relative w-full h-[620px] swiper overflow-hidden">

    <div class="swiper-wrapper">
        <?php foreach ($slides as $slide): ?>

        <?php 
        $post = $slide['property']; 
        if (!$post) continue;

        $title = get_the_title($post);
        $excerpt = get_field('short_description', $post->ID);
        $location = get_field('location', $post->ID);
        $guests = get_field('guest_range', $post->ID);
        $link = get_permalink($post);
        $featured_image = get_the_post_thumbnail_url($post, 'full');
        ?>

        <div class="swiper-slide relative">

            <!-- Background -->
            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('<?php echo esc_url($featured_image); ?>');">
            </div>

            <div class="container h-full flex justify-center items-center md:justify-end">
                    <!-- CARD -->
                    <div class="relative bg-white w-[457px] px-14 pt-10 pb-12 space-y-8 flex flex-col gap-5">

                        <?php if (!empty($slide['featured'])): ?>
                            <div class="absolute -top-4 -right-4 bg-[#B9886A] h-[106px] w-[106px] flex items-center justify-center text-white text-[13px] px-4 py-1 rounded-full font-semibold">
                                FEATURED
                            </div>
                        <?php endif; ?>

                        <h2 class="font-display text-[26px] text-primary mb-3">
                            <?php echo esc_html($title); ?>
                        </h2>

                        <?php if ($excerpt): ?>
                        <p class="text-primary/80 mb-4 leading-relaxed">
                            <?php echo esc_html($excerpt); ?>
                        </p>
                        <?php endif; ?>

                        <div class="space-y-1 mb-6 text-primary/90">
                            <?php if ($location): ?>
                            <p class="flex items-center gap-2">
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
                                <?php echo esc_html($location); ?>
                            </p>
                            <?php endif; ?>

                            <?php if ($guests): ?>
                            <p class="flex items-center gap-2">
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
                                <?php echo esc_html($guests); ?> Guests
                            </p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <a href="<?php echo esc_url($link); ?>"
                            class="!no-underline inline-block bg-primary text-white px-6 py-2 rounded hover:bg-primary/90 transition">
                            View Details
                            </a>                    
                        </div>

                    </div>                
            </div>

        </div>

        <?php endforeach; ?>
    </div>

    <!-- Custom SVG Arrows -->
    <div class="nds-prev absolute top-1/2 left-14 -translate-y-1/2 cursor-pointer z-20">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="20" cy="20" r="20" transform="matrix(-1 0 0 1 40 0)" fill="#D7CFC5"/>
            <path d="M21.6167 25.8427L15.6964 20.3396L21.6224 14.8427"
                stroke="#1C1C1C" stroke-width="1.5" stroke-linecap="square"/>
        </svg>
    </div>

    <div class="nds-next absolute top-1/2 right-14 -translate-y-1/2 cursor-pointer z-20">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="20" cy="20" r="20" fill="#D7CFC5"/>
            <path d="M18.3829 25.8425L24.3031 20.3395L18.3772 14.8425"
                stroke="#1C1C1C" stroke-width="1.5" stroke-linecap="square"/>
        </svg>
    </div>



    <!-- Dots -->
    <div class="swiper-pagination"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    new Swiper('.nds-hero-carousel', {
        loop: true,
        speed: 750,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.nds-next',
            prevEl: '.nds-prev'
        }
    });
});
</script>
