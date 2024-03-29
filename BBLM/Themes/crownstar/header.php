<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Crownstar
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
        } else {
    do_action( 'wp_body_open' );
        } ?>
<div id="page" class="hfeed site">
  <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'crownstar' ); ?></a>

  <header id="masthead" class="site-header" role="banner">
    <div class="header-wrapper">
      <?php crownstar_header_area(); ?>
    </div><!-- .header-wrapper -->
  </header><!-- #masthead -->

  <div id="content" class="site-content">
    <div class="content-wrapper">
      <?php do_action( 'crownstar_before_template' ); ?>
