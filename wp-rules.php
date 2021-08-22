<?php
/**
 * Plugin Name: Business Rules
 * Plugin URI:  https://github.com/wp-tip/wp-rules
 * Description: WP Business Rules is business workflow rules plugin for WordPress CMS.
 * Author:      WP Tip
 * Author URI:  https://github.com/wp-tip
 * Version:     0.1.5
 * Text Domain: wp_rules
 * Domain Path: /languages/
 * License:     GPLv2 or later (license.txt)
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$rules_plugin_file_path = __FILE__;
$rules_plugin_dir       = plugin_dir_path( $rules_plugin_file_path );
$rules_plugin_url       = plugin_dir_url( $rules_plugin_file_path );

defined( 'WP_RULES_VERSION' ) || define( 'WP_RULES_VERSION', '0.1.5' );
defined( 'WP_RULES_PATH' ) || define( 'WP_RULES_PATH', $rules_plugin_dir );
defined( 'WP_RULES_URL' ) || define( 'WP_RULES_URL', $rules_plugin_url );
defined( 'WP_RULES_MIN_PHP' ) || define( 'WP_RULES_MIN_PHP', '7.2' );
defined( 'WP_RULES_MIN_WP' ) || define( 'WP_RULES_MIN_WP', '5.2' );

defined( 'WP_RULES_VIEWS_PATH' ) || define( 'WP_RULES_VIEWS_PATH', WP_RULES_PATH . 'Views' . DIRECTORY_SEPARATOR );
defined( 'WP_RULES_SRC_PATH' ) || define( 'WP_RULES_SRC_PATH', WP_RULES_PATH . 'src' . DIRECTORY_SEPARATOR );
defined( 'WP_RULES_FUNCTIONS_PATH' ) || define( 'WP_RULES_FUNCTIONS_PATH', WP_RULES_SRC_PATH . 'Functions' . DIRECTORY_SEPARATOR );

// Composer autoload.
if ( file_exists( WP_RULES_PATH . 'vendor/autoload.php' ) ) {
	require WP_RULES_PATH . 'vendor/autoload.php';
}

if ( ! class_exists( 'WPRules' ) ) {

	final class WPRules {

		/**
		 * WPRules constructor.
		 *
		 * Prevent this class from being instantiated directly.
		 */
		private function __construct() {
			/* Do nothing here */
		}

		/**
		 * Never clone this class.
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Don\'t try again!', 'rules' ), '2.1' );
		}

		/**
		 * Never wakeup.
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Don\'t try again!', 'rules' ), '2.1' );
		}

		/**
		 * Initialize the plugin.
		 */
		public static function init() {
			// Nothing to do if autosave.
			if ( defined( 'DOING_AUTOSAVE' ) ) {
				return;
			}

			static $instance = null;

			if ( null === $instance ) {
				$instance = new self();

				$instance->load_textdomain();

				// Check requirements.
				$requirements_checker = new \WP_Rules\Core\Plugin\RequirementsChecker(
					[
						'php_version' => WP_RULES_MIN_PHP,
						'wp_version'  => WP_RULES_MIN_WP,
					]
				);

				if ( $requirements_checker->process() ) {
					// load container.
					$container = new WP_Rules\Dependencies\League\Container\Container();

					// load functions.
					require_once WP_RULES_FUNCTIONS_PATH . 'Functions.php';

					// Load main service providers and subscribers.
					$loader = new \WP_Rules\Core\Plugin\Loader( $container );

					// Share the container instance using filter.
					add_filter( 'rules_container', [ $loader, 'get_container' ] );

					$loader->load();

				}
			}
		}

		/**
		 * Load plugin text domain.
		 */
		private function load_textdomain() {
			// Load translations from the languages directory.
			$locale = get_locale();

			// This filter is documented in /wp-includes/l10n.php.
			$locale = apply_filters( 'plugin_locale', $locale, 'rules' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals
			load_textdomain( 'wp-rules', WP_LANG_DIR . '/plugins/wp-rules-' . $locale . '.mo' );

			load_plugin_textdomain( 'wp-rules', false, dirname( plugin_basename( __FILE__ ) ) . '/Languages/' );
		}

	}

}

add_action( 'plugins_loaded', [ 'WPRules', 'init' ] );

register_deactivation_hook( $rules_plugin_file_path, [ 'WP_Rules\Core\Deactivation\Deactivate', 'index' ] );
register_activation_hook( $rules_plugin_file_path, [ 'WP_Rules\Core\Activation\Activate', 'index' ] );

unset( $rules_plugin_dir, $rules_plugin_file_path, $rules_plugin_url );
