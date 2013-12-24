<?php
/**
 * Test for \HylianShield\Validator\LogicalXor.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \HylianShield\Validator;
use \HylianShield\Validator\LogicalXor;

/**
 * Logical XOR gate test.
 */
class LogicalXorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provide a set of instances.
     *
     * @return array
     */
    public function instanceProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument.
            array(
                new LogicalXor(
                    new Validator\Float,
                    new Validator\Number
                ),
                1.0,
                false,
                'xor(float:0,0; number:0,0)'
            ),
            array(
              new LogicalXor(
                    new Validator\Float,
                    new Validator\Integer
                ),
                1.0,
                true,
                'xor(float:0,0; integer:0,0)'
            ),
            array(
              new LogicalXor(
                    new Validator\Float,
                    new Validator\Integer
                ),
                '1.0',
                false,
                'xor(float:0,0; integer:0,0)'
            )
        );
    }

    /**
     * Test the Logical XOR.
     *
     * @dataProvider instanceProvider
     */
    public function testLogicalXor($validator, $value, $shouldPass, $string)
    {
        $this->assertEquals($shouldPass, $validator($value));
        $this->assertEquals($string, (string) $validator);
    }

    /**
     * Test a lack of validators.
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage Cannot perform a logical gate with less than two validators.
     */
    public function testLackOfValidators()
    {
        new LogicalXor(new Validator\Integer);
    }
}
