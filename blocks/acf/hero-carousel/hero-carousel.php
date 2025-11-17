<?php
$slides = get_field('slides');
if (!$slides) return;
?>

<div class="nds-hero-carousel relative w-full h-[650px] swiper overflow-hidden">

    <div class="swiper-wrapper">
        <?php foreach ($slides as $slide): ?>
        <div class="swiper-slide relative">

            <!-- BG IMAGE -->
            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('<?php echo esc_url($slide['image']); ?>');">
            </div>

            <!-- CARD -->
            <div class="absolute right-[8%] top-1/2 -translate-y-1/2 bg-white w-[457px] p-16 space-y-8 flex flex-col gap-5">

                <?php if (!empty($slide['featured'])): ?>
                    <div class="absolute -top-4 -right-4 bg-[#B9886A] h-[106px] w-[106px] flex items-center justify-center text-white text-[13px] px-4 py-1 rounded-full font-semibold">
                        FEATURED
                    </div>
                <?php endif; ?>

                <h2 class="font-display h-text-24 text-primary mb-3">
                    <?php echo esc_html($slide['heading']); ?>
                </h2>

                <p class="text-primary/80 mb-4 leading-relaxed">
                    <?php echo esc_html($slide['description']); ?>
                </p>

                <div class="space-y-1 mb-6 text-primary/90">
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
                    </svg> <?php echo esc_html($slide['location']); ?>
                    </p>
                    <p class="flex items-center gap-2">
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
</svg> <?php echo esc_html($slide['guests']); ?>
                    </p>
                </div>

                <?php if (!empty($slide['link'])): ?>
                    <div>
                        <a href="<?php echo esc_url($slide['link']['url']); ?>"
                           class="!no-underline inline-block bg-primary text-white px-6 py-2 rounded hover:bg-primary/90 transition">
                            <?php echo esc_html($slide['link']['title']); ?>
                        </a>                        
                    </div>
                <?php endif; ?>

            </div>

        </div>
        <?php endforeach; ?>
    </div>

    <!-- ARROWS -->
    <div class="swiper-button-prev !w-10 !h-10 text-white drop-shadow"></div>
    <div class="swiper-button-next !w-10 !h-10 text-white drop-shadow"></div>

    <!-- DOTS -->
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
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        }
    });
});
</script>
