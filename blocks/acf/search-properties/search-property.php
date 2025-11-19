<?php
if (!function_exists('acf_choices')) {
    function acf_choices($name) {
        $obj = get_field_object($name);
        return ($obj && isset($obj['choices'])) ? $obj['choices'] : [];
    }
}

$vibe_choices = acf_choices('vibe');
$event_choices   = acf_choices('event_type');
$style_choices   = acf_choices('style');
$guest_choices   = acf_choices('guests');
$dest_choices    = acf_choices('destination');

$vibeField = get_field('vibe');
$eventField = get_field('event_type');
$styleField = get_field('style');
$guestField = get_field('guests');
$destinationField = get_field('destination');

$search_form_only = get_field('search_form_only'); 
$filterByCategory = get_field('property_category');
?>

<?php if ($search_form_only): ?>
    <div class="nds-search-form-only">
            <form action="<?php echo site_url('/property-for-events-listing/'); ?>" method="get" class="flex flex-col lg:flex-row gap-4 items-center">

                <!-- Vibe -->
                <?php if (!empty($vibeField)): ?> 
                    <select name="vibe">
                        <option value="">Select Vibe</option>

                        <?php 
                        $selected_vibe = isset($_GET['vibe']) ? $_GET['vibe'] : '';
                        foreach ($vibe_choices as $value => $label): 
                        ?>
                            <option 
                                value="<?= esc_attr($value); ?>"
                                <?= selected($selected_vibe, $value); ?>
                            >
                                <?= esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>


                <!-- Event Type -->
                <?php if (!empty($eventField)): ?>
                    <select name="event_type">
                        <option value="">Select Event Type</option>

                        <?php 
                        $selected_event = isset($_GET['event_type']) ? $_GET['event_type'] : '';
                        foreach ($event_choices as $value => $label): 
                        ?>
                            <option 
                                value="<?= esc_attr($value); ?>"
                                <?= selected($selected_event, $value); ?>
                            >
                                <?= esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>


                <!-- Style -->
                <?php if (!empty($styleField)): ?>
                    <select name="style">
                        <option value="">Select Style</option>

                        <?php 
                            $selected_style = isset($_GET['style']) ? $_GET['style'] : '';
                            foreach ($style_choices as $value => $label): 
                        ?>
                            <option 
                                value="<?= esc_attr($value); ?>"
                                <?= selected($selected_style, $value); ?>
                            >
                                <?= esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>


                <!-- Guests -->
                <?php if (!empty($guestField)): ?>
                    <select name="guests">
                        <option value="">Select Guests</option>

                        <?php 
                            $selected_guests = isset($_GET['guests']) ? $_GET['guests'] : '';
                            foreach ($guest_choices as $value => $label): 
                        ?>
                            <option 
                                value="<?= esc_attr($value); ?>"
                                <?= selected($selected_guests, $value); ?>
                            >
                                <?= esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>


                <!-- Destination -->
                <?php if (!empty($destinationField)): ?>
                    <select name="destination">
                        <option value="">Select Destination</option>

                        <?php 
                            $selected_dest = isset($_GET['destination']) ? $_GET['destination'] : '';
                            foreach ($dest_choices as $value => $label): 
                        ?>
                            <option 
                                value="<?= esc_attr($value); ?>"
                                <?= selected($selected_dest, $value); ?>
                            >
                                <?= esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>


                <!-- Search Button -->
                <button type="submit">Search</button>

            </form>
    </div>
<?php return; endif; ?>


