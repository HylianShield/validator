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

/**
 * Logical OR gate test.
 */
class LogicalOrTest extends \Tests\HylianShield\Validator\LogicalGateTestBase
{
    /**
     * The name of the class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\LogicalOr';

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
                'or(float:_,_; number:_,_)'
            ),
            array(
                array(
                    new Validator\Float,
                    new Validator\Integer
                ),
                1.0,
                true,
                'or(float:_,_; integer:_,_)'
            ),
            array(
                array(
                    new Validator\Float,
                    new Validator\Integer
                ),
                '1.0',
                false,
                'or(float:_,_; integer:_,_)'
            )
        );
    }
}
