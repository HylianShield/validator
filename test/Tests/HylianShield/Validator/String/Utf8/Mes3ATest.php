<?php
/**
 * Test for \HylianShield\Validator\String\Utf8\Mes3A.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\String\Utf8;

/**
 * Mes3ATest.
 */
class Mes3ATest extends \Tests\HylianShield\Validator\String\SubsetTestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\String\Utf8\Mes3A';

    /**
     * A range of invalid characters. Should be the hex value of the character.
     *
     * @var array $invalidCharacters
     */
    protected $invalidCharacters = array(
        '001F',
        '007F',
        '009F',
        '0500',
        '052F',
        '0590',
        '10CF',
        '1100',
        '1DFF',
        '2400',
        '243F',
        '2460',
        '24FF',
        '2700',
        'FAFF',
        'FB50',
        'FE1F',
        'FE30',
        'FFEF',
        'FFFE'
    );
}
