<?php if (have_rows('property_offers')): ?>
<section class="flex flex-col gap-8 mt-10">

    <!-- Heading -->
    <h3 class="text-20 font-[var(--font-sans)]">
        What This Venue Offers
    </h3>

    <!-- Offers Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-4 gap-x-8">

        <?php while (have_rows('property_offers')): the_row(); 
            $icon = get_sub_field('icon');
            $label = get_sub_field('label');
        ?>

        <div class="flex items-center gap-3">
            <!-- Icon (class is dynamic based on ACF value) -->
            <span class="offer-icon <?php echo esc_attr($icon); ?> w-5 h-5 block"></span>

            <span class="text-[14px] text-[#1C1C1C]">
                <?php echo esc_html($label); ?>
            </span>
        </div>

        <?php endwhile; ?>

    </div>

</section>
<?php endif; ?>
