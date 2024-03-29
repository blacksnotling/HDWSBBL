<?php
/*
Template Name: List Fixtures
*/
/*
*	Filename: bb.core.fixtures.php
*	Description: Page template to list the Fixtures
*/
?>
<?php get_header(); ?>
<div id="primary" class="content-area content-area-right-sidebar">
  <main id="main" class="site-main" role="main">
  <?php do_action( 'bblm_template_before_posts' ); ?>
	<?php if (have_posts()) : ?>
		<?php do_action( 'bblm_template_before_loop' ); ?>
		<?php while (have_posts()) : the_post(); ?>
			<?php do_action( 'bblm_template_before_content' ); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="page-header entry-header">

			<h2 class="entry-title"><?php the_title(); ?></h2>

		</header><!-- .page-header -->

			<div class="entry-content">

					<?php the_content(); ?>

<?php if (!empty($_POST['bblm_flayout'])) {
		$bblm_flayout = $_POST['bblm_flayout'];
} else {
		$bblm_flayout = "";
} ?>
				<form name="bblm_filterlayout" method="post" id="post" action="" class="selectbox">
				<p>Order Fixtures by
					<select name="bblm_flayout" id="bblm_flayout">
						<option value="bycomp"<?php if ("bycomp" == $bblm_flayout) { print(" selected=\"selected\""); } ?>>Competition</option>
						<option value="bydate"<?php if ("bydate" == $bblm_flayout) { print(" selected=\"selected\""); } ?>>Date</option>
					</select>
				<input name="bblm_filter_submit" type="submit" id="bblm_filter_submit" value="Filter" /></p>
				</form>
