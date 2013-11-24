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
        // This needs to be updated if future PHP versions increase or decrease
        // the maximum depth of JSON structures.
        $maximumDepth = 512;

        // Generate an array with a depth over the maximum allowed depth of the
        // json_encode function.
        $test = array_reduce(
            range(0, $maximumDepth + 1),
            function($r) {
                return array($r);
            }
        );

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
