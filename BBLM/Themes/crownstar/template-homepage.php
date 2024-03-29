<?php
/**
 * The template for displaying the homepage.
 *
 * Template Name: Homepage
 *
 * @package Crownstar
 */

get_header(); ?>

	<div id="primary" class="content-area content-area-full-width">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'homepage' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	
<?php get_footer(); ?>