<?php
				//Initial SQL
				$layout = "";
        $fixturesql = 'SELECT UNIX_TIMESTAMP(F.f_date) AS mdate, C.WPID AS CWPID, D.div_name, T.t_id AS TAid, T.WPID AS TATWPID, R.t_id AS TBid, R.WPID AS TBTWPID, F.f_id FROM '.$wpdb->prefix.'fixture F, '.$wpdb->prefix.'comp C, '.$wpdb->prefix.'division D, '.$wpdb->prefix.'team T, '.$wpdb->prefix.'team R WHERE F.f_teamA = T.t_id AND F.f_teamB = R.t_id AND F.c_id = C.WPID AND F.div_id = D.div_id AND F.f_complete = 0 ORDER BY ';
        $layout = "";
				//determine the required Layout
					switch ($bblm_flayout) {
						case ("bycomp" == $bblm_flayout):
					    	$layout .= 1;
					    	$fixturesql .= 'F.c_id DESC, F.div_id DESC, F.f_date ASC';
						    break;
						case ("bydate" == $bblm_flayout):
					    	$layout .= 0;
					    	$fixturesql .= 'F.f_date ASC, F.c_id DESC, F.div_id DESC';
						    break;
						default:
					    	$layout .= 1;
					    	$fixturesql .= 'F.c_id DESC, F.div_id DESC, F.f_date ASC';
						    break;
					}


				//Run the Query. If successful....
				if ($fixture = $wpdb->get_results($fixturesql)) {

					//grab the ID of the "tbd" team
					$bblm_tbd_team = bblm_get_tbd_team();

					if (1 == $layout) {
						//Load the default by Competition
						$is_first_comp = 1;
						$is_first_div = 0;
						$is_first_sea = 1;
						$current_comp = "";
						$current_div ="";
						$current_sea = "";
						$zebracount = 1;

						foreach ($fixture as $m) {
							if ($m->CWPID !== $current_comp) {
								$current_comp = $m->CWPID;
								$current_div = $m->div_name;
								if (1 !== $is_first_comp) {
									print(" </tbody></table>\n");
									$zebracount = 1;
								}
								$is_first_comp = 1;
							}
							if ($m->div_name !== $current_div) {
								$current_div = $m->div_name;
								if (1 !== $is_first_div) {
									print(" </tbody></table>\n");
									$zebracount = 1;
								}
								$is_first_div = 1;
							}
							if ($is_first_comp) {
								print("<h3>" . bblm_get_competition_link( $m->CWPID ) . "</h3>\n <h4 class=\"bblm-table-caption\">".$m->div_name."</h4>\n  <table class=\"bblm_table\">\n<thead>		 <tr>\n		   <th class=\"bblm_tbl_matchdate\">Date</th>\n		   <th class=\"bblm_tbl_matchname\">Match</th>\n		 </tr></thead><tbody>\n");
								$is_first_comp = 0;
								$is_first_div = 0;
							}
							if ($is_first_div) {
								print("<h4 class=\"bblm-table-caption\">".$m->div_name."</h4>\n  <table class=\"bblm_table\">\n		 <thead><tr>\n		   <th class=\"bblm_tbl_matchdate\">Date</th>\n		   <th class=\"bblm_tbl_matchname\">Match</th>\n		   </tr></thead><tbody>\n");
								$is_first_div = 0;
							}
							if ($zebracount % 2) {
                print("		<tr class=\"bblm_tbl_alt\"  id=\"F".$m->f_id."\">\n");
							}
							else {
								print("		<tr id=\"F".$m->f_id."\">\n");
							}
							print("		   <td>".date("d.m.y", $m->mdate)."</td>\n		<td>");
							if ($bblm_tbd_team == $m->TAid) {
								echo bblm_get_team_name( $m->TATWPID );
							}
							else {
								echo bblm_get_team_link( $m->TATWPID );
							}
							print(" vs ");
							if ($bblm_tbd_team == $m->TBid) {
                echo __( 'To Be Determined', 'bblm' );
							}
							else {
								echo bblm_get_team_link( $m->TBTWPID );
							}

							print("</td>\n	</tr>\n");
							$zebracount++;
						}
						print("</tbody></table>\n");
						//END OF LAYOUT 1 (by Comp)
					}
					else {
						//The Second Layout has been selected
						$zebracount = 1;
?>
        <h4 class="bblm-table-caption"><?php echo __('Upcoming Fixtures','bblm'); ?></h4>
        <table class="bblm_table bblm_sortable">
					<thead>
					<tr>
						<th class="bblm_tbl_matchdate">Date</th>
						<th class="bblm_tbl_matchname">Match</th>
						<th class="bblm_tbl_name">Competition</th>
						<th class="bblm_tbl_matchname">Round</th>
					</tr>
					</thead>
					<tbody>
<?php
						foreach ($fixture as $m) {
							if ($zebracount % 2) {
                print("					<tr class=\"bblm_tbl_alt\"  id=\"F".$m->f_id."\">\n");
							}
							else {
								print("					<tr  id=\"F".$m->f_id."\">\n");
							}
?>
						<td><?php print(date("d.m.y", $m->mdate)); ?></td>
						<td>
<?php
							if ($bblm_tbd_team == $m->TAid) {
								echo bblm_get_team_name( $m->TATWPID );
							}
							else {
                echo bblm_get_team_link( $m->TATWPID );
							}
							print(" vs ");
							if ($bblm_tbd_team == $m->TBid) {
								//echo bblm_get_team_name( $m->TBTWPID );
                echo __( 'To Be Determined', 'bblm' );
							}
							else {
								echo bblm_get_team_link( $m->TBTWPID );
							}
?>
						</td>
<?php

?>
						<td><?php echo bblm_get_competition_link( $m->CWPID ); ?></td>
						<td><?php print($m->div_name); ?></td>
					</tr>
<?php
							$zebracount++;
						}//end of foreach $fixture
?>
					</tbody>
				</table>
<?php
						//END OF LAYOUT 2 (by Date)
					}


				}
				else {
					//The Query did not run
					print("<div class=\"bblm_info\">\n	<p>There are currently no fixtures scheduled.</p>\n	</div>");
				}

?>
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
</main><!-- #main -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
