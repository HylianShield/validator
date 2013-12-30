<?php
/**
 * Test for \HylianShield\Validator\String.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Remko "CyberSecutor" Silvis
 */

namespace Tests\HylianShield\Validator;

/**
 * StringTest.
 */
class StringTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\String';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('Aap Noot Mies', true),
        array('0123456789', true),
        array('', true),
        array(0123456789, false),
        array(null, false),
        array(0, false)
    );
}
