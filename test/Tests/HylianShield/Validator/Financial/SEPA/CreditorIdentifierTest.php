<?php
/**
 * Test for \HylianShield\Validator\Financial\SEPA\CreditorIdentifier.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Remko "CyberSecutor" Silvis
 */

namespace Tests\HylianShield\Validator\Financial\SEPA\CreditorIdentifier;

/**
 * Creditor Identifier validator test.
 */
class CreditorIdentifierTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass
        = '\HylianShield\Validator\Financial\SEPA\CreditorIdentifier';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('NL51ZZZ405365330000', true),
        array('NL51AAA405365330000', true),
        array('NL51AB405365330000', false),
        array('NL00ZZZ405365330000', false),
        array('NL81ZZZ404010', true),
        array('NL67ZZZ4040', false)
    );
}
