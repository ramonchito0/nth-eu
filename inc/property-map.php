<?php
add_action('wp_ajax_nopriv_nds_filter_properties', 'nds_filter_properties');
add_action('wp_ajax_nds_filter_properties', 'nds_filter_properties');

function nds_filter_properties() {

    // Receive filters
    $vibe   = $_POST['vibe'] ?? '';
    $event  = $_POST['event_type'] ?? '';
    $style  = $_POST['style'] ?? '';
    $guests = $_POST['guests'] ?? '';
    $dest   = $_POST['destination'] ?? '';
    $category = $_POST['property_category'] ?? '';

    // Build query (same as your block)
    $args = [
        'post_type'      => 'property',
        'posts_per_page' => -1,
        'meta_query'     => ['relation' => 'AND'],
    ];

    if ($vibe) {
        $args['meta_query'][] = [
            'key'     => 'vibe',
            'value'   => $vibe,
            'compare' => 'LIKE'
        ];
    }

    if ($event) {
        $args['meta_query'][] = [
            'key'     => 'event_type',
            'value'   => $event,
            'compare' => 'LIKE'
        ];
    }

    if ($style) {
        $args['meta_query'][] = [
            'key'     => 'style',
            'value'   => $style,
            'compare' => 'LIKE'
        ];
    }

    if ($guests) {
        $args['meta_query'][] = [
            'key'     => 'guest_count',
            'value'   => $guests,
            'compare' => '='
        ];
    }

    if ($dest) {
        $args['meta_query'][] = [
            'key'     => 'state',
            'value'   => $dest,
            'compare' => '='
        ];
    }

    if( $category ) {
        $args['tax_query'][] = [
            'taxonomy' => 'property-category',
            'field'    => 'slug',
            'terms'    => $category,
        ];
    }    

    // Run query
    $query = new WP_Query($args);

    ob_start();

    // --------------------------
    // Render RESULT CARDS HTML
    // --------------------------
    if ($query->have_posts()) :

        // Sorting logic (promoted first, max 2)
        $promoted = [];
        $regular  = [];

        while ($query->have_posts()) : $query->the_post();
            $is_promoted = get_field('featured');

            if ($is_promoted && count($promoted) < 2) {
                $promoted[] = get_the_ID();
            } else {
                $regular[] = get_the_ID();
            }
        endwhile;

        $items = array_merge($promoted, $regular);

        wp_reset_postdata();

        foreach ($items as $post_id) :

            $lat   = get_field('lat', $post_id);
            $lng   = get_field('lng', $post_id);
            $city  = get_field('city', $post_id);
            $state = get_field('state', $post_id);
            $guest = get_field('guest_count', $post_id);
            $promo = get_field('featured', $post_id);
            
            ?>

        <article class="<?php echo $promo ? 'bg-accent' : 'bg-white'; ?> rounded p-6 flex gap-4">
            
            <!-- Thumbnail -->
            <div class="w-[100px] h-[100px] rounded-full overflow-hidden flex-shrink-0">
                <?= get_the_post_thumbnail( $post_id, 'thumbnail', ['class' => 'w-full h-full object-cover'] ); ?>
            </div>

            <!-- Content -->
            <div class="flex-1 flex flex-col gap-3">

                <?php if ( $promo ) : ?>
                    <span class="inline-flex items-center max-w-fit px-3 py-1 rounded bg-[#B9886A] text-xs font-medium text-white">
                        ★ Promoted
                    </span>
                <?php endif; ?>

                <h3 class="text-2md font-display font-semibold">
                    <?= get_the_title($post_id); ?>
                </h3>

                <div class="flex flex-col gap-1 text-sm">

                    <!-- Location -->
                    <span class="flex items-center gap-1">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.4324 6.13099C12.4324 9.60685 7.00135 13.3 7.00135 13.3C7.00135 13.3 1.57031 9.60685 1.57031 6.13099C1.57031 3.08961 4.12185 0.699951 7.00135 0.699951C9.88084 0.699951 12.4324 3.08961 12.4324 6.13099Z" stroke="#5F5F5F" stroke-linecap="round"/>
                            <path d="M7.00009 8.08613C8.07991 8.08613 8.95527 7.21077 8.95527 6.13095C8.95527 5.05114 8.07991 4.17578 7.00009 4.17578C5.92028 4.17578 5.04492 5.05114 5.04492 6.13095C5.04492 7.21077 5.92028 8.08613 7.00009 8.08613Z" stroke="#5F5F5F" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?= esc_html("$city, $state"); ?>
                    </span>

                    <!-- Guests -->
                    <?php if ( $guest ) : ?>
                        <span class="flex items-center gap-1">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.521484 12.3096L8.25586 12.3999C8.25586 12.3999 8.23802 11.9282 8.14639 11.4776C7.8935 10.2337 7.0674 8.03369 4.38806 8.03369C1.70873 8.03369 0.882654 10.2337 0.629714 11.4776C0.538095 11.9282 0.521484 12.3096 0.521484 12.3096Z" stroke="#5F5F5F" stroke-linecap="square"/>
                                <path d="M9.47852 8.03369C11.1716 8.03369 11.8651 9.78307 12.145 11.0439C12.2961 11.7248 11.7454 12.3096 11.0479 12.3096H10.293" stroke="#5F5F5F" stroke-linecap="square"/>
                                <path d="M4.38821 4.97954C5.6252 4.97954 6.62798 3.97676 6.62798 2.73977C6.62798 1.50278 5.6252 0.5 4.38821 0.5C3.15122 0.5 2.14844 1.50278 2.14844 2.73977C2.14844 3.97676 3.15122 4.97954 4.38821 4.97954Z" stroke="#5F5F5F" stroke-linecap="square"/>
                                <path d="M8.66406 4.97954C9.90107 4.97954 10.7002 3.97676 10.7002 2.73977C10.7002 1.50278 9.90107 0.5 8.66406 0.5" stroke="#5F5F5F" stroke-linecap="square"/>
                            </svg>
                            <?= esc_html( $guest ); ?> guests
                        </span>
                    <?php endif; ?>

                </div>

                <a href="<?= get_permalink($post_id); ?>"
                   class="!no-underline font-display flex items-center gap-1 text-14 font-semibold">
                    View Details
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.60547 0.5L10.9997 5.64901L5.60547 10.798" stroke="#1C1C1C" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.9999 5.64917L0.5 5.64917" stroke="#1C1C1C" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>

            </div>

        </article>

        <?php endforeach;

    else:
        echo "<p>No properties found.</p>";
    endif;

    $html = ob_get_clean();

    // --------------------------
    // MARKERS
    // --------------------------
    $markers = [];

    foreach ($items as $post_id) {
        $lat   = get_field('lat', $post_id);
        $lng   = get_field('lng', $post_id);

        if ($lat && $lng) {
            $markers[] = [
                'title' => get_the_title($post_id),
                'lat'   => floatval($lat),
                'lng'   => floatval($lng),
                'city'  => get_field('city', $post_id),
                'state' => get_field('state', $post_id),
                'link'  => get_permalink($post_id),
                'guests' => get_field('guest_count', $post_id),
                'image' => get_the_post_thumbnail_url($post_id, 'thumbnail'),
            ];
        }
    }

    wp_send_json([
        'html'    => $html,
        'markers' => $markers
    ]);
}


