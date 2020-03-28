<?php
/**
 * The wp-rules Plugin
 *
 * WP-rules is business workflow rules plugin for WordPress CMS.
 *
 * @package wp-rules
 * @subpackage Main
 */

/**
 * Plugin Name: WP Rules
 * Plugin URI:  https://github.com/engahmeds3ed/wp-rules
 * Description: WP Rules is business workflow rules plugin for WordPress CMS.
 * Author:      Ahmed Saeed
 * Author URI:  https://github.com/engahmeds3ed
 * Version:     1.0.0
 * Text Domain: wp_rules
 * Domain Path: /languages/
 * License:     GPLv2 or later (license.txt)
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$rules_bootstrap = __DIR__ . '/bootstrap.php';

// Include wp-rules bootstrap.
require $rules_bootstrap;

// Unset the loader, since it's loaded in global scope.
unset( $rules_bootstrap );
