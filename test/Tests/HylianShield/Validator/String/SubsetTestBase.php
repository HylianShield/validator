<?php
/**
 * Test for \HylianShield\Validator\String Subsets.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\String;

use \LogicException;

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
     * A range of invalid characters. Should be the hex value of the character.
     *
     * @var array $invalidCharacters
     */
    protected $invalidCharacters;

    /**
     * Set up a common validator.
     */
    protected function setUp()
    {
        parent::setUp();

        // Get the valid range.
        $validRange = $this->validator->getRange();
        $class = get_class($this->validator);
        $encoding = $class::ENCODING;

        if (empty($this->invalidCharacters)) {
            throw new LogicException(
                'Incomplete unit test. Empty list of invalid characters to test.'
            );
        }

        // Add validations.
        $this->validations = array(
            array('AapNootMies', true),
            array('0123456789', true),
            array('', true),
            array(0123456789, false),
            array(null, false),
            array(0, false),
            // Test all characters within the range.
            array(implode('', $validRange), true)
        );

        foreach ($this->invalidCharacters as $hex) {
            $decimal = hexdec($hex);
            $char = html_entity_decode(
                "&#{$decimal};",
                ENT_QUOTES,
                $encoding
            );

            // Could not decode this one.
            if ($char === "&#{$decimal};") {
                continue;
            }

            // Add this character as a validation that should fail.
            $this->validations[] = array($char, false);
        }
    }
}
