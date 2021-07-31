<?php
namespace WP_Rules\ThirdParty\Plugins;

/**
 * Class AbstractPlugin
 *
 * @package WP_Rules\ThirdParty\Plugins
 */
abstract class AbstractPlugin {

	/**
	 * Status of this plugin activation.
	 *
	 * @return bool
	 */
	abstract public static function is_allowed(): bool;

	/**
	 * Register this list of classes.
	 *
	 * @return string[]
	 */
	abstract public static function register(): array;

}
