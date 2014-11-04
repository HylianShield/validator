<?php
/**
 * Test for \HylianShield\Validator\Url\Network.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Url\Network;
/**
 * Http test.
 */
class HttpTest extends \HylianShield\Tests\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Url\Network\Http';

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
        array(0.123456789, false),
        array(null, false),
        array(0, false),
        array(.1, false),
        array('zelda://johmanx:secutor@hylianshield.git:1337/masterSword.swd?fairy=navi', false),
        array('http://johmanx:secutor@hylianshield.git:80/masterSword.swd?fairy=navi', true),
        array('zelda://hylianshield.git', false),
        array('hylianshield.git', false),
        array('http://someting:1337', false),
        array('http://something', true),
        array('http://something:80', true),
        array('https://something', false)
    );
}
