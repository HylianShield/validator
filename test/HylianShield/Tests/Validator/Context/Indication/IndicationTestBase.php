<?php
/**
 * Test base for indication entity tests.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context\Indication;

/**
 * Test base for indication entity tests.
 */
abstract class IndicationTestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * A reflection of the concrete entity.
     *
     * @var \ReflectionClass $reflection
     */
    private $reflection;

    /**
     * Get the reflection for the concrete indication class.
     *
     * @return \ReflectionClass
     */
    abstract protected function createReflection();

    /**
     * Getter for the reflection property.
     *
     * @return \ReflectionClass
     */
    protected function getReflection()
    {
        if (!isset($this->reflection)) {
            $this->setReflection(
                $this->createReflection()
            );
        }

        return $this->reflection;
    }

    /**
     * Setter for the reflection property.
     *
     * @param \ReflectionClass $reflection
     * @return static
     * @throws \InvalidArgumentException when $reflection reflects a class
     *   that does not implement the indication interface.
     */
    private function setReflection(\ReflectionClass $reflection)
    {
        if (!$reflection->implementsInterface(
            '\HylianShield\Validator\Context\Indication\IndicationInterface'
        )) {
            throw new \InvalidArgumentException(
                'Reflection should hold a class that implements the '
                . 'indication interface'
            );
        }

        $this->reflection = $reflection;

        return $this;
    }

    /**
     * Create an instance while skipping the constructor.
     *
     * @return IndicationInterface
     */
    protected function createEmptyInstance()
    {
        $reflection = $this->getReflection();

        if (method_exists($reflection, 'newInstanceWithoutConstructor')) {
            $rv = $reflection->newInstanceWithoutConstructor();
        } else {
            // Emulate a fallback for PHP <= PHP 5.4.
            $rv = $this->createDefaultInstance();

            foreach ($reflection->getProperties() as $property) {
                // Reset this property.
                $property->setAccessible(true);
                $property->setValue($rv, null);
                $property->setAccessible(false);
            }
        }

        return $rv;
    }

    /**
     * Get a list of default constructor arguments.
     *
     * @return array
     */
    abstract protected function getDefaultConstructorArguments();

    /**
     * Get an instance filled using default constructor arguments.
     *
     * @return IndicationInterface
     */
    protected function createDefaultInstance()
    {
        return $this
            ->getReflection()
            ->newInstanceArgs(
                $this->getDefaultConstructorArguments()
            );
    }

    /**
     * Get a list of invalid description arguments.
     *
     * @return array
     */
    public function invalidDescriptionProvider()
    {
        return array(
            array(false),
            array(null),
            array(12),
            array(new \stdClass())
        );
    }

    /**
     * Test that the description setter will throw an invalid argument
     * exception.
     *
     * @param mixed $description
     * @dataProvider invalidDescriptionProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidDescription($description)
    {
        $instance = $this->createEmptyInstance();
        $reflection = $this->getReflection();

        $setter = $reflection->getMethod('setDescription');
        $setter->setAccessible(true);
        $setter->invoke($instance, $description);
        $setter->setAccessible(false);
    }

    /**
     * Test that the instance throws when the description is missing.
     *
     * @expectedException \LogicException
     */
    public function testMissingDescription()
    {
        $this
            ->createEmptyInstance()
            ->getDescription();
    }
}
