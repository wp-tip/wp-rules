<?php

namespace WP_Rules\Tests\Unit;

define( 'WP_RULES_IS_TESTING', true );
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

init_test_suite( 'Unit' );
