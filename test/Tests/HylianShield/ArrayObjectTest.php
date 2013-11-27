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
     * Test if an ArrayObject gets dirty when you set data.
     */
    public function testDirtySet()
    {
        $data = new ArrayObject;
        $this->assertFalse($data->isDirty());
        $data['foo'] = 'bar';
        $this->assertArrayHasKey('foo', $data);
        $this->assertTrue($data->isDirty());
    }

    /**
     * Test if an ArrayObject gets dirty when you unset data.
     */
    public function testDirtyUnset()
    {
        $data = new ArrayObject(
            array(
                'foo' => 'bar'
            )
        );

        $this->assertArrayHasKey('foo', $data);
        $this->assertFalse($data->isDirty());
        unset($data['foo']);
        $this->assertTrue($data->isDirty());
    }

    /**
     * Appending data should throw an exception.
     *
     * @expectedException \LogicException
     */
    public function testAppending()
    {
        $data = new ArrayObject(
            array(
                'foo' => 'bar'
            )
        );

        $data->append('baz');
    }

    /**
     * A set of serializers.
     *
     * @return array
     */
    public function serializers()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            array(new \HylianShield\Serializer\JsonConf),
            array(new \HylianShield\Serializer\Php)
        );
    }

    /**
     * Test setting serializers.
     *
     * @dataProvider serializers
     */
    public function testSetSerializer($serializer)
    {
        $test = array(
            'Foo' => 'Bar',
            'Baz' => 12
        );
        $data = new ArrayObject($test);
        $data->setSerializer($serializer);

        $serialized = $serializer->serialize($test);
        $unserialized = $serializer->unserialize($serialized);

        // Test if the serializer and the array object return the same results.
        $this->assertEquals($serialized, $data->serialize());
        $this->assertEquals($serialized, (string) $data);
        $this->assertEquals($unserialized, $serializer->unserialize((string) $data));
        $this->assertEquals($unserialized, $data->getArrayCopy());

        // Now load in the serialized data from our test and try again.
        $data->unserialize($serialized);
        $this->assertEquals($serialized, $data->serialize());
        $this->assertEquals($serialized, (string) $data);
        $this->assertEquals($unserialized, $serializer->unserialize((string) $data));
        $this->assertEquals($unserialized, $data->getArrayCopy());
    }

    /**
     * Test invalid serialized data that doesn't resolve in a native array.
     *
     * @expectedException \UnexpectedValueException
     */
    public function testInvalidSerializedData()
    {
        $someData = 12;

        $serializer = ArrayObject::DEFAULT_SERIALIZER;
        $serializer = new $serializer;

        $data = new ArrayObject;
        $data->unserialize($serializer->serialize($someData));
    }

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
     * Test invalid arguments for the unserialize method.
     *
     * @dataProvider invalidArgumentProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidUnserializeArgument($invalidArgument)
    {
        $data = new ArrayObject;
        $data->unserialize($invalidArgument);
    }

    /**
     * Test the default serializer.
     */
    public function testDefaultSerializer()
    {
        $test = array('foo' => 'bar');
        $serializer = ArrayObject::DEFAULT_SERIALIZER;
        $serializer = new $serializer;
        $data = new ArrayObject($test);

        $this->assertEquals($data->serialize(), $serializer->serialize($test));
    }

    /**
     * Return a set of arrays to merge against eachother.
     *
     * @return array
     */
    public function mergeProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            array(
                // Each entry represents an array to merge against.
                array(
                    'foo' => 'bar',
                    'baz' => 12
                ),
                array(
                    'bar' => 'baz',
                    'foo' => 12
                ),
                array(
                    'honey' => 'tasty'
                )
            ),
            array(
                // Each entry represents an array to merge against.
                array(
                    'foo' => 'bar',
                    'baz' => 12
                ),
                range(1, 100),
                array(
                    'honey' => 'bear'
                )
            ),
        );
    }

    /**
     * Test the merging of multiple sets of data.
     *
     * @dataProvider mergeProvider
     */
    public function testMerge()
    {
        $merges = func_get_args();
        $test = array_shift($merges);
        $check = $test;

        $data = new ArrayObject($test);

        $this->assertFalse($data->isDirty());

        foreach ($merges as $merge) {
            $check = array_merge($check, $merge);
            $data->merge($merge);
            $this->assertTrue($data->isDirty());
            $this->assertEquals($data->getArrayCopy(), $check);
        }
    }

}
