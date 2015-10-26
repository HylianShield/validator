<?php
/**
 * Unit tests for the network protocol definition.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Url\Network;

use \HylianShield\Validator\Url\Network\ProtocolDefinition;

/**
 * Unit tests for the network protocol definition.
 */
class ProtocolDefinitionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provider for test cases using a definition.
     *
     * @return array
     */
    public function definitionProvider()
    {
        return array(
            array(new ProtocolDefinition())
        );
    }

    /**
     * Return a definition along with a property, for each property inside
     * the definition.
     *
     * @return array
     */
    public function definitionPropertyProvider()
    {
        $definition = new ProtocolDefinition();
        $reflection = new \ReflectionObject($definition);
        $rv = array();

        foreach ($reflection->getProperties() as $property) {
            $rv[] = array(clone $definition, $property);
        }

        return $rv;
    }

    /**
     * Set the supplied property to null on the supplied definition.
     *
     * @param ProtocolDefinition $definition
     * @param \ReflectionProperty $property
     * @return ProtocolDefinition
     */
    protected function destroyProperty(
        ProtocolDefinition $definition,
        \ReflectionProperty $property
    ) {
        $property->setAccessible(true);
        $property->setValue($definition, null);
        $property->setAccessible(false);

        return $definition;
    }

    /**
     * Test what happens if the supplied property is missing.
     *
     * @param ProtocolDefinition $definition
     * @param \ReflectionProperty $property
     * @return void
     * @dataProvider definitionPropertyProvider
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing property
     */
    public function testMissingProperty(
        ProtocolDefinition $definition,
        \ReflectionProperty $property
    ) {
        $this->destroyProperty($definition, $property);
        $propertyName = ucfirst($property->getName());

        foreach (array('get', 'is', 'has') as $getterPrefix) {
            $getter = $getterPrefix . $propertyName;

            if (!method_exists($definition, $getter)) {
                continue;
            }

            $definition->{$getter}();
        }
    }

    /**
     * Data provider for setter methods with illegal flags as arguments.
     *
     * @return array
     */
    public function illegalFlagSetterCallProvider()
    {
        $definition = new ProtocolDefinition();
        $reflection = new \ReflectionObject($definition);

        $rv = array();

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($definition);
            $property->setAccessible(false);

            if (!is_bool($value)) {
                continue;
            }

            $setter = $reflection->getMethod(
                'set' . ucfirst($property->getName())
            );

            $rv[] = array(
                clone $definition,
                $setter->getName(),
                null
            );
        }

        return $rv;
    }

    /**
     * Test that the flag setters throw when they receive a non-boolean.
     *
     * @param ProtocolDefinition $definition
     * @param string $method
     * @param mixed $value
     * @return void
     * @dataProvider illegalFlagSetterCallProvider
     * @expectedException \InvalidArgumentException
     */
    public function testIllegalFlagSetterCall(
        ProtocolDefinition $definition,
        $method,
        $value
    ) {
        $definition->{$method}($value);
    }
}
