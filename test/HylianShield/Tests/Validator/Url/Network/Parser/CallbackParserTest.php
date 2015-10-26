<?php
/**
 * Test the callback parser
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Url\Network\Parser;

use \HylianShield\Validator\Url\Network\Parser\CallbackParser;

/**
 * Test the callback parser
 */
class CallbackParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that garbage comes out after we put garbage in.
     *
     * @return void
     */
    public function testGarbageGoesInGarbageComesOut()
    {
        $parser = new CallbackParser(
            function (array $garbage) {
                return array_merge(
                    $garbage,
                    array('otherGarbage' => '')
                );
            }
        );

        $parsed = $parser->parse(array('myGarbage' => ''));

        $this->assertArrayHasKey('myGarbage', $parsed);
        $this->assertArrayHasKey('otherGarbage', $parsed);
    }

    /**
     * Test that the parser throws when we return garbage.
     *
     * @return void
     * @expectedException \HylianShield\Validator\Url\Network\Parser\ParserException
     * @expectedExceptionMessage Internal parser could not create a proper array structure
     */
    public function testIllegalParserOutput()
    {
        $parser = new CallbackParser(
            function () {
                return 42;
            }
        );

        $parser->parse('The answer to life, the universe and everything!');
    }
}