<form method="get" class="nds-search-property flex flex-col lg:flex-row gap-4 items-center">

                <!-- Vibe -->
                <?php if (!empty($vibeField)): ?> 
                    <select name="vibe">
                        <option value="">Select Vibe</option>

                        <?php 
                        $selected_vibe = isset($_GET['vibe']) ? $_GET['vibe'] : '';
                        foreach ($vibe_choices as $value => $label): 
                        ?>
                            <option 
                                value="<?= esc_attr($value); ?>"
                                <?= selected($selected_vibe, $value); ?>
                            >
                                <?= esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>


                <!-- Event Type -->
                <?php if (!empty($eventField)): ?>
                    <select name="event_type">
                        <option value="">Select Event Type</option>

                        <?php 
                        $selected_event = isset($_GET['event_type']) ? $_GET['event_type'] : '';
                        foreach ($event_choices as $value => $label): 
                        ?>
                            <option 
                                value="<?= esc_attr($value); ?>"
                                <?= selected($selected_event, $value); ?>
                            >
                                <?= esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>


                <!-- Style -->
                <?php if (!empty($styleField)): ?>
                    <select name="style">
                        <option value="">Select Style</option>

                        <?php 
                            $selected_style = isset($_GET['style']) ? $_GET['style'] : '';
                            foreach ($style_choices as $value => $label): 
                        ?>
                            <option 
                                value="<?= esc_attr(strtolower($value)); ?>"
                                <?= selected($selected_style, strtolower($value)); ?>
                            >
                                <?= esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>


                <!-- Guests -->
                <?php if (!empty($guestField)): ?>
                    <select name="guests">
                        <option value="">Select Guests</option>

                        <?php 
                            $selected_guests = isset($_GET['guests']) ? $_GET['guests'] : '';
                            foreach ($guest_choices as $value => $label): 
                        ?>
                            <option 
                                value="<?= esc_attr($value); ?>"
                                <?= selected($selected_guests, $value); ?>
                            >
                                <?= esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>


                <!-- Destination -->
                <?php if (!empty($destinationField)): ?>
                    <select name="destination">
                        <option value="">Select Destination</option>

                        <?php 
                            $selected_dest = isset($_GET['destination']) ? $_GET['destination'] : '';
                            foreach ($dest_choices as $value => $label): 
                        ?>
                            <option 
                                value="<?= esc_attr($value); ?>"
                                <?= selected($selected_dest, $value); ?>
                            >
                                <?= esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>

                <input type="hidden" name="property_category" value="<?= esc_attr($filterByCategory); ?>">


                    <!-- Search Button -->
                    <button type="submit">Search</button>

</form>


<?php
$filter_vibe        = isset($_GET['vibe']) ? $_GET['vibe'] : '';
$filter_event       = isset($_GET['event_type']) ? $_GET['event_type'] : '';
$filter_style       = isset($_GET['style']) ? $_GET['style'] : '';
$filter_guests      = isset($_GET['guests']) ? $_GET['guests'] : '';
$filter_destination = isset($_GET['destination']) ? $_GET['destination'] : '';

$args = [
    'post_type'      => 'property',
    'posts_per_page' => -1,
    'meta_query'     => ['relation' => 'AND'],
];

if ($filter_vibe) {
    $args['meta_query'][] = [
        'key'     => 'vibe',
        'value'   => $filter_vibe,
        'compare' => 'LIKE'
    ];
}

if ($filter_event) {
    $args['meta_query'][] = [
        'key'     => 'event_type',
        'value'   => $filter_event,
        'compare' => 'LIKE'
    ];
}

if ($filter_style) {
    $args['meta_query'][] = [
        'key'     => 'style',
        'value'   => $filter_style,
        'compare' => 'LIKE'
    ];
}

if ($filter_guests) {
    $args['meta_query'][] = [
        'key'     => 'guest_count',
        'value'   => $filter_guests,
        'compare' => '='
    ];
}

if ($filter_destination) {
    $args['meta_query'][] = [
        'key'     => 'state',
        'value'   => $filter_destination,
        'compare' => '='
    ];
}

if( $filterByCategory ) {
    $args['tax_query'][] = [
        'taxonomy' => 'property-category',
        'field'    => 'slug',
        'terms'    => $filterByCategory,
    ];
}


$query = new WP_Query($args);

$map_markers = [];
?>

<div class="grid grid-cols-1 lg:grid-cols-[490px_1fr] gap-6 items-stretch">
    <div class="bg-transparent">
        <div id="nds-loading" 
            class="hidden fixed inset-0 bg-white/70 backdrop-blur-sm z-50 flex items-center justify-center">
            <div class="animate-spin w-10 h-10 border-4 border-[#B9886A] border-t-transparent rounded-full"></div>
        </div>        
        <div class="results-list lg:h-[600px] overflow-y-auto pr-3 flex flex-col gap-4">

