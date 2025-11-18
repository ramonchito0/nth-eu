<?php if (have_rows('why_we_like')): ?>
<section class="flex flex-col gap-8 mt-14">

    <!-- Grid (2 columns on desktop) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-10 gap-x-10">

        <?php while (have_rows('why_we_like')): the_row(); 
            $icon = get_sub_field('icon');
            $title = get_sub_field('title');
            $description = get_sub_field('description');
        ?>

        <div class="flex items-start gap-4">

            <!-- Icon circle -->
            <div class="w-16 h-16 rounded-full bg-[#D7CFC5] flex items-center justify-center">
                <!-- Dynamic icon class (same as Property Offers) -->
                <span class="why-icon <?php echo esc_attr($icon); ?> w-6 h-6 block"></span>
            </div>

            <!-- Text content -->
            <div>
                <div class="font-semibold text-[16px] mb-1">
                    <?php echo esc_html($title); ?>
                </div>

                <div class="text-[14px] text-[#1C1C1C] leading-relaxed">
                    <?php echo esc_html($description); ?>
                </div>
            </div>

        </div>

        <?php endwhile; ?>

    </div>

</section>
<?php endif; ?>
