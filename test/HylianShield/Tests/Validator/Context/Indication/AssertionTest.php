<?php
/**
 * Test assertion indication entities.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Tests\Validator\Context\Indication;

use \HylianShield\Validator\Context\Indication\Assertion;
use \HylianShield\Validator\Context\Indication\IndicationTestBase;

/**
 * Test assertion indication entities.
 */
class AssertionTest extends IndicationTestBase
{
    /**
     * Get the reflection for the concrete indication class.
     *
     * @return \ReflectionClass
     */
    protected function createReflection()
    {
        return new \ReflectionClass(
            '\HylianShield\Validator\Context\Indication\Assertion'
        );
    }

    /**
     * Get a list of default constructor arguments.
     *
     * @return array
     */
    protected function getDefaultConstructorArguments()
    {
        return array('I am an assertion', true);
    }

    /**
     * Provide a list of invalid results.
     *
     * @return array
     */
    public function invalidResultProvider()
    {
        return array(
            array('true'),
            array(1),
            array(null),
            array('false'),
            array('Y'),
            array('y'),
            array('n'),
            array(new \stdClass())
        );
    }

    /**
     * Test that the result setter throws when the argument is invalid.
     *
     * @param mixed $result
     * @dataProvider invalidResultProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidResult($result)
    {
        $instance = $this->createEmptyInstance();
        $reflection = $this->getReflection();

        $setter = $reflection->getMethod('setResult');
        $setter->setAccessible(true);
        $setter->invoke($instance, $result);
        $setter->setAccessible(false);
    }

    /**
     * Test that the getter wil throw if the property is missing.
     *
     * @expectedException \LogicException
     */
    public function testMissingResult()
    {
        /** @var Assertion $assertion */
        $assertion = $this->createEmptyInstance();
        $assertion->getResult();
    }
}
