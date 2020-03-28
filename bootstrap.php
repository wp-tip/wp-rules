<?php
defined( 'ABSPATH' ) || exit;

use Rules\Admin\Rules_Admin_Manager;

if ( ! class_exists( 'Rules_Bootstrap' ) ) {

	final class Rules_Bootstrap {

		private function __construct() {
			/* Do nothing here */ }

		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Don\'t try again!', 'wp-rules' ), '2.1' ); }

		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Don\'t try again!', 'wp-rules' ), '2.1' ); }

		private function setup_constants() {
			$plugin_file_path = __FILE__;
			$plugin_dir       = plugin_dir_path( $plugin_file_path );
			$plugin_url       = plugin_dir_url( $plugin_file_path );

			$includes_dir = trailingslashit( $plugin_dir . 'includes' );
			$core_dir     = trailingslashit( $includes_dir . 'core' );
			$common_dir   = trailingslashit( $includes_dir . 'common' );
			$admin_dir    = trailingslashit( $includes_dir . 'admin' );
			$admin_views_dir    = trailingslashit( $admin_dir . 'views' );

			defined( 'RULES_VERSION' ) || define( 'RULES_VERSION', '1.0.0' );
			defined( 'RULES_DIR_PATH' ) || define( 'RULES_DIR_PATH', $plugin_dir );
			defined( 'RULES_DIR_URL' ) || define( 'RULES_DIR_URL', $plugin_url );
			defined( 'RULES_INCLUDES_PATH' ) || define( 'RULES_INCLUDES_PATH', $includes_dir );
			defined( 'RULES_CORE_PATH' ) || define( 'RULES_CORE_PATH', $core_dir );
			defined( 'RULES_COMMON_PATH' ) || define( 'RULES_COMMON_PATH', $common_dir );
			defined( 'RULES_ADMIN_PATH' ) || define( 'RULES_ADMIN_PATH', $admin_dir );
			defined( 'RULES_ADMIN_VIEWS_PATH' ) || define( 'RULES_ADMIN_VIEWS_PATH', $admin_views_dir );
		}

		private function includes() {
			// Include function based files
			require_once RULES_CORE_PATH . 'abstraction.php';
			require_once RULES_CORE_PATH . 'actions.php';
			require_once RULES_COMMON_PATH . 'ajax.php';

			// Admin actions
			if ( is_admin() ) {
				require RULES_ADMIN_PATH . 'actions.php';
				require RULES_ADMIN_PATH . 'functions.php';
			}
		}

		private function setup_autoloader() {
			try {
				require_once RULES_CORE_PATH . 'autoloader.php';
				new Rules_Autoloader( RULES_INCLUDES_PATH );
			} catch ( Exception $e ) {
				if ( WP_DEBUG ) {
					die( esc_attr( $e->getMessage() ) );
				}
			}
		}

		private function start_application() {
			if( is_admin() ) {
				$admin_manager = new Rules_Admin_Manager();
				$admin_manager->setup();
			}
		}

		public static function instance() {
			static $instance = null;

			if ( null === $instance ) {
				$instance = new Rules_Bootstrap();
				$instance->setup_constants();
				$instance->includes();
				$instance->setup_autoloader();
				$instance->start_application();
			}

			return $instance;
		}


	}

	/**
	 * The main function responsible for returning the one true wp-rules Instance
	 * to functions everywhere.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * Example: <?php $rules = wp_rules(); ?>
	 *
	 * @since 1.0.0 wp-rules
	 *
	 * @return Rules_Bootstrap The one true wp-rules Instance
	 */
	function wp_rules() {
		return Rules_Bootstrap::instance();
	}

	/**
	 * Hook wp-rules early onto the 'plugins_loaded' action.
	 *
	 * This gives all other plugins the chance to load before wp-rules, to get their
	 * actions, filters, and overrides setup without wp-rules being in the way.
	 */
	if ( defined( 'RULES_LATE_LOAD' ) ) {
		add_action( 'plugins_loaded', 'wp_rules', (int) RULES_LATE_LOAD );

		// "And now here's something we hope you'll really like!"
	} else {
		wp_rules();
	}
}