<?php if ( $query->have_posts() ) : ?>

    <?php
    // Arrays for sorting
    $promoted_items = [];
    $regular_items  = [];

    // First pass — sort posts
    while ( $query->have_posts() ) : $query->the_post();

        $is_promoted = get_field('featured', get_the_ID());

        if ( $is_promoted && count($promoted_items) < 2 ) {
            $promoted_items[] = get_the_ID();
        } else {
            $regular_items[] = get_the_ID();
        }

    endwhile;

    // Merge promoted first
    $final_items = array_merge($promoted_items, $regular_items);

    // Reset before second loop
    wp_reset_postdata();

    // Start real output loop
    foreach ( $final_items as $post_id ) :
        setup_postdata( $post_id );

        $lat   = get_field( 'lat', $post_id );
        $lng   = get_field( 'lng', $post_id );
        $city  = get_field( 'city', $post_id );
        $state = get_field( 'state', $post_id );
        $guest_label = get_field( 'guest_count', $post_id );
        $promoted = get_field( 'featured', $post_id );

        // Build map markers
        if ( $lat && $lng ) {
            $map_markers[] = [
                'title' => get_the_title($post_id),
                'lat'   => floatval($lat),
                'lng'   => floatval($lng),
                'city'  => $city,
                'state' => $state,
                'guests' => $guest_label,
                'image' => get_the_post_thumbnail_url($post_id, 'thumbnail'),
            ];
        }
    ?>

        <article class="<?php echo $promoted ? 'bg-accent' : 'bg-white'; ?> rounded p-6 flex gap-4">

            <!-- Thumbnail -->
            <div class="w-[100px] h-[100px] rounded-full overflow-hidden flex-shrink-0">
                <?= get_the_post_thumbnail( $post_id, 'thumbnail', ['class' => 'w-full h-full object-cover'] ); ?>
            </div>

            <!-- Content -->
            <div class="flex-1 flex flex-col gap-3">

                <?php if ( $promoted ) : ?>
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
                    <?php if ( $guest_label ) : ?>
                        <span class="flex items-center gap-1">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.521484 12.3096L8.25586 12.3999C8.25586 12.3999 8.23802 11.9282 8.14639 11.4776C7.8935 10.2337 7.0674 8.03369 4.38806 8.03369C1.70873 8.03369 0.882654 10.2337 0.629714 11.4776C0.538095 11.9282 0.521484 12.3096 0.521484 12.3096Z" stroke="#5F5F5F" stroke-linecap="square"/>
                                <path d="M9.47852 8.03369C11.1716 8.03369 11.8651 9.78307 12.145 11.0439C12.2961 11.7248 11.7454 12.3096 11.0479 12.3096H10.293" stroke="#5F5F5F" stroke-linecap="square"/>
                                <path d="M4.38821 4.97954C5.6252 4.97954 6.62798 3.97676 6.62798 2.73977C6.62798 1.50278 5.6252 0.5 4.38821 0.5C3.15122 0.5 2.14844 1.50278 2.14844 2.73977C2.14844 3.97676 3.15122 4.97954 4.38821 4.97954Z" stroke="#5F5F5F" stroke-linecap="square"/>
                                <path d="M8.66406 4.97954C9.90107 4.97954 10.7002 3.97676 10.7002 2.73977C10.7002 1.50278 9.90107 0.5 8.66406 0.5" stroke="#5F5F5F" stroke-linecap="square"/>
                            </svg>
                            <?= esc_html( $guest_label ); ?> guests
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

    <?php endforeach; ?>
 
<?php else : ?>
    <p class="text-sm text-[#666]">No properties found.</p>
<?php endif; ?>

<?php wp_reset_postdata(); ?>

        </div>
    </div>

    <div>
        <div class="h-[632px] border border-accent rounded-[12px] overflow-hidden p-4">
            <div id="nds-map" class="w-full h-full rounded-[12px]"></div>
        </div>
    </div>
</div>

