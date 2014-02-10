<?php
/**
 * Test for \HylianShield\Validator\String\Utf8\Mes1.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\String\Utf8;

/**
 * Mes1Test.
 */
class Mes1Test extends \Tests\HylianShield\Validator\String\SubsetTestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\String\Utf8\Mes1';

    /**
     * A range of invalid characters. Should be the hex value of the character.
     *
     * @var array $invalidCharacters
     */
    protected $invalidCharacters = array(
        '001F',
        '007F',
        '009F',
        '0180',
        '02AF',
        '0300',
        '1FFF',
        '2070',
        '209F',
        '20D0',
        '20FF',
        '2200',
        '25FF',
        '2700'
    );
}
