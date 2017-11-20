<?php

namespace Beans\Framework\Tests\UnitTests\API\Utilities;

use Beans\Framework\Tests\UnitTests\Test_Case;
use Brain\Monkey\Functions;

/**
 * Class Tests_Beans_Render_Function
 *
 * @package Beans\Framework\Tests\API\Utilities
 * @group   unit-tests
 * @group   api
 */
class Tests_Beans_Render_Function extends Test_Case {

	/**
	 * Setup test fixture.
	 */
	protected function setUp() {
		parent::setUp();

		require_once BEANS_TESTS_LIB_DIR . '/api/utilities/functions.php';
	}

	/**
	 * Test beans_render_function() should bail out when receiving a non-callable.
	 */
	public function test_should_bail_when_noncallable() {
		$this->assertNull( beans_render_function( 'this-callback-does-not-exist' ) );
	}

	/**
	 * Test beans_render_function() should work when there no arguments.
	 */
	public function test_should_work_when_no_arguments() {
		$this->assertEquals( 'You called me!', beans_render_function( function () {
			echo 'You called me!';
		} ) );
	}

	/**
	 * Test beans_render_function() should work with arguments.
	 */
	public function test_should_work_with_arguments() {

		Functions\when( 'callback_for_render_function' )
			->justEcho( 'foo' );
		$this->assertSame( 'foo', beans_render_function( 'callback_for_render_function', 'foo' ) );

		$callback = function ( $foo, $bar, $baz ) {
			echo "{$foo} {$bar} {$baz}";
		};
		$this->assertSame( 'foo bar baz', beans_render_function( $callback, 'foo', 'bar', 'baz' ) );

		$callback = function ( $array, $baz ) {
			echo join( ' ', $array ) . ' ' . $baz;
		};
		$this->assertSame(
			'foo bar baz',
			beans_render_function( $callback, array( 'foo', 'bar' ), 'baz' )
		);

		$callback = function ( $object ) {
			$this->assertObjectHasAttribute( 'foo', $object );
			echo $object->foo;
		};
		$this->assertSame(
			'beans',
			beans_render_function( $callback, (object) array( 'foo' => 'beans' ) )
		);
	}
}
