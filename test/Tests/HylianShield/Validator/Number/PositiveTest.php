<?php
/**
 * Test for \HylianShield\Validator\Number\Positive.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\Number;

use \HylianShield\Validator\Float\Positive;

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
    protected $validatorClass = '\HylianShield\Validator\Number\Positive';

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
        array(.1, true),
        array(array(), false),
        array(array(12), false),
        array('count', false),
        array('strtotime', false),
        array('MyNonExistentFunction', false)
    );

    /**
     * Set up a common validator.
     */
    protected function setUp()
    {
        $range = range(-10, 10);
        $boundary = Positive::BOUNDARY;

        $this->validations = array_merge(
            $this->validations,
            array_map(
                function ($number) use ($boundary) {
                    $number = .1 * $number;
                    return array($number, $number >= $boundary);
                },
                $range
            ),
            array_map(
                function ($number) use ($boundary) {
                    $number = (integer) $number;
                    return array($number, $number >= $boundary);
                },
                $range
            ),
            array_map(
                function ($number) {
                    return array("{$number}", false);
                },
                $range
            )
        );

        parent::setUp();
    }
}