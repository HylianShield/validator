<?php
/**
 * Test for \HylianShield\ArrayObject.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield;

use \HylianShield\ArrayObject;

/**
 * ArrayObjectTest.
 */
class ArrayObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if an ArrayObject gets dirty when you modify data.
     */
    public function testDirty()
    {
        $data = new ArrayObject;
        $this->assertFalse($data->isDirty());
        $data['foo'] = 'bar';
        $this->assertTrue($data->isDirty());
    }
}
