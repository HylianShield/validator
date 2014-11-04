<?php
/**
 * Test for \HylianShield\Validator\Financial\ISO20022\ExtPersonIdCode.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Financial\ISO20022;

/**
 * External Personal Identification Code test.
 */
class ExtPersonIdCodeTest extends \HylianShield\Tests\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Financial\ISO20022\ExtPersonIdCode';

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
        array('TRF', false),
        array('CHN', false),
        array('ARNU', true),
        array('CCPT', true),
        array('CUST', true),
        array('DRLC', true),
        array('EMPL', true),
        array('NIDN', true),
        array('SOSE', true),
        array('TXID', true)
    );
}
