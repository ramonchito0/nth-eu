<?php
/**
 * Footer template for nthdegreesearch theme
 */
?>

<footer class="site-footer pt-20 pb-5">
<div class="container">
    <div class="footer-container">
        <div class="footer-brand">
            <div class="footer-logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/eu-round-logo.svg" alt="Exclusive Use Logo" width="146" height="146">
            </div>
            <div class="footer-description flex flex-col gap-3">
                <?php
                    if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                      the_custom_logo();
                    } else {
                      bloginfo( 'name' ); 
                    }
                ?> 
                <p>A trusted hub connecting professionals to exceptional small group venues and exclusive-use options, helping both planners and property owners achieve better results, fast.</p>
            </div>
        </div>

        <div class="footer-links">
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Properties</a></li>
                    <li><a href="#">Join Loyalty Program</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>More</h3>
                <ul>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Privacy Policies</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Listings</h3>
                <ul>
                    <li><a href="#">Board Meetings</a></li>
                    <li><a href="#">Product Launches</a></li>
                    <li><a href="#">Conference</a></li>
                    <li><a href="#">Activity Spaces</a></li>
                    <li><a href="#">Team Building</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-left">
            <p>Exclusive Use Copyright &copy; <?php echo date('Y'); ?> <span>|</span> All Rights Reserved
                <span>|</span> <a href="#">Terms and Conditions</a> <span>|</span> <a href="#">Privacy Policy</a>
            </p>
        </div>

        <div class="footer-social">
            <a href="#">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="24" height="24" rx="4" fill="#B9886A"/>
<path d="M12.9759 18V12.5262H14.9057L15.1947 10.393H12.9759V9.03102C12.9759 8.4134 13.156 7.99252 14.0863 7.99252L15.2728 7.99199V6.08405C15.0675 6.0581 14.3632 6 13.5439 6C11.8332 6 10.662 6.99412 10.662 8.81982V10.393H8.72729V12.5262H10.662V17.9999H12.9759V18Z" fill="white"/>
</svg>              
            </a>
            <a href="#">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="24" height="24" rx="4" fill="#B9886A"/>
<g clip-path="url(#clip0_4023_2184)">
<mask id="mask0_4023_2184" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="6" y="6" width="12" height="12">
<path d="M18 6H6V18H18V6Z" fill="white"/>
</mask>
<g mask="url(#mask0_4023_2184)">
<path d="M13.1416 11.0786L17.6089 6H16.5503L12.6714 10.4097L9.57328 6H6L10.6849 12.6682L6 17.9938H7.05866L11.1549 13.3371L14.4267 17.9938H18L13.1414 11.0786H13.1416ZM11.6916 12.7269L11.217 12.0629L7.44011 6.77941H9.06615L12.1141 11.0434L12.5888 11.7074L16.5508 17.2499H14.9248L11.6916 12.7272V12.7269Z" fill="white"/>
</g>
</g>
<defs>
<clipPath id="clip0_4023_2184">
<rect width="12" height="12" fill="white" transform="translate(6 6)"/>
</clipPath>
</defs>
</svg>
              
            </a>
            <a href="#">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="24" height="24" rx="4" fill="#B9886A"/>
