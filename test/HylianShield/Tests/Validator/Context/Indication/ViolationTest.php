<?php
/**
 * Test violation entities.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Tests\Validator\Context\Indication;

use \HylianShield\Validator\Context\Indication\IndicationTestBase;
use \HylianShield\Validator\Context\Indication\Violation;

/**
 * Test violation entities.
 */
class ViolationTest extends IndicationTestBase
{
    /**
     * Get the reflection for the concrete indication class.
     *
     * @return \ReflectionClass
     */
    protected function createReflection()
    {
        return new \ReflectionClass(
            '\HylianShield\Validator\Context\Indication\Violation'
        );
    }

    /**
     * Test that the context getter throws when the property is missing.
     *
     * @expectedException \LogicException
     */
    public function testMissingContext()
    {
        /** @var Violation $violation */
        $violation = $this->createEmptyInstance();
        $violation->getContext();
    }

    /**
     * Test that the code getter throws when the property is missing.
     *
     * @expectedException \LogicException
     */
    public function testMissingCode()
    {
        /** @var Violation $violation */
        $violation = $this->createEmptyInstance();
        $violation->getCode();
    }

    /**
     * Provide a list of invalid arguments for the code setter.
     *
     * @return array
     */
    public function invalidCodeProvider()
    {
        return array(
            array('12'),
            array(null),
            array(array()),
            array(12.0),
            array(new \stdClass())
        );
    }

    /**
     * Test that the code setter throws when the argument is invalid.
     *
     * @param mixed $code
     * @dataProvider invalidCodeProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidResult($code)
    {
        $instance = $this->createEmptyInstance();
        $reflection = $this->getReflection();

        $setter = $reflection->getMethod('setCode');
        $setter->setAccessible(true);
        $setter->invoke($instance, $code);
        $setter->setAccessible(false);
    }

    /**
     * Get a list of invalid interpolate arguments.
     *
     * @return array
     */
    public function invalidInterpolateArgumentProvider()
    {
        return array(
            array(12, ':', ''),
            array('My :violation', 12, ''),
            array('My other :violation', ':', 12)
        );
    }

    /**
     * Test that the interpolate method will throw when you pass invalid
     * arguments.
     *
     * @param mixed $translation
     * @param mixed $start
     * @param mixed $end
     * @dataProvider invalidInterpolateArgumentProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidInterpolateArgument(
        $translation,
        $start,
        $end
    ) {
        static $violation;

        if (!isset($violation)) {
            $violation = new Violation(
                'Just another :violation',
                1,
                array('violation' => 'violation message')
            );
        }

        $violation->interpolate($translation, $start, $end);
    }
}
