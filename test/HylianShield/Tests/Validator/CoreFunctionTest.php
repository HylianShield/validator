<?php
/**
 * Test for \HylianShield\Validator\CoreFunction.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator;

/**
 * CoreFunction test.
 */
class CoreFunctionTest extends \HylianShield\Tests\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\CoreFunction';

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
        array('count', true),
        array('strtotime', true),
        array('MyNonExistentFunction', false)
    );

    /**
     * Set up a common validator.
     */
    protected function setUp()
    {
        // It is interesting to know if this invalidates a closure.
        $this->validations[] = array(function(){}, false);
        parent::setUp();
    }
}
