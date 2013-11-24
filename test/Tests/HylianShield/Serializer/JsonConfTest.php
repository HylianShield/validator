<?php
/**
 * Tests for the JsonConf serializer.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Serializer;

use \HylianShield\Serializer\JsonConf;

/**
 * JsonConfTest.
 */
class JsonConfTest extends \Tests\HylianShield\Serializer\TestBase
{
    /**
     * The serializer class name.
     *
     * @var string $serializerClass
     */
    protected $serializerClass = '\HylianShield\Serializer\JsonConf';

    /**
     * Test the JSON encoding error handling.
     *
     * @expectedException \RuntimeException
     */
    public function testEncodingError()
    {
        // Get a UTF-16BE character.
        $encoding = mb_internal_encoding();
        $unicode = '00f0';
        $test = mb_convert_encoding(
            pack('H*', $unicode),
            $encoding,
            'UTF-16BE'
        );

        // There are 3 ways we can trigger this RuntimeException.
        // - The first is to introduce a character outside of the range of UTF-8.
        // - The second is to use a resource as argument.
        // - The last one is to pass a structure with a depth of over 512.
        // Create an encoding error by sending the serialize method a non-UTF-8 char.
        $this->serializer->serialize($test);
    }

    /**
     * Test the JSON decoding error handling.
     *
     * @expectedException \RuntimeException
     */
    public function testDecodingError()
    {
        // This needs to be updated if future PHP versions increase or decrease
        // the maximum depth of JSON structures.
        $maximumDepth = JsonConf::MAXDEPTH;

        // Generate an array with a depth over the maximum allowed depth of the
        // unserialize method.
        $test = json_encode(
            array_reduce(
                range(0, $maximumDepth + 1),
                function($r) {
                    return array($r);
                }
            )
        );

        $this->serializer->unserialize($test);
    }
}
