<?php
/**
 * Test for \HylianShield\Validator\Regexp.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \HylianShield\Validator\Regexp;

/**
 * RegexpTest.
 */
class RegexpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provide invalid arguments.
     *
     * @return array
     */
    public function invalidArgumentProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            array(12),
            array(.12),
            array(array()),
            array(true),
            array(new \StdClass),
            // Invalid because it has no delimiter.
            array('12'),
            // Invalid because it has no ending delimiter.
            array('/12'),
            // Invalid because the ending delimiter did not match the initial delimiter.
            array('/12-')
        );
    }

    /**
     * Test invalid arguments.
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidArgumentProvider
     */
    public function testInvalidArgument($invalidArgument)
    {
        new Regexp($invalidArgument);
    }

    /**
     * Provide patterns for the validator.
     *
     * @return array
     */
    public function patternProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            // The first argument will represent the pattern.
            // All following arguments will be used to match against the pattern.
            array('/12/', '12', '1200'),
            array('|12|', '12', '1200'),
            array('-12-', '12', '1200'),
            array('/\d{4}\-\d{2}\-\d{2}/', '2013-01-01')
        );
    }

    /**
     * Test supplied patterns
     *
     * @dataProvider patternProvider
     */
    public function testPattern()
    {
        $matches = func_get_args();
        $pattern = array_shift($matches);
        $validator = new Regexp($pattern);

        foreach ($matches as $match) {
            $this->assertTrue(
                $validator->validate($match),
                "Failed to match {$match} against pattern {$pattern}"
            );
        }
    }
}
