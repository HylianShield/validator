<?php
/**
 * Test for \HylianShield\Validator\CoreArray.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \HylianShield\Validator\CoreArray;

/**
 * CoreArray test.
 */
class CoreArrayTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\CoreArray';

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
        array(0123456789, false),
        array(0.123456789, false),
        array(null, false),
        array(0, false),
        array(.1, false),
        array(array(), true),
        array(array(12), true)
    );

    /**
     * Set up a common validator.
     */
    protected function setUp()
    {
        // The new keyword is illegal in a class declaration.
        // However, it is interesting to know if CoreArray actually
        // invalidates an ArrayObject.
        $this->validations[] = array(new \ArrayObject, false);
        parent::setUp();
    }
}
