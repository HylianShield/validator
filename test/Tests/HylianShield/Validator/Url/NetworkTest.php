<?php
/**
 * Test for \HylianShield\Validator\Url\Network.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\Url;

use \HylianShield\Validator\Url\Network;

/**
 * Network test.
 */
class NetworkTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Url\Network';

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
        array('zelda://johmanx:secutor@hylianshield.git:1337/masterSword.swd?fairy=navi', true),
        array('zelda://hylianshield.git', true),
        array('hylianshield.git', false),
        array('//hylianshield.gitz/something', false)
    );
}
