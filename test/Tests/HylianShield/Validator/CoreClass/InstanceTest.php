<?php
/**
 * Test for \HylianShield\Validator\CoreClass\Instance.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\CoreClass;

use \HylianShield\Validator\CoreClass\Instance;

/**
 * InstanceTest.
 */
class InstanceTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\CoreClass\Instance';

    /**
     * Provide a set of invalid arguments.
     *
     * @return array
     */
    public function invalidArgumentProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            array(1),
            array(.1),
            array(array())
        );
    }

    /**
     * Test an invalid construct.
     *
     * @dataProvider invalidArgumentProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConstruct($invalidArgument)
    {
        $validator = $this->validatorClass;
        $validator = new $validator($invalidArgument);
    }

    /**
     * Return a bunch of class instances.
     *
     * @return array
     */
    public function classInstanceProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            array('\StdClass'),
            array(new \DateTime),
            array(new \DateTime('yesterday'))
        );
    }

    /**
     * Test if a class is an instance of the given class exist.
     *
     * @dataProvider classInstanceProvider
     */
    public function testClassInstances($class)
    {
        if (is_string($class)) {
            $name = $class;
            $instance = new $class;
        } else {
            $name = get_class($class);
            $instance = $class;
        }

        $test = new Instance($name);
        $this->assertTrue($test($instance));
    }
}
