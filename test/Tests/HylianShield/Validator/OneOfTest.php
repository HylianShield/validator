<?php
/**
 * Test for \HylianShield\Validator\OneOf.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \ReflectionClass;
use \HylianShield\Validator\OneOf;

/**
 * OneOf test.
 */
class OneOfTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the lack of constructor arguments.
     *
     * @expectedException \LogicException
     */
    public function testMissingArguments()
    {
        new OneOf;
    }

    /**
     * Return a set of collections, the value to test and the expected result.
     *
     * @return array
     */
    public function collectionProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument.
            // All entries, except the last 2, are constructor arguments.
            // The before-last entry is the value that will be validated.
            // The last entry is the expected result.
            array('aap', 'noot', 'mies', 'aap', true),
            array('aap', 'noot', 'mies', 'beer', false),
            array('Y', 'y', '1', 1, 'Y', true),
            array('y', '1', 1, 'Y', false),
            array('1', 1.0, 1, false)
        );
    }

    /**
     * Test collections.
     *
     * @dataProvider collectionProvider
     */
    public function testCollections()
    {
        $arguments = func_get_args();
        $expected = array_pop($arguments);
        $test = array_pop($arguments);

        $reflectionClass = new ReflectionClass('\\HylianShield\\Validator\\OneOf');
        $validator = $reflectionClass->newInstanceArgs($arguments);
        $this->assertEquals($expected, $validator->validate($test));

        // Test that the collection is correctly identified.
        $type = $validator->type();
        $identifier = implode(
            ', ',
            array_map(
                function ($arg) {
                    return '(' . gettype($arg) . ') ' . var_export($arg, true);
                },
                $arguments
            )
        );

        $this->assertEquals("{$type}({$identifier})", (string) $validator);
    }

    /**
     * Test that the validator throws if an argument was non-scalar.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testNonScalarArgument()
    {
        new OneOf(array());
    }
}
