<?php

    $destinations = get_field('destinations');
    if (!$destinations) return;
?>
<div class="relative w-full max-w-[1520px] mx-auto pt-10 pb-14 md:pb-20 px-5">

    <div class="swiper nds-destinations-swiper">
        <div class="swiper-wrapper">

            <?php foreach ($destinations as $item):
                $img = $item['image'];
                $title = $item['title'];
            ?>
            <div class="swiper-slide relative overflow-hidden rounded-[8px] cursor-pointer">

                <?php if ($img): ?>
                    <img
                        src="<?php echo esc_url($img['url']); ?>"
                        alt="<?php echo esc_attr($title); ?>"
                        class="w-full h-[320px] object-cover rounded-[8px]"
                    >
                <?php endif; ?>

                <!-- Gradient -->
                <div class="absolute bottom-0 left-0 w-full h-[45%] rounded-b-[8px] bg-gradient-to-t from-black/60 to-transparent"></div>

                <!-- Centered Heading -->
                <?php if ($title): ?>
                <h3 class="absolute w-full left-1/2 -translate-x-1/2 bottom-[38px]
                           text-white h-text-24 font-display 
                           tracking-[0.02em] text-center px-4">
                    <?php echo esc_html($title); ?>
                </h3>
                <?php endif; ?>

            </div>
            <?php endforeach; ?>

        </div>
    </div>

    <!-- Custom SVG Arrows -->
    <div class="nds-prev absolute top-1/2 -left-14 -translate-y-1/2 cursor-pointer">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="20" cy="20" r="20" transform="matrix(-1 0 0 1 40 0)" fill="#D7CFC5"/>
            <path d="M21.6167 25.8427L15.6964 20.3396L21.6224 14.8427"
                  stroke="#1C1C1C" stroke-width="1.5" stroke-linecap="square"/>
        </svg>
    </div>

    <div class="nds-next absolute top-1/2 -right-14 -translate-y-1/2 cursor-pointer">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="20" cy="20" r="20" fill="#D7CFC5"/>
            <path d="M18.3829 25.8425L24.3031 20.3395L18.3772 14.8425"
                  stroke="#1C1C1C" stroke-width="1.5" stroke-linecap="square"/>
        </svg>
    </div>

    <!-- Pagination Dots -->
    <div class="swiper-pagination mt-6"></div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".nds-destinations-swiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        speed: 500,

        navigation: {
            nextEl: ".nds-next",
            prevEl: ".nds-prev"
        },

        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            renderBullet: function (index, className) {
                return '<span class="' + className + '"></span>';
            }
        },

        breakpoints: {
            1400: { slidesPerView: 5 },
            1200: { slidesPerView: 4 },
            992:  { slidesPerView: 3 },
            768:  { slidesPerView: 2 },
            480:  { slidesPerView: 1 }
        }
    });

    /* Bullet colors */
    const observer = new MutationObserver(() => {
        document.querySelectorAll('.swiper-pagination-bullet').forEach(b => {
            b.style.background = '#D0D0D0';
            b.style.opacity = '1';
        });
        const active = document.querySelector('.swiper-pagination-bullet-active');
        if (active) active.style.background = '#5F5F5F';
    });

    observer.observe(document.body, { childList: true, subtree: true });
});
</script>
