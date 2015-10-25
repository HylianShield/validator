<?php
/**
 * Test the instruction set.
 *
 * @packagge HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Url\Network;

use \HylianShield\Validator\Url\Network\InstructionSet;
use \HylianShield\Validator\Url\Network\ProtocolDefinition;

/**
 * Test the instruction set.
 */
class InstructionSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test what happens if the definition property is missing.
     *
     * @return void
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing property definition
     */
    public function testMissingDefinition()
    {
        $instructionSet = InstructionSet::fromDefinition(
            new ProtocolDefinition()
        );
        $reflection = new \ReflectionObject($instructionSet);

        $property = $reflection->getProperty('definition');
        $property->setAccessible(true);
        $property->setValue($instructionSet, null);
        $property->setAccessible(false);

        $instructionSet->getRules();
    }

    /**
     * Test that a parser exceptio is thrown when a parser fails to return
     * the proper data structure.
     *
     * @return void
     * @expectedException \HylianShield\Validator\Url\Network\Parser\ParserException
     * @expectedExceptionMessage Parser returned non-array: Url_Network_Parser_Mock
     */
    public function testIllegalParserOutput()
    {
        $instructionSet = InstructionSet::fromDefinition(
            new ProtocolDefinition()
        );

        // Prime the parsers.
        $instructionSet->getParsers();

        $parser = $this->getMock(
            // We cannot use the parsers based on ParserAbstract, as the
            // parse method is final and even PHPUnit can't help that.
            'stdClass',
            array('parse'),
            array(),
            'Url_Network_Parser_Mock'
        );

        $parser
            ->expects($this->any())
            ->method('parse')
            ->will($this->returnValue(false));

        $reflection = new \ReflectionObject($instructionSet);

        // Manipulate the list of parsers.
        $parserList = $reflection->getProperty('parsers');
        $parserList->setAccessible(true);
        $parserList->setValue($instructionSet, array($parser));
        $parserList->setAccessible(false);

        $instructionSet->parse('http://www.johmanx.com');
    }
}
