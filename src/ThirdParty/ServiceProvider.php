<?php
namespace WP_Rules\ThirdParty;

use WP_Rules\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package WP_Rules\Triggers
 */
class ServiceProvider extends AbstractServiceProvider {

	/**
	 * Provides array, will be filled on constructor.
	 *
	 * @var string[]
	 */
	public $provides = [];

	/**
	 * List of plugins.
	 *
	 * @var array
	 */
	private $plugins = [
		'ContactForm7',
		'NinjaForms',
	];

	/**
	 * List of themes
	 *
	 * @var string[]
	 */
	private $themes = [];

	/**
	 * List of registered classes sent to the container
	 *
	 * @var array
	 */
	private $registered_classes = [];

	/**
	 * Load plugins and themes then fill provides array.
	 */
	public function __construct() {
		$this->register_thirdparty_plugins();
		$this->register_thirdparty_themes();

		if ( empty( $this->registered_classes ) ) {
			return;
		}

		$this->provides = array_keys( $this->registered_classes );
	}

	/**
	 * Register plugins.
	 */
	private function register_thirdparty_plugins() {
		foreach ( $this->plugins as $plugin ) {
			$plugin_class = '\\WP_Rules\\ThirdParty\\Plugins\\' . $plugin . '\\Plugin';
			if ( ! method_exists( $plugin_class, 'is_allowed' ) || ! $plugin_class::is_allowed() ) {
				continue;
			}

			if ( ! method_exists( $plugin_class, 'register' ) ) {
				continue;
			}

			foreach ( $plugin_class::register() as $class_name => $class_path ) {
				$this->registered_classes[ 'rules_thirdparty_plugin_' . $plugin . '_' . $class_name ] = $class_path;
			}
		}
	}

	/**
	 * Register themes.
	 */
	private function register_thirdparty_themes() {
		foreach ( $this->themes as $theme ) {
			$theme_class = '\\WP_Rules\\ThirdParty\\Themes\\' . $theme . '\\Theme';
			if ( ! method_exists( $theme_class, 'is_allowed' ) || ! $theme_class::is_allowed() ) {
				continue;
			}

			if ( ! method_exists( $theme_class, 'register' ) ) {
				continue;
			}

			foreach ( $theme_class::register() as $class_name => $class_path ) {
				$this->registered_classes[ 'rules_thirdparty_theme_' . $theme . '_' . $class_name ] = $class_path;
			}
		}
	}

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		if ( empty( $this->registered_classes ) ) {
			return;
		}

		$container = $this->getContainer();

		foreach ( $this->registered_classes as $class_name => $class_path ) {
			$container->share( $class_name, $class_path );
		}

	}
}
