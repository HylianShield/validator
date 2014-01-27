<?php
/**
 * Test for \HylianShield\Validator\Integer.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \HylianShield\Validator\Integer;

/**
 * Integer test.
 */
class IntegerTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Integer';

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
        array(0123456789, true),
        array(0.123456789, false),
        array(null, false),
        array(0, true)
    );

    /**
     * Test if zero is an actual length that will be checked, as opposed to the
     * default value null.
     */
    public function testDefaultNotZero()
    {
        $validator = $this->validatorClass;
        $validator = new $validator(0, 0);
        $this->assertTrue($validator->validate(0));
        $this->assertFalse($validator->validate(1));
        $this->assertFalse($validator->validate(-1));
    }
}
