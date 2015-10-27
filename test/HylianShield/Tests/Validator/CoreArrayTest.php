<?php
/**
 * Test for \HylianShield\Validator\CoreArray.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator;

use \HylianShield\Validator\CoreArray;

/**
 * CoreArray test.
 */
class CoreArrayTest extends \HylianShield\Tests\Validator\TestBase
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

    /**
     * Provide illegal constructor arguments.
     *
     * @return array
     */
    public function illegalConstructorArgumentsProvider()
    {
        return array(
            array(null, 'aap'),
            array(12, 'aap'),
            array('aap', null),
            array('aap', 12)
        );
    }

    /**
     * Test that the constructor throws an invalid argument exception.
     *
     * @param mixed $min
     * @param mixed $max
     * @return void
     * @dataProvider illegalConstructorArgumentsProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConstructorArguments($min, $max)
    {
        new CoreArray($min, $max);
    }
}
