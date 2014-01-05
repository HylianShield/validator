<?php
/**
 * Test for \HylianShield\Validator\Url\Webpage.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\Url;

use \HylianShield\Validator\Url\Webpage;

/**
 * Webpage test.
 */
class WebpageTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Url\Webpage';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('Aap Noot Mies', false),
        array('0123456789', false),
        array('', false),
        array('€αβγδε', false),
        array(0123456789, false),
        array(0.123456789, false),
        array(null, false),
        array(0, false),
        array(.1, false),
        array('zelda://johmanx:secutor@hylianshield.git:1337/masterSword.swd?fairy=navi', false),
        array('https://johmanx:secutor@hylianshield.git:443/masterSword.swd?fairy=navi', true),
        array('zelda://hylianshield.git', false),
        array('hylianshield.git', false),
        array('https://someting:1337', false),
        array('https://something', true),
        array('https://something:80', false),
        array('https://something:443', true),
        array('http://something', true)
    );
}
