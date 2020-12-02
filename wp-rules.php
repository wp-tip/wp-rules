<?php
/**
 * Plugin Name: WP Rules
 * Plugin URI:  https://github.com/engahmeds3ed/wp-rules
 * Description: WP Rules is business workflow rules plugin for WordPress CMS.
 * Author:      Ahmed Saeed
 * Author URI:  https://github.com/engahmeds3ed
 * Version:     0.1
 * Text Domain: wp_rules
 * Domain Path: /languages/
 * License:     GPLv2 or later (license.txt)
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$plugin_file_path = __FILE__;
$plugin_dir       = plugin_dir_path( $plugin_file_path );
$plugin_url       = plugin_dir_url( $plugin_file_path );

defined( 'WP_RULES_VERSION' )  || define( 'WP_RULES_VERSION' , '0.1' );
defined( 'WP_RULES_PATH' )     || define( 'WP_RULES_PATH'    , $plugin_dir );
defined( 'WP_RULES_URL' )      || define( 'WP_RULES_URL'     , $plugin_url );
defined( 'WP_RULES_MIN_PHP' )  || define( 'WP_RULES_MIN_PHP' , '7.2' );
defined( 'WP_RULES_MIN_WP' )   || define( 'WP_RULES_MIN_WP'  , '5.2' );

defined( 'WP_RULES_VIEWS_PATH' )     || define( 'WP_RULES_VIEWS_PATH'  , WP_RULES_PATH . "Views" . DIRECTORY_SEPARATOR );
defined( 'WP_RULES_SRC_PATH' )       || define( 'WP_RULES_SRC_PATH'  , WP_RULES_PATH . "src" . DIRECTORY_SEPARATOR );
defined( 'WP_RULES_FUNCTIONS_PATH' ) || define( 'WP_RULES_FUNCTIONS_PATH'  , WP_RULES_SRC_PATH . "Functions" . DIRECTORY_SEPARATOR );

// Composer autoload.
if ( file_exists( WP_RULES_PATH . 'vendor/autoload.php' ) ) {
	require WP_RULES_PATH . 'vendor/autoload.php';
}

if ( ! class_exists( 'WPRules' ) ) {

	final class WPRules {

		private function __construct() {
			/* Do nothing here */
		}

		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Don\'t try again!', 'wp-rules' ), '2.1' );
		}

		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Don\'t try again!', 'wp-rules' ), '2.1' );
		}

		public static function init() {
			// Nothing to do if autosave.
			if ( defined( 'DOING_AUTOSAVE' ) ) {
				return;
			}

			static $instance = null;

			if ( null === $instance ) {
				$instance = new self();

				$instance->load_textdomain();

				//Check requirements.
				$requirements_checker = new \WP_Rules\Core\Plugin\RequirementsChecker(
					[
						'php_version' => WP_RULES_MIN_PHP,
						'wp_version'  => WP_RULES_MIN_WP
					]
				);

				if ( $requirements_checker->process() ) {
					//load container.
					$container = new WP_Rules\Dependencies\League\Container\Container();

					//load functions.
					require_once WP_RULES_FUNCTIONS_PATH . "Functions.php";

					//Load main service providers and subscribers.
					$loader = new \WP_Rules\Core\Plugin\Loader( $container );
					$loader->load();

					//Share the container instance using filter.
					add_filter( 'rules_container', [ $loader, 'get_container' ] );

				}
			}
		}

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
