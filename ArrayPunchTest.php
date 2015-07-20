<?php
/**
 * Challenge Yourselph - 011
 *
 * Array Punch
 *   This weeks challenge (from Eddie Pfremmer, team Bacon) is a little open ended and abstract.
 *   Provide your interpretation of what a native PHP function array_punch should do.
 *
 * @see https://github.com/php/php-src/tree/master/ext/standard/tests/array/array_push*
 *
 * @author Konr Ness <konr.ness@gmail.com>
 */

require 'array_punch.php';

class ArrayPunchTest extends PHPUnit_Framework_TestCase {

    private $empty_array;
    private $number;
    private $str;
    private $mixed_array;

    public function setUp()
    {
        $this->empty_array = array();
        $this->number = 5;
        $this->str = "abc";
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage array_punch() expects at least 2 parameters, 0 given
     */
    public function testZeroArguments()
    {
        $this->assertNull(array_punch());
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage array_punch() expects parameter 1 to be array, integer given
     */
    public function testScalarArgument()
    {
        $this->assertNull(array_punch($this->number, 22));
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage array_punch() expects parameter 1 to be array, string given
     */
    public function testStringArgument()
    {
        $this->assertNull(array_punch($this->str, 22));
    }

    public function testInvalidNumberOfArguments()
    {
        $array = array( 1,2,3,4,5,6,7,8,9 );

        $count = array_punch($array,1,2);

        $this->assertEquals(array( 1,2,3,4,5,6,7,8,1,2,9 ), $array);
        $this->assertEquals(11, $count);
    }

    /**
     * @dataProvider normalFunctionalityProvider
     */
    public function testNormalFunctionality($input, $expectedArray)
    {
        $this->assertEquals(count($expectedArray), array_punch($input, 22, "abc"));

        $this->assertEquals($expectedArray, $input);
    }


    public function normalFunctionalityProvider()
    {
        return array(
            array(array(), array(22, "abc")),
            array(array( 1,2,3,4,5,6,7,8,9 ),array( 1,2,3,4,5,6,7,8,22,'abc',9)),
            array(array( "One", "_Two", "Three", "Four", "Five" ),array( "One", "_Two", "Three", "Four", 22, 'abc', "Five" )),
            array(array( 6, "six", 7, "seven", 8, "eight", 9, "nine" ),array( 6, "six", 7, "seven", 8, "eight", 9, 22, 'abc', "nine" )),
            array(array( "a" => "aaa", "A" => "AAA", "c" => "ccc", "d" => "ddd", "e" => "eee" ),array( "a" => "aaa", "A" => "AAA", "c" => "ccc", "d" => "ddd", 22, 'abc', "e" => "eee" )),
            array(array( 1 => "one", 2 => "two", 3 => 7, 4 => "four", 5 => "five" ),array( 1 => "one", 2 => "two", 3 => 7, 4 => "four", 5 => 22, 6 => 'abc', 7 => "five" )),
            array(array( "f" => "fff", "1" => "one", 4 => 6, "" => "blank", 2.4 => "float", "F" => "FFF"),array( "f" => "fff", "1" => "one", 4 => 6, "" => "blank", 2.4 => "float", 22, 'abc', "F" => "FFF")),
            array(array("blank" => "", 3.7 => 3.7, 5.4 => 7, 6 => 8.6, '5' => "Five", "4name" => "jonny", "a" => NULL, NULL => 3 ),array("blank" => "", 3.7 => 3.7, 5.4 => 7, 6 => 8.6, '5' => "Five", "4name" => "jonny", "a" => NULL, 22, 'abc', NULL => 3 )),
            array(array( 12, "name", 'age', '45' ),array( 12, "name", 'age', 22, 'abc', '45' )),
            array(array( array("oNe", "tWo", 4), array(10, 20, 30, 40, 50), array() ),array( array("oNe", "tWo", 4), array(10, 20, 30, 40, 50), 22, 'abc', array() )),
            array(array( "one" => 1, "one" => 2, "three" => 3, 3, 4, 3 => 33, 4 => 44, 5, 6, 5.4 => 54, 5.7 => 57, "5.4" => 554, "5.7" => 557 ), array( "one" => 1, "one" => 2, "three" => 3, 3, 4, 3 => 33, 4 => 44, 5, 6, 5.4 => 54, 5.7 => 57, "5.4" => 554, 22, 'abc', "5.7" => 557 )),
        );
    }
}
 