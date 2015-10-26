<?php
/**
 * Test for \HylianShield\Validator\String Subsets.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\String;

use \LogicException;
use \ReflectionClass;
use \HylianShield\Validator\String\Subset;

/**
 * SubsetTestBase.
 */
abstract class SubsetTestBase extends \HylianShield\Tests\Validator\TestBase
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
     * The checker for string lengths.
     *
     * @var callable $lengthChecker
     */
    private $lengthChecker;

    /**
     * Set up a common validator.
     */
    protected function setUp()
    {
        parent::setUp();

        // Set the regex encoding to one that differs from the tested encoding.
        mb_regex_encoding('EUC-JP');

        // Get the valid range.
        /** @var Subset $validator */
        $validator = $this->validator;
        $validRange = $validator->getRange();
        $class = get_class($this->validator);
        $reflection = new ReflectionClass($class);
        $encoding = $reflection->getConstant('ENCODING');

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

    /**
     * Getter for the lengthChecker property.
     *
     * @return callable
     */
    protected function getLengthChecker()
    {
        if (!isset($this->lengthChecker)) {
            $reflection = new \ReflectionObject($this->validator);
            $property = $reflection->getProperty('lengthCheck');
            $property->setAccessible(true);
            $this->lengthChecker = $property->getValue($this->validator);
            $property->setAccessible(false);
        }

        return $this->lengthChecker;
    }

    /**
     * Provide calls for the string length validation test.
     *
     * @return array
     */
    final public function stringLengthValidationProvider()
    {
        parent::setUp();

        $reflection = new \ReflectionObject($this->validator);
        $property = $reflection->getProperty('ranges');
        $property->setAccessible(true);
        $ranges = $property->getValue($this->validator);
        $property->setAccessible(false);

        $rv = array();

        foreach ($ranges as $range) {
            foreach ($range as $hex) {
                $rv[] = array(
                    html_entity_decode(
                        '&#' . hexdec($hex) . ';',
                        ENT_QUOTES,
                        $reflection->getConstant('ENCODING')
                    ),
                    // Should be 1 in length.
                    1
                );
            }
        }

        return $rv;
    }

    /**
     * Test different string lengths using the string length checker.
     *
     * @param string $string
     * @param integer $length
     * @dataProvider stringLengthValidationProvider
     */
    final public function testStringLength($string, $length)
    {
        $this->assertEquals(
            $length,
            call_user_func(
                $this->getLengthChecker(),
                $string
            )
        );
    }

    /**
     * Test validations.
     */
    public function testValidations()
    {
        parent::testValidations();
    }

    /**
     * Test validations that are optimized.
     *
     * @depends testValidations
     */
    public function testOptimizedValidations()
    {
        // Get some basic information.
        $class = get_class($this->validator);
        $reflection = new ReflectionClass($class);
        $encoding = $reflection->getConstant('ENCODING');
        mb_regex_encoding($encoding);

        // Reset the validator.
        parent::setUp();

        // Test the validations once more.
        $this->testValidations();

        // This method needs some assertions itself, to prevent it from being
        // registered as skipped.
        if (!$this->testValidations && phpversion() < 5.4) {
            // At least we know this much.
            $this->assertEmpty($this->validator);
        } else {
            $this->assertInternalType('string', $this->validator->getType());
        }
    }

    /**
     * Test that the ranges getter throws when the property is malformed.
     *
     * @return void
     * @expectedException \LogicException
     * @expectedExceptionMessage No character ranges implemented.
     */
    public function testEmptyRange()
    {
        /** @var Subset $validator */
        $validator = clone $this->validator;
        $reflection = new \ReflectionObject($validator);
        $rangesProperty = $reflection->getProperty('ranges');
        $rangesProperty->setAccessible(true);
        $rangesProperty->setValue($validator, array());
        $rangesProperty->setAccessible(false);
        $validator->getRange();
    }

    /**
     * Test that the ranges getter throws when the property is malformed.
     *
     * @return void
     * @expectedException \LogicException
     * @expectedExceptionMessage Invalid range encountered:
     */
    public function testIllegalRangeStructure()
    {
        /** @var Subset $validator */
        $validator = clone $this->validator;
        $reflection = new \ReflectionObject($validator);
        $rangesProperty = $reflection->getProperty('ranges');
        $rangesProperty->setAccessible(true);
        $rangesProperty->setValue(
            $validator,
            array(
                array('a', 'b', 'c')
            )
        );
        $rangesProperty->setAccessible(false);
        $validator->getRange();
    }
}
