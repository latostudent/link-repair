<?php

/**
 *
 * The plugin bootstrap file
 *
 * This file is responsible for starting the plugin using the main plugin class file.
 *
 * @since 0.0.1
 * @package lato_link_repair
 *
 * @wordpress-plugin
 * Plugin Name:     Link Repair
 * Description:     Este plugin te ayudara a encontrar enlaces que no funcionan en tus posts.
 * Version:         0.0.1
 * Author:          Carlos La Torre
 * Author URI:      https://latodev.com
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     lato_link_repair
 * Domain Path:     /lang
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access not permitted.' );
}

if ( ! class_exists( 'lato_link_repair' ) ) {

	/*
	 * main lato_link_repair class
	 *
	 * @class lato_link_repair
	 * @since 0.0.1
	 */
	class lato_link_repair {

		/*
		 * lato_link_repair plugin version
		 *
		 * @var string
		 */
		public $version = '4.7.5';

		/**
		 * The single instance of the class.
		 *
		 * @var lato_link_repair
		 * @since 0.0.1
		 */
		protected static $instance = null;

		/**
		 * Main lato_link_repair instance.
		 *
		 * @since 0.0.1
		 * @static
		 * @return lato_link_repair - main instance.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * lato_link_repair class constructor.
		 */
		public function __construct() {
			$this->load_plugin_textdomain();
			$this->define_constants();
			$this->includes();
			$this->define_actions();
		}

		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'lato-link-repair', false, basename( dirname( __FILE__ ) ) . '/lang/' );
		}

		/**
		 * Include required core files
		 */
		public function includes() {
            // Example
			//require_once __DIR__ . '/includes/loader.php';

			// Load custom functions and hooks
			require_once __DIR__ . '/includes/includes.php';
			require_once __DIR__ . '/includes/meta-fields.php';
			require_once __DIR__ . '/includes/schedule.php';
			require_once __DIR__ . '/includes/update.php';
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
		 * Define lato_link_repair constants
		 */
		private function define_constants() {
			define( 'LATO_LINK_REPAIR_PLUGIN_FILE', __FILE__ );
			define( 'LATO_LINK_REPAIR_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			define( 'LATO_LINK_REPAIR_VERSION', $this->version );
			define( 'LATO_LINK_REPAIR_PATH', $this->plugin_path() );
		}

		/**
		 * Define lato_link_repair actions
		 */
		public function define_actions() {
			//
		}

		/**
		 * Define lato_link_repair menus
		 */
		public function define_menus() {
            //
			
		}
	}

	$lato_link_repair = new lato_link_repair();
}
