<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register Custom Post types
 *
 * Registers post types and taxonomies required for BBowlLeagueMan
 *
 * @class 		BBLM_Post_types
 * @version		1.0
 * @package		BBowlLeagueMan/CPTCore
 * @category	Class
 * @author 		blacksnotling
 */
class BBLM_Post_types {

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
		add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 10 );
    add_action( 'init', array( $this, 'include_post_type_handlers' ) );

	}

	/**
	 * Register core post types
	 */
	public static function register_post_types() {

		register_post_type( 'bblm_dyk',
			array(
				'labels' => array(
					'name' 					=> __( 'Did You Know?', 'bblm' ),
					'singular_name' 		=> __( 'Did You Know?', 'bblm' ),
					'add_new_item' 			=> __( 'Add New Did You Know', 'bblm' ),
					'edit_item' 			=> __( 'Edit Did You Know', 'bblm' ),
					'new_item' 				=> __( 'New', 'bblm' ),
					'view_item' 			=> __( 'View Did You Know', 'bblm' ),
					'view_items' 			=> __( 'View Did You Knows', 'bblm' ),
					'search_items' 			=> __( 'Search', 'bblm' ),
					'not_found' 			=> __( 'No results found.', 'bblm' ),
					'not_found_in_trash' 	=> __( 'No results found.', 'bblm' ),
					'all_items' 			=> __( 'Did You Know?', 'bblm' ),
				),
				'public' 				=> true,
				'show_ui' 				=> true,
				'map_meta_cap' 			=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> true, //exclude from search
				'hierarchical' 			=> false,
				'rewrite' 				=> array( 'slug' => 'did-you-know' ),
				'supports' 				=> array( 'title', 'editor'),
				'has_archive' 			=> true,
				'show_in_nav_menus' 	=> true,
        'show_in_menu' => 'bblm_main_menu',
			)
		); //end of Did You Know
    register_post_type( 'bblm_stadium',
			array(
				'labels' => array(
					'name' 					=> __( 'Stadiums', 'bblm' ),
					'singular_name' 		=> __( 'Stadium', 'bblm' ),
					'add_new_item' 			=> __( 'Add New Stadium', 'bblm' ),
					'edit_item' 			=> __( 'Edit Stadium', 'bblm' ),
					'new_item' 				=> __( 'New', 'bblm' ),
					'view_item' 			=> __( 'View Stadium', 'bblm' ),
					'view_items' 			=> __( 'View Stadiums', 'bblm' ),
					'search_items' 			=> __( 'Search', 'bblm' ),
					'not_found' 			=> __( 'No results found.', 'bblm' ),
					'not_found_in_trash' 	=> __( 'No results found.', 'bblm' ),
					'all_items' 			=> __( 'Stadiums', 'bblm' ),
				),
				'public' 				=> true,
				'show_ui' 				=> true,
				'map_meta_cap' 			=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				'rewrite' 				=> array( 'slug' => 'stadiums' ),
				'supports' 				=> array( 'title', 'editor', 'author'),
				'has_archive' 			=> true,
				'show_in_nav_menus' 	=> true,
        'menu_icon' 			=> 'dashicons-store',
        'show_in_menu' => 'bblm_main_menu',
			)
		); //end of Stadiums
    register_post_type( 'bblm_cup',
			array(
				'labels' => array(
					'name' 					=> __( 'Championships', 'bblm' ),
					'singular_name' 		=> __( 'Championship', 'bblm' ),
					'add_new_item' 			=> __( 'Add New Championship', 'bblm' ),
					'edit_item' 			=> __( 'Edit Championship', 'bblm' ),
					'new_item' 				=> __( 'New', 'bblm' ),
					'view_item' 			=> __( 'View Championship', 'bblm' ),
					'view_items' 			=> __( 'View Championships', 'bblm' ),
					'search_items' 			=> __( 'Search', 'bblm' ),
					'not_found' 			=> __( 'No results found.', 'bblm' ),
					'not_found_in_trash' 	=> __( 'No results found.', 'bblm' ),
					'all_items' 			=> __( 'Championships', 'bblm' ),
				),
				'public' 				=> true,
				'show_ui' 				=> true,
				'map_meta_cap' 			=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				'rewrite' 				=> array( 'slug' => 'cups' ),
				'supports' 				=> array( 'title', 'editor', 'thumbnail'),
				'has_archive' 			=> true,
				'show_in_nav_menus' 	=> true,
        'menu_icon' 			=> 'dashicons-awards',
        'show_in_menu' => 'bblm_main_menu',
			)
		); //end of Championships / Cups
    register_post_type( 'bblm_season',
			array(
				'labels' => array(
					'name' 					=> __( 'Seasons', 'bblm' ),
					'singular_name' 		=> __( 'Season', 'bblm' ),
					'add_new_item' 			=> __( 'Start New Season', 'bblm' ),
					'edit_item' 			=> __( 'Edit Season', 'bblm' ),
					'new_item' 				=> __( 'New', 'bblm' ),
					'view_item' 			=> __( 'View Season', 'bblm' ),
					'view_items' 			=> __( 'View Seasons', 'bblm' ),
					'search_items' 			=> __( 'Search', 'bblm' ),
					'not_found' 			=> __( 'No results found.', 'bblm' ),
					'not_found_in_trash' 	=> __( 'No results found.', 'bblm' ),
					'all_items' 			=> __( 'Seasons', 'bblm' ),
				),
				'public' 				=> true,
				'show_ui' 				=> true,
				'map_meta_cap' 			=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				'rewrite' 				=> array( 'slug' => 'season' ),
				'supports' 				=> array( 'title', 'editor'),
				'has_archive' 			=> true,
				'show_in_nav_menus' 	=> true,
        'menu_icon' 			=> 'dashicons-calendar-alt',
        'show_in_menu' => 'bblm_main_menu',
			)
		); //end of Seasons
    register_post_type( 'bblm_race',
			array(
				'labels' => array(
					'name' 					=> __( 'Races', 'bblm' ),
					'singular_name' 		=> __( 'Race', 'bblm' ),
					'add_new_item' 			=> __( 'New Race', 'bblm' ),
					'edit_item' 			=> __( 'Edit Race and Positions', 'bblm' ),
					'new_item' 				=> __( 'New', 'bblm' ),
					'view_item' 			=> __( 'View Race', 'bblm' ),
					'view_items' 			=> __( 'View Races', 'bblm' ),
					'search_items' 			=> __( 'Search', 'bblm' ),
					'not_found' 			=> __( 'No results found.', 'bblm' ),
					'not_found_in_trash' 	=> __( 'No results found.', 'bblm' ),
					'all_items' 			=> __( 'Races', 'bblm' ),
				),
				'public' 				=> true,
				'show_ui' 				=> true,
				'map_meta_cap' 			=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				'rewrite' 				=> array( 'slug' => 'races' ),
				'supports' 				=> array( 'title', 'editor'),
				'has_archive' 			=> true,
				'show_in_nav_menus' 	=> true,
        'menu_icon' 			=> 'dashicons-universal-access-alt',
        'show_in_menu' => 'bblm_main_menu',
			)
		); //end of Races
		register_post_type( 'bblm_comp',
			array(
				'labels' => array(
					'name' 					=> __( 'Competitions', 'bblm' ),
					'singular_name' 		=> __( 'Competition', 'bblm' ),
					'add_new_item' 			=> __( 'New Comp', 'bblm' ),
					'edit_item' 			=> __( 'Edit Competition', 'bblm' ),
					'new_item' 				=> __( 'New', 'bblm' ),
					'view_item' 			=> __( 'View Competition', 'bblm' ),
					'view_items' 			=> __( 'View Competition', 'bblm' ),
					'search_items' 			=> __( 'Search', 'bblm' ),
					'not_found' 			=> __( 'No results found.', 'bblm' ),
					'not_found_in_trash' 	=> __( 'No results found.', 'bblm' ),
					'all_items' 			=> __( 'Competitions', 'bblm' ),
				),
				'public' 				=> true,
				'show_ui' 				=> true,
				'map_meta_cap' 			=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				'rewrite' 				=> array( 'slug' => 'competitions' ),
				'supports' 				=> array( 'title', 'editor'),
				'has_archive' 			=> true,
				'show_in_nav_menus' 	=> true,
        'menu_icon' 			=> 'dashicons-shield-alt',
        'show_in_menu' => 'bblm_main_menu',
			)
		); //end of Competitions
		register_post_type( 'bblm_team',
			array(
				'labels' => array(
					'name' 					=> __( 'Teams', 'bblm' ),
					'singular_name' 		=> __( 'Team', 'bblm' ),
					'add_new_item' 			=> __( 'New Team', 'bblm' ),
					'edit_item' 			=> __( 'Edit Team', 'bblm' ),
					'new_item' 				=> __( 'New', 'bblm' ),
					'view_item' 			=> __( 'View Team', 'bblm' ),
					'view_items' 			=> __( 'View Teams', 'bblm' ),
					'search_items' 			=> __( 'Search', 'bblm' ),
					'not_found' 			=> __( 'No Teams found.', 'bblm' ),
					'not_found_in_trash' 	=> __( 'No Teams found.', 'bblm' ),
					'all_items' 			=> __( 'Teams', 'bblm' ),
				),
				'public' 				=> true,
				'show_ui' 				=> true,
				'map_meta_cap' 			=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> true,
				'rewrite' 				=> array( 'slug' => 'teams' ),
				'supports' 				=> array( 'title', 'editor', 'thumbnail'),
				'has_archive' 			=> true,
				'show_in_nav_menus' 	=> true,
        'menu_icon' 			=> 'dashicons-clipboard',
        'show_in_menu' => 'bblm_main_menu',
			)
		); //end of Competitions
		register_post_type( 'bblm_player',
			array(
				'labels' => array(
					'name' 					=> __( 'Players', 'bblm' ),
					'singular_name' 		=> __( 'Player', 'bblm' ),
					'add_new_item' 			=> __( 'New Player', 'bblm' ),
					'edit_item' 			=> __( 'Edit Player', 'bblm' ),
					'new_item' 				=> __( 'New', 'bblm' ),
					'view_item' 			=> __( 'View Player', 'bblm' ),
					'view_items' 			=> __( 'View Players', 'bblm' ),
					'search_items' 			=> __( 'Search', 'bblm' ),
					'not_found' 			=> __( 'No Players found.', 'bblm' ),
					'not_found_in_trash' 	=> __( 'No Players found.', 'bblm' ),
					'all_items' 			=> __( 'Players', 'bblm' ),
				),
				'public' 				=> true,
				'show_ui' 				=> true,
				'map_meta_cap' 			=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				'rewrite' 				=> array( 'slug' => 'players'  ),
				'supports' 				=> array( 'title', 'editor'),
				'has_archive' 			=> true,
				'show_in_nav_menus' 	=> true,
				'menu_icon' 			=> 'dashicons-universal-access',
				'show_in_menu' => 'bblm_main_menu',
			)
		); //end of Players
		register_post_type( 'bblm_roster',
			array(
				'labels' => array(
					'name' 					=> __( 'Rosters', 'bblm' ),
					'singular_name' 		=> __( 'Roster', 'bblm' ),
					'add_new_item' 			=> __( 'New Roster', 'bblm' ),
					'edit_item' 			=> __( 'Edit Rostrer', 'bblm' ),
					'new_item' 				=> __( 'New', 'bblm' ),
					'view_item' 			=> __( 'View Roster', 'bblm' ),
					'view_items' 			=> __( 'View Rosters', 'bblm' ),
					'search_items' 			=> __( 'Search', 'bblm' ),
					'not_found' 			=> __( 'No Rosters found.', 'bblm' ),
					'not_found_in_trash' 	=> __( 'No Rosters found.', 'bblm' ),
					'all_items' 			=> __( 'Rosters', 'bblm' ),
				),
				'public' 				=> true,
				'show_ui' 				=> true,
				'map_meta_cap' 			=> true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> true, //exclude from search
				'hierarchical' 			=> false,
				'rewrite' 				=> array( 'slug' => 'rosters' ),
				'supports' 				=> array( 'title', 'editor'),
				'has_archive' 			=> true,
				'show_in_nav_menus' 	=> true,
				'menu_icon' 			=> 'dashicons-nametag',
				'show_in_menu' => 'bblm_main_menu',
			)
		); //end of Rosters
	}

