<?php
/**
 * Test the path parser.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Url\Network\Parser;

use \HylianShield\Validator\Url\Network\Parser\PathParser;

/**
 * Test the path parser.
 */
class PathParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test what happens if the parser receives invalid data.
     *
     * @return void
     * @expectedException \HylianShield\Validator\Url\Network\Parser\ParserException
     * @expectedExceptionMessage Expected url to be an array: string
     */
    public function testInvalidParseCall()
    {
        $parser = new PathParser();
        $parser->parse('broken');
    }
}
