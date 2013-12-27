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

/**
 * Logical AND gate test.
 */
class LogicalAndTest extends \Tests\HylianShield\Validator\LogicalGateTestBase
{
    /**
     * The name of the class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\LogicalAnd';

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
                array(
                    new Validator\Float,
                    new Validator\Number
                ),
                1.0,
                true,
                'and(float:0,0; number:0,0)'
            ),
            array(
                array(
                    new Validator\Float,
                    new Validator\Integer
                ),
                1.0,
                false,
                'and(float:0,0; integer:0,0)'
            )
        );
    }
}
