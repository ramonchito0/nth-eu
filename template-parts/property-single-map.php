<?php
$street = get_field('street');
$city = get_field('city');
$state = get_field('state');
$postal = get_field('postal_code');
$country = get_field('country');
$lat = get_field('lat');
$lng = get_field('lng');
?>

<section class="bg-white mt-10 py-20">

   <div class="container">
 <!-- Heading -->
    <h2 class="h-text-32 mb-6">Location</h2>

    <!-- Address -->
    <div class="flex items-center gap-2 mb-6 text-[#1C1C1C]">
        
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0_4002_3386)">
        <path d="M15.9831 7.88266C15.9831 12.3516 9.00034 17.0999 9.00034 17.0999C9.00034 17.0999 2.01758 12.3516 2.01758 7.88266C2.01758 3.97232 5.29812 0.899902 9.00034 0.899902C12.7025 0.899902 15.9831 3.97232 15.9831 7.88266Z" stroke="#393B44" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M9.00012 10.3965C10.3885 10.3965 11.5139 9.27102 11.5139 7.88269C11.5139 6.49436 10.3885 5.3689 9.00012 5.3689C7.61179 5.3689 6.48633 6.49436 6.48633 7.88269C6.48633 9.27102 7.61179 10.3965 9.00012 10.3965Z" stroke="#393B44" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </g>
        <defs>
        <clipPath id="clip0_4002_3386">
        <rect width="18" height="18" fill="white"/>
        </clipPath>
        </defs>
        </svg>


        <span class="text-[15px]">
            <?php echo esc_html("$street, $city, $state $postal $country"); ?>
        </span>
    </div>

    <!-- Map Container -->
    <div class="w-full h-[350px] lg:h-[420px] rounded-xl border overflow-hidden relative p-5"
         style="border-color: var(--color-accent);">

        <div id="propertyMap" class="w-full h-full rounded-lg"></div>

    </div>    
   </div>

</section>

<script>
document.addEventListener("DOMContentLoaded", function () {

    let lat = <?php echo floatval($lat); ?>;
    let lng = <?php echo floatval($lng); ?>;

    function initMap() {
        let map = new google.maps.Map(document.getElementById("propertyMap"), {
            center: { lat: lat, lng: lng },
            zoom: 11,
            disableDefaultUI: true,
            zoomControl: true,
            fullscreenControl: true,
styles: [
    {
        "elementType": "geometry",
        "stylers": [
            { "color": "#f5f5f5" }
        ]
    },
    {
        "elementType": "labels.icon",
        "stylers": [
            { "visibility": "off" }
        ]
    },
    {
        "elementType": "labels.text.fill",
        "stylers": [
            { "color": "#616161" }
        ]
    },
    {
        "elementType": "labels.text.stroke",
        "stylers": [
            { "color": "#f5f5f5" }
        ]
    },
    {
        "featureType": "administrative.land_parcel",
        "stylers": [
            { "visibility": "off" }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "stylers": [
            { "visibility": "off" }
        ]
    },
    {
        "featureType": "poi",
        "stylers": [
            { "visibility": "off" }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [
            { "color": "#ffffff" }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels.icon",
        "stylers": [
            { "visibility": "off" }
        ]
    },
    {
        "featureType": "road.arterial",
        "stylers": [
            { "color": "#f0f0f0" }
        ]
    },
    {
        "featureType": "road.highway",
        "stylers": [
            { "color": "#e0e0e0" }
        ]
    },
    {
        "featureType": "road.local",
        "stylers": [
            { "color": "#ffffff" }
        ]
    },
    {
        "featureType": "transit",
        "stylers": [
            { "visibility": "off" }
        ]
    },
    {
        "featureType": "water",
        "stylers": [
            { "color": "#e9e9e9" }
        ]
    }
]

        });

        // Marker
// Custom SVG pin (inline)
const pinSvg = `
<svg width="30" height="40" viewBox="0 0 30 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M0 15V15.7317C0 19.3039 1.21575 22.7697 3.4473 25.559L15 40L26.5528 25.559C28.7843 22.7697 30 19.3039 30 15.7317V15C30 6.71572 23.2843 0 15 0C6.71572 0 0 6.71572 0 15ZM15 20C17.7614 20 20 17.7614 20 15C20 12.2386 17.7614 10 15 10C12.2386 10 10 12.2386 10 15C10 17.7614 12.2386 20 15 20Z" fill="#B9886A"/>
</svg>
`;

const marker = new google.maps.Marker({
    position: { lat: lat, lng: lng },
    map,
    icon: {
        url: "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(pinSvg),
        scaledSize: new google.maps.Size(30, 40),
        anchor: new google.maps.Point(15, 40) // center bottom
    }
});


        // Circle overlay
        new google.maps.Circle({
            strokeColor: "#D7CFC5",
            strokeOpacity: 0,
            strokeWeight: 0,
            fillColor: "#D7CFC5",
            fillOpacity: 0.35,
            map: map,
            center: { lat: lat, lng: lng },
            radius: 3000 // adjust as needed
        });
    }

    // wait for google script
    if (typeof google !== "undefined") {
        initMap();
    } else {
        window.initMap = initMap;
    }
});
</script>
