<?php
/**
 * Test for \HylianShield\Validator\String\Utf8\WordCharacter.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\String\Utf8;

/**
 * WordCharacterTest.
 */
class WordCharacterTest extends \Tests\HylianShield\Validator\String\SubsetTestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\String\Utf8\WordCharacter';

    /**
     * A range of invalid characters. Should be the hex value of the character.
     *
     * @var array $invalidCharacters
     */
    protected $invalidCharacters = array(
        '002F',
        '003A',
        '0040',
        '005B',
        '0060',
        '007B',
        '00BE',
        '0100'
    );
}
