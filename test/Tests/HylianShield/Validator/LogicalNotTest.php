<?php
/**
 * Test for \HylianShield\Validator\LogicalNot.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \HylianShield\Validator;
use \HylianShield\Validator\LogicalNot;

/**
 * LogicalNotTest.
 */
class LogicalNotTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provide validators for the validator.
     *
     * @return array
     */
    public function validatorProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            // The first argument will represent the validator.
            // The second argument will be the value to validate.
            // The third value will be the expected outcome of the validation as if there was no NOT.
            array(new Validator\Regexp('/12/'), '12', true),
            array(new Validator\Integer(-12, 12), 16, false),
            array(
                new Validator\LogicalAnd(
                    new Validator\String,
                    new Validator\Date\Mysql
                ),
                '2013-12-12',
                true
            )
        );
    }

    /**
     * Test supplied validators
     *
     * @dataProvider validatorProvider
     */
    public function testValidators($validator, $test, $result)
    {
        $this->assertEquals(
            $result,
            $validator->validate($test),
            "Validator to test with was broken: {$validator}"
        );

        $not = new LogicalNot($validator);

        $this->assertEquals(
            !$result,
            $not->validate($test),
            "Failed to inverse the outcome of: {$validator}"
        );

        $this->assertEquals(
            "not({$validator})",
            (string) $not,
            "Could not cast the LogicalNot to the expected string"
        );
    }
}
