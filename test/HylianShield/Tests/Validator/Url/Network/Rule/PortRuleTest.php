<?php
/**
 * Test the port rule.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Url\Network\Rule;

use \HylianShield\Validator\Url\Network\Rule\PortRule;

/**
 * Test the port rule.
 */
class PortRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test what happens if a non-boolean is supplied as constructor argument.
     *
     * @return void
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid required flag supplied: array
     */
    public function testNonBooleanConstructorFlag()
    {
        new PortRule(array(), array());
    }
}
