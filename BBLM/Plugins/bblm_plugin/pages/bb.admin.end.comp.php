<?php
/**
 * BBowlLeagueMan End Compeition
 *
 * Page used to end a competiton and assigna awards
 *
 * @author 		Blacksnotling
 * @category 	Core
 * @package 	BBowlLeagueMan/Pages
 */

//Check the file is not being accessed directly
if (!function_exists('add_action')) die('You cannot run this file directly. Naughty Person');

?>
<div class="wrap">
	<h2>Assign End of Competition Awards</h2>
	<p>Use the following page to assign the end of Competition awards to teams and players. <strong>If you wish to close a season then navigate to the Seasons menu and add an end date!</strong></p>

<?php

if (isset($_POST['bblm_comp_close'])) {
  //////////////////////////////
 // Third Step - Final Input //
//////////////////////////////



	$bblm_safe_input['edate'] = $_POST['bblm_edate'] ." 00:00:01";
    $bblm_safe_input['cid'] = $_POST['bblm_cid'];



	// Loop for team assignments //

	//Set initial values for mainloop
	 if (0 < $_POST['bblm_numoftawards']) {
		$pmax = $_POST['bblm_numoftawards'];
		$p = 1;

		$awardteamsql = 'INSERT INTO `'.$wpdb->prefix.'awards_team_comp` (`a_id`, `t_id`, `c_id`, `atc_value`) VALUES ';
		//Initialize var to capture first input
		$is_first_team = 1;

		//Beginning of main loop.
		while ($p <= $pmax){

			//before we go any further, we need to check if the award was assigned.
			if ("on" == $_POST['bblm-t-s-'.$p]) {

				//we only want a comma added for all but the first
				if (1 !== $is_first_team) {
					$awardteamsql .= ", ";
				}

				//generate the SQL
				$awardteamsql .= '(\''.$_POST['bblm-t-'.$p].'\', \''.$_POST['bblm-t-win-'.$p].'\', \''.$bblm_safe_input['cid'].'\', \''.$_POST['bblm-t-v-'.$p].'\')';


				$is_first_team = 0;
			}
			//regardless if this one was assigned or not, we need to increment the counter
			$p++;


		} //end of while loop

	} //end of team assignment loop


	// Loop for payer assignments //

	//Set initial values for mainloop
	 if (0 < $_POST['bblm_numofpawards']) {
		$pmax = $_POST['bblm_numofpawards'];
		$p = 1;

		$awardplayersql = 'INSERT INTO `'.$wpdb->prefix.'awards_player_comp` (`a_id`, `p_id`, `c_id`, `apc_value`) VALUES ';
		//Initialize var to capture first input
		$is_first_player = 1;

		//Beginning of main loop.
		while ($p <= $pmax){

			//before we go any further, we need to check if the award was assigned.
			if ("on" == $_POST['bblm-p-s-'.$p]) {

				//we only want a comma added for all but the first
				if (1 !== $is_first_player) {
					$awardplayersql .= ", ";
				}

				//generate the SQL
				$awardplayersql .= '(\''.$_POST['bblm-p-'.$p].'\', \''.$_POST['bblm-p-win-'.$p].'\', \''.$bblm_safe_input['cid'].'\', \''.$_POST['bblm-p-v-'.$p].'\')';


				$is_first_player = 0;
			}
			//regardless if this one was assigned or not, we need to increment the counter
			$p++;


		} //end of while loop

	} //end of Player assignment loop




      ///////////////
	 // SQL Input //
	///////////////


	if (0 < $_POST['bblm_numoftawards']) {
		if (FALSE !== $wpdb->query($awardteamsql)) {
			$sucess = TRUE;
			do_action( 'bblm_post_submission' );
		}
	}
	if (0 < $_POST['bblm_numofpawards']) {
		if (FALSE !== $wpdb->query($awardplayersql)) {
			$sucess = TRUE;
			do_action( 'bblm_post_submission' );
		}
	}


?>
	<div id="updated" class="updated fade">
	<p>
	<?php
	if ($sucess) {
		print("Competition has been closed down and awards assigned. thanks.");
	}
	else {
		print("Something went wrong");
	}
	?>
</p>
	</div>
<?php



} //end of if

  /////////////////////////////////
 // Second Step - Assign Awards //
/////////////////////////////////

