<?php
/**
 * Test for \HylianShield\Validator\Integer.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator;

use \HylianShield\Validator\Integer;

/**
 * Integer test.
 */
class IntegerTest extends \HylianShield\Tests\Validator\TestBase
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
        /** @var \HylianShield\Validator\Integer $validator */
        $validator = new $validator(0, 0);

        $this->assertTrue($validator->validate(0));
        $this->assertFalse($validator->validate(1));
        $this->assertFalse($validator->validate(-1));
    }

    /**
     * Provide scenarios for the validator to test.
     *
     * @return array
     */
    public function rangeScenarioProvider()
    {
        return array(
            // Min-length validation.
            array(-1, null),
            // Max-length validation.
            array(null, 1),
            // Range validation.
            array(-10, 10)
        );
    }

    /**
     * Provide scenarios for the validator to test.
     *
     * @return array
     */
    public function scenarioProvider()
    {
        return array_merge(
            array(
                // Basic validation.
                array(null, null),
            ),
            $this->rangeScenarioProvider()
        );
    }

    /**
     * Test what happens if the concrete class implements a wrong validator.
     *
     * @param integer|null $min
     * @param integer|null $max
     * @return void
     * @dataProvider scenarioProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Validator should be callable!
     */
    public function testIllegalValidatorCallable($min, $max)
    {
        $validator = new Integer($min, $max);

        $reflection = new \ReflectionObject($validator);
        $validatorProp = $reflection->getProperty('validator');
        $initializer = $reflection->getMethod('initialize');

        // Make this into something that is not callable.
        $validatorProp->setAccessible(true);
        $validatorProp->setValue($validator, null);
        $validatorProp->setAccessible(false);

        // Re-initialize the validator.
        $initializer->setAccessible(true);
        $initializer->invoke($validator);

        // In theory, the unit test never reaches this line.
        $initializer->setAccessible(false);
    }

    /**
     * Test what happens if the concrete class implements a wrong validator.
     *
     * @param integer|null $min
     * @param integer|null $max
     * @return void
     * @dataProvider rangeScenarioProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Length checker should be callable!
     */
    public function testIllegalLengthCheckerCallable($min, $max)
    {
        $validator = new Integer($min, $max);

        $reflection = new \ReflectionObject($validator);
        $lengthCheckerProp = $reflection->getProperty('lengthCheck');
        $initializer = $reflection->getMethod('initialize');

        // Make this into something that is not callable.
        $lengthCheckerProp->setAccessible(true);
        $lengthCheckerProp->setValue($validator, null);
        $lengthCheckerProp->setAccessible(false);

        // Re-initialize the validator.
        $initializer->setAccessible(true);
        $initializer->invoke($validator);

        // In theory, the unit test never reaches this line.
        $initializer->setAccessible(false);
    }
}
