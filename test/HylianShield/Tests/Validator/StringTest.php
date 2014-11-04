<?php
/**
 * Test for \HylianShield\Validator\String.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator;

/**
 * StringTest.
 */
class StringTest extends \HylianShield\Tests\Validator\TestBase
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
        array(null, false),
        array(0, false)
    );
}