else if (isset($_POST['bblm_comp_select'])) {
?>
	<form name="bblm_endcomp" method="post" id="post">


		<input type="hidden" name="bblm_cid" size="3" value="<?php print($_POST['bblm_cid']); ?>">


<?php
		  /////////////////
		 // Team Awards //
		/////////////////

		//before we generate the list of awards, we need to grab the teams into an array
		$teamsql = 'SELECT DISTINCT(C.t_id), T.t_name FROM '.$wpdb->prefix.'team_comp C, '.$wpdb->prefix.'team T WHERE C.t_id = T.t_id AND T.t_show = 1 AND C.c_id = '.$_POST['bblm_cid'].' ORDER BY T.t_name ASC';
		//initialise vars
		$are_teams = 1;
		if ($teams = $wpdb->get_results($teamsql)) {
			//we have some teams so build the repeated input
			$teamlisting = "			<option value=\"0\">Not Applicable</option>\n";
			foreach ($teams as $t) {
				$teamlisting .= "			<option value=\"".$t->t_id."\">".$t->t_name."</option>\n";
			}
		}
		else {
			//no teams where returned
			$are_teams = 0;
		}

		//Now we set our counter up
		$p = 1;


		if ($are_teams) {
			print("<h3>Team Awards</h3>\n<p>Please assign the awards to the teams. If you don't wish to assign an award at this point, please untick the corresponding box.</p>\n");
			print("<table>\n	<tr>\n		<th>Award</th>\n		<th>Team</th>\n		<th>Value</th>\n		<th>Assigned?</th>\n	</tr>\n");
			$awardsql = 'SELECT a_id, a_name, a_cup FROM '.$wpdb->prefix.'awards ORDER BY a_id';
			if ($awards = $wpdb->get_results($awardsql)) {
				foreach ($awards as $aw) {
					print("	<tr>\n		<td>".$aw->a_name."<input type=\"hidden\" name=\"bblm-t-".$p."\" size=\"3\" value=\"".$aw->a_id."\"></td>\n		<td><select name=\"bblm-t-win-".$p."\" id=\"bblm-t-win-".$p."\">\n");
					print($teamlisting);
					print("		</select></td>\n		<td><input type=\"");
					if (1 == $aw->a_cup) {
						print("hidden");
					}
					else {
						print("text");
					}
					print("\" name=\"bblm-t-v-".$p."\" size=\"5\" value=\"0\" maxlength=\"5\"></td>\n		<td><input type=\"checkbox\" name=\"bblm-t-s-".$p."\" checked=\"checked\"></td>	</tr>\n");
					//before we leave the loop we move the counter on and reset the array
					$p++;

				}
			}
			print("</table>\n");

		}//end if $are_teams
?>
		<input type="hidden" name="bblm_numoftawards" size="3" value="<?php print($p-1); ?>">
<?php
		// end of team assignment


		  /////////////////
		 // Player Awards //
		/////////////////

		//before we generate the list of awards, we need to grab the players into an array
		$playersql = 'SELECT DISTINCT(P.p_id), P.p_name, T.t_name, P.p_num FROM '.$wpdb->prefix.'player P, '.$wpdb->prefix.'match M, '.$wpdb->prefix.'comp C, '.$wpdb->prefix.'match_player A, '.$wpdb->prefix.'team T WHERE A.m_id = M.m_id AND M.c_id = C.WPID AND A.p_id = P.p_id AND P.t_id = T.t_id AND A.mp_spp > 1 AND C.c_id = '.$_POST['bblm_cid'].' ORDER BY T.t_name ASC, P.p_num ASC';
		//initialise vars
		$are_players = 1;
		$last_team = "";
		if ($players = $wpdb->get_results($playersql)) {
			//we have some teams so build the repeated input
			$playerlisting = "			<option value=\"0\">Not Applicable</option>\n";
			foreach ($players as $pd) {
				if ($last_team !== $pd->t_name) {
					$playerlisting .= "			<option value=\"0\">".$pd->t_name."</option>\n";
					$last_team = $pd->t_name;
				}
				$playerlisting .= "			<option value=\"".$pd->p_id."\"> -- #".$pd->p_num." - ".$pd->p_name."</option>\n";
			}
		}
		else {
			//no players where returned
			$are_players = 0;
		}

		//Now we set our counter up
		$p = 1;


		if ($are_players) {
			print("<h3>Player Awards</h3>\n<p>Please assign the awards to the Players. If you don't wish to assign an award at this point, please untick the corresponding box.</p>\n");
			print("<table>\n	<tr>\n		<th>Award</th>\n		<th>Player</th>\n		<th>Value</th>\n		<th>Assigned?</th>\n	</tr>\n");
			$awardsql = 'SELECT a_id, a_name, a_cup FROM '.$wpdb->prefix.'awards WHERE a_cup = 0 ORDER BY a_id';
			if ($awards = $wpdb->get_results($awardsql)) {
				foreach ($awards as $aw) {
					print("	<tr>\n		<td>".$aw->a_name."<input type=\"hidden\" name=\"bblm-p-".$p."\" size=\"3\" value=\"".$aw->a_id."\"></td>\n		<td><select name=\"bblm-p-win-".$p."\" id=\"bblm-p-win-".$p."\">\n");
					print($playerlisting);
					print("	</select></td>\n		<td><input type=\"text\" name=\"bblm-p-v-".$p."\" size=\"5\" value=\"0\" maxlength=\"5\"></td>\n		<td><input type=\"checkbox\" name=\"bblm-p-s-".$p."\" checked=\"checked\"></td>	</tr>\n");
					//before we leave the loop we move the counter on and reset the array
					$p++;
				}
			}
			print("</table>\n");

		}//end if $are_players
?>
		<input type="hidden" name="bblm_numofpawards" size="3" value="<?php print($p-1); ?>">
<?php
		// end of Player assignment

?>

		<p class="submit">
		<input type="submit" name="bblm_comp_close" tabindex="4" value="Assign Awards and finish" title="Assign Awards and finish"/>
		</p>
	</form>


<?php
} //end of else if

else {
  ////////////////////////////////
 // First Step - Select a comp //
////////////////////////////////

?>
	<form name="bblm_endcomp" method="post" id="post">

	<p>Please slelect the competition you wish to close.</p>

    	  <label for="bblm_cid" class="selectit">Competition</label>
		  <select name="bblm_cid" id="bblm_cid">
		<?php
		$compsql = 'SELECT C.c_id, C.WPID, C.series_id, C.sea_id FROM '.$wpdb->prefix.'comp C WHERE C.c_active = 1';
		if ($comps = $wpdb->get_results($compsql)) {
			foreach ($comps as $comp) {
				print("<option value=\"".$comp->WPID."\">".bblm_get_competition_name( $comp->WPID )." - ".bblm_get_season_name( $comp->sea_id )." - ". bblm_get_cup_name( $comp->series_id ) ."</option>\n");
			}
		}
		?>
	</select>

	<p class="submit">
	<input type="submit" name="bblm_comp_select" tabindex="4" value="Select above competition" title="Select above competition"/>
	</p>
	</form>

<?php
} //end of else
?>

</div>
