<?php
/*
Plugin Name: Blood Bowl League Manager System (BBLM)
Plugin URI: http://www.hdwsbbl.co.uk/
Description: A BloodBowl League Manager
Version: 1.14
Author: Blacksnotling
Author URI: https://github.com/blacksnotling
Requires at least: 4.7
Tested up to: 5.6

Text Domain: bblm

*/
//stop people from accessing the file directly and causing errors.
if (!function_exists('add_action')) die('You cannot run this file directly. Naughty Person');

/**
 * Defnes a new capability, bblm_manage_league which is used to authorise access to the acmin section
 * http://www.garyc40.com/2010/04/ultimate-guide-to-roles-and-capabilities/
 *
 */
add_action( 'init', 'bblm_roles_init' );

function bblm_roles_init() {
	$roles_object = get_role( 'administrator' );
	$roles_object->add_cap('bblm_manage_league');
}

/**
 *	New Class structure below!
 */

/**
 *
 * @package BBowlLeagueMan
 * @category Core
 * @author Blacksnoptling
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'BBowlLeagueMan' ) ) :

/**
 * Main BBowlLeagueMan Class
 *
 * @class BBowlLeagueMan
 * @version	1.8
 */
final class BBowlLeagueMan {

	/**
	 * @var string
	 */
	public $version = '1.8';

	/**
	 * @var BBowlLeagueMan The single instance of the class
	 */
	protected static $_instance = null;


	/**
	 * @var BBLM_Templates $templates
	 */
	public $templates = null;

	/**
	 * @var array
	 */
	public $text = array();

	/**
	 * Main BBowlLeagueMan Instance
	 *
	 * Ensures only one instance of BBowlLeagueMan is loaded or can be loaded.
	 *
	 * @static
	 * @see BBLM()
	 * @return BBowlLeagueMan - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Illegal Procedure', 'bblm' ), '1.7' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Illegal Procedure', 'bblm' ), '1.7' );
	}

	/**
	 * BBowlLeagueMan Constructor.
	 * @access public
	 * @return BBowlLeagueMan
	 */
	public function __construct() {

		// Auto-load classes on demand
		if ( function_exists( "__autoload" ) ) {
			spl_autoload_register( "__autoload" );
		}

		spl_autoload_register( array( $this, 'autoload' ) );

		// Define constants
		$this->define_constants();

		// Include required files
		$this->includes();

		// Hooks
		add_action( 'init', array( $this, 'init' ), 0 );
		add_action( 'after_setup_theme', array( $this, 'setup_environment' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'bblm_include_scripts' ) );

	}

	/**
	 * Auto-load BBLM classes on demand to reduce memory consumption (and in the event I forgot to include them in the code!).
	 *
	 * @param mixed $class
	 * @return void
	 */
	public function autoload( $class ) {
		$path  = null;
		$class = strtolower( $class );
		$file = 'class-' . str_replace( '_', '-', $class ) . '.php';

		if ( $path && is_readable( $path . $file ) ) {
			include_once( $path . $file );
			return;
		}

		// Fallback
		if ( strpos( $class, 'bblm_' ) === 0 ) {
			$path = $this->plugin_path() . '/includes/';
		}

		if ( $path && is_readable( $path . $file ) ) {
			include_once( $path . $file );
			return;
		}
	}

	/**
	 * Define BBLM Constants.
	 */
	private function define_constants() {
		define( 'BBLM_PLUGIN_FILE', __FILE__ );
		define( 'BBLM_VERSION', $this->version );

		if ( ! defined( 'BBLM_TEMPLATE_PATH' ) ) {
			define( 'BBLM_TEMPLATE_PATH', $this->template_path() );
		}

	}

	/**
	 * Include required core files
	 */
	private function includes() {

		include_once( 'includes/bblm-common-functions.php' );
		include_once( 'includes/bblm-common-display-functions.php' );

		if ( is_admin() ) {
			include_once( 'includes/admin/class-bblm-admin.php' );
		}

		if ( ! is_admin() ) {
			$this->frontend_includes();
		}

		include_once( 'includes/class-bblm-post-types.php' );		// Registers post types
		include_once( 'includes/class-bblm-widgets.php' );			// Loads the Widgets
		include_once( 'includes/bblm-conditional-functions.php' );		// loads the conditional functions for templating
		include_once( 'includes/bblm-common-template-functions.php' );
		include_once( 'includes/class-custom-template.php' );					// Class for static (non CPT) templates

	}

	/**
	 * Include required frontend files.
	 */
	public function frontend_includes() {

		include_once( 'includes/class-bblm-template-loader.php' );		// Template Loader
		include_once( 'includes/class-bblm-stats.php' );							// Class for displaying Statistics

	}

	/**
	 * Includes any CSS or Javascript required by the plugin. These will load
	 * on ALL pages.
	 */
function bblm_include_scripts() {

	wp_enqueue_style( 'bblm_core_styles', $this->plugin_url() . '/includes/CSS/bblm.css' );

}

	/**
	 * Init BBowlLeagueMan when WordPress Initialises.
	 */
	public function init() {

		//flush rules on plugin init so that the custom permalinks all work (hopefully).
		flush_rewrite_rules();
	}


	/**
	 * Ensure theme and server variable compatibility and setup image sizes if the theme we are using does not include them.
	 */
	public function setup_environment() {
		if ( ! current_theme_supports( 'post-thumbnails' ) ) {
			add_theme_support( 'post-thumbnails' );
		}

		// Add image sizes
		add_image_size( 'bblm-crop-medium',  300, 300, true );
		add_image_size( 'bblm-fit-medium',  300, 300, false );
		add_image_size( 'bblm-fit-icon',  158, 158, false );
		add_image_size( 'bblm-fit-mini',  32, 32, false );
		add_image_size( 'bblm-fit-micro',  20, 20, false );
	}

	/** Helper functions ******************************************************/

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Get the template path.
	 *
	 * @return string
	 */
	public function template_path() {
		//return apply_filters( 'BBLM_TEMPLATE_PATH', 'Bs-cpt-plugin-test/' );
		$tppath = plugin_dir_path( __FILE__ );
		$tppath .= 'templates/';
		return $tppath;
	}
}

endif;

if ( ! function_exists( 'BBLM' ) ):

/**
 * Returns the main instance of BBLM to prevent the need to use globals.
 *
 * @return BBowlLeagueMan
 */
function BBLM() {
	return BBowlLeagueMan::instance();
}

endif;

BBLM();
?>
