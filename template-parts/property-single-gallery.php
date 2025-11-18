<?php 
$gallery = get_field('gallery'); 
if ($gallery): 
?>

<section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        <!-- Large main image -->
        <div class="lg:col-span-2">
            <?php if (!empty($gallery[0])): ?>
                <a 
                    data-fancybox="property-gallery" 
                    href="<?php echo esc_url($gallery[0]['url']); ?>"
                >
                    <img 
                        src="<?php echo esc_url($gallery[0]['url']); ?>" 
                        alt="<?php echo esc_attr($gallery[0]['alt']); ?>" 
                        class="w-full h-[420px] lg:h-[452px] object-cover"
                    >
                </a>
            <?php endif; ?>
        </div>

        <!-- Side 4-image grid -->
        <div class="grid grid-cols-2 gap-4">

            <?php for ($i = 1; $i <= 4; $i++): ?>
                <?php if (!empty($gallery[$i])): ?>
                    <a 
                        data-fancybox="property-gallery" 
                        href="<?php echo esc_url($gallery[$i]['url']); ?>"
                    >
                        <img 
                            src="<?php echo esc_url($gallery[$i]['url']); ?>" 
                            alt="<?php echo esc_attr($gallery[$i]['alt']); ?>" 
                            class="w-full h-[200px] lg:h-[214px] object-cover"
                        >
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    Fancybox.bind("[data-fancybox='property-gallery']", {});
});
</script>
<?php endif; ?>
