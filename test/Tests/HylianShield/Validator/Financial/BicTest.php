<?php
/**
 * Test for \HylianShield\Validator\Financial\Bic.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Remko "CyberSecutor" Silvis
 */

namespace Tests\HylianShield\Validator\Financial\BicTest;

/**
 * Bic validator test.
 */
class BicTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Financial\Bic';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('', false),
        array(null, false),
        array('0', false),
        array('ABNABEBR ', false),
        array(' ABNABEBR', false),
        array('RABO2.NLU', false),
        array('RABO.NL.24', false),
        array('RABO NL 2U', false),
        array('RABO-NL-2Y', false),
        array('RBOS,NL2A', false),
        array('ABNABEBR', true),
        array('ABNAML2A', true),
        array('ABNANI2A', true),
        array('ABNANK2A', true),
        array('ABNANL2A', true),
        array('ANBANL2A', true),
        array('AXABBE22', true),
        array('BABONL2U', true),
        array('BBRUBEBB', true),
        array('BBRUBEBB010', true),
        array('BBRUBEBB400', true),
        array('BBRUBEBB800', true),
        array('BCVSCH2LXXX', true),
        array('BKCPBEB1BKB', true),
        array('BKCPBEB1WVB', true),
        array('BNAGBEBB', true),
        array('BNPANL2A', true),
        array('BPOTBEB1', true),
        array('BRRUBEBB', true),
        array('CREGBEBB', true),
        array('DEUTNL2A', true),
        array('DEUTNL2N', true),
        array('EURBBE99', true),
        array('FRBKNL2L', true),
        array('FTSBNL2R', true),
        array('FVLBNL22', true),
        array('GEBABEBB', true),
        array('GEBABEBB01A', true),
        array('GEBABEBB05A', true),
        array('GEBABEBB08A', true),
        array('GEBABEBB18A', true),
        array('GEBABEBB36A', true),
        array('GEBABEBBO8A', true),
        array('GEBABEDD', true),
        array('GEBADEBB', true),
        array('GKCCBEBB', true),
        array('HBKABE22', true),
        array('INGBNL2A', true),
        array('INGBNLZA', true),
        array('INGINGBNL2A', true),
        array('KRED8EBB', true),
        array('KREDBEBB', true),
        array('NICABEBB', true),
        array('NL07RABO', true),
        array('NL21RABO037', true),
        array('NL28ABNA042', true),
        array('NL30RABO012', true),
        array('NL47RABO011', true),
        array('NL59RABO016', true),
        array('NL72INGB066', true),
        array('NLINGB2A', true),
        array('NLRABO2U', true),
        array('PSTBNL21', true),
        array('RABO2NLU', true),
        array('RABONL24', true),
        array('RABONL2U', true),
        array('RABONL2Y', true),
        array('RBOSNL2A', true),
        array('SNSBNL2A', true),
        array('SPAABE22', true),
        array('SPAABE32', true),
        array('TESTNL2A', true),
        array('TRIONL2U', true)
    );
}
