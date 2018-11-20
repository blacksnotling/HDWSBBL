<?php get_header(); ?>
  <?php do_action( 'bblm_template_before_posts' ); ?>
	<?php if (have_posts()) : ?>
    <?php do_action( 'bblm_template_before_loop' ); ?>
		<?php while (have_posts()) : the_post(); ?>
      <?php do_action( 'bblm_template_before_content' ); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <?php $own = new BBLM_CPT_Owner; ?>

        <header class="entry-header">
          <h2 class="entry-title"><?php the_title(); ?></h2>
        </header><!-- .entry-header -->

        <div class="entry-content">
          <?php /* the_content(); */ ?>
          <?php $has_team = $own->get_number_teams();
                $has_played = $own->get_number_games();
          if ( ( $has_team > 0 ) && ( $has_played > 0 ) ) { ?>

            <h3>Career Performance</h3>
            <table class="bblm_tbl">
              <tr>
                <th><?php echo __( 'Teams', 'bblm'); ?></th>
                <th class="tbl_stat">P</th>
                <th class="tbl_stat">W</th>
                <th class="tbl_stat">L</th>
                <th class="tbl_stat">D</th>
                <th class="tbl_stat">Tf</th>
                <th class="tbl_stat">Ta</th>
                <th class="tbl_stat">Cf</th>
                <th class="tbl_stat">Ca</th>
                <th class="tbl_stat">Comp</th>
                <th class="tbl_stat">Int</th>
                <th class="tbl_stat">%</th>
              </tr>
              <tr>
                <td><?php echo $has_team; ?></td>
                <?php $own->individual_stat_tbl_part() ?>
              </tr>
            </table>

            <?php $own->individual_stat_desc(); ?>

            <h3>Their Teams</h3>
            <table class="sortable bblm_tbl bblm_sortable">
              <tr>
                <th><?php echo __( 'Team', 'bblm'); ?></th>
                <th class="tbl_stat">P</th>
                <th class="tbl_stat">W</th>
                <th class="tbl_stat">L</th>
                <th class="tbl_stat">D</th>
                <th class="tbl_stat">Tf</th>
                <th class="tbl_stat">Ta</th>
                <th class="tbl_stat">Cf</th>
                <th class="tbl_stat">Ca</th>
                <th class="tbl_stat">Comp</th>
                <th class="tbl_stat">Int</th>
                <th class="tbl_stat">%</th>
              </tr>
                <?php $own->team_stat_tbl_row() ?>
            </table>

            <h3>Races Used</h3>
            <table class="sortable bblm_tbl bblm_sortable">
              <tr>
                <th><?php echo __( 'Race', 'bblm'); ?></th>
                <th class="tbl_stat">P</th>
                <th class="tbl_stat">W</th>
                <th class="tbl_stat">L</th>
                <th class="tbl_stat">D</th>
                <th class="tbl_stat">Tf</th>
                <th class="tbl_stat">Ta</th>
                <th class="tbl_stat">Cf</th>
                <th class="tbl_stat">Ca</th>
                <th class="tbl_stat">Comp</th>
                <th class="tbl_stat">Int</th>
                <th class="tbl_stat">%</th>
              </tr>
                <?php $own->race_stat_tbl_row() ?>
            </table>

            <h3>Season Performance</h3>
            <table class="sortable bblm_tbl bblm_sortable">
              <tr>
                <th><?php echo __( 'Season', 'bblm'); ?></th>
                <th class="tbl_stat">P</th>
                <th class="tbl_stat">W</th>
                <th class="tbl_stat">L</th>
                <th class="tbl_stat">D</th>
                <th class="tbl_stat">Tf</th>
                <th class="tbl_stat">Ta</th>
                <th class="tbl_stat">Cf</th>
                <th class="tbl_stat">Ca</th>
                <th class="tbl_stat">Comp</th>
                <th class="tbl_stat">Int</th>
                <th class="tbl_stat">%</th>
              </tr>
                <?php $own->season_stat_tbl_row() ?>
            </table>

            <h3>Competition Performance</h3>
            <table class="sortable bblm_tbl bblm_sortable">
              <tr>
                <th><?php echo __( 'Competition', 'bblm'); ?></th>
                <th class="tbl_stat">P</th>
                <th class="tbl_stat">W</th>
                <th class="tbl_stat">L</th>
                <th class="tbl_stat">D</th>
                <th class="tbl_stat">Tf</th>
                <th class="tbl_stat">Ta</th>
                <th class="tbl_stat">Cf</th>
                <th class="tbl_stat">Ca</th>
                <th class="tbl_stat">Comp</th>
                <th class="tbl_stat">Int</th>
                <th class="tbl_stat">%</th>
              </tr>
                <?php $own->comp_stat_tbl_row() ?>
            </table>

            <h3>Championship Cup Performance</h3>
            <table class="sortable bblm_tbl bblm_sortable">
              <tr>
                <th><?php echo __( 'Competition', 'bblm'); ?></th>
                <th class="tbl_stat">P</th>
                <th class="tbl_stat">W</th>
                <th class="tbl_stat">L</th>
                <th class="tbl_stat">D</th>
                <th class="tbl_stat">Tf</th>
                <th class="tbl_stat">Ta</th>
                <th class="tbl_stat">Cf</th>
                <th class="tbl_stat">Ca</th>
                <th class="tbl_stat">Comp</th>
                <th class="tbl_stat">Int</th>
                <th class="tbl_stat">%</th>
              </tr>
                <?php $own->cup_stat_tbl_row() ?>
            </table>

            <h3>Top Players They Coached</h3>
            <h3>Star Players Hired</h3>

<?php     } /* End of if $has_team */
          else {
            //Owner has either not played any games, OR has not made their debut yet
            echo __( 'This Owner has not made their League debut yet!', 'bblm');
          }

?>

        </div><!-- .entry-content -->

        <footer class="entry-footer">
          <p class="postmeta">&nbsp;</p>
        </footer><!-- .entry-footer -->

      </article><!-- .post-ID -->

    <?php do_action( 'bblm_template_after_content' ); ?>
    <?php endwhile; ?>
  <?php do_action( 'bblm_template_after_loop' ); ?>
	<?php endif; ?>

<?php do_action( 'bblm_template_after_posts' ); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>