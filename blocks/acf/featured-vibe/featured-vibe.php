<?php
$items = get_field('vibe_items');
if ($items):
?>

<div class="container mx-auto px-4 py-10">

    <!-- First Row: 4 columns -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <?php for ($i = 0; $i < 4 && $i < count($items); $i++):
            $item = $items[$i];
            $title = $item['title'];
            $image = $item['image']['url'] ?? '/wp-content/uploads/2025/11/vibe-img1.png';
            $link  = $item['link'];
        ?>

        <div class="border border-[#DADADA] rounded-xl overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1">

            <div class="overflow-hidden rounded-t-xl">
                <img src="<?php echo esc_url($image); ?>" 
                     class="w-full h-[180px] object-cover transition-transform duration-300 hover:scale-105">
            </div>

            <div class="p-4">
                <?php if ($link): ?>
                    <a href="<?php echo esc_url($link['url']); ?>" 
                       target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
                        <h3 class="text-[18px] font-display text-[var(--color-primary)] text-center">
                            <?php echo esc_html($title); ?>
                        </h3>
                    </a>
                <?php else: ?>
                    <h3 class="text-[18px] font-display text-[var(--color-primary)] text-center">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
            </div>

        </div>

        <?php endfor; ?>
    </div>

    <!-- Second Row: 3 columns -->
    <?php if (count($items) > 4): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

        <?php for ($i = 4; $i < 7 && $i < count($items); $i++):
            $item = $items[$i];
            $title = $item['title'];
            $image = $item['image']['url'] ?? '/wp-content/uploads/2025/11/vibe-img1.png';
            $link  = $item['link'];
        ?>

        <div class="border border-[#DADADA] rounded-xl overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1">

            <div class="overflow-hidden rounded-t-xl">
                <img src="<?php echo esc_url($image); ?>" 
                     class="w-full h-[180px] object-cover transition-transform duration-300 hover:scale-105">
            </div>

            <div class="p-4">
                <?php if ($link): ?>
                    <a href="<?php echo esc_url($link['url']); ?>" 
                       target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
                        <h3 class="text-[18px] font-display text-[var(--color-primary)] text-center">
                            <?php echo esc_html($title); ?>
                        </h3>
                    </a>
                <?php else: ?>
                    <h3 class="text-[18px] font-display text-[var(--color-primary)] text-center">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>
            </div>

        </div>

        <?php endfor; ?>
    </div>
    <?php endif; ?>

</div>

<?php endif; ?>