/**
 * Register taxonomies.
 */
public static function register_taxonomies() {


	// Teams Tax for posts
	register_taxonomy(
		'post_teams',
		'post',
		array(
			'label' => __( 'Teams', 'bblm'),
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'team-post' ),
		)

	);

	// Competitions Tax for posts
	register_taxonomy(
		'post_competitions',
		'post',
		array(
			'label' => __( 'Competitions', 'bblm' ),
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'competition-post' ),
		)

	);

	// Add "Competition type" Tax for Competitions
	$labels = array(
			'name'                       => _x( 'Competition Type', 'bblm' ),
			'singular_name'              => _x( 'Competition Type', 'bblm' ),
			'search_items'               => __( 'Search Competition Types', 'bblm' ),
			'all_items'                  => __( 'All Competition Types', 'bblm' ),
			'parent_item'                => __( 'Parent Competition Type', 'bblm' ),
			'parent_item_colon'          => __( 'Parent Competition Type:', 'bblm' ),
			'edit_item'                  => __( 'Edit Competition Type', 'bblm' ),
			'update_item'                => __( 'Update Competition Type', 'bblm' ),
			'add_new_item'               => __( 'Add New Competition Type', 'bblm' ),
			'new_item_name'              => __( 'New Competition Type', 'bblm' ),
			'not_found'                  => __( 'No Competition Types defined', 'bblm' ),
			'menu_name'                  => __( 'Competition Types', 'bblm' ),
	);

	$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'comp_type' ),
	);

	register_taxonomy( 'comp_type', 'bblm_comp', $args );



	}



  /**
	 * Loads all the CPT handler classes front end
	 */
	public function include_post_type_handlers() {

    include_once( 'post-types/class-bblm-cpt-dyk.php' );
    include_once( 'post-types/class-bblm-cpt-stadium.php' );
    include_once( 'post-types/class-bblm-cpt-cup.php' );
    include_once( 'post-types/class-bblm-cpt-season.php' );
    include_once( 'post-types/class-bblm-cpt-race.php' );

 }

} //End of Class

new BBLM_Post_types();
