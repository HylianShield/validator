<?php
/**
 * Test for \HylianShield\Validator\CoreClass\Method.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\CoreClass;

use \HylianShield\Validator\CoreClass\Method;

/**
 * MethodTest.
 */
class MethodTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\CoreClass\Method';

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
     * Return a bunch of class methods.
     *
     * @return array
     */
    public function classMethodProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            array('\ReflectionClass', 'getEndLine', true),
            array('\ReflectionClass', 'getCyberSecutor', false),
            array(new \DateTime, 'modify', true),
            array(new \DateTime, 'goFlipYourself', false)
        );
    }

    /**
     * Test if class methods exist.
     *
     * @dataProvider classMethodProvider
     */
    public function testClassMethods($class, $method, $exists)
    {
        $validator = new Method($class);
        $this->assertEquals($validator($method), $exists);
    }
}
