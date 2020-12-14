<?php

namespace WP_Rules\Tests\Integration\src\Core\Template\Render;

use WP_Rules\Tests\Integration\TestCase;

/**
 * @covers \WP_Rules\Core\Template\Render::render
 * @group  Core
 */
class Test_render extends TestCase {

	/**
	 * @dataProvider providerTestData
	 */
	public function testShouldAssureTestCase( $input, $output ) {
		$this->assertSame( $input, $output );
	}

}
