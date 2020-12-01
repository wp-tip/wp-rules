<?php

namespace WP_Rules\Tests\Unit;

use Brain\Monkey;
use Brain\Monkey\Functions;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use ReflectionObject;

abstract class TestCase extends PHPUnitTestCase {
	use MockeryPHPUnitIntegration;

	protected static $mockCommonWpFunctionsInSetUp = false;

	protected $test_data;

	protected function setUp() {
		if ( empty( $this->test_data ) ) {
			$this->loadTestData();
		}

		parent::setUp();
		Monkey\setUp();

		if ( static::$mockCommonWpFunctionsInSetUp ) {
			$this->mockCommonWpFunctions();
		}
	}

	protected function tearDown() {
		Monkey\tearDown();
		parent::tearDown();
	}

	protected function mockCommonWpFunctions() {
		Functions\stubs(
			[
				'__',
				'esc_attr__',
				'esc_html__',
				'_x',
				'esc_attr_x',
				'esc_html_x',
				'_n',
				'_nx',
				'esc_attr',
				'esc_html',
				'esc_textarea',
				'esc_url',
			]
		);

		$functions = [
			'_e',
			'esc_attr_e',
			'esc_html_e',
			'_ex',
		];

		foreach ( $functions as $function ) {
			Functions\when( $function )->echoArg();
		}
	}

	protected function loadTestData() {
		$obj      = new ReflectionObject( $this );
		$filename = $obj->getFileName();

		$this->test_data = $this->getTestData( dirname( $filename ), basename( $filename, '.php' ) );
	}

	protected function getTestData( $dir, $filename ) {
		if ( empty( $dir ) || empty( $filename ) ) {
			return [];
		}

		$dir = str_replace( [ 'Integration', 'Unit' ], 'Fixtures', $dir );
		$dir = rtrim( $dir, '\\/' );
		$testdata = "$dir/{$filename}.php";

		return is_readable( $testdata )
			? require $testdata
			: [];
	}

	public function providerTestData() {
		if ( empty( $this->test_data ) ) {
			$this->loadTestData();
		}

		return isset( $this->test_data['test_data'] )
			? $this->test_data['test_data']
			: $this->test_data;
	}
}
