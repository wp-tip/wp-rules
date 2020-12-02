<?php

namespace WP_Rules\Tests\Integration;

define( 'WP_RULES_IS_TESTING', true );
define( 'WP_RULES_PLUGIN_ROOT', dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR );
define( 'WP_RULES_TESTS_FIXTURES_DIR', dirname( __DIR__ ) . '/Fixtures' );
define( 'WP_RULES_TESTS_DIR', __DIR__ );
define( 'WP_RULES_PHPUNIT_ROOT_DIR', dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR );
define( 'WP_RULES_PHPUNIT_ROOT_TEST_DIR', __DIR__ );

function init_test_suite( $test_suite = 'Unit' ) {
	if ( 'Unit' === $test_suite && ! defined( 'ABSPATH' ) ) {
		define( 'ABSPATH', WP_RULES_PHPUNIT_ROOT_DIR );
	}

	check_readiness();

	// Load the Composer autoloader.
	require_once WP_RULES_PHPUNIT_ROOT_DIR . 'vendor/autoload.php';

	// Load Patchwork before everything else in order to allow us to redefine WordPress, 3rd party, or any other non-native PHP functions.
	require_once WP_RULES_PHPUNIT_ROOT_DIR . 'vendor/antecedent/patchwork/Patchwork.php';
}

function check_readiness() {
	if ( version_compare( phpversion(), '5.6.0', '<' ) ) {
		trigger_error( 'Test Suite requires PHP 5.6 or higher.', E_USER_ERROR );
	}

	if ( ! file_exists( WP_RULES_PHPUNIT_ROOT_DIR . '/vendor/autoload.php' ) ) {
		trigger_error( 'Whoops, we need Composer before we start running tests.  Please type: `composer install`.  When done, try running `phpunit` again.', E_USER_ERROR ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error -- Valid use case for our testing suite.
	}
}

init_test_suite( 'Integration' );

$tests_dir = getenv( 'WP_TESTS_DIR' );

// Travis CI & Vagrant SSH tests directory.
if ( empty( $tests_dir ) ) {
	$tests_dir = '/tmp/wordpress-tests-lib';
}

// If the tests' includes directory does not exist, try a relative path to Core tests directory.
if ( ! file_exists( $tests_dir . '/includes/' ) ) {
	$tests_dir = '../../../../../../../../tests/phpunit';
}

// Check it again. If it doesn't exist, stop here and post a message as to why we stopped.
if ( ! file_exists( $tests_dir . '/includes/' ) ) {
	trigger_error( 'Unable to run the integration tests, because the WordPress test suite could not be located.', E_USER_ERROR ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error -- Valid use case for our testing suite.
}

// Strip off the trailing directory separator, if it exists.
$wp_tests_dir = rtrim( $tests_dir, DIRECTORY_SEPARATOR );

// Give access to tests_add_filter() function.
require_once $wp_tests_dir . '/includes/functions.php';

// Manually load the plugin being tested.
tests_add_filter(
	'muplugins_loaded',
	function() {

		// Load the plugin.
		require WP_RULES_PLUGIN_ROOT . '/wp-rules.php';

	} );

// Start up the WP testing environment.
require_once $wp_tests_dir . '/includes/bootstrap.php';
