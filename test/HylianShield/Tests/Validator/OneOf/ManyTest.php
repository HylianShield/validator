<?php
/**
 * Test for \HylianShield\Validator\OneOf\Many.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Tests\Validator;

use \ReflectionClass;
use \HylianShield\Validator\OneOf\Many;

/**
 * Many test.
 */
class ManyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the lack of constructor arguments.
     *
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testMissingArguments()
    {
        new Many;
    }

    /**
     * Test empty constructor arguments.
     *
     * @expectedException \LogicException
     */
    public function testEmptyArguments()
    {
        new Many(array());
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

        $validator = new Many($arguments);

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
}
