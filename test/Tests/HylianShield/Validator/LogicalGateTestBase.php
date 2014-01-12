<?php
/**
 * A test base for all logical gate validator tests.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \ReflectionClass;
use \HylianShield\Validator;

/**
 * LogicalGateTestBase.
 */
abstract class LogicalGateTestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * The validator class name.
     *
     * @var string $validatorClass
     */
    protected $validatorClass;

    /**
     * Provide arguments to create new validor instances.
     *
     * @return array
     */
    abstract public function instanceProvider();

    /**
     * Test the Logical fate.
     *
     * @dataProvider instanceProvider
     */
    final public function testLogicalGate($args, $value, $shouldPass, $string)
    {
        $reflection = new ReflectionClass($this->validatorClass);
        $validator = $reflection->newInstanceArgs($args);

        // While we're at it, lest test the __tostring method.
        $this->assertRegexp(
            '/^' . preg_quote($validator->type()) . '(\:(.+)|\((.+)\))?/',
            $validator->__tostring()
        );

        $this->assertEquals($shouldPass, $validator($value));
        $this->assertEquals($string, (string) $validator);
    }

    /**
     * Test a lack of validators.
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage Cannot perform a logical gate with less than two validators.
     */
    final public function testLackOfValidators()
    {
        $class = $this->validatorClass;
        new $class(new Validator\Integer);
    }

    /**
     * Provide invalid arguments.
     *
     * @return array
     */
    final public function invalidArgumentProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument.
            array('aap', 'noot'),
            array(12, 12.12),
            array(new \StdClass, new \DateTime),
            array(null, true),
            array(true, true),
            array(new Validator\Integer, false)
        );
    }

    /**
     * Test invalid arguments
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidArgumentProvider
     */
    final public function testInvalidArguments($a = null, $b = null)
    {
        $class = $this->validatorClass;
        new $class($a, $b);
    }
}