<path d="M12 6C14.3966 6 15.5949 6.00025 16.458 6.57129C16.8435 6.82633 17.1737 7.15655 17.4287 7.54199C17.9998 8.40514 18 9.60336 18 12C18 14.3966 17.9998 15.5949 17.4287 16.458C17.1737 16.8435 16.8435 17.1737 16.458 17.4287C15.5949 17.9998 14.3966 18 12 18C9.60336 18 8.40514 17.9998 7.54199 17.4287C7.15655 17.1737 6.82633 16.8435 6.57129 16.458C6.00025 15.5949 6 14.3966 6 12C6 9.60336 6.00025 8.40514 6.57129 7.54199C6.82633 7.15655 7.15655 6.82633 7.54199 6.57129C8.40514 6.00025 9.60336 6 12 6ZM12 8.89355C10.2845 8.89355 8.89364 10.2845 8.89355 12C8.89355 13.7155 10.2845 15.1064 12 15.1064C13.7155 15.1064 15.1064 13.7155 15.1064 12C15.1064 10.2846 13.7154 8.89361 12 8.89355ZM12 9.94434C13.135 9.94439 14.0556 10.865 14.0557 12C14.0557 13.1351 13.1351 14.0556 12 14.0557C10.8649 14.0557 9.94434 13.1351 9.94434 12C9.94442 10.8649 10.8649 9.94434 12 9.94434ZM15.2285 8.00781C14.8256 8.00799 14.499 8.33529 14.499 8.73828C14.4993 9.14106 14.8257 9.46759 15.2285 9.46777C15.6315 9.46777 15.9587 9.14117 15.959 8.73828C15.959 8.33518 15.6316 8.00781 15.2285 8.00781Z" fill="white"/>
</svg>

              
            </a>
            <a href="#">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="24" height="24" rx="4" fill="#B9886A"/>
<path d="M6 7.61321C6 7.2284 6.13514 6.91094 6.40541 6.66082C6.67567 6.4107 7.02703 6.28564 7.45946 6.28564C7.88417 6.28564 8.2278 6.40877 8.49035 6.65505C8.76061 6.90902 8.89575 7.23994 8.89575 7.64784C8.89575 8.01725 8.76448 8.32508 8.50193 8.57136C8.23166 8.82533 7.87645 8.95231 7.43629 8.95231H7.42471C7 8.95231 6.65637 8.82533 6.39382 8.57136C6.13127 8.31739 6 7.998 6 7.61321ZM6.15058 17.7142V10.0028H8.72201V17.7142H6.15058ZM10.1467 17.7142H12.7181V13.4083C12.7181 13.1389 12.749 12.9311 12.8108 12.7849C12.9189 12.5233 13.083 12.302 13.3031 12.1211C13.5232 11.9403 13.7992 11.8499 14.1313 11.8499C14.9961 11.8499 15.4286 12.4309 15.4286 13.593V17.7142H18V13.2929C18 12.1538 17.7297 11.29 17.1892 10.7012C16.6486 10.1125 15.9344 9.81811 15.0463 9.81811C14.0502 9.81811 13.2741 10.2452 12.7181 11.0995V11.1226H12.7066L12.7181 11.0995V10.0028H10.1467C10.1622 10.2491 10.1699 11.0148 10.1699 12.3001C10.1699 13.5853 10.1622 15.39 10.1467 17.7142Z" fill="white"/>
</svg>

              
            </a>
            <a href="#">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="24" height="24" rx="4" fill="#B9886A"/>
<path d="M12.2923 16.6533L9.58421 16.6027C8.70738 16.585 7.82837 16.6202 6.96873 16.4375C5.66102 16.1645 5.56837 14.8259 5.47143 13.7031C5.33786 12.1245 5.38957 10.5173 5.64164 8.95192C5.78395 8.07358 6.34397 7.54947 7.21002 7.49243C10.1336 7.28545 13.0766 7.30998 15.9937 7.40654C16.3018 7.4154 16.612 7.46378 16.9157 7.51885C18.4153 7.78747 18.4519 9.3044 18.5491 10.5814C18.646 11.8715 18.6051 13.1683 18.4198 14.4497C18.2711 15.5106 17.9867 16.4003 16.7865 16.4862C15.2826 16.5985 13.8133 16.6889 12.3052 16.6601C12.3053 16.6533 12.2966 16.6533 12.2923 16.6533ZM10.7002 13.9673C11.8335 13.3024 12.9451 12.6485 14.0719 11.988C12.9365 11.3231 11.827 10.6692 10.7002 10.0087V13.9673Z" fill="white"/>
</svg>
              
            </a>
        </div>
    </div>  
</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
