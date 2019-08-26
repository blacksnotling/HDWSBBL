<?php get_header(); ?>
  <?php do_action( 'bblm_template_before_posts' ); ?>
	<?php if (have_posts()) : ?>
    <?php do_action( 'bblm_template_before_loop' ); ?>
		<?php while (have_posts()) : the_post(); ?>
      <?php do_action( 'bblm_template_before_content' ); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">
          <h2 class="entry-title"><?php the_title(); ?></h2>
        </header><!-- .entry-header -->

				<?php $stad = new BBLM_CPT_Stadium; ?>
				<?php $match = new BBLM_CPT_Match; ?>

        <div class="entry-content">
					<h3><?php echo __( 'Home Teams', 'bblm'); ?></h3>

					<?php $stad->display_home_teams(); ?>

					<div class="details bblm_details bblm_stadium_description">
						<?php the_content(); ?>
					</div>

					<h3><?php echo __( 'Recent Matches in this stadium', 'bblm'); ?></h3>
					<?php $match->display_match_by_stadium(); ?>

				</div><!-- .entry-content -->

			<footer class="entry-footer">
				<p class="postmeta"><?php bblm_display_page_edit_link(); ?></p>
			</footer><!-- .entry-footer -->

		</article><!-- .post-ID -->

<?php do_action( 'bblm_template_after_content' ); ?>
<?php endwhile; ?>
<?php do_action( 'bblm_template_after_loop' ); ?>
<?php endif; ?>

<?php do_action( 'bblm_template_after_posts' ); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
