<?php
/**
 * Test for \HylianShield\Validator\LogicalAnd.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \HylianShield\Validator;
use \HylianShield\Validator\LogicalAnd;

/**
 * Logical AND gate test.
 */
class LogicalAndTest extends \PHPUnit_Framework_TestCase
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
                new LogicalAnd(
                    new Validator\Float,
                    new Validator\Number
                ),
                1.0,
                true
            ),
            array(
              new LogicalAnd(
                    new Validator\Float,
                    new Validator\Integer
                ),
                1.0,
                false
            )
        );
    }

    /**
     * Test the Logical AND.
     *
     * @dataProvider instanceProvider
     */
    public function testLogicalAnd($validator, $value, $shouldPass)
    {
        $this->assertEquals($shouldPass, $validator($value));
    }

    /**
     * Test a lack of validators.
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage Cannot perform a logical gate with less than two validators.
     */
    public function testLackOfValidators()
    {
        new LogicalAnd(new Validator\Integer);
    }

    /**
     * Provide invalid arguments.
     *
     * @return array
     */
    public function invalidArgumentProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument.
            array('aap', 'noot'),
            array(12, 12.12),
            array(new \StdClass, new \DateTime),
            array(null, true),
            array(true, true),
            array(new Validator\Integer, false)
        );
    }

    /**
     * Test invalid arguments
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidArgumentProvider
     */
    public function testInvalidArguments($a = null, $b = null)
    {
        new LogicalAnd($a, $b);
    }
}
