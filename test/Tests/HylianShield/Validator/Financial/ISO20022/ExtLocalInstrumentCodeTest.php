<?php
/**
 * Test for \HylianShield\Validator\Financial\ISO20022\ExtLocalInstrumentCode.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Remko "CyberSecutor" Silvis
 */

namespace Tests\HylianShield\Validator\Financial\ISO20022;

/**
 * External Local Instrument Code test.
 */
class ExtLocalInstrumentCodeTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass
        = '\HylianShield\Validator\Financial\ISO20022\ExtLocalInstrumentCode';

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
        array('TRF', true),
        array('CHN', true),
        array('CPP', true),
        array('DDT', true),
        array('GST', true),
        array('RDD', true),
        array('RTR', true),
        array('SCN', true),
        array('SDD', true),
        array('SGT', true),
        array('SRD', true),
        array('SRT', true),
        array('STR', true),
        array('82', true),
        array('83', true),
        array('CARD', true),
        array('04', true),
        array('05', true),
        array('IN', true),
        array('19', true),
        array('58', true),
        array('08', true),
        array('60', true),
        array('85', true),
        array('89', true),
        array('RIBA', true),
        array('RIDO', true),
        array('RIDV', true),
        array('ACCEPT', true),
        array('IDEAL', true),
        array('NLDO', true),
        array('NLGOV', true),
        array('NLUP', true),
        array('SDN', true),
        array('0000', true),
        array('0001', true),
        array('0002', true),
        array('0090', true),
        array('0091', true),
        array('0092', true),
        array('0220', true),
        array('0221', true),
        array('0222', true),
        array('0223', true),
        array('0224', true),
        array('0225', true),
        array('0226', true),
        array('0227', true),
        array('IN', true),
        array('ONCL', true),
        array('SDCL', true),
        array('B2B', true),
        array('B2BAMIPM', true),
        array('COR1', true),
        array('CORAMIPM', true),
        array('CORE', true),
        array('CR1AMIPM', true),
        array('DDFA', true),
        array('DDNR', true),
        array('FADAMIPM', true),
        array('CCI', true),
        array('BTR', true),
        array('CKS', true),
        array('CTP', true),
        array('CTR', true),
        array('DEP', true),
        array('DRB', true),
        array('DRC', true),
        array('DRW', true),
        array('FFR', true),
        array('FFS', true),
        array('SVC', true),
        array('ARC', true),
        array('CCD', true),
        array('CIE', true),
        array('CTX', true),
        array('IAT', true),
        array('POP', true),
        array('POS', true),
        array('PPD', true),
        array('RCK', true),
        array('TEL', true),
        array('WEB', true)
    );
}
