<?php
/**
 * Test for \HylianShield\Validator\String Subsets.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\String;

/**
 * SubsetTestBase.
 */
class SubsetTestBase extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass;

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations;

    /**
     * Set up a common validator.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->validations = array(
            array('AapNootMies', true),
            array('0123456789', true),
            array('', true),
            array(0123456789, false),
            array(null, false),
            array(0, false),
            // Test all characters within the range.
            array(implode('', $this->validator->getRange()), true)
        );
    }
}
