<?php
/**
 * Test the url string parser.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Url\Network\Parser;

use \HylianShield\Validator\String;
use \HylianShield\Validator\Url\Network\Parser\UrlStringParser;

/**
 * Test the url string parser.
 */
class UrlStringParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that objects that can be converted to string are used as proper
     * input for URL parsing.
     *
     * @return void
     */
    public function testConvertibleObjectArgument()
    {
        $argument = new String();

        $parser = new UrlStringParser();
        $parsed = $parser->parse($argument);


        list($scheme, $path) = explode(':', (string) $argument);

        $this->assertArrayHasKey('scheme', $parsed);

        if (array_key_exists('scheme', $parsed)) {
            $this->assertEquals($scheme, $parsed['scheme']);
        }

        $this->assertArrayHasKey('path', $parsed);

        if (array_key_exists('path', $parsed)) {
            $this->assertEquals($path, $parsed['path']);
        }
    }
}
