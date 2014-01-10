<?php
/**
 * Test for \HylianShield\Validator\Integer\Positive.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\Integer;

use \HylianShield\Validator\Integer\Positive;

/**
 * Positive test.
 */
class PositiveTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Integer\Positive';

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
        array(-.1, false),
        array('.1', false),
        array(1, true),
        array(-1, false),
        array(\HylianShield\Validator\Float\Positive::BOUNDARY, false),
        array(\HylianShield\Validator\Integer\Positive::BOUNDARY, true),
        array(\HylianShield\Validator\Float\Negative::BOUNDARY, false),
        array(\HylianShield\Validator\Integer\Negative::BOUNDARY, false),
        array(array(), false),
        array(array(12), false),
        array('count', false),
        array('strtotime', false),
        array('MyNonExistentFunction', false)
    );
}