/* helper function select fields */
function nds_render_select_field($fieldEnabled, $name, $label, $choices) {
    if (empty($fieldEnabled) || empty($choices)) {
        return;
    }

    $selected = isset($_GET[$name]) ? $_GET[$name] : '';
    ?>
    <select name="<?= esc_attr($name); ?>">
        <option value=""><?= esc_html($label); ?></option>

        <?php foreach ($choices as $value => $text): ?>
            <option 
                value="<?= esc_attr($value); ?>"
                <?= selected($selected, $value); ?>
            >
                <?= esc_html($text); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}

/* helper function for alpine js fields */

function nds_dropdown($fieldEnabled, $name, $label, $choices) {

    if (empty($fieldEnabled) || empty($choices)) {
        return;
    }

    $selected = isset($_GET[$name]) ? $_GET[$name] : '';
    ?>

    <div 
        x-data="dropdown_<?= $name ?>()"
        class="relative w-full"
    >
        <!-- Hidden GET field -->
        <input type="hidden" name="<?= esc_attr($name) ?>" x-model="value">

        <!-- Trigger -->
        <button 
            type="button"
            @click="toggle()"
            class="w-full bg-white border border-[#909191] rounded-lg px-4 py-3 text-left flex justify-between items-center"
            x-ref="trigger"
        >
            <span x-text="selectedLabel || '<?= esc_html($label) ?>'"></span>

            <!-- ORIGINAL CARET (your icon) -->
            <svg width="12" height="9" viewBox="0 0 12 9" fill="none"
                 xmlns="http://www.w3.org/2000/svg"
                 class="transition-transform duration-200"
                 :class="open ? 'rotate-180' : ''">
                <path d="M11.5 1.05983L6 6.98291L0.5 1.05983" stroke="#5F5F5F" stroke-width="1.5" stroke-linecap="square"/>
            </svg>
        </button>

        <!-- Teleported dropdown -->
        <template x-teleport="body">
            <div 
                x-show="open"
                x-transition
                @click.away="open = false"
                class="absolute bg-white border border-[#909191] rounded-lg shadow-xl z-[9999]"
                :style="`top:${coords.top}px; left:${coords.left}px; width:${coords.width}px`"
            >
                <div 
                    @click="select('', '')"
                    class="rounded-tl-lg rounded-tr-lg px-4 py-2 cursor-pointer hover:bg-[#F4F4F4]"
                    :class="value === '' ? 'bg-[#F4F4F4]' : ''"
                >
                    <?= esc_html($label) ?>
                </div>            
                <template x-for="(label, val) in items" :key="val">
                    <div 
                        @click="select(val, label)"
                        class="px-4 py-2 cursor-pointer hover:bg-[#F4F4F4]"
                        :class="value === val ? 'bg-[#F4F4F4]' : ''"
                        x-text="label"
                    ></div>
                </template>
            </div>
        </template>
    </div>
 <?php if (!wp_doing_ajax()): ?>
    <script>
        function dropdown_<?= $name ?>() {
            return {
                open: false,
                value: "<?= esc_js($selected) ?>",
                selectedLabel: "<?= esc_js($choices[$selected] ?? '') ?>",
                items: <?= json_encode($choices) ?>,

                coords: { top: 0, left: 0, width: 0 },

                toggle() {
                    this.open = !this.open;
                    if (this.open) this.updatePosition();
                },

                updatePosition() {
                    this.$nextTick(() => {
                        const trigger = this.$refs.trigger;
                        const rect = trigger.getBoundingClientRect();

                        this.coords = {
                            top: rect.bottom + window.scrollY + 6,
                            left: rect.left + window.scrollX,
                            width: rect.width
                        };
                    });
                },

                select(val, label) {
                    this.value = val;
                    this.selectedLabel = label;
                    this.open = false;
                }
            }
        }
    </script>
<?php endif; ?>
    <?php
}


