<?php
/**
 * Test for \HylianShield\Validator\LogicalOr.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \HylianShield\Validator;
use \HylianShield\Validator\LogicalOr;

/**
 * Logical OR gate test.
 */
class LogicalOrTest extends \PHPUnit_Framework_TestCase
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
                new LogicalOr(
                    new Validator\Float,
                    new Validator\Number
                ),
                1.0,
                true
            ),
            array(
              new LogicalOr(
                    new Validator\Float,
                    new Validator\Integer
                ),
                1.0,
                true
            ),
            array(
              new LogicalOr(
                    new Validator\Float,
                    new Validator\Integer
                ),
                '1.0',
                false
            )
        );
    }

    /**
     * Test the Logical OR.
     *
     * @dataProvider instanceProvider
     */
    public function testLogicalOr($validator, $value, $shouldPass)
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
        new LogicalOr(new Validator\Integer);
    }
}
