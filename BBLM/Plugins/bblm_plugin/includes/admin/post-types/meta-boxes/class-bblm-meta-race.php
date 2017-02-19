<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Races CPT Meta-Boxes
 *
 * THe output and save functions for Meta-Boxes linked to the Races CPT
 * For the other admin functions see the admin/post-meta directory
 * For front end functions reloated to the CPT see the includes/post-types directory
 *
 * @class 		BBLM_Meta_Race
 * @version		1.0
 * @package		BBowlLeagueMan/Admin/CPT/Meta_Boxes
 * @category	Class
 * @author 		blacksnotling
 */

class BBLM_Meta_Race {

  /**
	 * Constructor
	 */
	public function __construct() {

    add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ),  10, 2 );

	}

  /**
	 * Register the metaboxes to be used for the post type
	 *
	 */
	public function register_meta_boxes() {

		add_meta_box(
			'race_rrcost',
      __( 'ReRoll Cost', 'bblm' ),
			array( $this, 'render_meta_boxes_rrcost' ),
			'bblm_race',
			'side',
			'low'
		);
		add_meta_box(
			'race_stars',
			__( 'Star Players Availible for this Race', 'bblm' ),
			array( $this, 'render_meta_boxes_stars' ),
			'bblm_race',
			'normal',
			'low'
		);

	}

/**
 * The HTML for the RRcost Meta Box
 *
 */
 function render_meta_boxes_rrcost( $post ) {

   $meta = get_post_custom( $post->ID );
   $rrcost = ! isset( $meta['race_rrcost'][0] ) ? '00000' : $meta['race_rrcost'][0];
   wp_nonce_field( basename( __FILE__ ), 'race_rrcost' );
?>
<div class="field">
		<p><input type="text" class="race_rr" name="race_rr" value="<?php echo $rrcost; ?>"/>
		<em class="field-summary summary">GP<br>(no comma)</em></p>
</div>
<?php

 }

 /**
  * The HTML for the Star Players Meta Box(s)
  *
  */
  function render_meta_boxes_stars( $post ) {

 ?>
<p>To Be Implemented!</p>
 <?php

  }

 /**
 	* Action when Saving the post type
 	*
 	*/
 	function save_meta_boxes( $post_id ) {
 		global $post;

 		// Verify nonce
 		if ( !isset( $_POST['race_rrcost'] ) || !wp_verify_nonce( $_POST['race_rrcost'], basename(__FILE__) ) ) {
 			return $post_id;
 		}
 		// Check Autosave
 		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) {
 			return $post_id;
 		}
 		// Don't save if only a revision
 		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
 			return $post_id;
 		}
 		// Check permissions
 		if ( !current_user_can( 'edit_post', $post->ID ) ) {
 			return $post_id;
 		}
 		$meta['race_rrcost'] = ( isset( $_POST['race_rr'] ) ? esc_textarea( $_POST['race_rr'] ) : '' );
 		foreach ( $meta as $key => $value ) {
 			update_post_meta( $post->ID, $key, $value );
 		}

 	}

}
new BBLM_Meta_Race();