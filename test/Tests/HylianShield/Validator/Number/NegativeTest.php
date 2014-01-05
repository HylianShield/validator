<?php
/**
 * Test for \HylianShield\Validator\Number\Negative.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\Number;

use \HylianShield\Validator\Number\Negative;

/**
 * Negative test.
 */
class NegativeTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Number\Negative';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('Aap Noot Mies', false),
        array('0123456789', false),
        array('', false),
        array('€αβγδε', false),
        array(null, false),
        array(0, false),
        array(.1, false),
        array(-.1, true),
        array('.1', false),
        array(1, false),
        array(-1, true),
        array(\HylianShield\Validator\Float\Positive::BOUNDARY, false),
        array(\HylianShield\Validator\Integer\Positive::BOUNDARY, false),
        array(\HylianShield\Validator\Float\Negative::BOUNDARY, true),
        array(\HylianShield\Validator\Integer\Negative::BOUNDARY, true),
        array(array(), false),
        array(array(12), false),
        array('count', false),
        array('strtotime', false),
        array('MyNonExistentFunction', false)
    );
}