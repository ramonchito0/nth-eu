<?php if (have_rows('features')): ?>
<section class="mt-12">


    <!-- Header Row -->
    <div class="grid grid-cols-2 font-semibold text-[#1C1C1C] pb-3 border-b">
        <div class="text-20">Feature</div>
        <div class="text-20">Destination</div>
    </div>

    <!-- Rows -->
    <div class="divide-y border-b" style="--tw-divide-opacity:1; divide-color: var(--color-accent);">

        <?php while (have_rows('features')): the_row(); 
            $label = get_sub_field('label'); 
            $value = get_sub_field('value');
        ?>
            <div class="grid grid-cols-2 py-3 text-[14px] text-[#1C1C1C]">
                <div><?php echo esc_html($label); ?></div>
                <div><?php echo wp_kses_post($value); ?></div>
            </div>
        <?php endwhile; ?>

    </div>

</section>
<?php endif; ?>
