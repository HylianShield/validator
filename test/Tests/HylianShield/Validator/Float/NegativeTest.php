<?php
/**
 * Test for \HylianShield\Validator\Float\Negative.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\Float;

use \HylianShield\Validator\Float\Negative;

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
    protected $validatorClass = '\HylianShield\Validator\Float\Negative';

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
        $boundary = Negative::BOUNDARY;

        $this->validations = array_merge(
            $this->validations,
            array_map(
                function ($float) use ($boundary) {
                    $float = .1 * $float;
                    return array($float, $float <= $boundary);
                },
                $range
            ),
            array_map(
                function ($float) {
                    return array("{$float}", false);
                },
                $range
            ),
            array_map(
                function ($float) {
                    return array((integer) $float, false);
                },
                $range
            )
        );

        parent::setUp();
    }
}