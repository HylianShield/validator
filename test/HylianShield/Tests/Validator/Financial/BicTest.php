<?php
/**
 * Test for \HylianShield\Validator\Financial\Bic.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Remko "CyberSecutor" Silvis
 */

namespace HylianShield\Tests\Validator\Financial\BicTest;

/**
 * Bic validator test.
 */
class BicTest extends \HylianShield\Tests\Validator\TestBase
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
        array('ABNAML20', false),
        array('ABNANI21', true),
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
        array('KRED8EBB', false),
        array('NICABEBB', true),
        array('NL07RABO', false),
        array('NL21RABO037', false),
        array('NL28ABNA042', false),
        array('NL30RABO012', false),
        array('NL47RABO011', false),
        array('NL59RABO016', false),
        array('NL72INGB066', false),
        array('NLINGB2A', true),
        array('NLRABO2U', true),
        array('PSTBNL21', true),
        array('RABO2NLU', false),
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

    /**
     * Provide a set of invalid arguments.
     *
     * @return array
     */
    public function invalidArgumentProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            array('true'),
            array(''),
            array(0),
            array(-1),
            array(1)
        );
    }

    /**
     * Test an invalid construct.
     *
     * @dataProvider invalidArgumentProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConstruct($invalidArgument)
    {
        $validator = $this->validatorClass;
        $validator = new $validator($invalidArgument);
    }

    /**
     * Provide a set of valid validations.
     *
     * @return array
     */
    public function validAlternativeValidationSet()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            array('ABNABEBR'),
            array('ABNANK2A'),
            array('ABNANL2A'),
            array('ANBANL2A'),
            array('ABNAML20'),
            array('ABNANI21')
        );
    }

    /**
     * Test alternative validator construct using test BIC codes.
     *
     * @dataProvider validAlternativeValidationSet
     */
    public function testValidAlternateConstruct($validate) {
        $validator = $this->validatorClass;
        $validator = new $validator(true);

        $this->assertEquals(true, $validator($validate));
    }

    /**
     * Provide a set of invalid validations.
     *
     * @return array
     */
    public function invalidAlternativeValidationSet()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            array('RBOS,NL2A'),
            array('RABO2NLU'),
            array('NL07RABO'),
            array('NL21RABO037'),
        );
    }

    /**
     * Test alternative validator construct using test BIC codes.
     *
     * @dataProvider invalidAlternativeValidationSet
     */
    public function testInvalidAlternateConstruct($validate) {
        $validator = $this->validatorClass;
        $validator = new $validator(true);

        $this->assertEquals(false, $validator($validate));
    }
}
