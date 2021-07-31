<?php
namespace WP_Rules\ThirdParty\Themes;

/**
 * Class AbstractTheme
 *
 * @package WP_Rules\ThirdParty\Themes
 */
abstract class AbstractTheme {

	/**
	 * Status of this theme activation.
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
