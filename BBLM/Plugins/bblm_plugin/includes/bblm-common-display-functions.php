<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * BBowlLeagueMan Common Display Functions
 *
 * Common Display functions used on both the front-end and the admin.
 *
 * @author 		Blacksnotling
 * @category 	Core
 * @package 	BBowlLeagueMan/Functions
 * @version   1.1
 */

/**
 * Returns the name of a team, properly escaped and formatted
 * Takes in the ID of the Wordpress Page
 */
function bblm_get_team_name( $ID ) {

  $output = "";

  $output .= esc_html( get_the_title( $ID ) );

  return $output;

}// end of bblm_get_team_name

/**
 * Returns the link of a team, properly escaped and formatted
 * Takes in the ID of the Wordpress Page
 */
function bblm_get_team_link( $ID ) {

  $team_name = bblm_get_team_name( $ID );
  $output = "";

  $output .= '<a title="Read more about ' . $team_name . '" href="' . get_post_permalink( $ID ) . '">' . $team_name . '</a>';

  return __( $output, 'bblm');

}// end of bblm_get_team_link

/**
 * Returns the name of a Player, properly escaped and formatted
 * Takes in the ID of the Wordpress Page
 */
function bblm_get_player_name( $ID ) {

  $output = "";

  $output .= esc_html( get_the_title( $ID ) );

  return $output;

}// end of bblm_get_player_name

/**
 * Returns the link for a player, properly escaped and formatted
 * Takes in the ID of the Wordpress Page
 */
function bblm_get_player_link( $ID ) {

  $player_name = bblm_get_player_name( $ID );
  $output = "";

  $output .= '<a title="Read more about ' . $player_name . '" href="' . get_post_permalink( $ID ) . '">' . $player_name . '</a>';

  return __( $output, 'bblm');

}// end of bblm_get_player_link

/**
 * Returns the name of a Stadium, properly escaped and formatted
 * Takes in the ID of the Wordpress Page
 */
function bblm_get_stadium_name( $ID ) {

  $output = "";

  $output .= esc_html( get_the_title( $ID ) );

  return $output;

}// end of bblm_get_stadium_name

/**
 * Returns the link of a Stadsium, properly escaped and formatted
 * Takes in the ID of the Wordpress Page
 */
function bblm_get_stadium_link( $ID ) {

  $stadium_name = bblm_get_team_name( $ID );
  $output = "";

  $output .= '<a title="Read more about ' . $stadium_name . '" href="' . get_post_permalink( $ID ) . '">' . $stadium_name . '</a>';

  return __( $output, 'bblm');

}// end of bblm_get_stadium_link

/**
 * Returns the name of an Owner, properly escaped and formatted
 * Takes in the ID of the Wordpress Page
 */
function bblm_get_owner_name( $ID ) {

  $output = "";

  $output .= esc_html( get_the_title( $ID ) );

  return $output;

}// end of bblm_get_owner_name

/**
 * Returns the link of an Owner, properly escaped and formatted
 * Takes in the ID of the Wordpress Page
 */
function bblm_get_owner_link( $ID ) {

  $owner_name = bblm_get_team_name( $ID );
  $output = "";

  $output .= '<a title="Read more about ' . $owner_name . '" href="' . get_post_permalink( $ID ) . '">' . $owner_name . '</a>';

  return __( $output, 'bblm');

}// end of bblm_get_owner_link

/**
 * Returns the name of a Championship Cup, properly escaped and formatted
 * Takes in the ID of the Wordpress Page
 */
function bblm_get_cup_name( $ID ) {

  $output = "";

  $output .= esc_html( get_the_title( $ID ) );

  return $output;

}// end of bblm_get_cup_name

/**
 * Returns the link of a Championship Cup, properly escaped and formatted
 * Takes in the ID of the Wordpress Page
 */
function bblm_get_cup_link( $ID ) {

  $cup_name = bblm_get_cup_name( $ID );
  $output = "";

  $output .= '<a title="Read more about ' . $cup_name . '" href="' . get_post_permalink( $ID ) . '">' . $cup_name . '</a>';

  return __( $output, 'bblm');

}// end of bblm_get_cup_link

/**
 * Outputs the edit linl, formatted for the bllm plugin
 */
function bblm_display_page_edit_link() {

  edit_post_link( __( 'Edit', 'bblm' ), ' <strong>[</strong> ', ' <strong>]</strong> ');

}// end of bblm_display_page_edit_link()
