<?php
/**
 * Test for \HylianShield\Validator\String\Utf8\Mes2.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\String\Utf8;

/**
 * Mes2Test.
 */
class Mes2Test extends \Tests\HylianShield\Validator\String\SubsetTestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\String\Utf8\Mes2';

    /**
     * A range of invalid characters. Should be the hex value of the character.
     *
     * @var array $invalidCharacters
     */
    protected $invalidCharacters = array(
        '001F',
        '007F',
        '009F',
        '0300',
        '036F',
        '0500',
        '1DFF',
        '20D0',
        '20FF',
        '2400',
        '24FF',
        '2700',
        'FAFF',
        'FB50',
        'FFEF',
        'FFFE'
    );
}
