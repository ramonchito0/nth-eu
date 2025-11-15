<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header header--mast <?= is_front_page() ? 'home-header' : '' ?>">
  <div class="container header-inner">
    <div class="header-logo">
          <?php
          if( is_front_page() ) {
            echo '<a href="' . home_url() . '"><img src="' . get_template_directory_uri() . '/assets/images/eu-logo-white.svg" alt="Exclusive Use Logo"></a>';
          } else {
            if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
              the_custom_logo();
            } else {
              bloginfo( 'name' ); 
            }
          }?>  
    </div>

    <button class="header-burger" aria-label="Toggle navigation">
      <span></span><span></span><span></span>
    </button>

    <nav class="header-nav">
      <?php
      wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'header-menu',
        'fallback_cb'    => false,
      ) );
      ?>
    </nav>

    <div class="header-actions">
      <a href="#" class="btn btn-default btn-default-variant">List With Us</a>
      <a href="#" class="btn btn-default btn-secondary">Join Our Loyalty Club</a>
    </div>
  </div>

<!-- Mobile Navigation -->
<div class="mobile-nav">
  <div class="mobile-nav__backdrop"></div>

  <div class="mobile-nav__drawer">
    <!-- Drawer header: logo + close -->
    <div class="mobile-nav__header">
        <?php
          if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
            the_custom_logo();
          } else {
            bloginfo( 'name' ); 
          }
        ?>
      <button class="mobile-close" aria-label="Close menu" type="button">×</button>
    </div>

    <!-- Drawer content: menu + actions (buttons directly below) -->
    <div class="mobile-nav__content">
      <?php
      wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'mobile-menu',
        'fallback_cb'    => false,
      ) );
      ?>

      <div class="mobile-actions">
        <a href="#" class="btn btn-default btn-default-variant">List With Us</a>
        <a href="#" class="btn btn-default btn-secondary">Join Our Loyalty Club</a>
      </div>
    </div>
  </div>
</div>

</header>

