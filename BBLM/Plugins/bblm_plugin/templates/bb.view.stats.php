<?php
/**
 * BBowlLeagueMan Teamplate View Stats
 *
 * Page Template to view the main Statistics page
 *
 * @author 		Blacksnotling
 * @category 	Template
 * @package 	BBowlLeagueMan/Templates
 */
/*
 * Template Name: View Stats
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

<?php
				$matchnumsql = 'SELECT COUNT(*) AS MATCHNUM FROM '.$wpdb->prefix.'match M, '.$wpdb->prefix.'comp C WHERE M.c_id = C.WPID AND C.c_counts = 1';
				$matchnum = $wpdb->get_var($matchnumsql);
				$compnum = wp_count_posts( 'bblm_comp')->publish;
				$cupnum = wp_count_posts( 'bblm_cup')->publish; //Determine number of 'Published' Championship Cups
				$playernumsql = 'SELECT COUNT(*) AS playernum FROM '.$wpdb->prefix.'player M, '.$wpdb->prefix.'team T, '.$wpdb->prefix.'bb2wp J, '.$wpdb->posts.' P WHERE M.t_id = T.t_id AND T.t_show = 1 AND M.p_id = J.tid AND J.prefix = \'p_\' AND J.pid = P.ID';
				$playernum = $wpdb->get_var($playernumsql);
				$teamnumsql = 'SELECT COUNT(*) AS teamnum FROM '.$wpdb->prefix.'team M, '.$wpdb->prefix.'bb2wp J, '.$wpdb->posts.' P WHERE M.t_show = 1 AND M.t_id = J.tid AND J.prefix = \'t_\' AND J.pid = P.ID';
				$teamnum = $wpdb->get_var($teamnumsql);
				$countseanum = wp_count_posts( 'bblm_season' );
				$seanum = $countseanum->publish;
				$sppnumsql = 'SELECT SUM(M.p_spp) AS sppnum FROM '.$wpdb->prefix.'player M, '.$wpdb->prefix.'bb2wp J, '.$wpdb->posts.' P, '.$wpdb->prefix.'team T WHERE T.t_id = M.t_id AND M.p_id = J.tid AND J.prefix = \'p_\' AND J.pid = P.ID AND M.p_spp > 0';
				$sppnum = $wpdb->get_var($sppnumsql);
				$deathnumsql = 'SELECT COUNT(F.f_id) AS DEAD FROM '.$wpdb->prefix.'player_fate F, '.$wpdb->prefix.'match M, '.$wpdb->prefix.'comp C WHERE (F.f_id = 1 OR F.f_id = 6 OR F.f_id = 7) AND F.m_id = M.WPID AND M.c_id = C.WPID AND C.c_counts = 1';
				$deathnum = $wpdb->get_var($deathnumsql);

				$matchstatssql = 'SELECT SUM(M.m_tottd) AS TD, SUM(M.m_totcas) AS CAS, SUM(M.m_totcomp) AS COMP, SUM(M.m_totint) AS MINT FROM '.$wpdb->prefix.'match M, '.$wpdb->prefix.'comp C WHERE M.c_id = C.WPID AND C.c_counts = 1';
				if ($matchstats = $wpdb->get_results($matchstatssql)) {
					foreach ($matchstats as $ms) {
						$tottd = $ms->TD;
						$totcas = $ms->CAS;
						$totcomp = $ms->COMP;
						$totint = $ms->MINT;
					}
				}
?>
        <h3><?php echo __( 'Overall Statistics','bblm'); ?></h3>

				<p>Since the <strong><?php echo bblm_get_league_name(); ?>'s</strong> inception, <strong><?php print($playernum); ?></strong> Players in <strong><?php print($teamnum); ?></strong> Teams have played <strong><?php print($matchnum); ?></strong> Matches in <strong><?php print($compnum); ?></strong> Competitions for <strong><?php print($cupnum); ?></strong> Championship Cups over <strong><?php print($seanum); ?></strong> Seasons. In total they have managed to:</p>
				<ul>
					<li>Score <strong><?php print($tottd); ?></strong> Touchdowns (average <strong><?php print(round($tottd/$matchnum,1)); ?></strong> per match);</li>
					<li>Make <strong><?php print($totcomp); ?></strong> successful Completions (average <strong><?php print(round($totcomp/$matchnum,1)); ?></strong> per match);</li>
					<li>Cause <strong><?php print($totcas); ?></strong> Casualties (average <strong><?php print(round($totcas/$matchnum,1)); ?></strong> per match);</li>
					<li>Catch <strong><?php print($totint); ?></strong> Interceptions (average <strong><?php print(round($totint/$matchnum,1)); ?></strong> per match).</li>
					<li>Kill <strong><?php print($deathnum); ?></strong> players (average <strong><?php print(round($deathnum/$matchnum,1)); ?></strong> per match).</li>
					<li>Earn a total of <strong><?php print($sppnum); ?></strong> Star Player Points.</li>
				</ul>

        <h3 class="bblm-table-caption"><?php echo bblm_get_league_name() . __( ' Cup Winners','bblm'); ?></h3>
<?php
				$championssql = 'SELECT COUNT(A.a_name) AS ANUM, P.post_title, P.guid FROM '.$wpdb->prefix.'awards_team_comp T, '.$wpdb->prefix.'awards A, '.$wpdb->prefix.'bb2wp J, '.$wpdb->posts.' P, '.$wpdb->prefix.'comp C WHERE T.c_id = C.WPID AND T.t_id = J.tid AND J.prefix = \'t_\' AND J.pid = P.ID AND A.a_id = 1 AND A.a_id = T.a_id GROUP BY T.t_id ORDER BY ANUM DESC, P.post_title ASC';
				if ($champions = $wpdb->get_results($championssql)) {
					$zebracount = 1;
					print("	<table class=\"bblm_table\">\n		<thead><tr>\n			<th class=\"bblm_tbl_name\">Team</th>\n			<th class=\"bblm_tbl_stat\">Championships</th>\n		</tr></thead><tbody>\n");
					foreach ($champions as $champ) {
						if ($zebracount % 2) {
              print("		<tr class=\"bblm_tbl_alt\">\n");
						}
						else {
							print("		<tr>\n");
						}
						print("			<td><a href=\"".$champ->guid."\" title=\"View more about ".$champ->post_title."\">".$champ->post_title."</a></td>\n			<td>".$champ->ANUM."</td>\n		</tr>\n");
						$zebracount++;
					}
					print("	<tbody></table>\n");
				}
?>

        <h3 class="bblm-table-caption"><?php echo __( 'Statistics Breakdown by Season','bblm'); ?></h3>
<?php
				$seasonsql = 'SELECT C.sea_id, COUNT(m_id) AS NUMMAT, SUM(M.m_tottd) AS TD, SUM(M.m_totcas) AS CAS, SUM(M.m_totcomp) AS COMP, SUM(M.m_totint) AS MINT FROM '.$wpdb->prefix.'match M, '.$wpdb->prefix.'comp C WHERE M.c_id = C.WPID AND C.c_counts = 1 GROUP BY C.sea_id ORDER BY C.sea_id DESC';
				if ( $seasonstats = $wpdb->get_results( $seasonsql ) ) {
?>
          <div role="region" aria-labelledby="Caption01" tabindex="0">
					<table class="bblm_table bblm_sortable">
						<thead>
							<tr>
								<th class="bblm_tbl_name"><?php echo __( 'Season', 'bblm' ); ?></th>
								<th class="bblm_tbl_stat"><?php echo __( 'Games', 'bblm' ); ?></th>
								<th class="bblm_tbl_stat"><?php echo __( 'TD', 'bblm' ); ?></th>
								<th class="bblm_tbl_stat"><?php echo __( 'CAS', 'bblm' ); ?></th>
								<th class="bblm_tbl_stat"><?php echo __( 'COMP', 'bblm' ); ?></th>
								<th class="bblm_tbl_stat"><?php echo __( 'INT', 'bblm' ); ?></th>
							</tr>
						</thead>
						<tbody>
<?php
					$zebracount = 1;
					foreach ( $seasonstats as $ss ) {
						if ( $zebracount % 2 ) {
              echo '<tr class="bblm_tbl_alt">';
						}
						else {
							echo '<tr>';
						}
						echo '<td>' . bblm_get_season_link( $ss->sea_id ) . '</td><td>' . $ss->NUMMAT . '</td><td>' . $ss->TD . '</td><td>' . $ss->CAS . '</td><td>' . $ss->COMP . '</td><td>' . $ss->MINT . '</td></tr>';
						$zebracount++;
					}
					echo '</tbody>';
					echo '</table>';
          echo '</div>';

				}
?>
        <h3 class="bblm-table-caption"><?php echo __( 'Statistics Breakdown by Compeition','bblm'); ?></h3>
        <div role="region" aria-labelledby="Caption01" tabindex="0">
<?php
				$compsql = 'SELECT C.WPID AS CWPID, COUNT(m_id) AS NUMMAT, SUM(M.m_tottd) AS TD, SUM(M.m_totcas) AS CAS, SUM(M.m_totcomp) AS COMP, SUM(M.m_totint) AS MINT FROM '.$wpdb->prefix.'match M, '.$wpdb->prefix.'comp C WHERE M.c_id = C.WPID AND C.c_counts = 1 GROUP BY C.c_id ORDER BY C.c_sdate DESC';
				if ($compstats = $wpdb->get_results($compsql)) {
					print("<table class=\"bblm_table bblm_sortable\">\n	<thead>\n	<tr>\n		<th class=\"bblm_tbl_name\">Competition</th>\n		<th class=\"bblm_tbl_stat\">Games</th>\n		<th class=\"bblm_tbl_stat\">TD</th>\n		<th class=\"bblm_tbl_stat\">CAS</th>\n		<th class=\"bblm_tbl_stat\">COMP</th>\n		<th class=\"bblm_tbl_stat\">INT</th>\n	</tr>\n	</thead>\n	<tbody>\n");
					$zebracount = 1;
					foreach ($compstats as $ss) {
						if ($zebracount % 2) {
              print("	<tr class=\"bblm_tbl_alt\">\n");
						}
						else {
							print("	<tr>\n");
						}
						print("		<td>" . bblm_get_competition_link( $ss->CWPID ) . "</td>\n		<td>".$ss->NUMMAT."</td>\n		<td>".$ss->TD."</td>\n		<td>".$ss->CAS."</td>\n		<td>".$ss->COMP."</td>\n		<td>".$ss->MINT."</td>\n	</tr>\n");
						$zebracount++;
					}
					print("	</tbody>\n</table>\n</div>");

				}
?>

        <h3 class="bblm-table-caption"><?php echo __( 'Statistics Breakdown by Teams','bblm'); ?></h3>
        <div role="region" aria-labelledby="Caption01" tabindex="0">
				<table class="bblm_table bblm_sortable">
					<thead>
					<tr>
						<th class="bblm_tbl_name">Team</th>
						<th class="bblm_tbl_stat">P</th>
						<th class="bblm_tbl_stat">W</th>
						<th class="bblm_tbl_stat">L</th>
						<th class="bblm_tbl_stat">D</th>
						<th class="bblm_tbl_stat">TF</th>
						<th class="bblm_tbl_stat">TA</th>
						<th class="bblm_tbl_stat">CF</th>
						<th class="bblm_tbl_stat">CA</th>
						<th class="bblm_tbl_stat">COMP</th>
						<th class="bblm_tbl_stat">INT</th>
						<th class="bblm_tbl_stat">Win%</th>
					</tr>
					</thead>
					<tbody>

<?php
				$teamstatssql = 'SELECT P.post_title, SUM(T.tc_played) AS TP, SUM(T.tc_W) AS TW, SUM(T.tc_L) AS TL, SUM(T.tc_D) AS TD, SUM(T.tc_tdfor) AS TDF, SUM(T.tc_tdagst) AS TDA, SUM(T.tc_casfor) AS TCF, SUM(T.tc_casagst) AS TCA, SUM(T.tc_INT) AS TI, SUM(T.tc_comp) AS TC, P.guid FROM '.$wpdb->prefix.'team_comp T, '.$wpdb->prefix.'bb2wp J, '.$wpdb->posts.' P, '.$wpdb->prefix.'comp C, '.$wpdb->prefix.'team Z WHERE Z.t_id = T.t_id AND Z.t_show = 1 AND C.WPID = T.c_id AND C.c_counts = 1 AND T.t_id = J.tid AND J.prefix = \'t_\' AND J.pid = P.ID GROUP BY T.t_id ORDER BY P.post_title ASC';
				if ($teamstats = $wpdb->get_results($teamstatssql)) {
					$zebracount = 1;

					foreach ($teamstats as $tst) {
						if ($zebracount % 2) {
              print("					<tr class=\"bblm_tbl_alt\">\n");
						}
						else {
							print("					<tr>\n");
						}
						print("						<td><a href=\"".$tst->guid."\" title=\"Read more on ".$tst->post_title."\">".$tst->post_title."</a></td>\n						<td>".$tst->TP."</td>\n						<td>".$tst->TW."</td>\n						<td>".$tst->TL."</td>\n						<td>".$tst->TD."</td>\n						<td>".$tst->TDF."</td>\n						<td>".$tst->TDA."</td>\n						<td>".$tst->TCF."</td>\n						<td>".$tst->TCA."</td>\n						<td>".$tst->TC."</td>\n						<td>".$tst->TI."</td>\n						");
						if ($tst->TP > 0) {
							print("<td>".number_format((($tst->TW/$tst->TP)*100))."%</td>\n");
						}
						else {
							print("<td>N/A</td>\n");
						}
						print("					</tr>\n");
						$zebracount++;
					}

				}
?>
				</tbody>
				</table>
      </div>

        <h3><?php echo __( 'Detailed Statistics Breakdown','bblm'); ?></h3>
				<p><?php echo __( 'This page only covers the high level statistics. The following links will take you through to more detailed pages.','bblm' ); ?></p>
				<div id="statslinkscontainer">
					<ol id="statslinks">
						<li><a href="<?php echo home_url(); ?>/stats/td/" title="View more Touchdown related Statistics">Touchdown Statistics</a></li>
						<li><a href="<?php echo home_url(); ?>/stats/cas/" title="View more Casualty related Statistics">Casualty Statistics </a></li>
						<li><a href="<?php echo home_url(); ?>/stats/misc/" title="View more Miscellaneous Statistics">Miscellaneous Statistics </a></li>
<!--						<li><a href="<?php echo home_url(); ?>/stats/records/" title="View Match Records">Match Records</a></li> -->
						<li><a href="<?php echo home_url(); ?>/stats/awards/" title="View The Awards that have been assigned in the league">Awards</a></li>
						<li><a href="<?php echo home_url(); ?>/stats/milestones/" title="View the Milestones of the League">Milestones</a></li>
					</ol>
				</div>



        <h3><?php echo __( 'Statistics Breakdown by Players','bblm'); ?></h3>
<?php
        $stat_limit = bblm_get_stat_limit();
				$bblm_star_team = bblm_get_star_player_team();

				  ////////////////////////
				 // Active Top Players //
				////////////////////////
				$statsql = 'SELECT P.WPID AS PID, T.WPID, SUM(M.mp_spp) AS VALUE, R.pos_name FROM '.$wpdb->prefix.'player P, '.$wpdb->prefix.'team T, '.$wpdb->prefix.'match_player M, '.$wpdb->prefix.'position R WHERE P.pos_id = R.pos_id AND M.p_id = P.p_id AND P.t_id = T.t_id AND M.mp_counts = 1 AND M.mp_spp > 0 AND T.t_active = 1 AND P.p_status = 1 AND T.t_id != '.$bblm_star_team.' GROUP BY P.p_id ORDER BY VALUE DESC LIMIT '.$stat_limit;
        echo '<h4 class="bblm-table-caption">' . __('Top Players (Active)','bblm' ) . '</h4>';
				if ($topstats = $wpdb->get_results($statsql)) {
          echo '<div role="region" aria-labelledby="Caption01" tabindex="0">';
					print("<table class=\"bblm_table bblm_expandable\">\n	<thead><tr>\n		<th class=\"bblm_tbl_stat\">#</th>\n		<th class=\"bblm_tbl_name\">Player</th>\n		<th>Position</th>\n		<th class=\"bblm_tbl_name\">Team</th>\n		<th class=\"bblm_tbl_stat\">SPP</th>\n		</tr></thead></tbody>\n");
					$zebracount = 1;
					$prevvalue = 0;

					foreach ($topstats as $ts) {
						if (($zebracount % 2) && (10 < $zebracount)) {
              print("	<tr class=\"bblm_tbl_alt bblm_tbl_hide\">\n");
						}
						else if (($zebracount % 2) && (10 >= $zebracount)) {
							print("	<tr class=\"bblm_tbl_alt\">\n");
						}
						else if (10 < $zebracount) {
							print("	<tr class=\"bblm_tbl_hide\">\n");
						}
						else {
							print("	<tr>\n");
						}
						if ($ts->VALUE > 0) {
							if ($prevvalue == $ts->VALUE) {
								print("	<td>-</td>\n");
							}
							else {
								print("	<td><strong>".$zebracount."</strong></td>\n");
							}
							print("	<td>" . bblm_get_player_link( $ts->PID ) . "</td>\n	<td>" . esc_html( $ts->pos_name ) . "</td>\n	<td><a href=\"" . get_post_permalink( $ts->WPID ) . "\" title=\"Read more on this team\">" . esc_html( get_the_title( $ts->WPID ) ) . "</a></td>\n	<td>".$ts->VALUE."</td>\n	</tr>\n");
							$prevvalue = $ts->VALUE;
						}
						$zebracount++;
					}
					print("</tbody></table></div>\n");
				}
				else {
					print("	<div class=\"bblm_info\">\n		<p>No active players have scored any Star Player Points!</p>\n	</div>\n");
				}

				  //////////////////////////
				 // All time Top Players //
				//////////////////////////
				$statsql = 'SELECT P.WPID AS PID, T.WPID, SUM(M.mp_spp) AS VALUE, R.pos_name, T.t_active, P.p_status FROM '.$wpdb->prefix.'player P, '.$wpdb->prefix.'team T, '.$wpdb->prefix.'match_player M, '.$wpdb->prefix.'position R WHERE P.pos_id = R.pos_id AND M.p_id = P.p_id AND P.t_id = T.t_id AND M.mp_spp > 0 AND M.mp_counts = 1 AND T.t_id != '.$bblm_star_team.' GROUP BY P.p_id ORDER BY VALUE DESC LIMIT '.$stat_limit;
        echo '<h4 class="bblm-table-caption">' . __('Top Players (All Time)','bblm' ) . '</h4>';
				if ($topstats = $wpdb->get_results($statsql)) {
          echo '<div role="region" aria-labelledby="Caption01" tabindex="0">';
					print("<table class=\"bblm_table bblm_expandable\">\n	<thead><tr>\n		<th class=\"bblm_tbl_stat\">#</th>\n		<th class=\"bblm_tbl_name\">Player</th>\n		<th>Position</th>\n		<th class=\"bblm_tbl_name\">Team</th>\n		<th class=\"bblm_tbl_stat\">SPP</th>\n		</tr></thead><tbody>\n");
					$zebracount = 1;
					$prevvalue = 0;

					foreach ($topstats as $ts) {
            if (($zebracount % 2) && (10 < $zebracount)) {
              print("	<tr class=\"bblm_tbl_alt bblm_tbl_hide\">\n");
						}
						else if (($zebracount % 2) && (10 >= $zebracount)) {
							print("	<tr class=\"bblm_tbl_alt\">\n");
						}
						else if (10 < $zebracount) {
							print("	<tr class=\"bblm_tbl_hide\">\n");
						}
						else {
							print("	<tr>\n");
						}
						if ($ts->VALUE > 0) {
							if ($prevvalue == $ts->VALUE) {
								print("	<td>-</td>\n");
							}
							else {
								print("	<td><strong>".$zebracount."</strong></td>\n");
							}
							print("	<td>");
							if ($ts->t_active && $ts->p_status) {
								print("<strong>" . bblm_get_player_link( $ts->PID ) . "</strong>");
							}
							else {
								print(bblm_get_player_link( $ts->PID ));
							}
							print("</td>\n	<td>" . esc_html( $ts->pos_name ). "</td>\n	<td><a href=\"" . get_post_permalink( $ts->WPID ) . "\" title=\"Read more on this team\">" . esc_html( get_the_title( $ts->WPID ) ) . "</a></td>\n	<td>".$ts->VALUE."</td>\n	</tr>\n");
							$prevvalue = $ts->VALUE;
						}
						$zebracount++;
					}
					print("</tbody></table>\n</div>");
          echo '<p>' . __('Players who are <strong>highlighted</strong> are still active in the League.','bblm' ) . '</p>';
				}
				else {
					print("	<div class=\"bblm_info\">\n		<p>Nobody has scored any Star Player Points!</p>\n	</div>\n");
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
