<?php
/**
 * Test for \HylianShield\Validator\Financial\Iban.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Remko "CyberSecutor" Silvis
 */

namespace Tests\HylianShield\Validator\Financial\IbanTest;

/**
 * Iban validator test.
 */
class IbanTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass
        = '\HylianShield\Validator\Financial\Iban';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('', false),
        array(null, false),
        array('0', false),
        array('NL5140536533000', false),
        array('NL51405365330000', true),
        array('BE83405365330000', true),
        array('NL52405365330000', false),
        array('NL5140536533000', false),
        array('BE51405365330000', false)
    );
}
