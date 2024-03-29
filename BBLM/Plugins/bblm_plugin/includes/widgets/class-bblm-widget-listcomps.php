<?php
/**
 * Competition Widget
 *
 * A Widget that displays a list of recent, active, and upcoming competitions
 *
 * @class 		BBLM_Widget_ListComps
 * @author 		Blacksnotling
 * @category 	Admin
 * @package 	BBowlLeagueMan/Widget
 * @version   1.3
 */

class BBLM_Widget_ListComps extends WP_Widget {

  function __construct() {

    $widget_ops = array('classname' => 'widget_bblm widget_bblm_listcomps', 'description' => __( 'Display a List of recent, active, and upcoming Competitions', 'bblm' ) );
    parent::__construct('bblm_listcomps', __( 'BB:All: Competitions List', 'bblm' ), $widget_ops);

  }

  //The Widget Output in the front-end
  public function widget( $args, $instance ) {
    global $wpdb;

    echo $args['before_widget'];

    //get current Season
    $sea_id = BBLM_CPT_Season::get_current_season();

		$compsql = 'SELECT C.WPID AS CWPID, C.c_active, UNIX_TIMESTAMP(C.c_sdate) AS sdate  FROM '.$wpdb->prefix.'comp C WHERE C.c_counts = 1 AND C.sea_id = '.$sea_id.' ORDER BY C.c_active DESC, C.c_sdate ASC';
		if ( $complisting = $wpdb->get_results( $compsql ) ) {
      //set up the code below
			$is_first = 1;
			$last_stat = 0;
			$today = date("U");
      $zebracount = 1;

			foreach ( $complisting as $cl ) {
				if ( ( $cl->c_active ) && ( $cl->sdate < $today ) ) {

						if ( ( 1 !== $last_stat ) && ( !$is_first ) ) {
              $zebracount = 1;
							echo '</tbody></table>';
							$is_first = 1;
						}
						if ( $is_first ) {
              echo '<div>';
              echo $args['before_title'] . apply_filters( 'widget_title', __( 'Active Competitions' ) ) . $args['after_title'];
              echo '<table><tbody>';

              $is_first = 0;
						}
            if ( $zebracount % 2 ) {
              echo '<tr class="bblm_tbl_alt"><td>';
            }
            else {
              echo '<tr><td>';
            }
            echo bblm_get_competition_link( $cl->CWPID ) . '</td></tr>';
						$last_stat = 1;
				}//end of active comp
				else if ( ( $cl->c_active ) && ( $cl->sdate > $today ) ) {

						if ( ( 2 !== $last_stat ) && ( !$is_first ) ) {
              $zebracount = 1;
							echo '</tbody></table>';
							$is_first = 1;
						}
						if ( $is_first ) {
              echo '<div>';
              echo $args['before_title'] . apply_filters( 'widget_title', __( 'Upcoming Competitions' ) ) . $args['after_title'];
              echo '<table><tbody>';

							$is_first = 0;
						}
            if ( $zebracount % 2 ) {
              echo '<tr class="bblm_tbl_alt"><td>';
            }
            else {
              echo '<tr><td>';
            }
            echo bblm_get_competition_link( $cl->CWPID ) . '</td></tr>';
						$last_stat = 2;
				}//end of upcoming comp
				else {

						if ( ( 3 !== $last_stat ) && ( !$is_first ) ) {
              $zebracount = 1;
							echo '</tbody></table>';
							$is_first = 1;
						}
						if ( $is_first ) {
              echo '<div>';
              echo $args['before_title'] . apply_filters( 'widget_title', __( 'Recent Competitions' ) ) . $args['after_title'];
              echo '<table><tbody>';

							$is_first = 0;
						}
            if ( $zebracount % 2 ) {
              echo '<tr class="bblm_tbl_alt"><td>';
            }
            else {
              echo '<tr><td>';
            }
            echo bblm_get_competition_link( $cl->CWPID ) . '</td></tr>';
						$last_stat = 3;
				}//end of recent comp
        $zebracount++;
			}//end of for each
			echo '</tbody></table>';
		}//end of if sql


    echo $args['after_widget'];

  }

  // The Widget output on the admin screen
  public function form( $instance ) {

    echo '<p>'.__( 'Displays a list of recent, active, and upcoming competitions (suitible for the sidebar)', 'bblm' ).'</p>';

  }

  // Function to save any settings from he widget
  public function update( $new_instance, $old_instance ) {

    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    return $instance;

  }

}

// Register the widget.
function bblm_register_widget_lcs() {
  register_widget( 'BBLM_Widget_ListComps' );
}
add_action( 'widgets_init', 'bblm_register_widget_lcs' );
