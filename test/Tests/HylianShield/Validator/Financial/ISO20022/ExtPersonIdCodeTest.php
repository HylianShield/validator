<?php
/**
 * Test for \HylianShield\Validator\Financial\ISO20022\ExtPersonIdCode.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Remko "CyberSecutor" Silvis
 */

namespace Tests\HylianShield\Validator\Financial\ISO20022;

/**
 * External Personal Identification Code test.
 */
class ExtPersonIdCodeTest extends \Tests\HylianShield\Validator\TestBase
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
        array(0123456789, false),
        array('', false),
        array(null, false),
        array(82, false),
        array(0000, false),
        array(0001, false),
        array(0227, false),
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
