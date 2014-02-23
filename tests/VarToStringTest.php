<?php

use \Xethron\ToString;

class VarToStringTest extends PHPUnit_Framework_TestCase
{

	public function __construct()
	{
		$this->array = [1,2,3,4,5];

		$this->two_dimentional_array = [
			$this->array,
			$this->array,
			$this->array,
			$this->array,
			$this->array
		];

		$this->three_dimentional_array = [
			$this->two_dimentional_array,
			$this->two_dimentional_array,
			$this->two_dimentional_array,
			$this->two_dimentional_array,
			$this->two_dimentional_array
		];
	}

	public function testNull()
	{
		$expected = 'null';
		$this->assertTest( $expected,null );
	}

	public function testString()
	{
		$string = 'Hello World!';

		$expected = '"'. $string .'"';
		$this->assertTest( $expected, $string );
	}

	public function testInt()
	{
		$int = 5;
		$expected = '5';
		$this->assertTest( $expected, $int );
	}

	public function testDecimal()
	{
		$int = 5.5;
		$expected = '5.5';
		$this->assertTest( $expected, $int );
	}

	public function testBoolean()
	{
		$this->assertTest( 'true', true );
		$this->assertTest( 'false', false );
	}

	/**
	 * Test a normal Array
	 * @return [type] [description]
	 */
	public function test1dArray()
	{
		$array = $this->array;

		/*******************************************
		 *  Test One Dimentional Array for 1 line  *
		 *******************************************/
		$lines = 1;
		$expected = "Array(5)";
		$this->assertTest( $expected, $array, $lines );

		/*******************************************
		 * Test One Dimentional Array for 4 lines  *
		 *******************************************/
		$lines = 4;
		$this->assertTest( $expected, $array, $lines );

		/*******************************************
		 * Test One Dimentional Array for 5 lines  *
		 *******************************************/
		$lines = 5;
		$expected = "Array
(
    [0] => 1
    ... (4)
)";
		$this->assertTest( $expected, $array, $lines );

		/*******************************************
		 * Test One Dimentional Array for 7 lines  *
		 *******************************************/
		$lines = 7;
		$expected = "Array
(
    [0] => 1
    [1] => 2
    [2] => 3
    ... (2)
)";
		$this->assertTest( $expected, $array, $lines );

		/*******************************************
		 * Test One Dimentional Array for 8 lines  *
		 *******************************************/
		$lines = 8;
		$expected = "Array
(
    [0] => 1
    [1] => 2
    [2] => 3
    [3] => 4
    [4] => 5
)";
		$this->assertTest( $expected, $array, $lines );

		/*******************************************
		 * Test One Dimentional Array for 10 lines *
		 *******************************************/
		$lines = 10;
		$this->assertTest( $expected, $array, $lines );

	}

	public function test2dArray()
	{
		$array = $this->two_dimentional_array;

		/*******************************************
		 * Test Two Dimentional Array for 5 lines  *
		 *******************************************/
		$lines = 5;
		$expected = "Array
(
    [0] => Array(5)
    ... (4)
)";
		$this->assertTest( $expected, $array, $lines );

		/*******************************************
		 * Test Two Dimentional Array for 7 lines  *
		 *******************************************/
		$lines = 7;
		$expected = "Array
(
    [0] => Array(5)
    [1] => Array(5)
    [2] => Array(5)
    ... (2)
)";
		$this->assertTest( $expected, $array, $lines );

		/*******************************************
		 * Test Two Dimentional Array for 13 lines *
		 *******************************************/
		$lines = 13;
		$expected = "Array
(
    [0] => Array
        (
            [0] => 1
            [1] => 2
            ... (3)
        )
    [1] => Array(5)
    [2] => Array(5)
    [3] => Array(5)
    [4] => Array(5)
)";
		$this->assertTest( $expected, $array, $lines );

		/*******************************************
		 * Test Two Dimentional Array for 15 lines *
		 *******************************************/
		$lines = 15;
		$expected = "Array
(
    [0] => Array
        (
            [0] => 1
            [1] => 2
            [2] => 3
            [3] => 4
            [4] => 5
        )
    [1] => Array(5)
    [2] => Array(5)
    [3] => Array(5)
    [4] => Array(5)
)";
		$this->assertTest( $expected, $array, $lines );

		/*******************************************
		 * Test Two Dimentional Array for 18 lines *
		 *******************************************/
		$lines = 18;
		$this->assertTest( $expected, $array, $lines );

		/*******************************************
		 * Test Two Dimentional Array for 19 lines *
		 *******************************************/
		$lines = 19;
		$expected = "Array
(
    [0] => Array
        (
            [0] => 1
            [1] => 2
            [2] => 3
            [3] => 4
            [4] => 5
        )
    [1] => Array
        (
            [0] => 1
            ... (4)
        )
    [2] => Array(5)
    [3] => Array(5)
    [4] => Array(5)
)";
		$this->assertTest( $expected, $array, $lines );
	}


	public function test3dArray()
	{
		$array = $this->three_dimentional_array;

		/*********************************************
		 * Test Three Dimentional Array for 98 lines *
		 *********************************************/
		$lines = 98;
		$expected = "Array
(
    [0] => Array
        (
            [0] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                    [3] => 4
                    [4] => 5
                )
            [1] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                    [3] => 4
                    [4] => 5
                )
            [2] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                    [3] => 4
                    [4] => 5
                )
            [3] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                    [3] => 4
                    [4] => 5
                )
            [4] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                    [3] => 4
                    [4] => 5
                )
        )
    [1] => Array
        (
            [0] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                    [3] => 4
                    [4] => 5
                )
            [1] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                    [3] => 4
                    [4] => 5
                )
            [2] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                    [3] => 4
                    [4] => 5
                )
            [3] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                    [3] => 4
                    [4] => 5
                )
            [4] => Array
                (
                    [0] => 1
                    [1] => 2
                    [2] => 3
                    [3] => 4
                    [4] => 5
                )
        )
    [2] => Array
        (
            [0] => Array(5)
            [1] => Array(5)
            [2] => Array(5)
            ... (2)
        )
    [3] => Array(5)
    [4] => Array(5)
)";
		$this->assertTest( $expected, $array, $lines );
	}

	protected function assertTest( $expected, $variable, $lines = 40, $max_depth = 6, $min_depth = 1 )
	{
		$result = Xethron\ToString::variable(
			$variable,
			$lines,
			$max_depth,
			$min_depth
		);
		$this->assertEquals( $expected, $result );
	}

}