<script>
// ==== GOOGLE MAP STYLE ======================================================
const ndsMapStyle = [
    { "elementType": "geometry", "stylers": [{ "color": "#f5f5f5" }] },
    { "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] },
    { "elementType": "labels.text.fill", "stylers": [{ "color": "#616161" }] },
    { "elementType": "labels.text.stroke", "stylers": [{ "color": "#f5f5f5" }] },
    { "featureType": "administrative.land_parcel", "stylers": [{ "visibility": "off" }] },
    { "featureType": "administrative.neighborhood", "stylers": [{ "visibility": "off" }] },
    { "featureType": "poi", "stylers": [{ "visibility": "off" }] },
    { "featureType": "road", "elementType": "geometry", "stylers": [{ "color": "#ffffff" }] },
    { "featureType": "road", "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] },
    { "featureType": "road.arterial", "stylers": [{ "color": "#f0f0f0" }] },
    { "featureType": "road.highway", "stylers": [{ "color": "#e0e0e0" }] },
    { "featureType": "road.local", "stylers": [{ "color": "#ffffff" }] },
    { "featureType": "transit", "stylers": [{ "visibility": "off" }] },
    { "featureType": "water", "stylers": [{ "color": "#e9e9e9" }] }
];

// ==== PHP → JS Markers ======================================================
window.NDS_MAP_MARKERS = <?php echo json_encode($map_markers); ?>;

// ==== GOOGLE MAP INIT =======================================================
let ndsMap;
let ndsMarkers = [];

function initNDSMap() {
    const mapElement = document.getElementById("nds-map");
    if (!mapElement) return;

    ndsMap = new google.maps.Map(mapElement, {
        center: { lat: -25.2744, lng: 133.7751 }, // Australia center
        styles: ndsMapStyle,
        zoomControl: true,
        mapTypeControl: false,
        streetViewControl: false,
        fullscreenControl: false,
    });

    renderNDSMarkers();
}


// ==== RENDER MARKERS ========================================================
function renderNDSMarkers() {

    // Remove old markers
    ndsMarkers.forEach(m => m.setMap(null));
    ndsMarkers = [];

    if (!window.NDS_MAP_MARKERS || window.NDS_MAP_MARKERS.length === 0)
        return;

    const bounds = new google.maps.LatLngBounds();

    // Marker
    // Custom SVG pin (inline)
    const pinSvg = `
    <svg width="30" height="40" viewBox="0 0 30 40" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 15V15.7317C0 19.3039 1.21575 22.7697 3.4473 25.559L15 40L26.5528 25.559C28.7843 22.7697 30 19.3039 30 15.7317V15C30 6.71572 23.2843 0 15 0C6.71572 0 0 6.71572 0 15ZM15 20C17.7614 20 20 17.7614 20 15C20 12.2386 17.7614 10 15 10C12.2386 10 10 12.2386 10 15C10 17.7614 12.2386 20 15 20Z" fill="#B9886A"/>
    </svg>
    `;    

    window.NDS_MAP_MARKERS.forEach(point => {

        const marker = new google.maps.Marker({
            position: { lat: point.lat, lng: point.lng },
            map: ndsMap,
            title: point.title,
            icon: {
                url: "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(pinSvg),                
                scaledSize: new google.maps.Size(30, 40),
            }
        });

const info = new google.maps.InfoWindow({
    maxWidth: 262,
    content: `
        <div style="
            font-family: Montserrat;
            width: 262px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        ">
            <img src="${point.image}" 
                 alt="${point.title}" 
                 style="width:100%; height:150px; object-fit:cover;">

            <div style="padding:16px;">

                <h3 style="
                    margin:0 0 8px 0;
                    font-family: 'Zodiak', serif;
                    font-size: 18px;
                    color:#1C1C1C;
                ">
                    ${point.title}
                </h3>

                <p style="
                    margin:0 0 4px 0;
                    font-size:14px;
                    color:#5F5F5F;
                    display:flex;
                    align-items:center;
                    gap:4px;
                ">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M12.4324 6.13099C12.4324 9.60685 7.00135 13.3 7.00135 13.3C7.00135 13.3 1.57031 9.60685 1.57031 6.13099C1.57031 3.08961 4.12185 0.699951 7.00135 0.699951C9.88084 0.699951 12.4324 3.08961 12.4324 6.13099Z" stroke="#5F5F5F" stroke-linecap="round"/>
                        <path d="M7.00009 8.08613C8.07991 8.08613 8.95527 7.21077 8.95527 6.13095C8.95527 5.05114 8.07991 4.17578 7.00009 4.17578C5.92028 4.17578 5.04492 5.05114 5.04492 6.13095C5.04492 7.21077 5.92028 8.08613 7.00009 8.08613Z" stroke="#5F5F5F" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    ${point.city}, ${point.state}
                </p>

                <p style="
                    margin:0;
                    font-size:14px;
                    color:#5F5F5F;
                    display:flex;
                    align-items:center;
                    gap:4px;
                ">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                        <path d="M0.521484 12.3096L8.25586 12.3999C8.25586 12.3999 8.23802 11.9282 8.14639 11.4776C7.8935 10.2337 7.0674 8.03369 4.38806 8.03369C1.70873 8.03369 0.882654 10.2337 0.629714 11.4776C0.538095 11.9282 0.521484 12.3096 0.521484 12.3096Z" stroke="#5F5F5F" stroke-linecap="square"/>
                        <path d="M9.47852 8.03369C11.1716 8.03369 11.8651 9.78307 12.145 11.0439C12.2961 11.7248 11.7454 12.3096 11.0479 12.3096H10.293" stroke="#5F5F5F" stroke-linecap="square"/>
                        <path d="M4.38821 4.97954C5.6252 4.97954 6.62798 3.97676 6.62798 2.73977C6.62798 1.50278 5.6252 0.5 4.38821 0.5C3.15122 0.5 2.14844 1.50278 2.14844 2.73977C2.14844 3.97676 3.15122 4.97954 4.38821 4.97954Z" stroke="#5F5F5F" stroke-linecap="square"/>
                        <path d="M8.66406 4.97954C9.90107 4.97954 10.7002 3.97676 10.7002 2.73977C10.7002 1.50278 9.90107 0.5 8.66406 0.5" stroke="#5F5F5F" stroke-linecap="square"/>
                    </svg>
                    Up to ${point.guests} Guests
                </p>

            </div>
        </div>
    `
});


        marker.addListener("click", () => {
            info.open({
                anchor: marker,
                map: ndsMap,
                shouldFocus: false
            });
        });

        ndsMarkers.push(marker);
        bounds.extend(marker.getPosition());
    });

    // Auto center
    if (ndsMarkers.length > 1) {
        ndsMap.fitBounds(bounds);
    } else if (ndsMarkers.length === 1) {
        ndsMap.setCenter(ndsMarkers[0].getPosition());
        ndsMap.setZoom(10);
    }
}


document.addEventListener("DOMContentLoaded", function() {

    // If Google Maps loaded, init immediately
    if (window.google && google.maps) {
        initNDSMap();
        return;
    }

    // If script isn't loaded yet, wait for load event
    window.addEventListener("load", function() {
        if (window.google && google.maps) {
            initNDSMap();
        }
    });
});
</script>



<script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.querySelector(".nds-search-property");
    const resultsBox = document.querySelector(".results-list");
    const loading = document.getElementById("nds-loading");

    const ajaxUrl = "<?= admin_url('admin-ajax.php'); ?>";

    // Update browser URL
    function updateURL(params) {
        const url = new URL(window.location);

        url.search = ""; // reset

        Object.keys(params).forEach(k => {
            if (params[k]) {
                url.searchParams.set(k, params[k]);
            }
        });

        history.pushState({}, "", url);
    }

    // AJAX FILTER FUNCTION
    function runFilter(e) {
        e.preventDefault();

        // Show loading screen
        loading.classList.remove("hidden");

        const formData = new FormData(form);
        const params = Object.fromEntries(formData);

        updateURL(params);

        fetch(ajaxUrl, {
            method: "POST",
            body: new URLSearchParams({
                action: "nds_filter_properties",
                ...params
            }),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
        })
        .then(res => res.json())
        .then(data => {

            // Replace results HTML
            resultsBox.innerHTML = data.html;

            // Update map markers
            window.NDS_MAP_MARKERS = data.markers;
            renderNDSMarkers();

        })
        .finally(() => {
            // Hide loading overlay
            loading.classList.add("hidden");
        });
    }

    // Bind submit event
    form.addEventListener("submit", runFilter);

    // Back/forward browser navigation
    window.addEventListener("popstate", () => {
        window.location.reload();
    });

});
</script>



