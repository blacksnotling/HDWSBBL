<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Season CPT admin functions
 *
 * Defines the admin functions related to the Season CPT (edit screens, custom messages, post saving etc)
 * For the Meta-Boxes, see the meta-boxes directory
 * For front end functions reloated to the CPT see the includes/post-types directory
 *
 * @class 		BBLM_Admin_CPT_Season
 * @author 		Blacksnotling
 * @category 	Admin
 * @package 	BBowlLeagueMan/Admin/CPT
 * @version   1.1
 */

class BBLM_Admin_CPT_Season {

 /**
  * Constructor
 	*/
  public function __construct() {

    add_filter( 'manage_edit-bblm_season_columns', array( $this, 'my_edit_season_columns' ) );
    add_action( 'manage_bblm_season_posts_custom_column', array( $this, 'my_manage_season_columns' ), 10, 2 );

 	}

  /**
   * Sets the Column headers for the CPT edit list screen
   */
  function my_edit_season_columns( $columns ) {

  	$columns = array(
  		'cb' => '<input type="checkbox" />',
  		'title' => __( 'Season', 'bblm' ),
			'id' => __( 'ID', 'bblm' ),
  		'competition' => __( 'Competitions', 'bblm' ),
  		'sdate' => __( 'Started', 'bblm' ),
			'fdate' => __( 'Ended', 'bblm' ),
			'awards' => __( 'Awards', 'bblm' ),
  	);

  	return $columns;

  }

  /**
   * Sets the Column content for the CPT edit list screen
   */
  function my_manage_season_columns( $column, $post_id ) {
  	global $post;

    switch( $column ) {

      /* If displaying the 'competition' column. */
      case 'competition' :

        echo '<a href="' . get_bloginfo("url") . '/wp-admin/edit.php?s&post_status=all&post_type=bblm_comp&action=-1&m=0&bblm_comp-filter-season=' . $post_id . '&filter_action=Filter&paged=1&action2=-1" title="Start a new Competition">Manage Competitions.</a>';

      break;

      // If displaying the 'sdate' column.
      case 'sdate' :

        $type = get_post_meta( $post_id, 'season_sdate', true );
        if ( '0000-00-00' == $type ) {

  			     echo __( 'TBC', 'bblm' );

        }
        else {

          echo date("d-m-Y (25y)", strtotime( $type ) );

        }

      break;

			/* If displaying the 'id' column. */
			case 'id' :

				echo $post_id;

			break;

			// If displaying the 'fdate' column.
      case 'fdate' :

        //$bblm_season = new BBLM_CPT_Season;

        if ( BBLM_CPT_Season::is_season_active( $post_id ) ) {

  			     echo __( 'In Progress', 'bblm' );

        }
        else {

          echo date("d-m-Y (25y)", strtotime( get_post_meta( $post_id, 'season_fdate', true ) ) );

        }

      break;

			/* If displaying the 'awards' column. */
			case 'awards' :

				echo 'Manage Awards';

			break;

      // Break out of the switch statement for anything else.
      default :
      break;

    }

  }

}

new BBLM_Admin_CPT_Season();
