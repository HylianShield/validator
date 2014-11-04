<?php
/**
 * Test for \HylianShield\Validator\Financial\ISO20022\ExtOrganizationIdCode.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Financial\ISO20022;

/**
 * External Organization Identification Code test.
 */
class ExtOrganizationIdCodeTest extends \HylianShield\Tests\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass
        = '\HylianShield\Validator\Financial\ISO20022\ExtOrganizationIdCode';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('Aap Noot Mies', false),
        array('', false),
        array(null, false),
        array(82, false),
        array('BANK', true),
        array('CBID', true),
        array('CHID', true),
        array('COID', true),
        array('CUST', true),
        array('DUNS', true),
        array('EMPL', true),
        array('GS1G', true),
        array('SREN', true),
        array('SRET', true),
        array('TXID', true)
    );
}
