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
        array(0.123456789, false),
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
        $boundary = Positive::BOUNDARY;

        $this->validations = array_merge(
            $this->validations,
            array_map(
                function ($int) use ($boundary) {
                    return array($int, $int >= $boundary);
                },
                $range
            ),
            array_map(
                function ($int) {
                    return array("{$int}", false);
                },
                $range
            ),
            array_map(
                function ($int) {
                    return array((float) $int, false);
                },
                $range
            )
        );

        parent::setUp();
    }
}